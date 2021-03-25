package fuzzyhash_test

import (
	"shellboy/pkg/fuzzyhash"
	"testing"
)

var testHashes = `48:Lgyb7ZNBBPggOZNTnhSnPvs+rDsJZ4N1are4mH27BQ:UyzBRluMhnWZ2xs7K,"UpServlet.java"
1536:TqNXIlidRzaWRNe2dzaWRNedp3n9cumC6bkWsEkpcCj:TsIJlMkWsjj,"jspspy有屏幕.txt"
3072:l7VXb7dijqGv1r8/7QyrgudxUtbEcM/WTMt4K5ole73WGv:PXtevkxj4K5qbGv,"AspxSpy2014Final.aspx"`

func TestLoadFromStore(t *testing.T) {
	mockObj := fuzzyhash.FuzzyHash{}
	count := mockObj.LoadHashes(testHashes)
	if count != 3 {
		t.Errorf("invalid hash count. expect: 3, got: %d", count)
	}
}

func TestFindHash(t *testing.T) {
	mockObj := fuzzyhash.FuzzyHash{}
	mockObj.LoadHashes(testHashes)
	mockObj.SetMinScore(98)

	score, name, err := mockObj.FindHash("./testdata/AspxSpy2014Final.aspx")
	if err != nil {
		t.Errorf("cannot find hash: %v", err)
	}

	if score != 100 {
		t.Errorf("invalid hash score. expect: 100, got: %d", score)
	}

	if name != "AspxSpy2014Final.aspx" {
		t.Errorf("invalid file name: expect: AspxSpy2014Final.aspx, got: %s", name)
	}
}

func BenchmarkFindHash(b *testing.B) {
	mockObj := fuzzyhash.FuzzyHash{}
	mockObj.LoadHashes(testHashes)
	mockObj.SetMinScore(100)
	for n := 0; n < b.N; n++ {
		_, _, _ = mockObj.FindHash("./testdata/AspxSpy2014Final.aspx")
	}
}
