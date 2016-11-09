#!/bin/sh

# update wordpress

check_update=`wp core check-update`

if [[ "$check_update" != "" ]] && [[ "$check_update" != *"Success"* ]]; then
	wp core update
fi

# EOF
