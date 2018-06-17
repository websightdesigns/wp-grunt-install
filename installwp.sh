#!/bin/bash

# configure general options
timezone="America/Denver"
mysqlconfig="$HOME/.my.cnf"
skeletonfiles="./skeleton-files"

# configure database credentials
dbhost="localhost"
dbname="newsitedb"
dbuser="root"
dbprefix="wp_"

# configure site
site_title="My New Site"
site_url="http://installwp.localhost"

# configure wordpress admin credentials
admin_user="neo"
admin_pass="matrix"
admin_email="foo@domain.com"

# configure theme
theme_name="My Theme"
theme_slug="my-theme"
theme_prefix="my_theme"
theme_url="http://domain.com"
theme_author="John Doe"
theme_author_url="http://domain.com"
theme_version="1.0.0"

# configure plugins
plugins=(
	'wp-customize'
	'google-sitemap-generator'
)

# parse options
while :; do
	case "$1" in
		-d|--delete)
			./removewp.sh
			echo "DROP DATABASE $dbname;" | mysql --defaults-group-suffix=$dbuser --defaults-file=$mysqlconfig -u $dbuser
			;;
		-b|--beta)
			beta="true"
			;;
		-c|--cleanup)
			cleanup="true"
			;;
		-p|--posts)
			posts="true"
			;;
		-h|--help)
			echo "Memorable Usage: $0 [ --delete | --posts | --cleanup | --beta ] [ --help ]"
			echo "Shorthand Usage: $0 [ -d | -p | -c | -b ] [ -h ]"
			exit 1
			;;
		*) # Default case: If no more options then break out of the loop.
			break
	esac
	shift
done

# if no mysqlconfig exists, exit with error
if [ ! -f $mysqlconfig ]; then
	echo "ERROR: mysql config does not exist"
	exit
fi

# check if the wp command is available
wp_cmd_check=`type wp`
if [[ $wp_cmd_check == *"not found"* ]]; then
	echo "ERROR: wp command not found"
	exit
fi

# check if the grunt command is available
grunt_cmd_check=`type grunt`
if [[ $grunt_cmd_check == *"not found"* ]]; then
	echo "ERROR: grunt command not found"
	exit
fi

# get root password from mysql config
dbpass_tmp=`awk "/client$dbuser/{getline; print}" $mysqlconfig`
if [[ $dbpass_tmp == *"\""* ]]; then
	dbpass=`echo $dbpass_tmp | cut -d '"' -f2`
fi
if [[ $dbpass_tmp == *"'"* ]]; then
	dbpass=`echo $dbpass_tmp | cut -d "'" -f2`
fi

# check if password variable has a value
if [ -z $dbpass ]; then
	# if not, print error and exit
	echo "ERROR: no database password"
	exit
else
	# if so, continue...

	# install wordpress
	wp core download --path=.
	wp core config --dbname="$dbname" --dbuser="$dbuser" --dbpass="$dbpass" --dbhost="$dbhost" --dbprefix="$dbprefix" --extra-php <<PHP
// Enable debug mode
define( 'WP_DEBUG', true );

// Enable debug logging to the /wp-content/debug.log file
define( 'WP_DEBUG_LOG', true );

