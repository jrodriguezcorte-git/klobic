<nav class="navbar navbar-default header-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand" href="<?php echo OFFICIAL_DOMAIN_NAME; ?>"><img src="/images/logo.png" /></a>   
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?php
                if(isset($_SESSION['user_login_status']) && $_SESSION['user_login_status']==1){
            ?>
                <ul class="nav navbar-nav navbar-left">
                    
                </ul>
                
                <!--<form class="navbar-form navbar-left">-->
                <!--  <div class="form-group">-->
                <!--    <input type="text" class="form-control" placeholder="Search">-->
                <!--  </div>-->
                <!--  <button type="submit" class="btn btn-default">Submit</button>-->
                <!--</form>-->
                <ul class="nav navbar-nav navbar-right">
                    <?php 
                        require_once($_SERVER['DOCUMENT_ROOT'].'/php/connection.php');
                        $email = $_SESSION['user_email'];
                        $query='SELECT admin FROM users WHERE email=?';
                        $user_list=pdoSelect($query, array($email));
                        
                        if ($user_list != 'error' && $user_list != 'empty'){
                            if($user_list[0]['admin'] === '1'){ ?>
                                <li><a href="/admin/">Admin</a></li>
                        <?php }
                        } ?>
                    <li><a href="/banner-creator/my-banners/">My banners</a></li>
                    <li class="new-banner"><a href="/banner-creator/">Create new</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle profile-image" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <img src="https://openclipart.org/download/247320/abstract-user-flat-4.svg" class="img-circle" height="32px" width="32px"> 
                            <span class="capitalize" style="margin-left:5px;"><?=$_SESSION['user_name']?></span>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/account">Account options</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="/account?logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            <?php
                } else {
            ?>  
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <li><a href="/auth/login.php">Login</a></li>
                        <li><a href="/auth/signup.php">Sign Up</a></li>
                    </li>
                </ul>
            <?php
                } 
            ?>  
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>