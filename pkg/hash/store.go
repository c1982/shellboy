package hash

type HashStore struct {
	items    []HashItem
	provider HashProvider
}

func NewHashStore() *HashStore {
	return &HashStore{}
}

func (f *HashStore) Load() {
}

func (f *HashStore) Detect(filepath string) (detected bool, item HashItem, err error) {
	return detected, item, err
}
