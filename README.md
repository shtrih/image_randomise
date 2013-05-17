Image randomise
===============

Random output (raw) image from directory.

1. Edit `image_index.sh` and **chmod +x** `image_index.sh`;
```
#!/bin/bash
...
dir=/foo/bar
```

2. Edit `random.php` (fix path to image folder);
```
<?php
//global variables
/*   for example:
$url = 'http://server.tld/';
$folder = '/nyaa_images/';
*/
$url = '';
$folder = '';
```

3. Rename `example.htaccess` to `.htaccess`;
4. Add `image_index.sh` in crontab for autoindex image files;
5. ?????
6. Nya~ ♥



<img src="https://raw.github.com/fastpoke/image_randomise/master/preview.png">
