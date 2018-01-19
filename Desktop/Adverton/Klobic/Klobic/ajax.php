<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/header.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/libraries/simple_html_dom.php');

if(!empty($_POST['page']))
    $page = $_POST['page'];
else
    $page = $_GET['page'];

$email = $_SESSION['user_email'];
$query='SELECT id, admin, free FROM users WHERE email=?';
$user_list=pdoSelect($query, array($email));

// $page = $_GET['p'];
// $items_per_page = $_GET['ipp'];
// $order_by = $_GET['order_by'];
// $offset = ($page - 1) * $items_per_page;

if ($user_list != 'error' && $user_list != 'empty'){
    $userRequesting = $user_list[0];
    $user_id = $userRequesting['id'];
    
} else {
    if(isset($email)) session_destroy();
    echo '{"code":501,"res":"Your session has expired. Please <a target=\"_self\" href=\"\/auth\/login.php\">log in<\/a> again."}';
    die();
}

function saveTemplate($email, $userRequesting, $connection, $connectionNull = false, $data = false, $hash = false, $noEcho = false){
    if(!$data) $data = $_POST['data'];
    if(!$hash) $hash = $_POST['hash'];
    
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
    
    $type = typeOfBanner($data);
    $bannerData = json_decode($data);
    if($hash == 'false') $hash = generateRandomString();
    
    if(!empty($data) && !empty($email) && $userRequesting['admin'] == '1'){
    	if(!$connectionNull) 
    	    $connection->beginTransaction();
    	
    	$query='SELECT id, banner, hash FROM templates WHERE hash=?';
    	$banner_list=pdoSelect($query, array($hash));
    	
		if ($banner_list != 'error' && $banner_list != 'empty'){
			$banner_id = $banner_list[0]['id'];
			$banner_data = $banner_list[0]['banner'];
			if($banner_data != $data){
    			$query='UPDATE templates SET name=?, width=?, height=?, type=?, date_last_update=?, banner=? WHERE id=?';
    			$result=pdoSet($query, array($bannerData->properties->name,
			                                $bannerData->properties->width,
			                                $bannerData->properties->height,
			                                $type,
    			                            date("Y-m-d H:i:s"), 
    			                            $data, 
    			                            $banner_id));
			} else {
                if(!$noEcho) 
                    echo '{"code":20,"res":{"hash_id": "templates"}}';
                    
                die();
			}
		} else {
			$query = 'INSERT INTO templates (hash, name, width, height, type, date_last_update, banner) VALUES (?, ?, ?, ?, ?, ?, ?)';
			$result = pdoSet($query, array($hash,
			                            $bannerData->properties->name, 
			                            $bannerData->properties->width, 
			                            $bannerData->properties->height, 
			                            $type,
			                            date("Y-m-d H:i:s"), 
			                            $data));
			
        	$query='SELECT id, hash, banner FROM templates WHERE id=?';
        	$banner_list=pdoSelect($query, array($result));
		}
		
        $connection->commit();
        $result = 0;
        
        if($result === 'error'){
            if(!$noEcho) 
                echo '{"code":500,"res":"'.$result.'"}';
        } else {
            // $banner_list[0]['banner'] = json_decode($banner_list[0]['banner']);
            
            // delete 
            require_once($_SERVER['DOCUMENT_ROOT'].'/php/saveImage.php');
            require_once($_SERVER['DOCUMENT_ROOT'].'/php/renderBanner.php');
            $render = new RenderBanner($hash);
            $image = $render->getImage(true);
		    $imageSaver = new SaveImage($image, '/photos/templates/'.$hash.'.png');
		    
            if(!$noEcho) echo '{"code":20,"res":{"hash_id": "templates"}}';
            
            // if(!$noEcho) {
            //     $res = array('code' => 20, 
            //         'res' => array(
            //             "id" => $banner_list[0]['id'],
            //             "id_parent" => "0",
            //             "id_user" => $user_id,
            //             "hash_id" => $banner_list[0]['hash'],
            //             "name" => $banner_list[0]['banner']->properties->name,
            //             "thumb" => "0",
            //             "width" => $banner_list[0]['banner']->properties->width,
            //             "height" => $banner_list[0]['banner']->properties->height,
            //             "bgcolor" => $banner_list[0]['banner']->properties->bgcolor,
            //             "quality" => $banner_list[0]['banner']->properties->quality,
            //             "tags" => "",
            //             "type" => $type,
            //             "banner_type" => "html5",
            //             "date_created" => "2017-03-25 03:54:05",
            //             "date_last_update" => $banner_list[0]['date_last_update'],
            //             "date_published" => "2017-03-25 03:54:21",
            //             "date_premium" => null,
            //             "active" => "1",
            //             "pub_free_embed" => "0",
            //             "pub_pro_embed" => "0",
            //             "pub_pro_embed_unlock_type" => "points",
            //             "pub_pro_download" => "0",
            //             "pub_pro_download_unlock_type" => "points",
            //             "pub_pro_download_count" => "0",
            //             "pub_free_gif" => "0",
            //             "pub_free_mp4" => "0",
            //             "premium" => "0",
            //             "premium_type" => "subscription",
            //             "flags" => 524288,
            //             "version" => null,
            //             "short_url" => "",
            //             "score_overall" => null
            //         )
            //     );
            //     echo json_encode($res);
            // }
        }
            
    } else if($userRequesting['admin'] != '1')
        if(!$noEcho) echo '{"code":500,"res":"You can\'t update a template"}';
    else
        if(!$noEcho) echo '{"code":500,"res":"Banner not found"}';
}


