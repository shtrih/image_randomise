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
	echo "<!DOCTYPE html>
<html>
	<head>
		<title>nyaa~ :: $name</title>
		<style type=\"text/css\">
			html {background: url(\"bg.png\") center repeat fixed;}
			.content {width: 800px; position: relative; margin: auto;}
			.img {padding-top: 20px; padding-bottom: 20px; max-height: 1000px;width: 800px; margin: 0 auto;}
			.img img {max-height: 1000px; max-width: 800px; margin: 0 auto; border: 1px solid rgba(0,0,0,0.1); text-align: center; display: block;}
			.share {width: 600px; text-align: center;}
			.link {display: block;}
			.gplus {display: block; float: left; padding-right: 5px;}
			input {height: 29px; width: 764px; background: #fff; border: 1px solid rgba(0,0,0,0.1);}
		</style>
	</head>
	<body>
		<div class=\"content\">
			<div class=\"share\">
				<a class=\"gplus\" href=\"https://plus.google.com/share?url=http://nyan.me/$img\" onclick=\"javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;\"><img src=\"https://www.gstatic.com/images/icons/gplus-32.png\" alt=\"Share on Google+\"/></a>
				<input autofocus readonly class=\"link\" type=\"text\" value=\"http://nyan.me/$img\">
			</div>
			<div class=\"img\">
				<a href=\"/$img\" alt=\"$name\" title=\"$name\"><img src=\"/$img\" alt=\"$name\" title=\"$name\"></a>
			</div>
		</div>
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
