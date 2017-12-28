<?php 
// include the configs / constants for the database connection
require_once($_SERVER['DOCUMENT_ROOT'].'/views/tpl/head-init.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/php/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');

$loggedIn = $login->isUserLoggedIn();

$email = $_SESSION['user_email'];
$query='SELECT * FROM users WHERE email=? AND admin=?';
$user_list=pdoSelect($query, array($email, 1));

if ($user_list != 'error' && $user_list != 'empty'){
    $user_id = $user_list[0]['id'];
    
} else {
    Redirect('/auth/login.php', false);
    die();
}
    
$path = $_SERVER['REQUEST_URI']; // this gives you /folder1/folder2/THIS_ONE/file.php
$folders = explode('/',$path); // splits folders in array
$type = $folders[2];
$action = '';
if(count($folders) > 3) $action = $folders[3];

if (strpos($action, 'actions') !== false) {
    require_once('panel/actions.php');
    die();
}

require_once($_SERVER['DOCUMENT_ROOT']."/views/tpl/head.php");

if (strpos($action, 'edit') !== false) {
    require_once('panel/edit.php');
    die();
    
} elseif (!empty($type)) {
    require_once('panel/index.php');
    die();
    
}

?>
</head>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'].'/views/tpl/navbar.php'); ?>
    <!-- Example row of columns -->
    <div class="main-holder text-center panel-admin">
        <?php
            $query='SELECT COUNT(*) FROM users';
            $count = pdoSelect($query, array());
            $count = $count[0]['COUNT(*)'];
            
            $total_users = $count;
            
            
            $query='SELECT COUNT(*) FROM banners';
            $count = pdoSelect($query, array());
            $count = $count[0]['COUNT(*)'];
            
            $total_banners = $count;
            
            
            $query='SELECT COUNT(*) FROM banners WHERE paid=?';
            $count = pdoSelect($query, array(1));
            $count = $count[0]['COUNT(*)'];
            
            $total_paid_banners = $count;
        ?>
        <a href="users">
            <i class="ion-person-stalker"></i>
            <span>Users</span>
            <h5 class="text-muted">
                <b>
                    Users (<?php echo $total_users; ?>) 
                    <br/>
                    Banners (<?php echo $total_banners; ?>)
                    <br/>
                    Paid banners (<?php echo $total_paid_banners; ?>)
                </b>
            </h5>
        </a>
        <?php
            $query='SELECT COUNT(*) FROM templates';
            $count = pdoSelect($query, array());
            $count = $count[0]['COUNT(*)'];
            
            $total_templates = $count;
        ?>
        <a href="/banner-creator/my-banners/?hash=templates">
            <i class="fi-layout"></i>
            <span>Templates</span>
            <h5 class="text-muted">
                <b>
                    &nbsp;
                    <br/>
                    Templates (<?php echo $total_templates; ?>)
                    <br/>
                    &nbsp;
                </b>
            </h5>
        </a>
        <?php
            $query='SELECT COUNT(*) FROM payments';
            $count = pdoSelect($query, array());
            $count = $count[0]['COUNT(*)'];
            
            $total_payments = $count;
        ?>
        <a href="payments">
            <i class="ion-cash"></i>
            <span>Payments</span>
            <h5 class="text-muted"><b>
                &nbsp;
                <br/>
                Payments (<?php echo $total_payments; ?>)
                <br/>
                &nbsp;
            </b></h5>
        </a>
    </div>
        
    <?php include($_SERVER['DOCUMENT_ROOT'].'/views/tpl/footer.php'); ?>
    <!-- /container -->
</body>

</html>