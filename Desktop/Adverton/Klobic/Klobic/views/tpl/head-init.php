<?php
error_reporting(E_ALL);
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Please update your php version");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {    
    require_once("php/libraries/password_compatibility_library.php");
}

// include the configs / constants for the database connection
require_once($_SERVER['DOCUMENT_ROOT']."/config/settings.php");
require_once($_SERVER['DOCUMENT_ROOT'].'/php/helpers.php');

/*** nullify any existing autoloads ***/
spl_autoload_register(null, false);

/*** specify extensions that may be loaded ***/
spl_autoload_extensions('.php, .class.php');

/*** class Loader ***/
function classLoader($class)
{
    $filename = $class . '.php';
	$classesPath = dirname(__FILE__) . '/php/classes/';
    $file =  $_SERVER['DOCUMENT_ROOT'].'/php/classes/' . $filename;
	
    if (!file_exists($file))
    {
    	echo "<br />".$file ." not exits<br />";
        return false;
    }
    include $file;
}

/*** register the loader functions ***/
spl_autoload_register('classLoader');

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();

?>