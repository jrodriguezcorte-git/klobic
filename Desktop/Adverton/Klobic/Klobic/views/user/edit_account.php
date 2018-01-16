<?php 
// include the configs / constants for the database connection
require_once("views/tpl/head-init.php");

$loggedIn = $login->isUserLoggedIn();

if($loggedIn)
	$_SESSION['need_change_password'] = false;

if(!$loggedIn && isset($_GET['tk']) && $_GET['action'] === 'reset'){
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/connection.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
    
    $decryptedToken = encrypt_decrypt('decrypt', $_GET['tk']);
    $tokenInfo = json_decode($decryptedToken);
    
    if($tokenInfo && json_last_error() == JSON_ERROR_NONE && isset($tokenInfo->id) && isset($tokenInfo->time)){
        if((time() - $tokenInfo->time) < 30*60){
            $query='SELECT id, name, email FROM users WHERE id=?';
            $user_list=pdoSelect($query, array($tokenInfo->id));
            
            if ($user_list != 'error' && $user_list != 'empty'){
                // write user data into PHP SESSION (a file on your server)
                $_SESSION['need_change_password'] = 1;
                $_SESSION['user_name'] = $user_list[0]['name'];
                $_SESSION['user_email'] = $user_list[0]['email'];
                $loggedIn = true;
            }
        }
    }
}


// ... ask if we are logged in here:			
if ($loggedIn == false) {
    Redirect('/login.php', false);

} else {
	// create the registration object. when this object is created, it will do all registration stuff automatically
	// so this single line handles the entire registration process.
	$registration = new Registration();
	
	require_once('views/tpl/head.php');
?>
    <?php if(PRODUCTION) { ?>
        <script type="text/javascript" charset="utf-8" src="/js/user/loginSignup.min.js?v=<?php echo APP_VERSION; ?>"></script>
    <?php } else { ?>
        <script type="text/javascript" charset="utf-8" src="/js/app/user/loginSignup.js?v=<?php echo APP_VERSION; ?>"></script>
    <?php } ?>
</head>

<body>
    <?php include('views/tpl/navbar.php')?>
    <!-- Example row of columns -->
    <div class="main-holder">
        <form class="form-horizontal" action='account.php' method="post" name="registerform">
            <div class="login-box">
                
                <?php if(empty($_SESSION['need_change_password']) || $_SESSION['need_change_password'] === false){ ?>
                    <h1>Editar tu cuenta</h1>
                    <div id="errors"></div>
                    <div class="form-group">
                        <input type="text" name="user_name" class="form-control" id="login_input_name" placeholder="Name" value="<?=$_SESSION['user_name']?>" pattern="[a-zA-Z\s]{2,64}" required />
                    </div>
                    <div class="form-group">
                        <input type="email" name="user_email" class="form-control" id="login_input_email" placeholder="Email" value="<?=$_SESSION['user_email']?>"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="user_password_old" id="login_input_password_new" placeholder="Old password" required />
                    </div>
                <?php } else { ?>
                    <h1>Restablece tu contraseña</h1>
                    <div id="errors"></div>
                <?php } ?>
                
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="user_password_new" id="login_input_password_new" placeholder="New password" />
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="user_password_repeat" id="login_input_password_repeat" placeholder="Repeat new password" />
                </div>
                <button type="submit" name="update-account" class="form-submit">Actualizar contraseña</button>
                
                <?php $token = NoCSRF::generate( 'csrf_token' ); ?>
        	    <input type="hidden" name="csrf_token" value="<?php echo $token; ?>" />
        	    <input type="hidden" name="update-account" />
            </div>
        </form>
    </div>
        
    <?php include('views/tpl/footer.php'); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'].'/views/tpl/feedback.php'); ?>
    <!-- /container -->
</body>

</html>
<?php } ?>