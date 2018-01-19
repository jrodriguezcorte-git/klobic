<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config/settings.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/libraries/simple_html_dom.php');

$items = explode('/', $_SERVER['REQUEST_URI']);
$type = $items[sizeof($items) - 4]; // TYPE IF IT IS TEMPLATE OR BANNER
$hash = $items[sizeof($items) - 3];
$action = $items[sizeof($items) - 2];
$file = $items[sizeof($items) - 1];

if (strpos($file, '?') !== false) {
    $file = substr($file, 0, strpos($file, "?"));
}

$params = allParamsString();

if($type != 'templates') 
    $type = 'banners';
    
$query='SELECT id FROM templates WHERE hash=?';
$banner_list=pdoSelect($query, array($hash));

if ($banner_list != 'error' && $banner_list != 'empty'){
    $type = 'templates';
}   

if($file == 'index') $file = $file . '.html';

if($action == 'images'){
//     if($hash == 'embed'){
//         $hash = $items[sizeof($items) - 4];
//         $localFile = ROOT_FOLDER.'photos/'.$action.'/'.$file;
        
//         if (!file_exists($localFile)) {
//             require_once($_SERVER['DOCUMENT_ROOT'].'/php/saveImage.php');
//             $response = getImageRawData("http://cdn.bannersnack.com/banners/". $hash . "/embed/" .$action. "/" .$file . $params);
            
// // 			if (!file_exists(ROOT_FOLDER.'/photos/images/'.$hash)) {
// // 				makeDir('images/'.$hash);
// // 			}
			
//             if(PRODUCTION && $response['code'] == '200') 
//                 $imageSaver = new SaveImage(chunk_split(base64_encode($response['content'])), '/photos/'. $action .'/'. $file);
    
//             header('Content-type: '.$response['content_type']);
//             echo $response['content'];
//         } else {
//             header("Content-Length: " . filesize($localFile));
//             $file_info = new finfo(FILEINFO_MIME_TYPE);
//             $content = file_get_contents($localFile);
            
//             header('Content-type: '.$file_info->buffer($content));
//             readfile($localFile);
//             exit;
//         }
        
//         die();
//     }
    
    $localFile = ROOT_FOLDER.'photos/'.$type.'/'.$hash.'.png';
	$query='SELECT banner,paid FROM banners WHERE hash=?';
	$banner_list=pdoSelect($query, array($hash));
	
	if ($banner_list != 'error' && $banner_list != 'empty'){
        $bannerJson = json_decode($banner_list[0]['banner']);
        $bannerName = $bannerJson->properties->name;
	    $paid = $banner_list[0]['paid'];
        
	} else {
	    $paid = 1;
	    $bannerName = $hash;
	    $bannerJson = array();
	    
	}
	
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
    
    if($file == 'gif')
        $file = 'gif';
    else if($file == 'jpg')
        $file = 'jpg'; 
    else
        $file = 'png'; 
    
    if($_GET['download']) {
        header("Content-Disposition: attachment; filename=" . $bannerName . '.' . $file);
        header('Content-Transfer-Encoding: binary');
    }
    
    if (!file_exists($localFile)) {
        require_once($_SERVER['DOCUMENT_ROOT'].'/php/saveImage.php');
        $response = getImageRawData("https://creator.klobic.com/banners/". $hash . "/" . $action . "/" .$file . $params);
        
        if(PRODUCTION && $response['code'] == '200') 
            $imageSaver = new SaveImage(chunk_split(base64_encode($response['content'])), '/photos/'.$type.'/'.$hash.'.png');

        header('Content-type: '.$response['content_type']);
        echo $response['content'];
        
    } else {
        if($file == 'gif'){
            // if($bannerJson)
            $numberOfSlides = count($bannerJson->elements);
            
            require_once($_SERVER['DOCUMENT_ROOT'].'/php/saveImage.php');
            require_once($_SERVER['DOCUMENT_ROOT'].'/php/renderBanner.php');
            require_once($_SERVER['DOCUMENT_ROOT'].'/php/libraries/GifCreator.php');
            
            // Create an array containing file paths, resource var (initialized with imagecreatefromXXX), 
            // image URLs or even binary code from image files.
            // All sorted in order to appear.
            $frames = array();
            
            // Create an array containing the duration (in millisecond) of each frames (in order too)
            $durations = array();
            $infiniteLoop = 0;
            
            for($i=0; $i<$numberOfSlides; $i++){
                $render = new RenderBanner($hash, $i);
                $image = $render->getImage(true);
    		    $imageSaver = new SaveImage($image, '/photos/banners/'.$hash.'_'.$i.'.png');
	            array_push($frames, ROOT_FOLDER.'/photos/banners/'.$hash.'_'.$i.'.png');
	            array_push($durations, ($bannerJson->elements[$i]->properties->duration*100));
	            if($infiniteLoop != '1')
	                $infiniteLoop = $bannerJson->elements[$i]->properties->stopSlide;
            }
            
            if(empty($infiniteLoop)) $infiniteLoop = 0;
            
            // Initialize and create the GIF !
            $gc = new GifCreator();
            $gc->create($frames, $durations, $infiniteLoop, $paid);
            header('Content-type: image/gif');
            // header('Content-Disposition: filename="'.$bannerName.'.gif"');
            echo $gc->getGif();
            exit;
            die();
        }
        
        if(!$paid){
            // Load the stamp and the photo to apply the watermark to
            $source = @imagecreatefromstring(file_get_contents($localFile));
            // load the image you want to you want to be watermarked
            $watermark = imagecreatefrompng(ROOT_FOLDER.'images/logo-transparent.png');
            
            // get the width and height of the watermark image
            $water_width = imagesx($watermark);
            $water_height = imagesy($watermark);
            
            // get the width and height of the main image image
            $main_width = imagesx($source);
            $main_height = imagesy($source);
            
            if($main_height > 90)
                // resize watermark to half-width of the image
                $new_height = $main_height-((70*$main_height)/100);//round($water_height * $main_width / $water_width / 2);
            else 
                $new_height = $main_height-((30*$main_height)/100);//round($water_height * $main_width / $water_width / 2);
                
            $ratio = $water_width/$water_height; // width/height
            if( $ratio > 1) {
                $new_width = $new_height;
                $new_height = $new_height/$ratio;
            }
            else {
                $new_width = $new_height*$ratio;
                $new_height = $new_height;
            }
            
            $new_watermark = imagecreatetruecolor($new_width, $new_height);


            $color = imagecreatetruecolor($main_width, $main_height);
            
            // something to get a white background with black border
            // rgba(181, 181, 181, 0.45)
            $back = imagecolorallocatealpha($color, 181, 181, 181, 57);
            // keep transparent background
            imagealphablending( $color, false );
            imagesavealpha( $color, true );
            imagefilledrectangle($color, 0, 0, $main_width, $main_height, $back);

            imagecopy($source, $color, 0, 0, 0, 0, $main_width, $main_height);

            // keep transparent background
            imagealphablending( $new_watermark, false );
            imagesavealpha( $new_watermark, true );
            
            imagecopyresampled($new_watermark, $watermark, 0, 0, 0, 0, $new_width, $new_height, $water_width, $water_height);
            
            // Set the dimension of the area you want to place your watermark we use 0
            // from x-axis and 0 from y-axis 
            $dime_x = round(($main_width - $new_width)/2);
            $dime_y = round(($main_height - $new_height)/2);
            
            // copy both the images
            imagecopy($source, $new_watermark, $dime_x, $dime_y, 0, 0, $new_width, $new_height);
            
            // Final processing Creating The Image
            if($file == 'jpg'){
                header('Content-type: image/jpg');
                imagejpeg($source);
            } else {
                header('Content-type: image/png');
                imagepng($source);
            }
            
            imagedestroy($source);
            imagedestroy($watermark);
            imagedestroy($new_watermark);
        } else {
            $image = @imagecreatefromstring(file_get_contents($localFile));
            
            if($file == 'jpg'){
                header('Content-type: image/jpg');
                imagejpeg($image);
            } else {
                header('Content-type: image/png');
                imagepng($image);
            }
                
            imagedestroy($image);
            
            // header("Content-Length: " . filesize($localFile));
            // header('Content-type: image/'.$file);
            // readfile("$localFile");
            
            exit;
        }
    }
    
    
    die();
    // echo '<img src="data:image/png;base64,' . base64_encode($response) . '">';
}

