<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/header.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/config/settings.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');

$items = explode('/', $_SERVER['REQUEST_URI']);
$type = $items[sizeof($items) - 2];
$file = $items[sizeof($items) - 1];
$params = allParamsString();

$localFile = ROOT_FOLDER.'photos/textures/'. $type .'_'. $file .'.png';

header('Content-type: image/png');

if (!file_exists($localFile)) {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/saveImage.php');
    $response = getImageRawData("https://creator.klobic.com/textures/". $type .'/'. $file . $params);
    
    if(PRODUCTION && $response['code'] == '200') 
        $imageSaver = new SaveImage($response['content'], '/photos/textures/'. $type .'_'. $file .'.png');
        
    echo $response['content'];
    
} else {
    header("Content-Length: " . filesize($localFile));
    $file_info = new finfo(FILEINFO_MIME_TYPE);
    $content = file_get_contents($localFile);
    
    header('Content-type: '.$file_info->buffer($content));
    readfile($localFile);
    exit;
}

die();