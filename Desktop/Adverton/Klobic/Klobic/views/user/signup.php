<?php 
// include the configs / constants for the database connection
require_once($_SERVER['DOCUMENT_ROOT']."/views/tpl/head-init.php");

// ... ask if we are logged in here:			
if ($login->isUserLoggedIn() == true && !isset($_POST["update-account"])) {
    Redirect('/', false);

} else {
// create the registration object. when this object is created, it will do all registration stuff automatically
// so this single line handles the entire registration process.
$registration = new Registration();

require_once($_SERVER['DOCUMENT_ROOT'].'/views/tpl/head.php');
?>
    <?php if(PRODUCTION) { ?>
        <script type="text/javascript" charset="utf-8" src="/js/user/loginSignup.min.js?v=<?php echo APP_VERSION; ?>"></script>
    <?php } else { ?>
        <script type="text/javascript" charset="utf-8" src="/js/app/user/loginSignup.js?v=<?php echo APP_VERSION; ?>"></script>
    <?php } ?>
    <script>
    $(document).ready(function () {
        var name = $('<input>').attr('type', 'text').attr('name', 'user_name').attr('id', 'login_input_name').attr('pattern', '[a-zA-Z0-9\s]{2,64}').attr('placeholder', 'Nombre').attr('class', 'form-control'),
        email = $('<input>').attr('type', 'email').attr('name', 'user_email').attr('id', 'login_input_email').attr('pattern', '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$').attr('placeholder', 'Email').attr('class', 'form-control'),
        password = $('<input>').attr('type', 'password').attr('name', 'user_password_new').attr('id', 'login_input_password_new').attr('placeholder', 'Contraseña').attr('class', 'form-control'),
        passwordConfirm = $('<input>').attr('type', 'password').attr('name', 'user_password_repeat').attr('id', 'login_input_password_repeat').attr('placeholder', 'Repetir contraseña').attr('class', 'form-control'),
        button = $('<button>').attr('type', 'submit').attr('name', 'register').attr('class', 'form-submit').html('Sign up');
        
        name.appendTo($('.form-group')[0]);
        email.appendTo($('.form-group')[1]);
        password.appendTo($('.form-group')[2]);
        passwordConfirm.appendTo($('.form-group')[3]);
    });
    </script>
</head>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'].'/views/tpl/navbar.php')?>
    <!-- Example row of columns -->
    <div class="main-holder">
        <form class="form-horizontal" action='signup.php' method="post" name="registerform">
            <div class="login-box">
                <h1>Registrese</h1>
                <div id="errors"></div>
                <div class="form-group"></div>
                <div class="form-group"></div>
                <div class="form-group"></div>
                <div class="form-group"></div>
                <p>
                    <a href="login.php">Ir a la página de Login</a>
                </p>
                <button type="submit" name="register" class="form-submit">Registrarse</button>
                
                <?php $token = NoCSRF::generate( 'csrf_token' ); ?>
        	    <input type="hidden" name="csrf_token" value="<?php echo $token; ?>" />
        	    <input type="hidden" name="register" />
            </div>
        </form>
    </div>
        
    <?php include($_SERVER['DOCUMENT_ROOT'].'/views/tpl/footer.php'); ?>
    <!-- /container -->
</body>

</html>
<?php } ?>