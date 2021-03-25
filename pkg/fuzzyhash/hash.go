package fuzzyhash

import (
	_ "embed"
	"sort"
	"strings"

	"github.com/glaslos/ssdeep"
)

const (
	DefaultScore = -1
	DefaultName  = "unknown"
)

//go:embed db/fuzzy.db
var webShellStore string

//FuzzyHash main struct for fuzzyhash package
type FuzzyHash struct {
	minscore       int
	webshellHashes []string
	webshellCount  int
}

//NewFuzzyHash create fuzzy hash object for ssdeep hash check
func NewFuzzyHash(minscore int) *FuzzyHash {
	f := &FuzzyHash{minscore: minscore}
	_ = f.LoadHashes(webShellStore)
	return f
}

//SetMinScore set minimum webshell score
func (f *FuzzyHash) SetMinScore(score int) {
	if score > 100 {
		score = 100
	}
	f.minscore = score
}

//GetMinScore return the minimum score
func (f *FuzzyHash) GetMinScore() int {
	return f.minscore
}

func (f *FuzzyHash) LoadHashes(store string) int {
	f.webshellHashes = strings.Split(store, "\n")
	sort.Strings(f.webshellHashes)
	return len(f.webshellHashes)
}

func (f *FuzzyHash) fileHash(file string) (hash string, err error) {
	h1, err := ssdeep.FuzzyFilename(file)
	if err != nil {
		return "", err
	}

	return h1, err
}

//FindHash search hash from webshell store
func (f *FuzzyHash) FindHash(file string) (score int, name string, err error) {
	var (
		lo       int
		hi       int
		mid      int
		midValue string
	)

	filehash, err := f.fileHash(file)
	if err != nil {
		return DefaultScore, DefaultName, err
	}

	hi = len(f.webshellHashes) - 1
	for lo <= hi {
		mid = lo + (hi-lo)/2
		midValue = f.webshellHashes[mid]
		if s, _ := ssdeep.Distance(filehash, midValue); s >= f.minscore {
			name = f.getNameFromHash(midValue)
			return s, name, nil
		} else if midValue > filehash {
			hi = mid - 1
		} else {
			lo = mid + 1
		}
	}

	return score, DefaultName, err
}

func (f *FuzzyHash) getNameFromHash(hash string) string {
	blocks := strings.Split(hash, ",")
	if len(blocks) == 2 {
		return strings.Trim(blocks[1], `"`)
	}
	return DefaultName
}
