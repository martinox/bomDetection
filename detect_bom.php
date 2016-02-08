<?php
define('BOM_STRING', pack("CCC", 0xef, 0xbb, 0xbf));
$bomDir = dirname(__FILE__);


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

function checkDirectory(&$dir){
	if(substr($dir, -1) !== '/'){
		//append slash
		$dir .= '/';
	}

	$dirHandle = opendir($dir);

	if($dirHandle !== false){
		while(($file = readdir($dirHandle)) !== false){
			if($file !== '..' && $file !== '.'){

				$fullfilename = $dir.$file;

				if(is_dir($fullfilename) === false){
					//check file for BOM
					echo $fullfilename;
					if(isUTF8BOM($fullfilename) !== false){
						echo ' contains BOM';
					}
					else{
						echo ' does not contain BOM';
					}
					echo PHP_EOL;
				}
				else{
					//check next directory
					checkDirectory($fullfilename);
				}
			}
		}

		closedir($dirHandle);

	}
}

checkDirectory($bomDir);

?>