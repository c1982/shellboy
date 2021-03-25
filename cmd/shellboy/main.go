package main

import (
	"flag"
	"fmt"
	"os"
	"shellboy/pkg/fuzzyhash"
	"shellboy/pkg/walk"
	"strings"
)

var (
	Version   = "0.0.0"
	BuildDate = ""
)

func main() {
	currentPath, _ := os.Getwd()
	rootPath := flag.String("directory", currentPath, "Root directory for scan.")
	minScore := flag.Int("score", 98, "Minimum similarity score.")
	minBytes := flag.Int("minbytes", 4000, "Minimum file size (byte). Default 4kb")
	maxBytes := flag.Int("maxbytes", 1000000, "Maximum file size (byte). Default 1Mb")
	excludes := flag.String("excludes", "zip,exe,md,rar,gz", "Excluded file extensions. Empty is disabled")
	includes := flag.String("includes", "", "Included file extensions. Default empty")
	help := flag.Bool("h", false, "Display this help message")
	verbose := flag.Bool("v", false, "Verbose mode")
	flag.Parse()

	if *help {
		flag.PrintDefaults()
		return
	}

	excludeExtensions := strings.Split(*excludes, ",")
	includeExtensions := strings.Split(*includes, ",")
	fhash := fuzzyhash.NewFuzzyHash(*minScore)
	walker := walk.NewWalker(*rootPath, *minBytes, *maxBytes, excludeExtensions, includeExtensions)

	fmt.Printf("ShellBoy WebShell Scanner (%s-%s)\r\n", Version, BuildDate)
	fmt.Printf("Scanning... (%s)\r\n", *rootPath)
	err := walker.Scan(checkFileHash(fhash, *verbose))
	if err != nil {
		fmt.Printf("error: %v\r\n", err)
	}
	fmt.Printf("done!\r\n")
}

func checkFileHash(f *fuzzyhash.FuzzyHash, verbose bool) walk.ScanFunc {
	return func(path string, fileInfo os.FileInfo) error {
		score, name, err := f.FindHash(path)
		if err != nil {
			if verbose {
				fmt.Printf("error: %s, %s\r\n", err, path)
			}
			return nil
		}

		if score >= f.GetMinScore() {
			fmt.Printf("score: %d, name: %s, file: %s\r\n", score, name, path)
			return nil
		}

		return nil
	}
}
