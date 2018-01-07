<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/views/tpl/head-init.php');
// load the registration class
require_once($_SERVER['DOCUMENT_ROOT']."/config/settings.php");
require_once($_SERVER['DOCUMENT_ROOT'].'/php/connection.php');

$log_file_dir = __DIR__ . "/logs";
$save_log_file = true;

if (!$login->isUserLoggedIn() && empty($noRedirect)) {
    Redirect('/login.php', false);
}

// // PRODUCTION
// // $pp_hostname = "www.paypal.com";
// // $auth_token = "QFpYkgMVf4R26Isc6cv8X9w6jzX7VCUD9zO-cQLfnHe1pXfG4LHoDooP88O";

// // SANDBOX
// $pp_hostname = "www.sandbox.paypal.com";
// $auth_token = "NY2GuSKIvPgw5yS2e6DRYqKU-PSrwJdaVvNeBTa-frkcJfVDVVa0F4XKQdi";

// // read the post from PayPal system and add 'cmd'
// $req = 'cmd=_notify-synch';

// $tx_token = $_GET['tx'];
// $req .= "&tx=$tx_token&at=$auth_token&address_override=1";
// // echo $req.'<br/>';
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, "https://$pp_hostname/cgi-bin/webscr");
// curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
// //set cacert.pem verisign certificate path in curl using 'CURLOPT_CAINFO' field here,
// //if your server does not bundled with default verisign certificates.
// // curl_setopt($ch, CURLOPT_CAINFO, $_SERVER['DOCUMENT_ROOT'] . "/php/classes/cert/cacert.pem");
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: $pp_hostname"));
// $res = curl_exec($ch);
// curl_close($ch);

// print_r($res);
// if(!$res){
//     //HTTP ERROR
// }else{
//      // parse the data
//     $lines = explode("\n", trim($res));
//     $keyarray = array();
//     if (strcmp ($lines[0], "SUCCESS") == 0) {
//         for ($i = 1; $i < count($lines); $i++) {
//             $temp = explode("=", $lines[$i],2);
//             $keyarray[urldecode($temp[0])] = urldecode($temp[1]);
//         }
//     // check the payment_status is Completed
//     // check that txn_id has not been previously processed
//     // check that receiver_email is your Primary PayPal email
//     // check that payment_amount/payment_currency are correct
//     // process payment
//     $firstname = $keyarray['first_name'];
//     $lastname = $keyarray['last_name'];
//     $itemname = $keyarray['item_name'];
//     $amount = $keyarray['payment_gross'];

//     echo ("<p><h3>Thank you for your purchase!</h3></p>");

//     echo ("<b>Payment Details</b><br>\n");
//     echo ("<li>Name: $firstname $lastname</li>\n");
//     echo ("<li>Item: $itemname</li>\n");
//     echo ("<li>Amount: $amount</li>\n");
//     echo ("");
//     }
//     else if (strcmp ($lines[0], "FAIL") == 0) {
//         // log for manual investigation
//     }
// }

function get_item_number($str){
    while(($pos = strpos($str, '(')) !== false)
    {
        $str = substr($str, $pos + 1);
        $str = rtrim($str, "(");
        $str = rtrim($str, ")");
    }
    return $str;
}

//Get payment information from PayPal
if(!empty($_GET['item_name'])) $banner_hash = $_GET['item_name'];
else if(empty($banner_hash)) $banner_hash = '';

if(!empty($_GET['tx'])) $txn_id = $_GET['tx'];
else if(empty($txn_id)) $txn_id = '';

if(!empty($_GET['amt'])) $payment_gross = $_GET['amt'];
else if(empty($payment_gross)) $payment_gross = '';

if(!empty($_GET['cc'])) $currency_code = $_GET['cc'];
else if(empty($currency_code)) $currency_code = '';

if(!empty($_GET['st'])) $payment_status = $_GET['st'];
else if(empty($payment_status)) $payment_status = '';

$email = $_SESSION['user_email'];
$query='SELECT * FROM users WHERE email=?';
$user_list=pdoSelect($query, array($email));

if ($user_list != 'error' && $user_list != 'empty'){
    $user_id = $user_list[0]['id'];
    
} else {
    Redirect('/auth/login.php', false);
    die();
}

//$payment_gross = 4.99;
//$payment_gross = 8.99;
$payment_gross = 20;
$txn_id = 20;
$currency_code = "USD";
$payment_status = true;

    if (!empty($payment_gross) && !empty($txn_id) && !empty($payment_gross) && !empty($currency_code) && !empty($payment_status) && $payment_gross > 1) {
                if ($payment_gross == 4.99) {
                    $item_plan = 2;
                }
                if ($payment_gross == 8.99) {
                    $item_plan = 3;
                }
                if ($payment_gross == 20) {
                    $item_plan = 4;
                }   
                $query='UPDATE payment_user_group SET paymentgroupid=? WHERE userid=?';
                $result = pdoSet($query, array($item_plan,$user_id));  
                Redirect('/banner-creator/my-banners/', false);                
    }


if(!empty($banner_hash) && !empty($txn_id) && !empty($payment_gross) && !empty($currency_code) && !empty($payment_status)){
    $banner_hash = rtrim($banner_hash,")");
    $banner_hash = get_item_number($banner_hash);

    //Get product price from database
    $query="SELECT id, hash FROM banners WHERE hash=? LIMIT 1";
    $productResult = pdoSelect($query,array($banner_hash));

    if($payment_gross == $productPrice){
        //Check if payment data exists with the same TXN ID.
    	$query='SELECT id FROM payments WHERE txn_id=?';
    	$prevPaymentResult = pdoSelect($query,array($txn_id));

        if(count($prevPaymentResult) > 1){
            $last_insert_id = $prevPaymentResult[0]['id'];
        }else{
            //Insert tansaction data into the database
    		$query="INSERT INTO payments(banner_hash, txn_id, payment_gross, currency_code, payment_status, date) VALUES(?, ?, ?, ?, ?, ?)";
    		$result = pdoSet($query, array($banner_hash, $txn_id, $payment_gross, $currency_code, $payment_status, date("Y-m-d H:i:s")));


            //Check if payment data exists with the same TXN ID.
        	$query='SELECT id FROM payments WHERE txn_id=?';
        	$prevPaymentResult=pdoSelect($query,array($txn_id));
            $last_insert_id = $prevPaymentResult[0]['id'];
        }

    	$connection->beginTransaction();
    	$query='UPDATE banners SET paid=? WHERE hash=?';
    	$result=pdoSet($query,array(1, $productResult[0]['hash']));
    	$connection->commit();

        if(empty($noRedirect))
            Redirect('/banner-creator/my-banners/?success='.$productResult[0]['hash'], false);
    }
}

if(empty($noRedirect))
    Redirect('/banner-creator/my-banners/', false);
?>
