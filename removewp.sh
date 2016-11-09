#!/bin/sh

# if [ -f "~/.wp-cli/cache/core/wordpress-4.6.1-en_US.tar.gz" ]; then
# 	rm -v ~/.wp-cli/cache/core/wordpress-4.6.1-en_US.tar.gz
# fi

# check if any wp-* files or directories exist
for f in ./wp-*; do
    ## Check if the glob gets expanded to existing files.
    [ -e "$f" ] && rm -rfv ./wp-*

    # break after the first iteration
    break
done

if [ -d "./node_modules" ]; then
	rm -rfv ./node_modules
fi

if [ -d "./.sass-cache" ]; then
	rm -rfv ./.sass-cache
fi

if [ -f "package.json" ]; then
	rm package.json
fi

if [ -f "gruntfile.js" ]; then
	rm gruntfile.js
fi

if [ -f "config.yml" ]; then
	rm config.yml
fi

if [ -f "readme.html" ]; then
	rm readme.html
fi

if [ -f "license.txt" ]; then
	rm license.txt
fi

if [ -f "index.php" ]; then
	rm index.php
fi

if [ -f "xmlrpc.php" ]; then
	rm xmlrpc.php
fi

if [ -f ".htaccess" ]; then
	rm .htaccess
fi

if [ -f ".DS_Store" ]; then
	rm -v .DS_Store
fi

if [ -f "log.txt" ]; then
	rm -v log.txt
fi

# EOF
