#!/bin/bash
tmpfile=`mktemp`
index_dir=`pwd`
pic_dir=$index_dir/../i

cd $pic_dir && find . -type f | egrep -i "png|jpg|jpeg|gif" | sed 's/^.\///g' | sort > $tmpfile
mv $tmpfile $index_dir/index.ls && chmod 775 $index_dir/index.ls

exit 0
