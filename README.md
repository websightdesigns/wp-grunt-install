[![WebSight Designs](http://www.websightdesigns.com/img/logo.png)](http://www.websightdesigns.com)

# WP Grunt Install

This repository features an install script written in Bash which will install and configure WordPress, set up a starter theme, and configure grunt to compile JavaScript and Sass.

## Features

## Tools

- WP-CLI ([wp-cli.org](https://wp-cli.org))
- GruntJS ([gruntjs.com](http://gruntjs.com))

## Requirements

This script requires WP-CLI (the `wp` command) and GruntJS (the `grunt` command) to be installed and available, otherwise the script will print an error and exit.

You must also have a `.my.cnf` (MySQL configuration) file in your `$HOME` directory, configured for the `mysql` user you specify in the `dbuser` configuration variable.

For example, if the user you specify is `root` then you'd add the following to your `.my.cnf`:

	[clientroot]
	  password="changeme"

## Install

To clone this project run the following command in the `/wp-content/themes/` directory:

	git clone https://github.com/websightdesigns/wp-grunt-install.git

Or, to specify the destination directory:

	git clone https://github.com/websightdesigns/wp-grunt-install.git ./destination

Once installed, edit the configuration variables at the top of `installwp.sh` and then run the script:

	./installwp.sh

To see how long the script takes to run, you can use `time`:

	time ./installwp.sh

To log the output of the script a log file:

	./installwp.sh | tee log.txt

To remove the install scripts and files, use the `--cleanup` option:

    ./installwp.sh --cleanup

During development, you may wish to manually delete the database and files each time before you run the script again:

	./removewp.sh; \
		echo 'DROP DATABASE newsitedb;' | mysql --defaults-group-suffix=root --defaults-file=~/.my.cnf -u root; \
		time ./installwp.sh > log.txt

## Options

`-d | --delete`

If a database with the name specified in the `dbname` configuration variable already exists, it will be deleted before installing WordPress.

`-p | --posts`

If this option is provided, 5 default posts will be created.

`-b | --beta`

If this option is provided, WordPress will be upgraded to the latest beta version.

`-c | --cleanup`

If this option is provided, the `installwp.sh` script will delete all files from the repository, including itself.

`-h | --help`

This option will print the help screen and exit.

## Contributing

If you'd like to contribute to this project please feel free to submit a pull request.

## Our Website

For more information about webSIGHTdesigns, please visit [websightdesigns.com](http://websightdesigns.com/).
