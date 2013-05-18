Image randomise
===============

Random output (raw) image from directory.

1. Edit `image_index.sh` and **chmod +x** `image_index.sh`;
```
#!/bin/bash
...
dir=/foo/bar
```

2. Edit `random.php` or `random_v2.php` (fix path to image folder and url);
```
<?php
	//global variables
	/*   for example:
	define('IMAGE_DIR', 'nyaa_images/');
	$index = IMAGE_DIR.'index.ls';
	$url = 'http://server.tld/';
	*/
	define('IMAGE_DIR', '');
	$index = IMAGE_DIR.'index.ls';
	$url = '';
```

3. Rename `example.htaccess` to `.htaccess`;
4. Add `image_index.sh` in crontab for autoindex image files;
5. ?????
6. Nya~ ♥



<img src="https://raw.github.com/fastpoke/image_randomise/master/preview.png">