// $response = get_web_page("http://cdn.bannersnack.com/banners/bxma7q2ep/embed/index.html");

if($action == 'embed'){
	$query='SELECT * FROM banners WHERE hash=?';
	$banner_list=pdoSelect($query, array($hash));
	$items = array();
	
	if ($banner_list == 'empty'){
    	$query='SELECT * FROM templates WHERE hash=?';
    	$banner_list=pdoSelect($query, array($hash));
	}
	
	if ($banner_list != 'error' && $banner_list != 'empty'){
        $bannerJson = $banner_list[0];
        $bannerJson['banner'] = json_decode($banner_list[0]['banner']);
       
        // if($_GET[HTTP_GET_SECRET] == HTTP_GET_SECRET_TOKEN)
            // $bannerJson['paid'] = true;
        
        $bannerJson = json_encode($bannerJson);
	    
	} else {
        $response = get_web_page("https://creator.klobic.com/banners/". $hash . "/" . $action . "/" .$file . $params);
        $html = str_get_html($response);
        $script_tag = $html->find('script', 1)->innertext;
        
        if (preg_match('/var bannerJson = (.*?);/', $script_tag, $matches)){
            $bannerJson = $matches[1];
            
            if(PRODUCTION && $response['code'] == '200') {
    			$query = 'INSERT INTO templates (hash, banner) VALUES (?, ?)';
    			$result = pdoSet($query, array($hash, $bannerJson));
            }
                
            // echo $bannerJson;
    
            // $data = json_decode($matches[1]);
            // print_r($data);
        }
	}
	
	$isPreview = 'no';
	
    include_once($_SERVER['DOCUMENT_ROOT'].'/preview/index.php');
    die();
}
