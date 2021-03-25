#!/bin/bash

clone(){
    git clone --depth 1 --branch master --single-branch $1 $2
}

clean(){
    rm -rf ./collection-*
}

generatedb(){
    rm -rf ./fuzzy.db
    find ./collection-* -type f -size +1k -size -800k \
    -not -path "./.git*" \
    -not -name "*.md" \
    -not -name "*.rar" \
    -not -name "*.zip" \
    -not -name "*.gz" \
    -not -name "*.7z" \
    -not -name "*.png" \
    -not -name "*.sample" \
    -not -name "LICENSE" \
    -not -name "license" \
    -exec ssdeep -sb {} > fuzzy.db \;
    sed -i -e '/ssdeep,1.1--blocksize:hash:hash,filename/d' fuzzy.db
    rm -rf ./fuzzy.db-e
}

#clean
#clone https://github.com/tennc/webshell.git ./collection-1
#clone https://github.com/ysrc/webshell-sample.git ./collection-2
#clone https://github.com/xl7dev/WebShell.git ./collection-3
#clone https://github.com/JohnTroony/php-webshells/tree/master/Collection ./collection-4
#clone https://github.com/tanjiti/webshellSample.git ./collection-5
#clone https://github.com/BlackArch/webshells ./collection-6
#clone https://github.com/tutorial0/WebShell ./collection-7
generatedb

cp ./fuzzy.db ../pkg/fuzzyhash/db