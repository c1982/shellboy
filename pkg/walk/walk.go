package walk

import (
	"errors"
	"os"
	"path/filepath"
	"sync"
)

//ScanFunc inject file logic
type ScanFunc func(path string, fileInfo os.FileInfo) error

type scanResult struct {
	path string
	file os.FileInfo
	err  error
}

//FileSystemWalker for optional parameters field
type FileSystemWalker struct {
	RootPath              string
	MaxFileSize           int
	ExcludeFileExtentions []string
}

//NewWalker create a new file walker
func NewWalker(rootpath string) (fs *FileSystemWalker) {
	return &FileSystemWalker{RootPath: rootpath}
}

func (f *FileSystemWalker) walkFiles(done <-chan struct{}, root string) (<-chan scanResult, <-chan error) {
	c := make(chan scanResult)
	errc := make(chan error, 1)
	go func() {
		var wg sync.WaitGroup
		err := filepath.Walk(root, func(path string, info os.FileInfo, err error) error {
			if err != nil {
				return err
			}
			if !info.Mode().IsRegular() {
				return nil
			}
			wg.Add(1)
			go func() {
				select {
				case c <- scanResult{path, info, err}:
				case <-done:
				}
				wg.Done()
			}()

			select {
			case <-done:
				return errors.New("scan canceled")
			default:
				return nil
			}
		})

		go func() {
			wg.Wait()
			close(c)
		}()

		errc <- err
	}()
	return c, errc
}

//Scan start scan and pass your logic
func (f *FileSystemWalker) Scan(scanfn ScanFunc) error {
	done := make(chan struct{})
	defer close(done)

	c, errc := f.walkFiles(done, f.RootPath)
	for r := range c {
		if r.err != nil {
			return r.err
		}

		err := scanfn(r.path, r.file)
		if err != nil {
			return err
		}
	}

	return <-errc
}
