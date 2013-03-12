<?php

	$folder = '/foo/bar/';
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

	function rand_line($fileName, $maxLineLength = 4096) {
    $handle = @fopen($fileName, "r");
    if ($handle) {
        $random_line = null;
        $line = null;
        $count = 0;
        while (($line = fgets($handle, $maxLineLength)) !== false) {
            $count++;
            if(rand() % $count == 0) {
              $random_line = $line;
            }
        }
        if (!feof($handle)) {
            echo "Error: unexpected fgets() fail";
            fclose($handle);
            return null;
        } else {
            fclose($handle);
        }
        return $random_line;
    }
}

	$fileList = trim(preg_replace('/[\r\n]+/m','',rand_line("/foo/bar/index.ls"))); 
	$img = $folder.$fileList;
}

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
