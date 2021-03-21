package yara

import (
	"bytes"
	_ "embed"
	"io/ioutil"

	"github.com/VirusTotal/gyp"
	"github.com/VirusTotal/gyp/ast"
)

//go:embed webshells_v2.yar
var webshells string

type YaraEngine struct {
	data *ast.RuleSet
}

func NewYaraEngine() (*YaraEngine, error) {
	y := &YaraEngine{}
	err := y.loadEmbededSring()
	if err != nil {
		return nil, err
	}
	return y, nil
}

func (y *YaraEngine) loadEmbededSring() (err error) {
	y.data, err = gyp.ParseString(webshells)
	return err
}

func (y *YaraEngine) loadString(rules string) (err error) {
	y.data, err = gyp.ParseString(rules)
	return err
}

func (y *YaraEngine) Check(filepath string) (malwareok bool, name string, err error) {
	dat, err := ioutil.ReadFile(filepath)
	if err != nil {
		return malwareok, name, err
	}
	malwareok, name = y.match(dat)
	return malwareok, name, err
}

func (y *YaraEngine) match(dat []byte) (matched bool, name string) {
	for _, v := range y.data.Rules {
		for i := 0; i < len(v.Strings); i++ {
			pattern := v.Strings[i].AsProto().GetValue()
			if r := bytes.Index(dat, []byte(pattern)); r != -1 {
				return true, v.Identifier
			}
		}
	}
	return false, name
}
