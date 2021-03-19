package fuzzyhash

import (
	"github.com/glaslos/ssdeep"
)

const (
	DefaultScore = -1
)

type FuzzyHash struct {
}

func NewFuzzyHash() *FuzzyHash {
	return &FuzzyHash{}
}

func (f *FuzzyHash) FileHash(file string) (hash string, err error) {
	h1, err := ssdeep.FuzzyFilename(file)
	if err != nil {
		return "", err
	}

	return h1, err
}

func (f *FuzzyHash) Score(hash1, hash2 string) (score int, err error) {
	score, err = ssdeep.Distance(hash1, hash2)
	return score, nil
}

func (f *FuzzyHash) ScoreFile(file1 string, file2 string) (score int, err error) {
	h1, err := ssdeep.FuzzyFilename(file1)
	if err != nil {
		return DefaultScore, err
	}

	h2, err := ssdeep.FuzzyFilename(file2)
	if err != nil {
		return DefaultScore, err
	}

	score, err = ssdeep.Distance(h1, h2)
	return score, nil
}
