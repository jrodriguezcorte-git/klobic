<?php
    if(!$bannerJson) $bannerJson=$_POST['json'];
    if($bannerJson){
        $data = json_decode($bannerJson);
        $id = $data->hash;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="ad.size" content="width=336,height=280">
    <title></title>
    <?php if(PRODUCTION) { ?>
        <link type="text/css" rel="stylesheet" href="/css/embed/embed.min.css?v=2.0" />
        <script src="/js/embed/embed.min.js?v=2.0"></script>
    <?php } else { ?>
        <link type="text/css" rel="stylesheet" href="/css/app/embed/embed.css?v=2.0" />
        <script src="/js/app/embed/embed.js?v=2.0"></script>
    <?php } ?>
    
    <script>
        var clickTag = '';
        var bannerJson = <?php if($bannerJson) echo $bannerJson; else echo '{}'; ?>;
        var bannerConfig = {
            "photosUrl":"\/files\/",
            "embedUrl":"\/banners\/<?php if($id) echo $id; else echo 'bxh82u1b8'; ?>\/embed\/",
            "startSlide": <?php if(isset($_GET['showSlide']) && is_numeric($_GET['showSlide'])) echo $_GET['showSlide']; else echo 'null'; ?>,
            "noAnimation": <?php if(isset($_GET['noAnimation'])) echo 'true'; else echo 'false'; ?>,
            "preview": <?php if(empty($isPreview)) echo 'true'; else echo 'false'; ?>,
            "showOnlyOneSlide": <?php if(isset($_GET['showSlide'])) echo 'true'; else echo 'false'; ?>,
            "download": false,
            "env": "live",
            "printScreen": <?php if($_GET[HTTP_GET_SECRET] == HTTP_GET_SECRET_TOKEN) echo 'true'; else echo 'false'; ?>
        };
        document.addEventListener("DOMContentLoaded", function() {
            var embedCanvas = new EmbedCanvas();
            embedCanvas.init(document.getElementById("bs"), bannerJson, bannerConfig);

        });
    </script>
</head>
<body><div id="bs"></div></body>
</html>
