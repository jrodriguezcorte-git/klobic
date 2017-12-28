<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/views/tpl/head-init.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<meta name="DESCRIPTION" content="" />
	<meta name="LANGUAGE" content="en" />
    <meta name="AUDIENCE" content="ALL" />
    <meta name="COPYRIGHT" content="<?php echo COMPANY_NAME; ?>" />
    <meta name="AUTHOR" content="<?php echo COMPANY_NAME; ?>" />
    <script type="text/javascript">
        var vpw = (screen.width<768) ? 'width=768' : "width=device-width, initial-scale=1";
        document.write('<meta name="viewport" content="'  + vpw + '" >');
    </script>
    <meta name="format-detection" content="telephone=no">

    <title><?php echo COMPANY_NAME; ?></title>

    <link rel="icon" href="/images/favicon.ico" sizes="32x32" />
    <link rel="icon" href="/images/favicon-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon-precomposed" href="/images/favicon-180x180.png" />
    <meta name="msapplication-TileImage" content="/images/favicon-270x270.png" />

    <link type="text/css" rel="stylesheet" href="/css/bootstrap.min.css?v=<?php echo APP_VERSION; ?>" async="true" />
    <link type="text/css" rel="stylesheet" href="/fonts/font-awesome/css/font-awesome.min.css?v=<?php echo APP_VERSION; ?>" async="true" />
    <link type="text/css" rel="stylesheet" href="/fonts/ionicons/css/ionicons.min.css?v=<?php echo APP_VERSION; ?>" async="true" />
    <link type="text/css" rel="stylesheet" href="/fonts/foundation-icons/foundation-icons.css?v=<?php echo APP_VERSION; ?>" async="true" />
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    
    <?php if(empty($hideBoostrap)) { ?>
        <script src="/js/jquery/jquery.min.js"></script>
        <script src="/js/bootstrap/bootstrap.min.js"></script>
    <?php } else { ?>
        <script type="text/javascript" charset="utf-8" src="/js/jquery/jquery.min.js"></script>
    <?php } ?>
    
    
    <?php if(PRODUCTION) { ?>
        <script type="text/javascript" charset="utf-8" src="/config/settings.min.js?v=<?php echo APP_VERSION; ?>"></script>
        <script type="text/javascript" charset="utf-8" src="/js/functions.min.js?v=<?php echo APP_VERSION; ?>"></script>
        <link rel="stylesheet" href="/css/main.min.css?v=<?php echo APP_VERSION; ?>"> 
    <?php } else { ?>
        <script type="text/javascript" charset="utf-8" src="/config/settings.js?v=<?php echo APP_VERSION; ?>"></script>
        <script type="text/javascript" charset="utf-8" src="/js/app/functions.js?v=<?php echo APP_VERSION; ?>"></script>
        <link rel="stylesheet" href="/css/app/main.css?v=<?php echo APP_VERSION; ?>"> 
    <?php } ?>