<?php
namespace Listener;

require_once($_SERVER['DOCUMENT_ROOT'].'/views/tpl/head-init.php');
if(!$_POST) Redirect('/', false);

require_once($_SERVER['DOCUMENT_ROOT'].'/config/settings.php');
// Set this to true to use the sandbox endpoint during testing:
$enable_sandbox = false;

// Use this to specify all of the email addresses that you have attached to paypal:
$my_email_addresses = array($paypalID);

// Set this to true to send a confirmation email:
$send_confirmation_email = true;
$confirmation_email_address = "Klobic Team <paypal@klobic.com>";
$from_email_address = "Klobic Team <paypal@klobic.com>";

// Set this to true to save a log file:
$save_log_file = false;
$log_file_dir = __DIR__ . "/logs";

// Here is some information on how to configure sendmail:
// http://php.net/manual/en/function.mail.php#118210

$stripeToken = $_POST['stripeToken'];

// use PaypalIPN;
if(!empty($stripeToken)){
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/libraries/stripe-php/init.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/connection.php');

    \Stripe\Stripe::setApiKey($stripe['secret_key']);

    $email = $_SESSION['user_email'];
    $query='SELECT * FROM users WHERE email=?';
    $user_list=pdoSelect($query, array($email));
    $banner_id = $_GET['item_number'];
    
    if ($user_list != 'error' && $user_list != 'empty'){
        $user_id = $user_list[0]['id'];
        
    } else {
        Redirect('/auth/login.php', false);
        die();
    }
    
    $error = 'Something wen\'t wrong, check your details and try again.';

    function error_handler($e = false){
        // Since it's a decline, \Stripe\Error\Card will be caught
        $body = $e->getJsonBody();
        $err  = $body['error'];
        
        if($e != false)
            $error = $err['message'];
        
        Redirect('/pay/choose.php?error='.$error.'&item_name='. $_GET['item_name'] .'&item_number='. $_GET['item_number'], false);
        die();
    }

    try {
        $customer = \Stripe\Customer::create(array(
            'email' => $email,
            'source'  => $stripeToken
        ));
        
        $charge = \Stripe\Charge::create(array(
            'customer' => $customer->id,
            'amount'   => str_replace(".", "0", $productPrice),
            'currency' => 'usd'
        ));
    } catch(\Stripe\Error\Card $e) {
        error_handler($e);
    } catch (\Stripe\Error\RateLimit $e) {
        // Too many requests made to the API too quickly
        error_handler();
    } catch (\Stripe\Error\InvalidRequest $e) {
        // Invalid parameters were supplied to Stripe's API
        error_handler($e);
    } catch (\Stripe\Error\Authentication $e) {
        // Authentication with Stripe's API failed
        // (maybe you changed API keys recently)
        error_handler();
    } catch (\Stripe\Error\ApiConnection $e) {
        // Network communication with Stripe failed
        error_handler();
    } catch (\Stripe\Error\Base $e) {
        // Display a very generic error to the user, and maybe send
        // yourself an email
        error_handler();
    } catch (Exception $e) {
        // Something else happened, completely unrelated to Stripe
        error_handler();
    }
    
    if($charge['status'] === 'succeeded'){
        //Get payment information from Stripe
        $banner_hash = $_GET["item_name"];
        $txn_id = 'Stripe-'.$charge['id'];
        $payment_gross = $productPrice;
        $currency_code = $charge['currency'];
        $payment_status = $charge['status'];
    
        // show the login view (with the registration form, and messages/errors)
        include_once($_SERVER['DOCUMENT_ROOT']."/views/pay/success.php");
        die();
    } 
    
    Redirect('/pay/choose.php?error='.$error.'&item_name='. $_GET['item_name'] .'&item_number='. $_GET['item_number'], false);
    die();
}

// if ($send_confirmation_email) {
//     // Send confirmation email
//     mail($confirmation_email_address, $test_text . "PayPal IPN : " . $paypal_ipn_status, "paypal_ipn_status = " . $paypal_ipn_status . "\r\n" . "paypal_ipn_date = " . $timestamp . "\r\n" . $data_text, "From: " . $from_email_address);
// }

// Reply with an empty 200 response to indicate to paypal the IPN was received correctly
header("HTTP/1.1 200 OK");
