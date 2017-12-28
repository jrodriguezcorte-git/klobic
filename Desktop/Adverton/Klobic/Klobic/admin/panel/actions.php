<?php 
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/connection.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
    
    if(!empty($_GET['delete'])){
        $path = $_SERVER['REQUEST_URI']; // this gives you /folder1/folder2/THIS_ONE/file.php
        $folders = explode('/',$path); // splits folders in array
        $type = $folders[2];
        
        $query = 'SELECT id FROM '.$type .' WHERE id=?';
        $banner_list = pdoSelect($query, array($_GET['delete']));
        
        if ($banner_list != 'error' && $banner_list != 'empty'){
        	$connection->beginTransaction();
        	$query = 'DELETE FROM '. $type .' WHERE id=?';
        	$result = pdoSet($query, array($_GET['delete']));
        	$connection->commit();
        	echo '{"code":200,"res":""}';
            
    	} else 
            echo '{"code":500,"res":"'. $type .'_not_found"}';
    }
    die();
?>