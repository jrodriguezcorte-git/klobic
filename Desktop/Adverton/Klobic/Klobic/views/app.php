<?php
$hideBoostrap = true;
require_once('views/tpl/head.php');
// load the registration class
require_once("config/settings.php");
require_once("php/connection.php");

$email = $_SESSION['user_email'];
$query='SELECT * FROM users WHERE email=?';
$user_list=pdoSelect($query, array($email));

if ($user_list != 'error' && $user_list != 'empty'){
    $user_id = $user_list[0]['id'];
    
} else {
    Redirect('/auth/login.php', false);
    die();
}

?>

    <!--[if lte IE 8]>
    <link type="text/css" rel="stylesheet" href="/css/ie.css?6">
    <link rel="stylesheet" type="text/css" href="/css/startupfw-ie8.css" />
    <![endif]-->
    <!--[if IE 9]><link type="text/css" rel="stylesheet" href="/css/ie9.css"><![endif]-->


	<script src="/js/jquery/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="/js/jquery/jquery.js"><\/script>')</script>


    <script src="/js/jqueryui/jquery-ui.min.js"></script>
    
    <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

    <!--<script type="text/javascript" src="/js/circliful/jquery.circliful.min.js"></script>-->

    <!--<script type="text/javascript" src="/js/heatmap/heatmap.js"></script>-->

    <script src="https://fb.me/react-with-addons-0.13.3.min.js"></script>
    <script>window.React || document.write('<script src="/js/react-0.13.3/react-with-addons.min.js"><\/script>')</script>

    <script type="text/javascript">
        var PAGE = 'banner-creator';
    </script>
    <script type="text/javascript" src="/js/bootstrap/bootstrap.min.js?v=<?php echo APP_VERSION; ?>"></script>

    <?php if(PRODUCTION) { ?>
        <script type="text/javascript">
            window.translationsJsFilePath = '/js/lang/en.min.js?v=<?php echo APP_VERSION; ?>';
        </script>
        
        <link type="text/css" rel="stylesheet" href="/css/global.min.css?v=<?php echo APP_VERSION; ?>" />
        <link rel="stylesheet" type="text/css" href="/css/session.min.css?v=<?php echo APP_VERSION; ?>" />
    
        <script type="text/javascript" src="/js/global.min.js?v=<?php echo APP_VERSION; ?>"></script>
        
        <script type="text/javascript" src="/js/session.min.js?v=<?php echo APP_VERSION; ?>"></script>
        <script type="text/javascript" src="/js/lang/en.min.js?v=<?php echo APP_VERSION; ?>"></script>
    <?php } else { ?>
        <script type="text/javascript">
            window.translationsJsFilePath = '/js/app/lang/en.js?v=<?php echo APP_VERSION; ?>';
        </script>
        
        <link type="text/css" rel="stylesheet" href="/css/app/global.css?v=<?php echo APP_VERSION; ?>" />
        <link rel="stylesheet" type="text/css" href="/css/app/session.css?v=<?php echo APP_VERSION; ?>" />
        
        <script type="text/javascript" src="/js/app/global.js?v=<?php echo APP_VERSION; ?>"></script>
        
        <script type="text/javascript" src="/js/app/session.js?v=<?php echo APP_VERSION; ?>"></script>
        <script type="text/javascript" src="/js/app/lang/en.js?v=<?php echo APP_VERSION; ?>"></script>
    <?php } ?>

    <!-- Google Analytics -->
    <script>
        (function(i,s,o,g,r,a,m){ i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    
        ga('create', 'UA-96093857-1', { 'legacyCookieDomain': 'none', 'allowLinker': true});
            ga('set', 'userId', <?php echo $user_list[0]['id']; ?>);
            ga('require', 'displayfeatures');
        ga('send', 'pageview', { 'page': location.pathname + location.search + location.hash});
    
    </script>
    <!-- End Google Analytics -->
    
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KM9WTRS');</script>
    <!-- End Google Tag Manager -->
    
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KM9WTRS"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    
    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window,document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '177415139465506'); 
    fbq('track', 'PageView');
    </script>
    <noscript>
    <img height="1" width="1" 
    src="https://www.facebook.com/tr?id=177415139465506&ev=PageView
    &noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->

	<!-- Start Alexa Certify Javascript -->
    <script type="text/javascript">
        var langPre = '';

        var userData = {
            "id": <?php echo $user_list[0]['id'] ?>,
            "admin": "<?php echo $user_list[0]['admin'] ?>",
            "accountId": "",
            "premium": true,
            "bannersCount": 0,
            "bannersCountCurrentCycle": 0,
            "rotatorsCount": 0,
            "occupation": "developer",
            "totalBannersCreated": 0,
            "confirmed": "1",
            "serviceType": "premium",
            "featuresAccess": {
                "bm_animated_templates": "yes",
                "bm_animation_presets": "yes",
                "bm_klobic_analytics": "7_d",
                "bm_banner_score": "yes",
                "bm_buttons": "yes",
                "bm_cliparts": "yes",
                "bm_download_gif": "no",
                "bm_download_html5": "no",
                "bm_download_images": "yes",
                "bm_download_mp4": "no",
                "bm_download_swf": "no",
                "bm_embed_code_views": "1000",
                "bm_embed_elements": "yes",
                "bm_heatmap": "no",
                "bm_menu": "yes",
                "bm_multiple_slides": "yes",
                "bm_number_of_banners": 10,
                "bm_static_templates": "yes",
                "bm_stock_photos": "yes",
                "bm_tags": "no",
                "bm_transitions": "yes",
                "bm_video": "yes",
                "br_advanced_rotation_settings": "yes",
                "br_klobic_analytics": "7_d",
                "br_embed_code_views": "1000",
                "br_number_of_rotators": 10
            },
            "registeredTime": 1487224800
        };
	</script>

</head>
<body class="lang-en logged">
	<div class="app-main-container">
        <div class="app-page-content">
            <script>
            window.bannerCreatorConfig = {
                previewUrl: "/preview/",
                originalImagesPath: "/files/",
                thumbsImagesPath: "/files/",
                cdnUrl: "/",
                templatesPath: "/banners/",
                texturesPath: "textures/images/",
                texturesThumbPath: "textures/thumbs/",
                accountDetails: {
                    "user_id":<?php echo $user_list[0]['id'] ?>,
                    "profile_photo":"/images/abstract-user-flat-4.svg",
                    "flags":"2",
                    "occupation":"developer"
                },
                userData: 
                {
                    "user":{
                        "id": <?php echo $user_list[0]['id'] ?>,
                        "screenname": "<?php echo $user_list[0]['name'] ?>",
                        "displayName": "<?php echo $user_list[0]['name'] ?>",
                        "email": "<?php echo $user_list[0]['email'] ?>",
                        "admin": "<?php echo $user_list[0]['admin'] ?>",
                        "flags":"2049",
                        "confirmed":"1",
                        "active":"1"
                    },
                    "bsData":{
                            "isAgencyAdministrator":false,
                            "isInCompany":false,
                            "isAgencyManager":false,
                            "showBudgetLink":false,
                            "hasBanners":true,
                            "hasCampaigns":false,
                            "hasRotators":false,
                            "agencyManagerHasClients":false,
                            "isCampaignAdmin":false,
                            "haveWhiteLabel":false,
                            "whiteLabel":null,
                            "budget":0
                        }
                },
                iframeEmbedHtml5Path: '/banners/',
                env: 'live',
                shortUrl: '<?php echo DOMAIN_NAME; ?>banners/',
                uaSessionId: $.userApi.sessionId,
                downloadUrls: {
                    "gif":"\/images\/gif?download=true",
                    "jpg":"\/images\/jpg?download=true",
                    "png":"\/images\/png?download=true"
                },
                managers: [],
                embedConfig: {
                <?php if(PRODUCTION) { ?>
                    "embedPath":"\/\/<?php echo DOMAIN_NAME_NO_HTTP; ?>js\/iframe\/embed.min.js",
                    "embedFloatPath":"\/\/<?php echo DOMAIN_NAME_NO_HTTP; ?>js\/iframe\/embed_float.min.js",
                <?php } else { ?>
                    "embedPath":"\/\/<?php echo DOMAIN_NAME_NO_HTTP; ?>js\/app\/iframe\/embed.js",
                    "embedFloatPath":"\/\/<?php echo DOMAIN_NAME_NO_HTTP; ?>js\/app\/iframe\/embed_float.js",
                <?php } ?>
                    "iframeEmbedHtml5Path":"\/\/<?php echo DOMAIN_NAME_NO_HTTP; ?>banners\/"
                },
                feedbackInfo: {
                    "votedForFeatures":false,
                    "points":0
                }
            };
        
            // Verifica daca e IE si ii zicem ca nu mai suportam IE
            $(function() {
                var ieVersion = getIeVersion();
                if (ieVersion && ieVersion < 12) {
                    displayIEMessage($('.app-page-content'));
                    $(".loader-hover").remove();
                    $('.app-page-content').css({ opacity: 1 });
                }
            });
        </script>

        <div id="bannerCreatorApp"></div>
    
        <?php if(PRODUCTION) { ?>
            <link href="/css/creator.min.css?v=<?php echo APP_VERSION; ?>" rel='stylesheet' type='text/css'/>
            <script type="text/javascript" src="/js/vendors.min.js?v=<?php echo APP_VERSION; ?>"></script>
            <script type="text/javascript" src="/js/creator.min.js?v=<?php echo APP_VERSION; ?>"></script>
        <?php } else { ?>
            <link href="/css/app/creator.css?v=<?php echo APP_VERSION; ?>" rel='stylesheet' type='text/css'/>
            <script type="text/javascript" src="/js/app/vendors.js?v=<?php echo APP_VERSION; ?>"></script>
            <script type="text/javascript" src="/js/app/creator.js?v=<?php echo APP_VERSION; ?>"></script>
        <?php } ?>

        </div>

    </div>
    <form action="/pay/choose.php" method="GET" id="pay_form" style="display:none;visibility:hidden;">
        <!-- Specify details about the item that buyers will purchase. -->
        <input type="hidden" name="item_name" value="null">
        <input type="hidden" name="item_number" value="null">
    </form>

    <script type="text/javascript">

        window.googleChart = false;
        // Load the Google Visualization API.
        // google.load('visualization', '1.0', {'packages':['corechart']});
        google.charts.load('43', {'packages':['corechart']}); // had to set version to 43 because there is a problem with version 44

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(function(){
            window.googleChart = true;
        });

    </script>
    <?php include($_SERVER['DOCUMENT_ROOT'].'/views/tpl/feedback.php'); ?>

</body>
</html>
