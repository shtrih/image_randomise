#!/bin/bash
tmpfile=`mktemp`
dir=`pwd`/i

cd $dir && find . -type f | egrep -i "png|jpg|jpeg|gif" | sed 's/^.\///g' | sort > $tmpfile
mv $tmpfile $dir/index.ls && chmod 775 $dir/index.ls

exit 0
