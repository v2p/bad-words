#!/usr/bin/env bash

mkdir -p ./raw-pages/swearing/
mkdir -p ./raw-pages/medicine/

wget -i swearing-urls.txt -P ./raw-pages/swearing/
wget -i medicine-urls.txt -P ./raw-pages/medicine/