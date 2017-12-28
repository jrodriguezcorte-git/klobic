<?php
require_once("connection.php");
$connection->beginTransaction();
function typeOfBanner($data){
    $a = 'animated';
    
    if(strpos($data, '"transition":{"type":"alpha"') !== false)
        return $a;
    if(strpos($data, '"transition":{"type":"blur"') !== false)
        return $a;
    if(strpos($data, '"transition":{"type":"slide"') !== false)
        return $a;
    if(strpos($data, '"transition":{"type":"scale"') !== false)
        return $a;
            
            
    if(strpos($data, '"buildIn":{"type":"alpha"') !== false)
        return $a;
    if(strpos($data, '"buildIn":{"type":"alpha-words"') !== false)
        return $a;
    if(strpos($data, '"buildIn":{"type":"blur"') !== false)
        return $a;
    if(strpos($data, '"buildIn":{"type":"blur-words"') !== false)
        return $a;
    if(strpos($data, '"buildIn":{"type":"slide"') !== false)
        return $a;
    if(strpos($data, '"buildIn":{"type":"scale"') !== false)
        return $a;
        
            
    if(strpos($data, '"buildOut":{"type":"alpha"') !== false)
        return $a;
    if(strpos($data, '"buildOut":{"type":"alpha-words"') !== false)
        return $a;
    if(strpos($data, '"buildOut":{"type":"blur"') !== false)
        return $a;
    if(strpos($data, '"buildOut":{"type":"blur-words"') !== false)
        return $a;
    if(strpos($data, '"buildOut":{"type":"slide"') !== false)
        return $a;
    if(strpos($data, '"buildOut":{"type":"scale"') !== false)
        return $a;
            
    return 'static';
}

                // "id":"27518096",
                // "screenname":"Jonathan Lovera",
                // "displayName":"Jonathan",
                // "email":"rockjonathan18@gmail.com",
                // "flags":"2049",
                // "type":"snacktools",
                // "confirmed":"1",
                // "active":"1",
                // "alias":{"id":"7648311","type":"facebook"}
