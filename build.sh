#!/bin/bash

echo "Checking for folders and clearing them...";

rm -r ./assets/css/
mkdir -p ./assets/css/
rm -r ./assets/js/
mkdir -p ./assets/js/

echo "Converting LESS and compressing output CSS...";

cat \
  style/style.less \
  | lessc --clean-css - \
  | yui-compressor --type=css \
  > ./assets/css/compiled.css;

echo "Combining and compressing global JS...";

cat \
  scripts/global.js \
  | yui-compressor --type=js \
  > ./assets/js/compiled.js;

echo "Combining and compressing app JS...";

cat \
  scripts/base64_encode.js \
  scripts/jquery.hotkeys.js \
  scripts/json2.js \
  scripts/utf8_encode.js \
  scripts/mapping.js \
  | yui-compressor --type=js \
  > ./assets/js/compiled_app.js;

echo "Build complete!";