<?php
	//global variables
	/*   for example:
	define('IMAGE_DIR', './nyaa_images/'); // images directory (with end slash)
	$index = IMAGE_DIR.'index.ls';
	*/
	define('IMAGE_DIR', '');
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
	//+Rei Ayanami and +Kot Obormot randomise engine fix
	$imageIndex = file($index, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$img = IMAGE_DIR.$imageIndex[array_rand(file($index))];
}

if (is_null($img)) {
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
} else {
	//set headers and image output
	$imageInfo = pathinfo($img);
	header('Content-type: '.$extList[ $imageInfo['extension'] ]);
	header('Content-Length: '.filesize($img));
	header('Content-Disposition: inline; filename="'.$imageInfo['basename'].'"');
	header('Cache-Control: no-cache');
	readfile ($img);
}

?>
