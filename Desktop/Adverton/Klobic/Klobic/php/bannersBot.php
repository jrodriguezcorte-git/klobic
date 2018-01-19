<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/header.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/libraries/simple_html_dom.php');

$loggedIn = $login->isUserLoggedIn();

$email = $_SESSION['user_email'];
$query='SELECT * FROM users WHERE email=? AND admin=?';
$user_list=pdoSelect($query, array($email, 1));

if ($user_list == 'error' || $user_list == 'empty'){
    Redirect('/auth/login.php', false);
    die();
}

function saveExternalTemplate($hash = false, $connection, $type = 'static'){
    if($hash != false){
        $response = get_web_page("https://creator.klobic.com/banners/". $hash ."/embed/index.html");
        $html = str_get_html($response);
        $script_tag = $html->find('script', 1)->innertext;
            
        if (preg_match('/var bannerJson = (.*?);/', $script_tag, $matches)){
            $matches[1] = preg_replace("/cdn.bannersnack/is", "creator.klobic", $matches[1]);
            $matches[1] = preg_replace("/bannersnack/is", "KLOBIC", $matches[1]);
            
            $bannerJson = $matches[1];
        
            $data = json_decode($matches[1]);
            $template_data = json_encode($data->banner);
            
            if(PRODUCTION){
                $connection->beginTransaction();
           
        		$query = 'INSERT INTO templates (hash, name, banner, width, height, type, date_last_update) VALUES (?, ?, ?, ?, ?, ?, ?)';
        		$result = pdoSet($query, array($hash, 
        		                                $data->banner->properties->name, 
        		                                $template_data,
        		                                $data->banner->properties->width,
        		                                $data->banner->properties->height,
        		                                $type, 
			                                    date("Y-m-d H:i:s")
    		                                )
		                                );
            	
                $connection->commit();
                
                if($result != 'error'){
                    require_once($_SERVER['DOCUMENT_ROOT'].'/php/saveImage.php');
                    require_once($_SERVER['DOCUMENT_ROOT'].'/php/renderBanner.php');
                    
                    $render = new RenderBanner($hash);
                    $image = $render->getImage(true);
                
        		    $imageSaver = new SaveImage($image, '/photos/templates/'.$hash.'.png');
                    echo $hash.' saved!</br>';
                }
            }
        }
    }
}


$response = get_web_page("https://creator.klobic.com/public/js/editor/v2/editor.gz.js");
preg_match('/\[{name:"Medium rectangle"(.*?)}}\]}/s', $response, $matches);
$templates = '{templates:'.$matches[0];
$templates = preg_replace('/(?<!")(?<!\w)(\w+)(?!")(?!\w)/', '"$1"', $templates);
$templates = preg_replace('/(!"0")/', '"0"', $templates);
$templates = preg_replace('/(!"1")/', '"1"', $templates);
$templates = preg_replace('/(?<!:|: )"(?=[^"]*?"(( [^:])|([,}])))/', '\\"', $templates);
$templates = json_decode($templates);
$templates = $templates->templates;

// FOR TESTING
// $templates = array($templates->templates[0]);

// TEXTURE
// saveExternalTemplate('bcmsrfi3d', $connection);

// BANNERSNACK WORD
// saveExternalTemplate('bc86zll5z', $connection);

$query='SELECT banner FROM templates WHERE hash=?';

$total = (int) count($templates);
for($n =0; $n < $total;$n++){
    $template = $templates[$n];
    // [name] => Medium rectangle
    // [width] => 300
    // [height] => 250
    // [group] => display
    // [panelCol] => 2
    $static = $template->templates->static;
    
    // FOR TESTING
    // $static = array($template->templates->static[0], json_decode('{"hash": "bc86zll5z"}'));
    
    if($template->templates->animated)
        $animated = $template->templates->animated;
    else
        $animated = array();
    
    $totalStatic = (int) count($static);
    for($nStatic = 0; $nStatic < $totalStatic; $nStatic++){
        $banner = $static[$nStatic];
        $hash = $banner->hash;
        $localFile = ROOT_FOLDER.'photos/templates/'. $hash .'.png';
        
        if (!file_exists($localFile)) {
        	$exist=pdoSelect($query, array($hash));
        	
    		if ($exist == 'error' || $exist == 'empty'){
    	        saveExternalTemplate($hash, $connection);
    		}
        }
    }
    
    $totalAnimated = (int) count($animated);
    for($nAnimated = 0; $nAnimated < $totalAnimated; $nAnimated++){
        $banner = $animated[$nAnimated];
        $hash = $banner->hash;
        $localFile = ROOT_FOLDER.'photos/templates/'. $hash .'.png';
        
        if (!file_exists($localFile)) {
        	$exist=pdoSelect($query, array($hash));
        	
    		if ($exist == 'error' || $exist == 'empty'){
    	        saveExternalTemplate($hash, $connection, 'animated');
    		}
        }
    }
}

echo 'All done!';

die();