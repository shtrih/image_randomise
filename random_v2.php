<?php
	//global variables
	define('SITE_URL', 'http://hitagi.ru');                   // Site url ( define('SITE_URL', 'http://server.tld'); for example )
	define('SITE_REAL_DIR', '/'.basename(dirname(__FILE__))); // Url to resources (css, images)
	define('IMAGE_DIR', './../i/');             // Images directory with end slash ( define('IMAGE_DIR', '/nyaa_images/'); for example )
	define('IMAGE_URL', '/i/');             // Images directory with end slash ( define('IMAGE_DIR', '/nyaa_images/'); for example )
	$index = './index.ls';
	$extList = array(
		'gif'  => 'image/gif',
		'jpg'  => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'png'  => 'image/png'
	);

if (isset($_GET['img'])) {
	$imageInfo = pathinfo($_GET['img']);
	if (
	    isset( $extList[ strtolower( $imageInfo['extension'] ) ] ) &&
        file_exists( IMAGE_DIR.$imageInfo['basename'] )
    ) {
		$img = IMAGE_DIR.$imageInfo['basename'];
	}
} else {
	$imageIndex = file("$index", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$img = IMAGE_DIR.$imageIndex[array_rand(file($index))];
}

if (is_null($img)) {
	header('HTTP 1.0 404 Not found', true, 404);
	echo '<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Cache-control" content="must-revalidate">
		<meta name="generator" content="cat /dev/urandom › random~" />
		<link rel="icon" href="'.SITE_REAL_DIR.'/img/9.png" type="image/x-png" />
		<link href="'.SITE_REAL_DIR.'/css/random.css" rel="stylesheet" media="all" />
		<title>nyaa~ error</title>
		</head>
	<body>
		<a href="https://github.com/fastpoke/image_randomise"><img class="github" src="'.SITE_REAL_DIR.'/img/github.png" /></a>
		<div class="content">
			<div class="error">
			<span>Oops~! Something is broken ._.</span>
			</div>
		</div>
		<div class="footer"><a href="http://fastpoke.org/" target="_blank">neko power solutions~</a> at <a href="'.SITE_URL.'" target="_blank">'.SITE_URL.'</a></div>
	</body>
</html>';
} else {
	$imageInfo = pathinfo($img);
	$name = $imageInfo['basename'];
	$size = round(filesize($img) / 1024, 0);
	$resolution = getimagesize($img);
	$width  = $resolution [0];
	$height = $resolution [1];
	echo '<!DOCTYPE html>
<html>
	<head>
		<!-- current version: 1.0 -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Cache-control" content="must-revalidate">
		<meta name="generator" content="cat /dev/urandom › random~" />
		<title>nyaa~ '.$name.'</title>
		<link href="'.SITE_REAL_DIR.'/css/random.css" rel="stylesheet" media="all" />
	</head>
	<body>
		<a href="https://github.com/fastpoke/image_randomise"><img class="github" src="'.SITE_REAL_DIR.'/img/github.png" /></a>
		<div class="content">
			<div class="share">
				<a class="gplus" href="https://plus.google.com/share?url='.SITE_URL.IMAGE_URL.$name.'" onclick="javascript:window.open(this.href,\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;"><img src="'.SITE_REAL_DIR.'/img/gplus.png" alt="Share on Google+" title="Share on Google+"/></a>
				<img class="reload" src="'.SITE_REAL_DIR.'/img/reload.png" onClick="window.location.reload(false);" title="Reload page" />
				<input readonly class="link" id="copy" type="text" value="'.SITE_URL.IMAGE_URL.$name.'" onclick="this.select()" />
			</div>
			<div class="info"><span>'.$width.' &times; '.$height.' px &nbsp;&nbsp;@&nbsp;&nbsp; '.$size.' Kb</span></div>
			<div class="img">
				<img src="'.SITE_URL.IMAGE_URL.$name.'" alt="'.$name.'" title="'.$name.'" />
			</div>
		</div>
		<div class="footer"><a href="http://fastpoke.org/" target="_blank">neko power solutions~</a> at <a href="'.SITE_URL.'" target="_blank">'.SITE_URL.'</a></div>
	</body>
</html>';
}
?>