switch ($page) {
    case 'render':
        require_once($_SERVER['DOCUMENT_ROOT'].'/php/renderBanner.php');
        $render = new RenderBanner($_GET['id']);
        break;
    case 'get-user-info':
		$query='UPDATE users SET last_login_at=? WHERE id=?';
		$result=pdoSet($query, array(date("Y-m-d H:i:s"),
		                            $user_id));
		                            
        //    echo '{"code":20,"res":{"data":{"id":27518096,"accountId":"99D8DA59E8C","premium":false,"bannersCount":2,"bannersCountCurrentCycle":0,"rotatorsCount":0,"occupation":"developer","totalBannersCreated":3,"confirmed":"1","serviceType":"free","featuresAccess":{"bm_animated_templates":"limited","bm_animation_presets":"yes","bm_bannersnack_analytics":"7_d","bm_banner_score":"yes","bm_buttons":"limited","bm_cliparts":"limited","bm_download_gif":"yes","bm_download_html5":"no","bm_download_images":"yes","bm_download_mp4":"no","bm_download_swf":"no","bm_embed_code_views":"1000","bm_embed_elements":"no","bm_heatmap":"no","bm_menu":"yes","bm_multiple_slides":"yes","bm_number_of_banners":10,"bm_static_templates":"limited","bm_stock_photos":"limited","bm_tags":"no","bm_transitions":"limited","bm_video":"yes","br_advanced_rotation_settings":"no","br_bannersnack_analytics":"7_d","br_embed_code_views":"1000","br_number_of_rotators":10}}}}';
        // PREMIUM
        $res = array('code' => 20, 
            'res' => 
                array(
                    "data" => array(
                        "id" => $user_id,
                        "accountId" => "",
                        "premium" => true,
                        "bannersCount" => 0,
                        "bannersCountCurrentCycle" => 0,
                        "rotatorsCount" => 0,
                        "occupation" => "developer",
                        "totalBannersCreated" => 0,
                        "confirmed" => "1",
                        "serviceType" => "premium",
                        // "serviceType" => "free",
                        "featuresAccess" => array(
                            "bm_animated_templates" => "yes",
                            "bm_animation_presets" => "yes",
                            "bm_klobic_analytics" => "7_d",
                            "bm_banner_score" => "yes",
                            "bm_buttons" => "yes",
                            "bm_cliparts" => "yes",
                            "bm_download_gif" => "no",
                            "bm_download_html5" => "no",
                            "bm_download_images" => "yes",
                            "bm_download_mp4" => "no",
                            "bm_download_swf" => "no",
                            "bm_embed_code_views" => "1000",
                            "bm_embed_elements" => "yes",
                            "bm_heatmap" => "no",
                            "bm_menu" => "yes",
                            "bm_multiple_slides" => "yes",
                            "bm_number_of_banners" => 10,
                            "bm_static_templates" => "yes",
                            "bm_stock_photos" => "yes",
                            "bm_tags" => "no",
                            "bm_transitions" => "yes",
                            "bm_video" => "yes",
                            "bm_klobic_analytics" => "7_d",
                            "br_advanced_rotation_settings" => "yes",
                            "br_embed_code_views" => "1000",
                            "br_klobic_analytics" => "7_d",
                            "br_number_of_rotators" => 10
                        )
                    )
                )
            );
            
        if($userRequesting['admin'] == 1)
            $res['res']['data']['admin'] = $userRequesting['admin'];

        echo json_encode($res);
        // echo '{"code":20,"res":{"data":{"id":27518096,"accountId":"99D8DA59E8C","premium":true,"bannersCount":2,"bannersCountCurrentCycle":0,"rotatorsCount":0,"occupation":"developer","totalBannersCreated":3,"confirmed":"1","serviceType":"free","featuresAccess":{"bm_animated_templates":"yes","bm_animation_presets":"yes","bm_bannersnack_analytics":"7_d","bm_banner_score":"yes","bm_buttons":"yes","bm_cliparts":"yes","bm_download_gif":"yes","bm_download_html5":"no","bm_download_images":"yes","bm_download_mp4":"no","bm_download_swf":"no","bm_embed_code_views":"1000","bm_embed_elements":"no","bm_heatmap":"no","bm_menu":"yes","bm_multiple_slides":"yes","bm_number_of_banners":10,"bm_static_templates":"yes","bm_stock_photos":"yes","bm_tags":"no","bm_transitions":"yes","bm_video":"yes","br_advanced_rotation_settings":"no","br_bannersnack_analytics":"7_d","br_embed_code_views":"1000","br_number_of_rotators":10}}}}';
        break;
    
    case 'banner-creator/feedback-displayed':
        break;
        
    case 'banner-creator/my-banners/load-banners':
        if($_GET['order_by'] === 'NAME_ASC')
            $order = 'name ASC';
        elseif($_GET['order_by'] === 'NAME_DESC')
            $order = 'name DESC';
        elseif($_GET['order_by'] === 'DATE_ASC')
            $order = 'date_last_update ASC';
        else
            $order = 'date_last_update DESC';
        // &p=1&ipp=50&search_text=&order_by=NAME_ASC&search_banner_type=ALL&user_id=1
        
        $ipp = $_GET['ipp'];
        $p = $_GET['p'];
        
        $limit = ($ipp * $p);
        $limit = ($limit-$ipp) .','. $limit;
        if($limit == 0) $limit = $ipp;
        
    	$from='banners WHERE userId=?';
    	
        if($_GET['user_id'] == 'templates'){
            $from='templates';
        }
        
        $query = "SELECT * FROM ". $from ." ORDER BY ".$order.' LIMIT '.$limit;
    	$banner_list=pdoSelect($query, array($user_id));
    	$items = array();
    	
    	$query = "SELECT COUNT(*) FROM ".$from;
    	$count = pdoSelect($query, array($user_id));
    	$count = $count[0]['COUNT(*)'];
    	$totalPages = ceil($count/$ipp);
    	
		if ($banner_list != 'error' && $banner_list != 'empty'){
		    foreach($banner_list as $banner){
		        $json = json_decode($banner['banner']);
		        $json = $json->properties;
		        $json->hash = $banner['hash'];
		      //  $json->hash = 'bxu90kj9r';
		        $json->paid = $banner['paid'];
		        $json->id = $banner['id'];
		        $json->id_user = $user_id;
		        
                // $json->id_parent = 0;
                // $json->id_user = 27518096;
                // $json->name = 'Test2';
                // $json->thumb = 0;
                // $json->width = "320";
                // $json->height = "50";
                // $json->bgcolor = null;
                // $json->quality = "90";
                // $json->tags = [];
                $json->type = "publish";
                $json->banner_type = "html5";
                $json->date_created = "2017-03-02 08:27:41";
                $json->date_last_update = $banner['date_last_update'];
                $json->date_published = "2017-03-02 08:27:53";
                // $json->date_premium = null;
                $json->active = "1";
                // $json->pub_free_embed = false;
                // $json->pub_pro_embed = false;
                // $json->pub_pro_embed_unlock_type = "points";
                // $json->pub_pro_download = false;
                // $json->pub_pro_download_unlock_type = "points";
                // $json->pub_pro_download_count = "0";
                // $json->pub_free_gif = false;
                // $json->pub_free_mp4 = false;
                // $json->premium = false;
                // $json->premium_type = "subscription";
                $json->flags = "623104";
                $json->version = null;
                $json->short_url = "";
                // $json->score_overall = null;
                // $json->view_count = "0";
                $json->banner_details_flags = "0";
                // $json->slides_count = 1;
                
                if(file_exists(ROOT_FOLDER.'/photos/banners/'.$banner['hash'].'.png'))
                    $size = filesize(ROOT_FOLDER.'/photos/banners/'.$banner['hash'].'.png');
                else 
                    $size = 0;
                    
                $json->size = $size;
                $json->is_real_html5_size = true;
                // $json->views = 0;
                // $json->t = 1488464873;
                // $json->has_animations = false;
                    
		        array_push($items, $json);
		    }
		}
		
        $res = array('code' => 20, 
            'res' => 
                array('items' => 
                    $items,
                    "allTimeStartDate" => "2017-02-15",
                    "filters" => array(
                        "orderType" => "DESC",
                        "orderBy" => "date",
                        "search" => array(
                            "banner_type" => "all",
                            "text" => ""
                        ),
                        "itemsPerPage" => $ipp
                    ),
                    "page" => $totalPages,
                    "totalItems" => $count,
                    "totalTypes" => 1,
                    "currentPage" => $p,
                    "totalBannersCreated" => count($items)
                )
            );

        echo json_encode($res);
        break;

    case 'banner-creator/my-banners/get-user-tags':
        echo '{"code":20,"res":{"tags":[]}}';
        break;

    case 'banner-creator/get-templates': 
        $hash = $_GET['hash'];
        $width = $_GET['width'];
        $height = $_GET['height'];
    	
    	$query='SELECT hash FROM templates WHERE width=? AND height=? AND type=?';
    	$static_list=pdoSelect($query, array($width, $height, 'static'));
    	if($static_list == 'error' || $static_list == 'empty')
    	    $static_list = array();
        
    	$animated_list=pdoSelect($query, array($width, $height, 'animated'));
    	if($animated_list == 'error' || $animated_list == 'empty')
    	    $animated_list = array();
    	
        $res = array('code' => 20, 
            'res' => array(
                "static" => $static_list,
                "animated" => $animated_list
            )
        );
         
        echo json_encode($res);
            // echo '{"code":20, "res":{"static": '. json_encode($template_list) .', "animated": [{"hash": "bc507ff8x"}],
            // "itemWidth":300, "itemHeight":200, "category":"static"}}';
        // else
        //     echo '{"code":404, "res":"Template not found"}';
            
        break;
        
    case 'banner-creator/get-template-data': 
        $hash = $_GET['hash'];	
    	$query='SELECT banner FROM templates WHERE hash=?';
    	$template_list=pdoSelect($query, array($hash));
    	
		if ($template_list != 'error' && $template_list != 'empty'){
			$template_data = $template_list[0]['banner'];
			
		}
		
        if(!empty($template_data) && $result != 'error')
            echo '{"code":20, "res":'. $template_data .'}';
        else
            echo '{"code":404, "res":"Template not found"}';
            
        break;

        
    case 'banner-creator/my-banners/duplicate-banners':
        $bannersIDS = $_GET['bannerIds'];
        
        foreach ($bannersIDS as $id){
        	$query='SELECT id, banner, hash FROM banners WHERE id=? AND userId=?';
        	$banner_list=pdoSelect($query, array($id, $user_id));
        	
        	$query='SELECT banner FROM banners ORDER BY id DESC LIMIT 1';
        	$lastId=pdoSelect($query, array());
        	$lastId=(json_decode($lastId[0]['banner'])->properties->lastId)+1;
        	
    		if ($banner_list != 'error' && $banner_list != 'empty'){
    		    $newHash = generateRandomString();
                $data = json_decode($banner_list[0]['banner']);
                $data->properties->name = 'Copy of '.$data->properties->name;
                $name = $data->properties->name;
                $data->properties->lastId = $lastId;
                $data = json_encode($data);
            	
            	$file = ROOT_FOLDER.'/photos/banners/'.$banner_list[0]['hash'].'.png';
                $newfile = ROOT_FOLDER.'/photos/banners/'.$newHash.'.png';
                
                if (!copy($file, $newfile)) {
                    echo '{"code":500,"res":"banner_not_found"}';
                    die();
                }
                
            	$connection->beginTransaction();
    			$query = 'INSERT INTO banners (hash, userId, name, banner) VALUES (?, ?, ?, ?)';
    			$result = pdoSet($query, array($newHash, $user_id, $name, $data));
            	$connection->commit();
    		}
        }
        echo '{"code":20,"res":'.$result.'}';
        
        break;
        
    case 'banner-creator/my-banners/delete-banners':
        $bannersIDS = $_GET['ids'];
        
        foreach ($bannersIDS as $id){
        	$query='SELECT hash FROM banners WHERE id=? AND userId=?';
        	$banner_list=pdoSelect($query, array($id, $user_id));
        	$templateOrBanner = 'banners WHERE id=? AND userId=?';
        	$templateOrBannerArray = array($id, $user_id);
        	
        	if ($banner_list == 'empty'){
            	$query='SELECT hash FROM templates WHERE id=?';
            	$banner_list=pdoSelect($query, array($id));
            	$templateOrBanner='templates';
        	    $templateOrBannerArray = array($id);
        	}
        	
        	if ($banner_list != 'error' && $banner_list != 'empty'){
                $hash = $banner_list[0]['hash'];
        	
            	$connection->beginTransaction();
            	$query='DELETE FROM '.$templateOrBanner;
            	$result=pdoSet($query, $templateOrBannerArray);
            	$connection->commit();
            	
            	if(file_exists(ROOT_FOLDER.'/photos/banners/'.$hash.'.png'))
            	    unlink (ROOT_FOLDER.'photos/banners/'.$hash.'.png');
                
        	} else 
                echo '{"code":500,"res":"banner_not_found"}';
        }
        
        echo '{"code":20,"res":{"bannerTypes":1}}';
        break;
        
    case 'banner-creator/my-banners/duplicate-banners':
        $bannersIDS = $_GET['bannerIds'];
        
        foreach ($bannersIDS as $id){
        	$connection->beginTransaction();
        	$query='DELETE FROM banners WHERE id=? AND userId=?';
        	$result=pdoSet($query,array($id, $user_id));
        	$connection->commit();
        }
        echo '{"code":20,"res":[]}';
        
        // echo '{"code":500,"res":"banner_not_found"}';
        break;
        
    case 'html5editor/save-banner':
        $data = $_POST['data'];
	    $bannerData = json_decode($data);
        $hash = $_POST['hash'];
        if($hash == 'false') $hash = generateRandomString();
        
        // $imageBase64 = $_POST['imagePreview'];
        
        if(!empty($data) && !empty($email)){
        	$connection->beginTransaction();
        	
            	$query='SELECT id, banner, hash FROM templates WHERE hash=?';
            	$banner_list=pdoSelect($query, array($hash));
        	
        	    if ($banner_list != 'error' && $banner_list != 'empty'){
        	        saveTemplate($email, $userRequesting, $connection, true);
        	        die();
        	    }
        	
            	$query='SELECT id, banner, hash FROM banners WHERE hash=? AND userId=?';
            	$banner_list=pdoSelect($query, array($hash, $user_id));
            	
        		if ($banner_list != 'error' && $banner_list != 'empty'){
        			$banner_id = $banner_list[0]['id'];
        			$banner_data = $banner_list[0]['banner'];
        			
        			if($banner_data != $data){
            			$query='UPDATE banners SET name=?, width=?, height=?, date_last_update=?, banner=?, paid=? WHERE id=? AND userId=?';
            			$result=pdoSet($query, array($bannerData->properties->name,
        		                                	$bannerData->properties->width,
        		                                	$bannerData->properties->height,
            			                            date("Y-m-d H:i:s"), 
            			                            $data,
            			                            $userRequesting['free'],
            			                            $banner_id,
            			                            $user_id));
        			}
        		} else {
        			$query = 'INSERT INTO banners (hash, userId, name, width, height, date_last_update, banner, paid) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        			$result = pdoSet($query, array($hash, 
        			                            $user_id, 
        			                            $bannerData->properties->name,
        			                            $bannerData->properties->width, 
        			                            $bannerData->properties->height,  
        			                            date("Y-m-d H:i:s"),
        			                            $data, 
        			                            $userRequesting['free']));
        			
                	$query='SELECT id, hash, banner FROM banners WHERE id=? AND userId=?';
                	$banner_list=pdoSelect($query, array($result, $user_id));
        		}
            $connection->commit();
            
            if($result === 'error')
                // {"code":20,"res":[{"bannerId":20103194,"flags":623104,"size":39243}]}
                echo '{"code":500,"res":"'.$result.'"}';
            else {
                $banner_list[0]['banner'] = json_decode($banner_list[0]['banner']);
                // delete 
    		
        // 		if($imageBase64){
                require_once($_SERVER['DOCUMENT_ROOT'].'/php/saveImage.php');
                require_once($_SERVER['DOCUMENT_ROOT'].'/php/renderBanner.php');
                $render = new RenderBanner($banner_list[0]['hash']);
                $image = $render->getImage(true);
    		    $imageSaver = new SaveImage($image, '/photos/banners/'.$hash.'.png');
        // 		}
                
                $res = array('code' => 20, 
                    'res' => array(
                            "id" => $banner_list[0]['id'],
                            "id_parent" => "0",
                            "id_user" => $user_id,
                            "hash_id" => $banner_list[0]['hash'],
                            "name" => $banner_list[0]['banner']->properties->name,
                            "thumb" => "0",
                            "width" => $banner_list[0]['banner']->properties->width,
                            "height" => $banner_list[0]['banner']->properties->height,
                            "bgcolor" => $banner_list[0]['banner']->properties->bgcolor,
                            "quality" => $banner_list[0]['banner']->properties->quality,
                            "tags" => "",
                            "type" => $banner_list[0]['banner']->properties->type,
                            "banner_type" => "html5",
                            "date_created" => "2017-03-25 03:54:05",
                            "date_last_update" => $banner_list[0]['date_last_update'],
                            "date_published" => "2017-03-25 03:54:21",
                            "date_premium" => null,
                            "active" => "1",
                            "pub_free_embed" => "0",
                            "pub_pro_embed" => "0",
                            "pub_pro_embed_unlock_type" => "points",
                            "pub_pro_download" => "0",
                            "pub_pro_download_unlock_type" => "points",
                            "pub_pro_download_count" => "0",
                            "pub_free_gif" => "0",
                            "pub_free_mp4" => "0",
                            "premium" => "0",
                            "premium_type" => "subscription",
                            "flags" => 524288,
                            "version" => null,
                            "short_url" => "",
                            "score_overall" => null
                    )
                );
             
                echo json_encode($res);
            }
                
        } else 
            echo '{"code":500,"res":"Banner not found"}';
            
        break;
        
     case 'html5editor/save-template':
        saveTemplate($email, $userRequesting, $connection);
        break;
    
    case 'html5editor/get-user-images':
        $query='SELECT * FROM images WHERE user_id=?';
        $images_list=pdoSelect($query, array($user_id));
        
        if ($images_list != 'error' && $images_list != 'empty'){
            $res = '{"code":20,"res":'.json_encode($images_list).'}';
            
        } else $res = '{"code":20,"res":false}';
        
        echo $res;
        break;
    
    case 'html5editor/remove-user-image':
        $hash = $_GET['hash'];
        
    	$query='SELECT id, type FROM images WHERE user_id=? AND hash=?';
    	$image_list=pdoSelect($query, array($user_id, $_GET['hash']));
    	
    	if ($image_list != 'error' && $image_list != 'empty'){
            $id = $image_list[0]['id'];
            $type = $image_list[0]['type'];
        	
        	if(file_exists(ROOT_FOLDER.'/photos/files/'.$hash.'.'.$type)){
        	    unlink (ROOT_FOLDER.'photos/files/'.$hash.'.'.$type);
    	
            	$connection->beginTransaction();
            	$query='DELETE FROM images WHERE id=?';
            	$result=pdoSet($query, array($id));
            	$connection->commit();
            	
    	        echo '{"code": 20, "res": ""}';
            
        	} else 
                echo '{"code":500,"res":"image_not_found"}';
            
    	} else 
            echo '{"code":500,"res":"image_not_found"}';
            
        break;
        
    case 'html5editor/get-stock-images':
        // $stockURL = "http://www.bannersnack.com/ajax.php?page=html5editor%2Fget-stock-images&p=".$_GET['p']."&ipp=".$_GET['ipp']."&imagesPath=".$_GET['imagesPath']."&search=".$_GET['search'];
        // $response = get_web_page($stockURL, array('Cookie: PHPSESSID='.PHPSESSID));
        // https://www.theadstock.com/api/getPhotos/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5

        // if(json_decode($response)->code == 501){
        //     $PHPSESSID = loginToBannerSnack();
        //     $response = get_web_page($stockURL, array('Cookie: PHPSESSID='.$PHPSESSID));
        // }
        $response = '{"code":20,"res":[]}';
        echo $response;
        // echo '{"code":20,"res":[{"type":"addstock","hash":"c592345ac02ed5fbf8ae2bc27ap21692","name":"TAS113_0876","width":"400","height":"600","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=c592345ac02ed5fbf8ae2bc27ap21692"},{"type":"addstock","hash":"6427f9bc6a21f8246a1fb215b1p19266","name":"TAS70_4122","width":"400","height":"600","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=6427f9bc6a21f8246a1fb215b1p19266"},{"type":"addstock","hash":"434ba863323d1045c4c6595484p21010","name":"TAS95_1620","width":"400","height":"600","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=434ba863323d1045c4c6595484p21010"},{"type":"addstock","hash":"eb7febdf2244283e16406d15b5p18932","name":"TAS64_5568","width":"600","height":"400","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=eb7febdf2244283e16406d15b5p18932"},{"type":"addstock","hash":"ad90e1d2021eba53c4d7e11685p19076","name":"TAS70_4122","width":"400","height":"600","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=ad90e1d2021eba53c4d7e11685p19076"},{"type":"addstock","hash":"3ee952d7cdb2fcc22be7f28186p21011","name":"TAS95_1633","width":"400","height":"600","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=3ee952d7cdb2fcc22be7f28186p21011"},{"type":"addstock","hash":"06d09fccbce9b3b1944ff58333p18665","name":"TAS66_0184","width":"600","height":"400","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=06d09fccbce9b3b1944ff58333p18665"},{"type":"addstock","hash":"201888968186a6f2e2cff68780p21691","name":"TAS113_0863","width":"400","height":"600","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=201888968186a6f2e2cff68780p21691"},{"type":"addstock","hash":"2c9261d2616d66eccc28a45bb0p21012","name":"TAS95_1635","width":"400","height":"600","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=2c9261d2616d66eccc28a45bb0p21012"},{"type":"addstock","hash":"0d566c1e4146075280f373dbc0p21009","name":"TAS95_1619","width":"400","height":"600","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=0d566c1e4146075280f373dbc0p21009"},{"type":"addstock","hash":"cfc6bc44b2e18b5da1f7e6c2abp21013","name":"TAS95_1643","width":"400","height":"600","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=cfc6bc44b2e18b5da1f7e6c2abp21013"},{"type":"addstock","hash":"7eff7473e3f899c1600ee64a7bp21690","name":"TAS113_0861","width":"600","height":"400","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=7eff7473e3f899c1600ee64a7bp21690"},{"type":"addstock","hash":"af7d4192fb8ab2a1287bb526a7p19286","name":"TAS70_4214","width":"400","height":"600","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=af7d4192fb8ab2a1287bb526a7p19286"},{"type":"addstock","hash":"3f028b5edac5f015efe5b8c240p21693","name":"TAS113_0879","width":"400","height":"600","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=3f028b5edac5f015efe5b8c240p21693"},{"type":"addstock","hash":"43d2a531c833377055ea79b9dbp21027","name":"TAS95_2563","width":"600","height":"400","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=43d2a531c833377055ea79b9dbp21027"},{"type":"addstock","hash":"b74b3b66c3bfc612566428556dp18930","name":"TAS64_5451","width":"400","height":"600","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=b74b3b66c3bfc612566428556dp18930"},{"type":"addstock","hash":"cb77e61e24e868639fa6bcbfcfp19096","name":"TAS70_4214","width":"400","height":"600","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=cb77e61e24e868639fa6bcbfcfp19096"},{"type":"addstock","hash":"7178175b8c04ff38a009ee8fccp21016","name":"TAS95_1677","width":"400","height":"600","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=7178175b8c04ff38a009ee8fccp21016"},{"type":"addstock","hash":"860dc1911736d1d34df911d359p21014","name":"TAS95_1649","width":"400","height":"600","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=860dc1911736d1d34df911d359p21014"},{"type":"addstock","hash":"443e2daf21c8ba0ec8a0126ffep21015","name":"TAS95_1652","width":"400","height":"600","imagePath":"http:\/\/www.theadstock.com\/api\/getPhoto\/?PHPSESSID=hk1h82vpl40uqil2gs5cphg0n5&hash=443e2daf21c8ba0ec8a0126ffep21015"}]}';
        break;

    case 'html5editor/get-unsplash-images':
        $stockURL = "https://creator.klobic.com/ajax.php?page=html5editor%2Fget-unsplash-images&p=".$_GET['p']."&ipp=".$_GET['ipp']."&search=".$_GET['search'];
        $response = get_web_page($stockURL, array('Cookie: PHPSESSID='.PHPSESSID));
        
        if(json_decode($response)->code == 501){
            $PHPSESSID = loginToBannerSnack();
            $response = get_web_page($stockURL, array('Cookie: PHPSESSID='.$PHPSESSID));
        }
        
        echo $response;
        // echo '{"code":20,"res":[{"type":"unsplash","hash":"kjPM82o7UEA","name":"kjPM82o7UEA","width":"1080","height":"720","imagePath":"https:\/\/images.unsplash.com\/photo-1445880374709-535a5a1b49f9?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=736a259bdf9a6b5e82bb7130b200b459","download":"https:\/\/images.unsplash.com\/photo-1445880374709-535a5a1b49f9?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=64bf863259778f19658c1a7f31b2bf43","imageUserName":"Kukuh Himawan Samudro","imageUserLink":"http:\/\/unsplash.com\/@kukuhhimawans"},{"type":"unsplash","hash":"7kr1csqUgDE","name":"7kr1csqUgDE","width":"1080","height":"720","imagePath":"https:\/\/images.unsplash.com\/photo-1432672301844-a3619c197980?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=7f05ed068c23027b76e5f07f4a7fd840","download":"https:\/\/images.unsplash.com\/photo-1432672301844-a3619c197980?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=456d4a39681bf116123b11795103846b","imageUserName":"Fr\u00e9 Sonneveld","imageUserLink":"http:\/\/unsplash.com\/@fresonneveld"},{"type":"unsplash","hash":"NensSRftBZk","name":"NensSRftBZk","width":"1080","height":"720","imagePath":"https:\/\/images.unsplash.com\/photo-1445966275305-9806327ea2b5?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=890f928d1cc9cf2c94bdf05fbd17723b","download":"https:\/\/images.unsplash.com\/photo-1445966275305-9806327ea2b5?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=113f33bf9e5406561a33ed06c87fe3d8","imageUserName":"Anders Jild\u00e9n","imageUserLink":"http:\/\/unsplash.com\/@andersjilden"},{"type":"unsplash","hash":"-6-uqd2hMCg","name":"-6-uqd2hMCg","width":"1080","height":"721","imagePath":"https:\/\/images.unsplash.com\/photo-1430740537271-3448563a1a7e?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=448b5cb45bdc661dbf4e957fbc9e7a95","download":"https:\/\/images.unsplash.com\/photo-1430740537271-3448563a1a7e?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=11e530420e8ede199572f6724ec2ca89","imageUserName":"Stefan Kunze","imageUserLink":"http:\/\/unsplash.com\/@stefankunze"},{"type":"unsplash","hash":"CqBjlUs6t50","name":"CqBjlUs6t50","width":"1080","height":"720","imagePath":"https:\/\/images.unsplash.com\/photo-1446482972539-0ed52b3e9520?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=a8a4ae32193e55157ad8e222ed246d00","download":"https:\/\/images.unsplash.com\/photo-1446482972539-0ed52b3e9520?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=01a2e6ef5593ffa7fa56e40d6161e9d7","imageUserName":"Paul Summers","imageUserLink":"http:\/\/unsplash.com\/@somonesummers"},{"type":"unsplash","hash":"LoMs1_wq3tU","name":"LoMs1_wq3tU","width":"1080","height":"810","imagePath":"https:\/\/images.unsplash.com\/photo-1431887773042-803ed52bed26?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=5a44b45d712e9431cc6f5ae3a84f9326","download":"https:\/\/images.unsplash.com\/photo-1431887773042-803ed52bed26?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=d4b9322e0ddfff3fe39964c611ba87ab","imageUserName":"Jared Erondu","imageUserLink":"http:\/\/unsplash.com\/@erondu"},{"type":"unsplash","hash":"SDjnK0Emh6A","name":"SDjnK0Emh6A","width":"1080","height":"720","imagePath":"https:\/\/images.unsplash.com\/photo-1444558933668-ff021ea418e0?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=b3fc17b6cf69a4338f55b6da9b2c65a4","download":"https:\/\/images.unsplash.com\/photo-1444558933668-ff021ea418e0?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=b5a17c02c49e765217b94ebc40e50139","imageUserName":"Nitish Kadam","imageUserLink":"http:\/\/unsplash.com\/@nitish007"},{"type":"unsplash","hash":"bBG0dtdDf6A","name":"bBG0dtdDf6A","width":"1080","height":"810","imagePath":"https:\/\/images.unsplash.com\/photo-1429044605642-68283f617432?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=92d94655d799f6611961d2a509b7a736","download":"https:\/\/images.unsplash.com\/photo-1429044605642-68283f617432?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=56b1c7425a70374d29095fe5c7558a3f","imageUserName":"Wolfgang Bonness","imageUserLink":"http:\/\/unsplash.com\/@leadwolf"},{"type":"unsplash","hash":"_Vq7JTlS4XE","name":"_Vq7JTlS4XE","width":"1080","height":"720","imagePath":"https:\/\/images.unsplash.com\/photo-1445297983845-454043d4eef4?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=8034adffd869437bac84c7f7e6ce7708","download":"https:\/\/images.unsplash.com\/photo-1445297983845-454043d4eef4?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=8339adf6dd8dd521440f9899ea6d3991","imageUserName":"Drew Hays","imageUserLink":"http:\/\/unsplash.com\/@drew_hays"},{"type":"unsplash","hash":"-R3C6Ub0FIU","name":"-R3C6Ub0FIU","width":"1080","height":"720","imagePath":"https:\/\/images.unsplash.com\/photo-1446575983799-470c50cfdd25?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=31f9a59b3574edcffd872d4e2df01fa4","download":"https:\/\/images.unsplash.com\/photo-1446575983799-470c50cfdd25?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=afd64eaf532dcf65918e6cf48603985c","imageUserName":"Collie Coburn","imageUserLink":"http:\/\/unsplash.com\/@colliesr"},{"type":"unsplash","hash":"xAs4SI0-3YM","name":"xAs4SI0-3YM","width":"1080","height":"810","imagePath":"https:\/\/images.unsplash.com\/photo-1445963103800-438f19d6e1e1?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=43a9f2d7815d8a545871faa36a96d14a","download":"https:\/\/images.unsplash.com\/photo-1445963103800-438f19d6e1e1?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=553f3fcd384e5b896b3eabda924db4ae","imageUserName":"Georg Nietsch","imageUserLink":"http:\/\/unsplash.com\/@bartondawes"},{"type":"unsplash","hash":"3Ku0e3k9qXU","name":"3Ku0e3k9qXU","width":"1080","height":"720","imagePath":"https:\/\/images.unsplash.com\/photo-1444041401850-6d9f537550c4?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=826da54cd3372ed5171843458dffedcf","download":"https:\/\/images.unsplash.com\/photo-1444041401850-6d9f537550c4?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=c2e4116b8dcf2baad33b21ed8427be11","imageUserName":"Lukasz Szmigiel","imageUserLink":"http:\/\/unsplash.com\/@szmigieldesign"},{"type":"unsplash","hash":"04zTvMalMfU","name":"04zTvMalMfU","width":"1080","height":"720","imagePath":"https:\/\/images.unsplash.com\/photo-1429081271179-49f13a9d4d99?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=ace7b99afd7193e196bca37847e7bab1","download":"https:\/\/images.unsplash.com\/photo-1429081271179-49f13a9d4d99?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=fa0d11d04070e899f97401c2276653ed","imageUserName":"Adriel Kloppenburg","imageUserLink":"http:\/\/unsplash.com\/@adriel"},{"type":"unsplash","hash":"Y9L7bPlJ3e8","name":"Y9L7bPlJ3e8","width":"1080","height":"810","imagePath":"https:\/\/images.unsplash.com\/photo-1429189096272-e07dc6aff539?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=f53e996ee48601ca53dd713a6f9244be","download":"https:\/\/images.unsplash.com\/photo-1429189096272-e07dc6aff539?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=9cad6a72b527ee7952b340bb5cbc9eec","imageUserName":"Anna  O\'Connolly","imageUserLink":"http:\/\/unsplash.com\/@anna_molly"},{"type":"unsplash","hash":"i_ivTcj8GFo","name":"i_ivTcj8GFo","width":"1080","height":"810","imagePath":"https:\/\/images.unsplash.com\/photo-1444351274028-b348e6da5f67?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=f538d2563f208526abb7a40119cc79d0","download":"https:\/\/images.unsplash.com\/photo-1444351274028-b348e6da5f67?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=5e88afd52b980073351db0f4d7bb985c","imageUserName":"Cagatay Orhan","imageUserLink":"http:\/\/unsplash.com\/@cagatayorhan"},{"type":"unsplash","hash":"wC69cxOE7Us","name":"wC69cxOE7Us","width":"1080","height":"769","imagePath":"https:\/\/images.unsplash.com\/photo-1433275630538-e87b43e53140?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=b4143cee492916944e8fe7dc8aa8bfae","download":"https:\/\/images.unsplash.com\/photo-1433275630538-e87b43e53140?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=74d2b83f8caba685e20ca40e55f7d7a5","imageUserName":"Ales Krivec","imageUserLink":"http:\/\/unsplash.com\/@aleskrivec"},{"type":"unsplash","hash":"hjdQdd3oudQ","name":"hjdQdd3oudQ","width":"1080","height":"720","imagePath":"https:\/\/images.unsplash.com\/photo-1445462357936-a1ae5e6706a6?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=b17603b312e75403b2407967c87ef5d1","download":"https:\/\/images.unsplash.com\/photo-1445462357936-a1ae5e6706a6?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=efeba3f09b56fd69dba6fd377e79722f","imageUserName":"Rob Morton","imageUserLink":"http:\/\/unsplash.com\/@rmorton3"},{"type":"unsplash","hash":"NFwDSMSq54Q","name":"NFwDSMSq54Q","width":"1080","height":"504","imagePath":"https:\/\/images.unsplash.com\/photo-1444526255837-566d42bd8a74?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=f04c18ba2019aa1d4a6e949b5ef6d918","download":"https:\/\/images.unsplash.com\/photo-1444526255837-566d42bd8a74?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=1ebe73db78331080a5ecba5f32a11e76","imageUserName":"Jeremy Goldberg","imageUserLink":"http:\/\/unsplash.com\/@jeremy"},{"type":"unsplash","hash":"UNOMwllEXfg","name":"UNOMwllEXfg","width":"1080","height":"666","imagePath":"https:\/\/images.unsplash.com\/photo-1431727499043-70167d3d8c90?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=08669a8f2c4d94b88f18e57c34043335","download":"https:\/\/images.unsplash.com\/photo-1431727499043-70167d3d8c90?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=28d5e5f6b4b0d383feca94b4db7f5e31","imageUserName":"Avel Chuklanov","imageUserLink":"http:\/\/unsplash.com\/@chuklanov"},{"type":"unsplash","hash":"yCH2PXtwdwc","name":"yCH2PXtwdwc","width":"1080","height":"715","imagePath":"https:\/\/images.unsplash.com\/photo-1444824350087-2460ceb43eef?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=6e50df5b49a1634105cad16d5d248462","download":"https:\/\/images.unsplash.com\/photo-1444824350087-2460ceb43eef?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&s=88a6a6f029fa453f433a9af2df0d5911","imageUserName":"Linda Xu","imageUserLink":"http:\/\/unsplash.com\/@rhindaxu"}]}';
        break;

    case 'banner-creator/new-banner':
        $_SESSION['w'] = $_GET['w'];
        $_SESSION['h'] = $_GET['h'];
        echo '{"code":20,"res":false}';
        break;

    case 'banner-creator/get-banner-json':
        if(isset($_SESSION['w'])) {
            $width = $_SESSION['w'];
            $_SESSION['w'] = null;
        } else 
            $width = 336;
        
        if(isset($_SESSION['h'])) {
            $height = $_SESSION['h'];
            $_SESSION['h'] = null;
        } else 
            $height = 280;
            
        if($_GET['hash'])
            $hash = $_GET['hash'];
        else
            $hash = generateRandomString();
        
        $query='SELECT * FROM templates WHERE hash=?';
        $banner_list=pdoSelect($query, array($hash));
        
        if ($banner_list == 'empty'){
            $query='SELECT * FROM banners WHERE hash=? AND userId=?';
            $banner_list=pdoSelect($query, array($hash, $user_id));
        }
        
        if ($banner_list != 'error' && $banner_list != 'empty'){
            $banner = $banner_list[0];
            $banner['banner'] = json_decode($banner_list[0]['banner']);
            
        } else 
            $banner = array(
                        "hash" => $hash,
                        "userId" => $user_id,
                        "paid" => 0,
                        "banner" => array(
                            "properties" => array(
                                "status" => "temp",
                                "name" => "",
                                "width" => $width,
                                "height" => $height,
                                "loop" => false,
                                "imageQuality" => 90,
                                "bannerUrl" => "",
                                "urlTarget" => "_blank",
                                "useHandCursor" => true,
                                "useBannerEntireArea" => true,
                                "bannerSize" => "300 x 250 - Medium rectangle",
                                "customSize" => true,
                                "presetSize" => false,
                                "backgroundColor" => array(
                                    "type" => "solid",
                                    "scolor" => "rgba(255,255,255,1)",
                                    "borderColor" => "#3d3d3d",
                                    "useBorder" => false
                                )
                            ),
                            "elements" => array(
                                array(
                                    "type" => "slide",
                                    "properties" => array(
                                        "duration" => 5
                                    ),
                                    "elements" => array()   
                                )
                            )
                        )
                    );
        
        $res = array('code' => 20, 
            'res' => 
                array('bannerJson' => $banner)
            );
            
        echo json_encode($res);
        // echo '{"code":20,"res":{"bannerJson":{"hash":"bc3eoa8pb","userId":"27518096","banner":{"properties":{"status":"temp","name":"","width":336,"height":280,"loop":false,"imageQuality":90,"bannerUrl":"","urlTarget":"_blank","useHandCursor":true,"useBannerEntireArea":true,"bannerSize":"300 x 250 - Medium rectangle","customSize":true,"presetSize":false,"backgroundColor":{"type":"solid","scolor":"rgba(255,255,255,1)","borderColor":"#3d3d3d","useBorder":false}},"elements":[{"type":"slide","properties":{"duration":5},"elements":[]}]}}}}';
        break;

    case 'banner-creator/my-banners/activate-options':
        $res = array('code' => 20, 
            'res' => array(
                "id" => 19658969,
                "data" =>  array(
                    array(
                        "type" => "free_html5_gif",
                        "status" => "WAITING"
                    )
                )
            )
        );

        echo json_encode($res);
        // echo '{"code":20,"res":{"id":19658969,"data":[{"type":"free_html5_gif","status":"WAITING"}]}}';
        break;

    default:
        // if upload an image
        if(isset($_FILES['0']) && $_FILES['0']['error'] != UPLOAD_ERR_NO_FILE) {
			
			$hash = generateRandomString(6, false);
            $fileName = $_FILES['0']['name'];
            $fileType = $_FILES['0']['type'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            
            // $fileContent = file_get_contents($_FILES['0']['tmp_name']);
            // header('Content-type: '.$fileType);

            
            // readfile($_FILES['0']['tmp_name']);
            // echo base64_encode($fileContent);
            // $fileContent = 'data:' . $fileType . ';base64,' . base64_encode($fileContent);
            
            $path = ROOT_FOLDER.'/photos/files/'.$hash.'.'.$fileExtension;
            move_uploaded_file($_FILES['0']['tmp_name'], $path);
            list($width, $height) = getimagesize($path);
            
            $connection->beginTransaction();
            
			$query='INSERT INTO images (user_id, hash, filename, type, width, height) VALUES (?, ?, ?, ?, ?, ?)';
			$result=pdoSet($query, array($user_id, $hash, $fileName, $fileExtension, $width, $height));
			
            $connection->commit();
            
            if($result != 'error'){
                $res = array('code' => 20, 
                    'res' => array(
                        "id" => $result,
                        "id_user" => $user_id,
                        "hash_id" => $hash,//"6849ec4d77dc2933c29227ff52901224",
                        "filename" => $fileName,
                        "type" => $fileExtension,
                        "width" => $width,
                        "height" => $height,
                        "size" => $_FILES['0']['size'],
                        // "date" => "2017-03-16 14:06:18",
                        // "status" => "pending",
                        // "cloneof" => null,
                        // "cloneof_url" => null,
                        // "date_changed" => "2017-03-16 14:06:18",
                        // "relation" => 1,
                        "hash" => $hash//"6849ec4d77dc2933c29227ff52901224"
                    )
                );
                echo json_encode($res);
                
            } else {
            	if(file_exists($path))
            	    unlink ($path);
            	    
                echo '{"code":500,"res":"Error"}';
            }
            
            // echo '{"code":20,"res":{"id":52901224,"id_user":"27518096","hash_id":"6849ec4d77dc2933c29227ff52901224","filename":"J.jpeg","type":"jpg","width":460,"height":460,"size":34120,"date":"2017-03-16 14:06:18","status":"pending","cloneof":null,"cloneof_url":null,"date_changed":"2017-03-16 14:06:18","relation":1,"hash":"6849ec4d77dc2933c29227ff52901224"}}';
            break;
        }

        echo '{"code":20,"res":false}';
        break;
}

die();
