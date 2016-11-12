#!/bin/bash

# configure
timezone="America/Denver"
mysqlconfig="$HOME/.my.cnf"
gruntskeleton="./grunt-skeleton"
dbhost="localhost"
dbname="newsitedb"
dbuser="root"
dbprefix="wp_"
site_title="My New Site"
site_url="http://installwp.localhost"
admin_user="neo"
admin_pass="matrix"
admin_email="foo@domain.com"
theme_name="My Theme"
theme_slug="my-theme"
theme_prefix="my_theme"
theme_url="http://domain.com"
theme_author="John Doe"
theme_author_url="http://domain.com"
theme_version="1.0.0"

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
            echo "Memorable Usage: $0 [ --delete | --posts | --cleanup | --beta ]"
            echo "Shorthand Usage: $0 [ --d | --p | --c | --b ]"
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

# check if the wp command is available
grunt_cmd_check=`type wp`
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
    cp $gruntskeleton/gruntfile.js .
    cp $gruntskeleton/package.json .
    cp $gruntskeleton/config.yml .
    cp $gruntskeleton/wp-config-remote.php .
    cp $gruntskeleton/wp-config-local.php .
    mkdir ./wp-content/themes/$theme_slug
    cp -Rv $gruntskeleton/theme/ ./wp-content/themes/$theme_slug

    # perform string replacements
    find ./gruntfile.js -type f -print -exec sed -i '' "s/SKEL_THEME_SLUG/$theme_slug/" {} \;
    find ./package.json -type f -print -exec sed -i '' "s/SKEL_THEME_SLUG/$theme_slug/" {} \;
    find ./package.json -type f -print -exec sed -i '' "s/SKEL_THEME_VERSION/$theme_version/" {} \;
    LC_ALL=C find ./wp-content/themes/$theme_slug/* -type f -print -exec sed -i '' "s/SKEL_THEME_NAME/$theme_name/" {} \;
    LC_ALL=C find ./wp-content/themes/$theme_slug/* -type f -print -exec sed -i '' "s|SKEL_THEME_URL|$theme_url|" {} \;
    LC_ALL=C find ./wp-content/themes/$theme_slug/* -type f -print -exec sed -i '' "s|SKEL_THEME_AUTHOR_URL|$theme_author_url|" {} \;
    LC_ALL=C find ./wp-content/themes/$theme_slug/* -type f -print -exec sed -i '' "s/SKEL_THEME_AUTHOR/$theme_author/" {} \;
    LC_ALL=C find ./wp-content/themes/$theme_slug/* -type f -print -exec sed -i '' "s/SKEL_THEME_VERSION/$theme_version/" {} \;
    LC_ALL=C find ./wp-content/themes/$theme_slug/* -type f -print -exec sed -i '' "s/SKEL_THEME_SLUG/$theme_slug/" {} \;
    LC_ALL=C find ./wp-content/themes/$theme_slug/* -type f -print -exec sed -i '' "s/SKEL_THEME_PREFIX/$theme_prefix/" {} \;

    # install packages
    npm install

    # run grunt
    grunt --verbose --debug build

    # activate theme
    wp theme activate $theme_slug

    # remove default plugins
    rm -rfv ./wp-content/plugins/*

    # copy plugins
    cp -Rv $gruntskeleton/plugins/* ./wp-content/plugins

    # activate any plugins in plugins directory
    for plugindir in `find $gruntskeleton/plugins/* -type d -maxdepth 0`
    do
        wp plugin activate `basename $plugindir`
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
    wp rewrite flush

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

    # optionally set up dummy posts
    if [[ "$posts" == "true" ]]; then
        for i in {1..5}; do
            postid=`wp post create ./$gruntskeleton/post.md --post_status='publish' --post_title='Modo altus saepe fecitque et seque Cecropio' --porcelain`
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
        rm -rfv $gruntskeleton
        rm removewp.sh
        rm installwp.sh
        rm README.md
        cp $gruntskeleton/README.md .
    fi

fi

# EOF