//-----------CREATES USERS TABLE
$query="CREATE TABLE `users` (
		  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing id of each user, unique index',
		  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name',
		  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
		  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
		  `admin` tinyint(1) NOT NULL DEFAULT '0',
		  `free` tinyint(1) NOT NULL DEFAULT '0',
		  `created_at` timestamp default current_timestamp,
		  `last_login_at` timestamp,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `email` (`email`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data'";
$result=pdoSet($query,array());
echo 'Users table created</br>';

$query="ALTER TABLE `users`
		ADD COLUMN `admin` tinyint(1) NOT NULL DEFAULT '0',
		ADD COLUMN `free` tinyint(1) NOT NULL DEFAULT '0';";
		
$result=pdoSet($query,array());
echo 'Users ALTERED</br>';

$query="ALTER TABLE `users`
		ADD COLUMN `created_at` timestamp default current_timestamp,
		ADD COLUMN `last_login_at` timestamp;";
		
$result=pdoSet($query,array());
echo 'Users ALTERED Created timestamp</br>';

//-----------CREATER IMAGES TABLE
$query="CREATE TABLE `images` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `hash` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'images''s hash, unique',
		  `user_id` int(11) DEFAULT NULL,
		  `filename` varchar(255) DEFAULT NULL,
		  `type` varchar(11) DEFAULT NULL,
		  `width` int(11) DEFAULT NULL,
		  `height` int(11) DEFAULT NULL,
		  `created_at` timestamp default current_timestamp,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `hash` (`hash`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8";
$result=pdoSet($query,array());

echo 'Images table created</br>';

$query="ALTER TABLE `images`
		ADD COLUMN `created_at` timestamp default current_timestamp;";
		
$result=pdoSet($query,array());
echo 'Images ALTERED</br>';

//-----------CREATER BANNERS TABLE
$query="CREATE TABLE `banners` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `hash` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT 'banner''s hash, unique',
		  `userId` int(11) DEFAULT NULL,
		  `banner` text,
		  `paid` tinyint(1) NOT NULL DEFAULT '0',
		  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
		  `date_last_update` varchar(64) NOT NULL,
		  `width` int(11) NOT NULL,
		  `height` int(11) NOT NULL,
		  `created_at` timestamp default current_timestamp,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `hash` (`hash`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8";
$result=pdoSet($query,array());
echo 'Banners table created</br>';

$query="ALTER TABLE `banners`
		ADD COLUMN `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
		ADD COLUMN `date_last_update` varchar(64) NOT NULL,
		ADD COLUMN `width` int(11) NOT NULL,
		ADD COLUMN `height` int(11) NOT NULL,
		ADD COLUMN `created_at` timestamp default current_timestamp;";
		
$result=pdoSet($query,array());
echo 'Banners ALTERED</br>';

// $query='SELECT * FROM banners';
// $banner_list=pdoSelect($query, array($_GET['id']));

// if ($banner_list != 'error' && $banner_list != 'empty'){
// 	foreach($banner_list as $banner){
		
// 	    $bannerData = json_decode($banner['banner']);
		
// 		$query='UPDATE banners SET name=?, width=?, height=?, date_last_update=? WHERE id=?';
// 		$result=pdoSet($query, array($bannerData->properties->name,
// 	                                $bannerData->properties->width,
// 	                                $bannerData->properties->height,
// 		                            date("Y-m-d H:i:s"),
// 		                            $banner['id']));
//         echo 'Banner '.$bannerData->properties->name.' updated with '. $result .'<br />';
// 	}
// }


//-----------CREATER TEMPLATES TABLE
$query="CREATE TABLE `templates` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `hash` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT 'template''s hash, unique',
		  `banner` text,
		  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
		  `date_last_update` varchar(64) NOT NULL,
		  `width` int(11) NOT NULL,
		  `height` int(11) NOT NULL,
		  `type` varchar(10) NOT NULL DEFAULT 'static',
		  `created_at` timestamp default current_timestamp,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `hash` (`hash`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8";
$result=pdoSet($query,array());
echo 'Templates table created</br>';

$query="ALTER TABLE `templates`
		ADD COLUMN `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
		ADD COLUMN `date_last_update` varchar(64) NOT NULL,
		ADD COLUMN `width` int(11) NOT NULL,
		ADD COLUMN `height` int(11) NOT NULL,
		ADD COLUMN `type` varchar(10) NOT NULL DEFAULT 'static',
		ADD COLUMN `created_at` timestamp default current_timestamp;";
		
$result=pdoSet($query,array());
echo 'Templates ALTERED</br>';

// $query='SELECT * FROM templates';
// $template_list=pdoSelect($query, array($_GET['id']));

// if ($template_list != 'error' && $template_list != 'empty'){
// 	foreach($template_list as $template){
		
// 	    $bannerData = json_decode($template['banner']);
	    
// 		$type = typeOfBanner($template['banner']);
		
// 		$query='UPDATE templates SET name=?, width=?, height=?, type=?, date_last_update=? WHERE id=?';
// 		$result=pdoSet($query, array($bannerData->properties->name,
// 	                                $bannerData->properties->width,
// 	                                $bannerData->properties->height,
// 	                                $type,
// 		                            date("Y-m-d H:i:s"),
// 		                            $template['id']));
//         echo 'Banner '.$bannerData->properties->name.' updated with no '. $result .'<br />';
// 	}
// }

//-----------CREATER PAYMENTS TABLE
$query="CREATE TABLE `payments` (
		 `id` int(11) NOT NULL AUTO_INCREMENT,
		 `banner_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		 `txn_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		 `payment_gross` float(10,2) NOT NULL,
		 `currency_code` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
		 `payment_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		 `date` varchar(64) NOT NULL,
		 PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$result=pdoSet($query,array());
echo 'Payments table created</br>';


$connection->commit();
?>
