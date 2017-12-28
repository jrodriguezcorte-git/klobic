<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/views/tpl/head-init.php');

// ... ask if we are logged in here:			
if ($login->isUserLoggedIn() == true) {
    Redirect('/', false);

} else {
    $forgot = new Forgot();
    
    require_once($_SERVER['DOCUMENT_ROOT'].'/views/tpl/head.php');
?>
    <?php if(PRODUCTION) { ?>
        <script type="text/javascript" charset="utf-8" src="/js/user/loginSignup.min.js?v=<?php echo APP_VERSION; ?>"></script>
    <?php } else { ?>
        <script type="text/javascript" charset="utf-8" src="/js/app/user/loginSignup.js?v=<?php echo APP_VERSION; ?>"></script>
    <?php } ?>
</head>

<body>
    <!--[if lt IE 7]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <?php include($_SERVER['DOCUMENT_ROOT'].'/views/tpl/navbar.php')?>
    
    <!-- Example row of columns -->
    <div class="main-holder">
        <form class="form-horizontal" name="loginform">
            <div class="login-box">
                <h1>Forgot your password?</h1>
                <h5>We'll send you an email to restore your password.</h5>
                <div id="errors"></div>
                <div class="form-group">
                    <input type="email" name="user_email" class="form-control" id="login_input_email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" placeholder="Email" />
                </div>
                <p>
                    <a href="login.php">Back to Login Page</a>
                </p>
                <button type="submit" name="submit" class="form-submit">Submit</button>
                
                <?php $token = NoCSRF::generate( 'csrf_token' ); ?>
        	    <input type="hidden" name="csrf_token" value="<?php echo $token; ?>" />
        	    <input type="hidden" name="forgot" id="forgot" />
            </div>
        </form>
    </div>
    
    <?php include($_SERVER['DOCUMENT_ROOT'].'/views/tpl/footer.php'); ?>
    <!-- /container -->

</body>

</html>
<?php
    }
?>
