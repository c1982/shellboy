package main

import (
	"fmt"
	"os"
	"shellboy/pkg/walk"
)

func main() {

	fn := func(path string, f os.FileInfo) error {
		if f.IsDir() {
			return nil
		}
		fmt.Printf("file: %s\r\n", path)
		return nil
	}

	scan := walk.NewWalker("/Users/oguzhan/basket")
	err := scan.Scan(fn)
	if err != nil {
		fmt.Printf("error: %s", err)
	}
}
