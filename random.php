<?php

	$folder = '/foo/bar/';
	$index = $folder.'index.sqlite';
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

    $imageIndex = file($index);
    $imageRandom = array_rand($imageIndex);
    $imageResult = $imageIndex[$imageRandom];
}

	$fileList = trim(preg_replace('/[\r\n]+/m','',$imageResult)); 
	$img = $folder.$fileList;

if ($img!=null) {
	$imageInfo = pathinfo($img);
	$contentType = 'Content-type: '.$extList[ $imageInfo['extension'] ];
	$name = 'Content-Disposition: inline; filename="'.$imageInfo['basename'].'"';
	header ($contentType);
	header ($name);
	readfile ($img);

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
