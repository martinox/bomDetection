<?php
define('BOM_STRING', pack("CCC", 0xef, 0xbb, 0xbf));

function isUTF8BOM(&$file){
	$handle = fopen($file);
	
	if($handle !== false){
		//read first three bytes
		$content = fread($handle, 3);
		if($content !== false && strncmp($content, BOM_STRING, 3) == 0){
			fclose($handle);
			return true;
		}

		fclose($handle);

	}

	return false;
}

?>