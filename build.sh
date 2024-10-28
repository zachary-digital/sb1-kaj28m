#!/bin/bash

# Create build directory
mkdir -p build/markdown-to-acf-converter

# Copy all necessary files
cp -r assets includes *.php composer.json readme.txt build/markdown-to-acf-converter/

# Install Composer dependencies
cd build/markdown-to-acf-converter
composer install --no-dev
cd ../..

# Create ZIP archive
cd build
zip -r markdown-to-acf-converter.zip markdown-to-acf-converter
cd ..

echo "Plugin has been packaged to build/markdown-to-acf-converter.zip"