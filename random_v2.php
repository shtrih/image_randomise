<?php
	//global variables
	$folder = '/foo/bar/';
	$index = $folder.'index.ls';
	$extList = array();
	$extList['gif'] = 'image/gif';
	$extList['jpg'] = 'image/jpeg';
	$extList['jpeg'] = 'image/jpeg';
	$extList['png'] = 'image/png';
	$img = null;

if (substr($folder,-1) != '/') {
	$folder = $folder.'/';
}

if (isset($_GET['img'])) {
	$imageInfo = pathinfo($_GET['img']);
	if (
	    isset( $extList[ strtolower( $imageInfo['extension'] ) ] ) &&
        file_exists( $folder.$imageInfo['basename'] )
    ) {
		$img = $folder.$imageInfo['basename'];
	}
} else {
	$imageIndex = file("$index", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$img = $folder.$imageIndex[array_rand(file($index))];
}

if ($img!=null) {
	$imageInfo = pathinfo($img);
	$name = $imageInfo['basename'];
	$fsize = filesize("$img");
	$size = (int)($fsize/1024);
	$resolution = getimagesize("$img");
	$width  = $resolution [0];
	$height = $resolution [1];
	echo "<!-- current version: 0.7 -->
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
		<meta http-equiv=\"Cache-control\" content=\"must-revalidate\">
		<meta name=\"generator\" content=\"cat /dev/urandom > random~\" />
		<title>nyaa~ $name</title>
		<link href=\"css/random.css\" rel=\"stylesheet\" media=\"all\" />
	</head>
	<body>
		<a href=\"https://github.com/fastpoke/image_randomise\"><img class=\"github\" src=\"/img/github.png\"></a>
		<div class=\"content\">
			<div class=\"share\">
				<a class=\"gplus\" href=\"https://plus.google.com/share?url=http://nyan.me/$img\" onclick=\"javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;\"><img src=\"img/gplus.png\" alt=\"Share on Google+\" title=\"Share on Google+\"/></a>
				<img class=\"reload\" src=\"img/reload.png\" onClick=\"window.location.reload(false);\" title=\"Reload page\">
				<input readonly class=\"link\" id=\"copy\" type=\"text\" value=\"http://nyan.me/$img\" onclick=\"this.select()\">
			</div>
			<div class=\"info\"><span>$width &times; $height px &nbsp;&nbsp;@&nbsp;&nbsp; $size Kb</span></div>
			<div class=\"img\">
					<img src=\"/$img\" alt=\"$name\" title=\"$name\">
			</div>
		</div>
		<div class=\"footer\"><a href=\"http://fastpoke.org/\" target=\"_blank\">neko power solutions~</a> at <a href=\"http://nyan.me/\" target=\"_blank\">nyan.me</a></div>
	</body>
</html>";
} else {
	if ( function_exists('imagecreate') ) {
		header ('Content-type: image/png');
		$im = @imagecreate (100, 100)
		    or die ("Cannot initialize new GD image stream");
		$background_color = imagecolorallocate ($im, 255, 255, 255);
		$text_color = imagecolorallocate ($im, 0,0,0);
		imagestring ($im, 2, 5, 5,  "IMAGE ERROR", $text_color);
		imagepng ($im);
		imagedestroy($im);
	}
}

?>
