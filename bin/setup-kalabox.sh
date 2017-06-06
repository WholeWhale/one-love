#!/bin/bash

BASEDIR="$(basename `pwd`)"
KBOX_DIR="$BASEDIR-kbox"
pushd ..
kbox create pantheon -- --name=$KBOX_DIR --env=dev
pushd $KBOX_DIR
kbox stop
rm -rf code
ln -s ../$BASEDIR code
sed -i'' 's/\/code/\/code\/web/g' config/nginx/wordpress.conf
sed -i'' 's/php: 56/php: 70/g' kalabox.yml
sed -i'' 's/php: 56/php: 70/g' kalabox.yml
kbox rebuild
kbox restart

popd
popd

[ -d 'web/wp-wp-content/mu-plugins' ] && rsync -a web/wp/wp-content/mu-plugins/* web/wp-content/mu-plugins/
[ -f 'web/wp/wp-config.php' ] && rm -rf ./web/wp/wp-config.php
[ -d 'web/wp/wp-content' ] && rm -rf ./web/wp/wp-content
