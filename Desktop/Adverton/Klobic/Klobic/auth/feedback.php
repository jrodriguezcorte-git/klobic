<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/php/header.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');

$email = $_SESSION['user_email'];
$query='SELECT id, name, email FROM users WHERE email=?';
$user_list=pdoSelect($query, array($email));

if ($user_list != 'error' && $user_list != 'empty'){
    $userRequesting = $user_list[0];
    $user_id = $userRequesting['id'];
    
} else {
    if(isset($email)) session_destroy();
    echo '{"code":501,"res":"Your session has expired. Please <a target=\"_self\" href=\"\/auth\/login.php\">log in<\/a> again."}';
    die();
}

// forgot via post data (if user just submitted a login form)
if ($_POST && isset($_POST["feedback"])) {
    // Get cURL resource
	$curl = curl_init();
	// Set some options - we are passing in a useragent too here
	curl_setopt_array($curl, array(
	    CURLOPT_RETURNTRANSFER => 1,
	    CURLOPT_URL => 'https://api.klobic.com/mailers/feedback.php',
	    CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5',
	    CURLOPT_POST => 1,
	    CURLOPT_POSTFIELDS => array(
	        "t" => HTTP_API_TOKEN,
	        "name" => $userRequesting['name'],
	        "email" => $userRequesting['email'],
	        "feedback" => $_POST["feedback"]
	    )
	));
	
	if(!curl_exec($curl))
		echo '{"res": "Feedback could not be sent. Try again."}';
	else
		echo '{"res": "Thanks for the feedback."}';
    
	// Close request to clear up some resources
	curl_close($curl);
	die();
} else {
    echo '{"code":501,"res":"Your session has expired. Please <a target=\"_self\" href=\"\/auth\/login.php\">log in<\/a> again."}';
    die();
}