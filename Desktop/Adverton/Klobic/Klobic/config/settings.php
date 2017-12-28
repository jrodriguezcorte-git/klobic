<?php
// Force HTTPS
if(empty($_SERVER['HTTP_X_ARR_SSL']) && $_SERVER['SERVER_PORT'] != 443 && ($_SERVER['SERVER_NAME'] != 'localhost' || $_SERVER['SERVER_NAME'] != '127.0.0.1')){
    $redirect = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}

require_once($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
define("APP_VERSION", '2.1.10');

// STRIPE
// require_once('vendor/autoload.php');

/**
 * Configuration for: Database Connection
 *
 * For more information about constants please @see http://php.net/manual/en/function.define.php
 * If you want to know why we use "define" instead of "const" @see http://stackoverflow.com/q/2447791/1114320
 *
 * DB_HOST: database host, usually it's "127.0.0.1" or "localhost", some servers also need port info
 * DB_NAME: name of the database. please note: database and database table are not the same thing
 * DB_USER: user for your database. the user needs to have rights for SELECT, UPDATE, DELETE and INSERT.
 * DB_PASS: the password of the above user
 */
if(getenv('MYSQL_HOST') !== false) $MYSQL_HOST = getenv('MYSQL_HOST');
else if(getenv('MYSQL_HOST') !== false) $MYSQL_HOST = getenv('IP');
else $MYSQL_HOST = "localhost";


if(getenv('MYSQL_NAME') !== false) $MYSQL_NAME = getenv('MYSQL_NAME');
else if(getenv('C9_USER') !== false) $MYSQL_NAME = "c9";
else $MYSQL_NAME = "klobic_creator";


if(getenv('MYSQL_USER') !== false) $MYSQL_USER = getenv('MYSQL_USER');
else if(getenv('C9_USER') !== false) $MYSQL_USER = getenv('C9_USER');
else $MYSQL_USER = "root";


if(getenv('MYSQL_PASS') !== false) $MYSQL_PASS = getenv('MYSQL_PASS');
else $MYSQL_PASS = "";

define("DB_HOST", $MYSQL_HOST);
define("DB_NAME", $MYSQL_NAME);
define("DB_USER", $MYSQL_USER);
define("DB_PASS", $MYSQL_PASS);

if(getenv('DOMAIN_NAME_NO_HTTP') !== false) $DOMAIN_NAME_NO_HTTP = getenv('DOMAIN_NAME_NO_HTTP');
else if(getenv('C9_HOSTNAME') !== false) $DOMAIN_NAME_NO_HTTP = getenv('C9_HOSTNAME').'/';
else $DOMAIN_NAME_NO_HTTP = "localhost";

// Define your domain name with the slash symbol on the end
define("DOMAIN_NAME_NO_HTTP", $DOMAIN_NAME_NO_HTTP);
define("OFFICIAL_DOMAIN_NAME", "https://".DOMAIN_NAME_NO_HTTP);
define("DOMAIN_NAME", OFFICIAL_DOMAIN_NAME);
define("COMPANY_NAME", "Klobic");

define('PRODUCTION', getenv('PRODUCTION'));

// Define the root folder where you will copy all files with the slash symbol on the end i.e httpdocs for plesk hosting
// define("ROOT_FOLDER","../");
define("ROOT_FOLDER", $_SERVER['DOCUMENT_ROOT'].'/');
//  /home/ubuntu/workspace/

$PHPSESSID = "";
if(file_exists("PHPSESSID")){
    $file = fopen("PHPSESSID", "r");
    $PHPSESSID = fread($file, filesize("PHPSESSID"));
    fclose($file);
}

define("PHPSESSID", $PHPSESSID);

if(getenv("HTTP_GET_SECRET") !== false) $HTTP_GET_SECRET = getenv("HTTP_GET_SECRET");
else $HTTP_GET_SECRET = "abcdef";
define("HTTP_GET_SECRET", $HTTP_GET_SECRET);

if(getenv("HTTP_GET_SECRET_TOKEN") !== false) $HTTP_GET_SECRET_TOKEN = getenv("HTTP_GET_SECRET_TOKEN");
else $HTTP_GET_SECRET_TOKEN = "123456";
define("HTTP_GET_SECRET_TOKEN", $HTTP_GET_SECRET_TOKEN);

if(getenv("HTTP_API_TOKEN") !== false) $HTTP_API_TOKEN = getenv("HTTP_API_TOKEN");
else $HTTP_API_TOKEN = "abcdef";
define("HTTP_API_TOKEN", $HTTP_API_TOKEN);

$productPrice = 0.99;
if(PRODUCTION){
    // PAYPAL
    $paypalID = 'paypal@klobic.com'; //Business Email
    $paypalURL = 'https://www.paypal.com/cgi-bin/webscr';
    $hosted_button_id = 'BLJB975JEJ36L';
    $paypalGifBtn = 'https://www.paypalobjects.com/es_XC/AR/i/btn/btn_buynowCC_LG.gif';
    $paypalGifPixel = 'https://www.paypalobjects.com/es_XC/i/scr/pixel.gif';

    // STRIPE
    $stripe = array(
      "secret_key"      => "sk_live_fegWLnSzQGpoMyzAeNHro3BS",
      "publishable_key" => "pk_live_cbqagtGs5jOuEL7CI0BEee6c"
    );
} else {
    $paypalID = 'paypal-facilitator@klobic.com'; //Business Email
    $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //Test PayPal API URL
    $hosted_button_id = 'ABKP3TBV3DQ3E';
    $paypalGifBtn = 'https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif';
    $paypalGifPixel = 'https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif';

    // STRIPE
    $stripe = array(
      "secret_key"      => "sk_test_7QqHp1nSTAHf4FNiW75I84hK",
      "publishable_key" => "pk_test_aKxl9x5ukulgY6zdnHmnM8qe"
    );
    
}

?>
