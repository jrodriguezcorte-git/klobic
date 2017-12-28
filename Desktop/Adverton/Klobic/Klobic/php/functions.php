<?php
//-------------------FTP functions-------------------------

function makeDir($the_dir)
    {
    $dir = ROOT_FOLDER.'photos/'.$the_dir;
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
//  $conn_id = ftp_connect('localhost');
//  $login_result = ftp_login($conn_id, FTP_USER, FTP_PASS);
//  if (ftp_mkdir($conn_id, $dir)) {
//      ftp_chmod($conn_id, 0777, $dir) !== false;
//      }
//  ftp_close($conn_id);
    }

//-------------------Image functions-------------------------

function getMimeType($filename)
{
    $mimetype = false;
    if (function_exists('getimagesize')) {
       $mimetype = getimagesize($filename);
    } elseif(function_exists('exif_imagetype')) {
       $mimetype = exif_imagetype($filename);
    } elseif(function_exists('mime_content_type')) {
       $mimetype = mime_content_type($filename);
    }
    return $mimetype;
}

function GuessExtension($type)
{
    $extension = "";
    switch($type)
    {
        case "image/png":
           return ".png";
           break;
        case "image/jpeg":
        default:
           return ".jpg";
           break;
    }
}

function get_http_response_code($url) {
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
}

function getImageRawData($image_url) {
  if (function_exists('curl_init')) {
    $opts                                   = array();
    $http_headers                           = array();
    $http_headers[]                         = 'Expect:';

    $opts[CURLOPT_URL]                      = $image_url;
    $opts[CURLOPT_HTTPHEADER]               = $http_headers;
    $opts[CURLOPT_CONNECTTIMEOUT]           = 10;
    $opts[CURLOPT_TIMEOUT]                  = 60;
    $opts[CURLOPT_HEADER]                   = FALSE;
    $opts[CURLOPT_BINARYTRANSFER]           = TRUE;
    $opts[CURLOPT_VERBOSE]                  = FALSE;
    $opts[CURLOPT_SSL_VERIFYPEER]           = FALSE;
    $opts[CURLOPT_SSL_VERIFYHOST]           = 2;
    $opts[CURLOPT_RETURNTRANSFER]           = TRUE;
    $opts[CURLOPT_FOLLOWLOCATION]           = TRUE;
    $opts[CURLOPT_MAXREDIRS]                = 2;
    $opts[CURLOPT_IPRESOLVE]                = CURL_IPRESOLVE_V4;
    $opts[CURLOPT_RETURNTRANSFER]           = 1;

    # Initialize PHP/CURL handle
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $content = curl_exec($ch);
    $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    $code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    // echo $content_type;

    # Close PHP/CURL handle
    curl_close($ch);
  }// use file_get_contents
  elseif (ini_get('allow_url_fopen')) {
    $code = get_http_response_code($image_url);
    $file_info = new finfo(FILEINFO_MIME_TYPE);
    $content = file_get_contents($image_url);
    $content_type = $file_info->buffer($content);
  }


    # Return results
    return array(
        'content'=>$content, 
        'content_type'=>$content_type, 
        'extension'=> GuessExtension($content_type), 
        'code'=> $code
    );
}

function get_web_page($url, $header = array('')) {
    $options = array(
        CURLOPT_RETURNTRANSFER => true,   // return web page
        CURLOPT_HEADER         => false,  // don't return headers
        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
        CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
        CURLOPT_ENCODING       => "",     // handle compressed
        CURLOPT_USERAGENT      => "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11", // name of client
        CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
        CURLOPT_TIMEOUT        => 120,    // time-out on response
        CURLOPT_HTTPHEADER     => $header,
    );

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);

    $content  = curl_exec($ch);

    // $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

    // $header = substr($content, 0, $header_size);
    // $body = substr($content, $header_size);

    curl_close($ch);

    return $content;
}

function loginToBannerSnack() {
    $options = array(
        CURLOPT_RETURNTRANSFER => true,   // return web page
        CURLOPT_HEADER         => true,  // don't return headers
        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
        CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
        CURLOPT_ENCODING       => "",     // handle compressed
        CURLOPT_USERAGENT      => "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11", // name of client
        CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
        CURLOPT_TIMEOUT        => 120,    // time-out on response
    );

    $ch = curl_init("https://www.bannersnack.com/ajax.php?page=auth%2Flogin&email=bola.gasa%40gmail.com&password=aSf73jh5m605Kjg8gGgG&rememberMe=true");
    curl_setopt_array($ch, $options);

    $content  = curl_exec($ch);
    
    preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $content, $matches);
    $cookies = array();
    foreach($matches[1] as $item) {
        parse_str($item, $cookie);
        $cookies = array_merge($cookies, $cookie);
    }

    // $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

    // $header = substr($content, 0, $header_size);
    // $body = substr($content, $header_size);

    curl_close($ch);
    
    $PHPSESSID = $cookies["PHPSESSID"];
    $myfile = fopen("PHPSESSID", "w");
    fwrite($myfile, $PHPSESSID);
    fclose($myfile);
    
    return $cookies["PHPSESSID"];
}

function grab_image($url,$saveto){
    $ch = curl_init ($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    $raw=curl_exec($ch);
    curl_close ($ch);
    if(file_exists($saveto)){
        unlink($saveto);
    }
    $fp = fopen($saveto,'x');
    fwrite($fp, $raw);
    fclose($fp);
}

function allParamsString(){
    $response = '?';
    foreach ($_GET as $key => $value) {
       $response .= '&' . $key . '=' . $value;
    }
    return $response;
}

function generateRandomString($length = 6, $md5Substr = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    
    if($md5Substr){
        $result = md5(uniqid($randomString, true));
        
        if($md5Substr == 6) $md5Substr = $length;
        $result = substr($result, 0, $md5Substr);
    } else $result = $randomString;
        
    return $result;
}


/**
 * simple method to encrypt or decrypt a plain text string
 * initialization vector(IV) has to be the same when encrypting and decrypting
 * 
 * @param string $action: can be 'encrypt' or 'decrypt'
 * @param string $string: string to encrypt or decrypt
 *
 * @return string
 */
function encrypt_decrypt($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}