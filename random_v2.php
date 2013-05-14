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
	echo "<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
		<title>nyaa~ $name</title>
		<style type=\"text/css\">
			html {background: url(\"bg.png\") center repeat scroll;}
			.content {width: 800px; position: relative; margin: auto;}
			.share {width: 800px; text-align: center; padding-top: 10px;}
			.link {height: 29px; width: 746px; background: #fff; border: 1px solid rgba(0,0,0,0.1); padding-left: 10px; display: block;}
			.gplus {display: block; float: left; margin-right: 10px; width: 32px; height: 32px;}
			.info {width: 800px; height: 20px; font-family: Arial; font-size: 10px; text-align: center;}
			.info span {display: block; margin-top: 4px;}
			.img {padding-top: 0px; padding-bottom: 10px; margin: 0 auto; width: 800px;}
			.img img {max-width: 798px; max-height: 1000px; margin: 0 auto; border: 1px solid rgba(0,0,0,0.1); display: block;}
			.footer {font-family: Arial; font-size: 10px; color: rgba(0,0,0,0.5); text-align: center; padding: 10px 0 10px 0;}
			.footer a {color: rgba(0,0,0,0.5); text-decoration: none;}
			.footer a:hover {color: #f00; text-decoration: none;}
		</style>
	</head>
	<body>
		<a href=\"https://github.com/fastpoke/image_randomise\"><img style=\"position: absolute; top: 0; right: 0; border: 0;\" src=\"github.png\"></a>
		<div class=\"content\">
			<div class=\"share\">
				<a class=\"gplus\" href=\"https://plus.google.com/share?url=http://nyan.me/$img\" onclick=\"javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;\"><img src=\"https://www.gstatic.com/images/icons/gplus-32.png\" alt=\"Share on Google+\"/></a>
				<input autofocus readonly class=\"link\" type=\"text\" value=\"http://nyan.me/$img\">
			</div>
			<div class=\"info\"><span>$width &times; $height px &nbsp;&nbsp;@&nbsp;&nbsp; $size Kb</span></div>
			<div class=\"img\">
					<img src=\"/$img\" alt=\"$name\" title=\"$name\">
			</div>
		</div>
		<div class=\"footer\"><a href=\"http://fastpoke.org/\" target=\"_blank\">neko power solutions~</a></div>
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
