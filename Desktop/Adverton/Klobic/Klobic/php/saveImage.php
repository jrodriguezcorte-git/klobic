<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/config/settings.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');

/**
 * Class SaveImage
 * handles the images save process
 */
class SaveImage
{
    public function __construct($img, $destination, $fileType = 'image/png')
    {	
		if (isset($img) && isset($destination)) {
			// if (!preg_match("/banners/", $destination) && !preg_match("/files/", $destination) && !preg_match("/templates/", $destination)) {
			// 	$destination_file_parts=explode('/',$destination);
			// 	$year_folder = $destination_file_parts[2];
			// 	$month_folder = $destination_file_parts[3];
				
			// 	if (!file_exists(ROOT_FOLDER.'/photos/'.$year_folder)) {
			// 		makeDir($year_folder);
			// 	}
			// 	if (!file_exists(ROOT_FOLDER.'/photos/'.$year_folder.$month_folder)) {
			// 		makeDir($year_folder.$month_folder);
			// 	}
				
			// } 
			
			if (!file_exists(ROOT_FOLDER.'/photos/textures/')) {
				makeDir("textures/");
			}
			
			if (!file_exists(ROOT_FOLDER.'/photos/templates/')) {
				makeDir("templates/");
			}
			
			if (!file_exists(ROOT_FOLDER.'/photos/banners/')) {
				makeDir("banners/");
			}
			
			if (!file_exists(ROOT_FOLDER.'/photos/files/')) {
				makeDir("files/");
			}
			
			if (!file_exists(ROOT_FOLDER.'/photos/images/')) {
				makeDir("images/");
			}
			
			if(preg_match("/files/", $destination) || preg_match("/textures/", $destination))
				file_put_contents(ROOT_FOLDER.$destination, $img);
				
			else
				file_put_contents(
					ROOT_FOLDER.$destination,
					base64_decode( 
						str_replace('data:'.$fileType.';base64,', '', $img)
					)
				);
			
			
			return true;
		} else {
			return false;
		}
		
		//move_uploaded_file($_FILES["file"]["tmp_name"], ROOT_FOLDER.$destination);
		//echo '/photos/'.$year_folder.$month_folder.$destination;
    }
}
?>
