package main

import (
	"fmt"
	"shellboy/pkg/fuzzyhash"
)

func main() {
	fh := fuzzyhash.NewFuzzyHash()
	h, _ := fh.ScoreFile("../../test_data/c99_v1.php", "../../test_data/c99_v2.php")
	fmt.Println(h)
}
