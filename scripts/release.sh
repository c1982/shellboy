#!/bin/bash

VERSION="v0.0.1"
BUILDDATE=`date '+%Y%m%d%H%M'`

cd ../cmd/shellboy
~/go/bin/gox -arch="amd64" -os="windows darwin" -ldflags "-X main.Version=${VERSION} -X main.Build=${BUILDDATE}" .
~/go/bin/gox -arch="amd64 arm" -os="linux" -ldflags "-X main.Version=${VERSION} -X main.Build=${BUILDDATE}" .

#git tag $(VERSION)
#git push origin --tags