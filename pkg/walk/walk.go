package walk

import (
	"errors"
	"os"
	"path/filepath"
	"strings"
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
	rootPath              string
	minFileSize           int64
	maxFileSize           int64
	excludeFileExtensions []string
	includeFileExtensions []string
}

//NewWalker create a new file walker
func NewWalker(rootpath string, minfilesize, maxfilesize int, excludes, includes []string) (fs *FileSystemWalker) {
	return &FileSystemWalker{
		rootPath:              rootpath,
		minFileSize:           int64(minfilesize),
		maxFileSize:           int64(maxfilesize),
		excludeFileExtensions: excludes,
		includeFileExtensions: includes,
	}
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
			//TODO: os.ModeSymlink check required

			if info.Size() < f.minFileSize {
				return nil
			}

			if info.Size() > f.maxFileSize {
				return nil
			}

			if f.isExcluded(path) {
				return nil
			}

			if !f.isIncluded(path) {
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

	c, errc := f.walkFiles(done, f.rootPath)
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

func (f *FileSystemWalker) containArray(filename string, slice []string) bool {
	for i := 0; i < len(slice); i++ {
		if ok := strings.HasSuffix(filename, slice[i]); ok {
			return ok
		}
	}
	return false
}

func (f *FileSystemWalker) isExcluded(filename string) bool {
	return f.containArray(filename, f.excludeFileExtensions)
}

func (f *FileSystemWalker) isIncluded(filename string) bool {
	return f.containArray(filename, f.includeFileExtensions)
}
