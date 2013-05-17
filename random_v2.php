<?php
	//global variables
	define('SITE_URL', 'http://hitagi.ru');  // Site url ( define('SITE_URL', 'http://server.tld'); for example )
	define('IMAGE_DIR', dirname(__FILE__).'/i/'); // Images directory with end slash ( define('IMAGE_DIR', '/nyaa_images/'); for example )
	$index = IMAGE_DIR.'index.ls';
	$extList = array(
		'gif'  => 'image/gif',
		'jpg'  => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'png'  => 'image/png'
	);
	$img = null;

if (isset($_GET['img'])) {
	$imageInfo = pathinfo($_GET['img']);
	if (
	    isset( $extList[ strtolower( $imageInfo['extension'] ) ] ) &&
        file_exists( IMAGE_DIR.$imageInfo['basename'] )
    ) {
		$img = IMAGE_DIR.$imageInfo['basename'];
	}
} else {
	$imageIndex = file($index, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$img = IMAGE_DIR.$imageIndex[array_rand(file($index))];
}

if (is_null($img)) {
	$imageInfo = pathinfo($img);
	$name = $imageInfo['basename'];
	$size = round(filesize($img) / 1024, 0);
	$resolution = getimagesize($img);
	$width  = $resolution [0];
	$height = $resolution [1];
	echo '<!-- current version: 0.8 -->
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Cache-control" content="must-revalidate">
		<meta name="generator" content="cat /dev/urandom > random~" />
		<title>nyaa~ '.$name.'</title>
		<link href="css/random.css" rel="stylesheet" media="all" />
	</head>
	<body>
		<a href="https://github.com/fastpoke/image_randomise"><img class="github" src="img/github.png"></a>
		<div class="content">
			<div class="share">
				<a class="gplus" href="https://plus.google.com/share?url='.SITE_URL.$img.'" onclick="javascript:window.open(this.href,\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;"><img src="img/gplus.png" alt="Share on Google+" title="Share on Google+"/></a>
				<img class="reload" src="img/reload.png" onClick="window.location.reload(false);" title="Reload page">
				<input readonly class="link" id="copy" type="text" value="'.SITE_URL.$img.'" onclick="this.select()">
			</div>
			<div class="info"><span>'.$width.' &times; '.$height.' px &nbsp;&nbsp;@&nbsp;&nbsp; '.$size.' Kb</span></div>
			<div class="img">
					<img src="'.$img.'" alt="'.$name.'" title="'.$name.'">
			</div>
		</div>
		<div class="footer"><a href="http://fastpoke.org/" target="_blank">neko power solutions~</a> at <a href="http://nyan.me/" target="_blank">nyan.me</a></div>
	</body>
</html>';
} else {
	header('HTTP 1.0 404 Not found', true, 404);
	echo '<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Cache-control" content="must-revalidate">
		<meta name="generator" content="cat /dev/urandom > random~" />
		<link rel="icon" href="img/9.png" type="image/x-png" />
		<link href="css/random.css" rel="stylesheet" media="all" />
		<title>nyaa~ error</title>
		</head>
	<body>
		<a href="https://github.com/fastpoke/image_randomise"><img class="github" src="img/github.png"></a>
		<div class="content">
			<div class="error">
			<span>Oops~! Something is broken ._.</span>
			</div>
		</div>
		<div class="footer"><span><a href="http://fastpoke.org/" target="_blank">neko power solutions~</a> at <a href="http://nyan.me/" target="_blank">nyan.me</a></span></div>
	</body>
</html>';
}

?>
