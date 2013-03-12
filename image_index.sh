#!/bin/bash
tmpfile=`mktemp`
dir=/foo/bar

cd $dir && ls -1 | egrep "png|PNG|jpg|JPG|jpeg|JPEG|gif|GIF" | sort > $tmpfile
mv $tmpfile $dir/index.ls && chmod 775 $dir/index.ls

exit 0
