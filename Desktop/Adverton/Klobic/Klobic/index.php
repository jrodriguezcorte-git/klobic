<?php
require_once('views/tpl/head-init.php');

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    $url = $_SERVER['REQUEST_URI']; //returns the current URL
    $parts = explode('/', $url);
    $parts = explode('?', $parts[1]);
    
    if($parts[0] != 'banner-creator')
        Redirect('/banner-creator/my-banners/', false);
    else
        include("views/app.php");

} else {
    Redirect('/auth/login.php', false);
}
?>
