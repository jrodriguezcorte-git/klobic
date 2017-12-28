<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/header.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/config/settings.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');

// $email = $_SESSION['user_email'];
// $query='SELECT id FROM users WHERE email=?';
// $user_list=pdoSelect($query, array($email));

// if ($user_list != 'error' && $user_list != 'empty'){
//     $user_id = $user_list[0]['id'];
    
// } else {
//     echo '{"code":501,"res":"Your session has expired. Please <a target=\"_blank\" href=\"\/auth\/login\/\">log in<\/a> again."}';
//     die();
// }

$items = explode('/', $_SERVER['REQUEST_URI']);
$file = $items[sizeof($items) - 1];
$params = allParamsString();
$extension = 'png';

$query='SELECT * FROM images WHERE hash=?';
$images_list=pdoSelect($query, array($file));

if ($images_list != 'error' && $images_list != 'empty'){
    $extension = $images_list[0]['type'];
}

$localFile = ROOT_FOLDER.'photos/files/'.$file.'.'.$extension;

header('Content-type: image/'.$extension);
    
if (!file_exists($localFile)) {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/saveImage.php');
    $response = getImageRawData("https://cdn.bannersnack.com/files/". $file . $params);
    
    if(PRODUCTION && $response['code'] == '200') 
        $imageSaver = new SaveImage($response['content'], '/photos/files/'.$file.'.png');

    header('Content-type: '.$response['content_type']);
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