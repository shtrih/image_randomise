#!/bin/bash
tmpfile=`mktemp`
dir=/foo/bar

cd $dir && find . -type f | sed 's/^.\///g' | egrep -i "png|jpg|jpeg|gif" | sort > $tmpfile
mv $tmpfile $dir/index.ls && chmod 775 $dir/index.ls

exit 0
