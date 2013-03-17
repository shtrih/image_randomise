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
    //+Rei Ayanami randomise engine fix
    $imageIndex = file($index);
    $imageResult = $imageIndex[array_rand(file($index))];
}
	//dirty '\n' hack /._.\
	$fileList = rtrim($imageResult, " \n");
	$img = $folder.$fileList;

if ($img!=null) {
	//set headers and image output
	$imageInfo = pathinfo($img);
	$contentType = 'Content-type: '.$extList[ $imageInfo['extension'] ];
	$contentLength = 'Content-Length: '.filesize($img);
	$name = 'Content-Disposition: inline; filename="'.$imageInfo['basename'].'"';
	header ($contentType);
	header ($contentLength);
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
