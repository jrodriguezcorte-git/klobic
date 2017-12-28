<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/config/settings.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');

require ROOT_FOLDER . 'vendor/autoload.php';
use Knp\Snappy\Image;
use Knp\Snappy\Media;

/**
 * Class SaveImage
 * handles the images save process
 */
class RenderBanner
{
    public function __construct($hash, $showSlide = 0)
    {	
    	$query='SELECT * FROM banners WHERE hash=? ORDER BY id DESC';
    	$banner_list=pdoSelect($query, array($hash));
    	
		if ($banner_list == 'empty'){
	    	$query='SELECT * FROM templates WHERE hash=? ORDER BY id DESC';
	    	$banner_list=pdoSelect($query, array($hash));
		}
	    	
		if ($banner_list != 'error' && $banner_list != 'empty'){
			/* 'wkhtmltoimage' executable  is located in the current directory */
			$snappy = new Image(ROOT_FOLDER . 'vendor/bin/wkhtmltoimage-amd64');
			$banner = json_decode($banner_list[0]['banner']);
			$width = $banner->properties->width;
			$height = $banner->properties->height;
			
			/* Displays the bbc.com website index page screen-shot in the browser */
			// header("Content-Type: image/jpg");
			
			// $snappy->setOption('zoom', 2);
			$snappy->setOption('crop-h', $height);
			$snappy->setOption('crop-w', $width);
			// $snappy->setOption('disable-smart-width', false);
			// $snappy->setOption('enable-smart-width', false);
		
			$snappy->setOption('quality', 100);
			// echo DOMAIN_NAME.'banners/'. $banner_list[0]['hash'] .'/embed/index?'.HTTP_GET_SECRET.'='.HTTP_GET_SECRET_TOKEN.'&showSlide='.$showSlide.'&noAnimation=true';
			$this->image = $snappy->getOutput(DOMAIN_NAME.'banners/'. $banner_list[0]['hash'] .'/embed/index?'.HTTP_GET_SECRET.'='.HTTP_GET_SECRET_TOKEN.'&showSlide='.$showSlide.'&noAnimation=true');
		}

    }
    
	public function getImage($base4 = false)
	{	
		if($base4)
			return 'data:image/png;base64,' . base64_encode($this->image);
			
	    return $this->image;
	}
}
?>