// Disable display of errors and warnings
define( 'WP_DEBUG_DISPLAY', false );
PHP
	wp db create
	wp core install --url="$site_url" --title="$site_title" --admin_user="$admin_user" --admin_password="$admin_pass" --admin_email="$admin_email" --skip-email

	# remove default themes
	rm -rfv ./wp-content/themes/*

	# remove default wp-config.php sample file
	rm -v ./wp-config-sample.php

	# remove .DS_Store files, if any
	find . -type f -name '.DS_Store' -exec rm -v {} \;

	# copy over files
	cp -v $skeletonfiles/.htaccess.sample .htaccess
	cp -v $skeletonfiles/gruntfile.js .
	cp -v $skeletonfiles/package.json .
	cp -v $skeletonfiles/wp-cli.yml .
	cp -v $skeletonfiles/sitemap.xsl .
	cp -v $skeletonfiles/wp-config-remote.php .
	cp -v $skeletonfiles/wp-config-local.php .
	mkdir ./wp-content/themes/$theme_slug
	cp -Rv $skeletonfiles/theme/ ./wp-content/themes/$theme_slug

	# perform string replacements
	find ./gruntfile.js -type f -print -exec sed -i "s/SKEL_THEME_SLUG/$theme_slug/" {} \;
	find ./package.json -type f -print -exec sed -i "s/SKEL_THEME_SLUG/$theme_slug/" {} \;
	find ./package.json -type f -print -exec sed -i "s/SKEL_THEME_VERSION/$theme_version/" {} \;
	LC_ALL=C find ./wp-content/themes/$theme_slug/* -type f -print -exec sed -i "s/SKEL_THEME_NAME/$theme_name/" {} \;
	LC_ALL=C find ./wp-content/themes/$theme_slug/* -type f -print -exec sed -i "s|SKEL_THEME_URL|$theme_url|" {} \;
	LC_ALL=C find ./wp-content/themes/$theme_slug/* -type f -print -exec sed -i "s|SKEL_THEME_AUTHOR_URL|$theme_author_url|" {} \;
	LC_ALL=C find ./wp-content/themes/$theme_slug/* -type f -print -exec sed -i "s/SKEL_THEME_AUTHOR/$theme_author/" {} \;
	LC_ALL=C find ./wp-content/themes/$theme_slug/* -type f -print -exec sed -i "s/SKEL_THEME_VERSION/$theme_version/" {} \;
	LC_ALL=C find ./wp-content/themes/$theme_slug/* -type f -print -exec sed -i "s/SKEL_THEME_SLUG/$theme_slug/" {} \;
	LC_ALL=C find ./wp-content/themes/$theme_slug/* -type f -print -exec sed -i "s/SKEL_THEME_PREFIX/$theme_prefix/" {} \;

	# re-copy the fonts directory after the string replacement above
	cp -Rv $skeletonfiles/theme/fonts/bootstrap/* ./wp-content/themes/$theme_slug/fonts/bootstrap/

	# install packages
	npm install

	# run grunt
	grunt --verbose --debug build

	# activate theme
	wp theme activate $theme_slug

	# remove default plugins
	echo "Removing default plugins..."
	rm -rfv ./wp-content/plugins/*

	# # copy plugins
	# cp -Rv $skeletonfiles/plugins/* ./wp-content/plugins

	# # activate any plugins in `skeleton-files/plugins` directory
	# for plugindir in `find $skeletonfiles/plugins/* -type d -maxdepth 0`
	# do
	#     wp plugin activate `basename $plugindir`
	# done

	# activate plugins from the wordpress plugins repository
	for i in "${plugins[@]}"
	do
		wp plugin install $i --activate
	done

	# delete default page and post
	wp post delete 1 --force
	wp post delete 2 --force

	# create home page and set as front page
	home_id=`wp post create --post_type=page --post_title='Home' --post_status=publish --porcelain`
	wp post meta set $home_id _wp_page_template template-home.php
	wp option update page_on_front $home_id --autoload=no
	wp option update show_on_front page --autoload=yes

	# create about page
	about_id=`wp post create --post_type=page --post_title='About' --post_status=publish --porcelain`
	wp post meta set $about_id _wp_page_template template-about.php

	# set rewrites structure and flush rewrites
	wp rewrite structure '/%postname%/'
	wp rewrite flush --hard

	# create menu titled "Primary Menu"
	wp menu create "Primary Menu"

	# assign primary-menu to "primary" location
	wp menu location assign primary-menu primary

	# set up menu links
	wp menu item add-custom primary-menu Home /
	wp menu item add-custom primary-menu About /about

	# update timezone
	wp option update timezone_string $timezone --autoload=yes

	# remove default widgets
	wp widget delete search-2
	wp widget delete recent-posts-2
	wp widget delete recent-comments-2
	wp widget delete archives-2
	wp widget delete categories-2
	wp widget delete meta-2

	# set up footer widgets
	wp widget add recent-posts footer-sidebar-1
	wp widget add recent-comments footer-sidebar-2
	wp widget add meta footer-sidebar-3

	# rename default category
	wp term update category 1 --name=Updates

	# update wp-customize options
	wp option add wpcustomize_admin_loginstyles --format=plaintext --autoload=yes < ./$skeletonfiles/wpcustomize_admin_loginstyles.txt
	wp option add wpcustomize_admin_footer_contents --autoload=yes "Website by &lt;a href=&quot;http://websightdesigns.com/&quot; target=&quot;_blank&quot;&gt;webSIGHTdesigns&lt;/a&gt;."
	wp option add wpcustomize_admin_bgcolor --autoload=yes "#f7f8f8"
	wp option add wpcustomize_admin_linkcolor --autoload=yes "#0b5394"
	wp option add wpcustomize_admin_linkhovercolor --autoload=yes "#4c99ef"
	wp option add wpcustomize_admin_page_title --autoload=yes "Please Authenticate"
	wp option add wpcustomize_hide_register_forgot_links --autoload=yes "1"
	wp option add wpcustomize_hide_back_link --autoload=yes "1"
	wp option add wpcustomize_remember_me_by_default --autoload=yes "1"
	wp option add wpcustomize_remove_login_shake --autoload=yes "1"
	field_name_username="$theme_prefix"
	field_name_username+="_user_login"
	wp option add field_name_username --autoload=yes "$field_name_username"
	field_name_password="$theme_prefix"
	field_name_password+="_user_pass"
	wp option add field_name_password --autoload=yes "$field_name_password"
	bg_attachment_id=`wp media import ./$skeletonfiles/wpcustomize_background.png --porcelain`
	bg_background_url=`wp db query "SELECT guid FROM $(wp db tables *_posts) WHERE ID=\"$bg_attachment_id\"" | head -n 2 | tail -1`
	wp option add wpcustomize_admin_login_background_url --autoload=yes "$bg_background_url"
	logo_attachment_id=`wp media import ./$skeletonfiles/wpcustomize_logo.png --porcelain`
	logo_background_url=`wp db query "SELECT guid FROM $(wp db tables *_posts) WHERE ID=\"$logo_attachment_id\"" | head -n 2 | tail -1`
	wp option add wpcustomize_admin_logo_image_url --autoload=yes "$logo_background_url"
	wp option add wpcustomize_admin_logo_width --autoload=yes "214"
	wp option add wpcustomize_admin_logo_height --autoload=yes "41"
	wp option add wpcustomize_admin_logo_area_width --autoload=yes "214"
	wp option add wpcustomize_admin_logo_area_height --autoload=yes "41"

	# update google-sitemap-generator options
	# note: google-sitemap-generator does not add the `sm_options` option until you visit the page in the admin, hence the below insanity...
	partialhash=`php -r "require './wp-load.php'; echo substr(sha1(sha1(get_bloginfo('url'))),0,20);"`
	phptime=`php -r 'echo time();'`
	wp option add sm_options --format=json '{"sm_b_prio_provider":"GoogleSitemapGeneratorPrioByCountProvider","sm_b_ping":true,"sm_b_stats":false,"sm_b_pingmsn":true,"sm_b_autozip":true,"sm_b_memory":"","sm_b_time":-1,"sm_b_style_default":true,"sm_b_style":"","sm_b_baseurl":"","sm_b_robots":true,"sm_b_html":true,"sm_b_exclude":{},"sm_b_exclude_cats":{},"sm_in_home":true,"sm_in_posts":true,"sm_in_posts_sub":false,"sm_in_pages":true,"sm_in_cats":false,"sm_in_arch":false,"sm_in_auth":false,"sm_in_tags":false,"sm_in_tax":false,"sm_in_customtypes":{},"sm_in_lastmod":true,"sm_cf_home":"daily","sm_cf_posts":"monthly","sm_cf_pages":"weekly","sm_cf_cats":"weekly","sm_cf_auth":"weekly","sm_cf_arch_curr":"daily","sm_cf_arch_old":"yearly","sm_cf_tags":"weekly","sm_pr_home":1,"sm_pr_posts":0.6,"sm_pr_posts_min":0.2,"sm_pr_pages":0.6,"sm_pr_cats":0.3,"sm_pr_arch":0.3,"sm_pr_auth":0.3,"sm_pr_tags":0.3,"sm_i_donated":false,"sm_i_hide_donated":false,"sm_i_install_date":1513222949,"sm_i_hide_survey":true,"sm_i_hide_note":false,"sm_i_hide_works":false,"sm_i_hide_donors":false,"sm_i_hash":"","sm_i_lastping":0,"sm_i_supportfeed":true,"sm_i_supportfeed_cache":false}'
	wp option patch update sm_options sm_i_install_date $phptime
	wp option patch update sm_options sm_i_hash $partialhash
	wp option patch update sm_options sm_i_hide_survey 1
	wp option patch update sm_options sm_b_style_default 0
	wp option patch update sm_options sm_b_style "/sitemap.xsl"
	wp option patch update sm_options sm_b_html 0

	# optionally set up dummy posts
	if [[ "$posts" == "true" ]]; then
		for i in {1..5}; do
			postid=`wp post create ./$skeletonfiles/post.txt --post_status='publish' --post_title='Modo altus saepe fecitque et seque' --porcelain`
			wp comment create --comment_post_ID=$postid --comment_content="Hello, world." --comment_author="wp-cli"
		done
	fi

	# optionally update core to beta version
	if [[ "$beta" == "true" ]]; then
		wp plugin install wordpress-beta-tester --activate
		wp option set wp_beta_tester_stream unstable
		wp core update
		wp core version --extra
	fi

	# perform final cleanup
	if [[ "$cleanup" == "true" ]]; then
		rm -rfv .git
		rm removewp.sh
		rm README.md
		cp $skeletonfiles/README.md .
		LC_ALL=C find ./README.md -type f -print -exec sed -i '' "s/SKEL_THEME_NAME/$theme_name/" {} \;
		rm -rfv $skeletonfiles
		rm installwp.sh
	fi

fi

# EOF
