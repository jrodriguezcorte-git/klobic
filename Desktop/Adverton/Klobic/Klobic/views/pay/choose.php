<style>
#mask {
  position: absolute;
  left: 0;
  top: 0;
  z-index: 9000;
  background-color: #000;
  display: none;
}

#boxes .window {
  position: absolute;
  left: 0;
  top: 0;
  width: 440px;
  height: 200px;
  display: none;
  z-index: 9999;
  padding: 20px;
  border-radius: 15px;
  text-align: center;
}

#boxes #dialog {
  width: 750px;
  height: 630px;
  padding: 10px;
  background-color: #ffffff;
  font-family: 'Segoe UI Light', sans-serif;
  font-size: 15pt;
}

#popupfoot {
  font-size: 16pt;
  position: absolute;
  bottom: 0px;
  width: 250px;
  left: 450px;
}

.close {
  float: right !important;   
  margin-bottom: 10px;
}

/* Create three equal columns that floats next to each other */
.column {
    float: left;
    width: 33.33%;
    padding: 10px;
    height: 250px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}

.pricing__item {
    background: #f8f9f9;
    border: none;
    border-top: 3px solid #f8f9f9;
    border-radius: 0px;
    padding: 35px 35px;
    padding: 2.1875rem 2.1875rem;
    position: relative;
    margin-bottom: 30px;
    margin-bottom: 1.875rem;
}

.pricing__price {
    padding: 15px 0px 15px;
    padding: 0.9375rem 0px 0.9375rem;
    margin-top: 20px;
    margin-top: 1.25rem;
    font-size: 40px;
    font-size: 2.5rem;
    border-top: 3px solid rgba(139, 144, 157, 0.1);
    font-weight: bold;
    font-family: serif,sans-serif;
    color: #333333;
}

.pricing__feature-list {
    font-style: italic;
    list-style: outside none none;
    margin: 0;
    padding: 0.25em 0 2.5em;
}

.btn-success:hover {
    color: #fff;
    background-color: #449d44;
    border-color: #419641;
}   

.btn-theme-primary {
    background: #03c4eb;
    color: #FFFFFF;
}

.btn-lg {
    font-size: 17px;
    font-size: 1.0625rem;
}

.btn-block {
    display: block;
    width: 100%;
}

.btn-group-lg>.btn, .btn-lg {
    padding: .75rem 1.25rem;
    font-size: 1.25rem;
    line-height: 1.333333;
    border-radius: .3rem;
}

.btn {
    text-transform: uppercase;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px;
    box-shadow: 0 -1px 0 0 rgba(0, 0, 0, 0.1) inset;
    font-size: 13px;
    font-size: 0.8125rem;
    font-weight: 600;
}    

a:-webkit-any-link {
    text-decoration: none;
}    
</style>
<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/views/tpl/head-init.php');
// load the registration class
require_once($_SERVER['DOCUMENT_ROOT']."/config/settings.php");
require_once($_SERVER['DOCUMENT_ROOT'].'/php/connection.php');

$email = $_SESSION['user_email'];
$query='SELECT * FROM users WHERE email=?';
$user_list=pdoSelect($query, array($email));
$banner_id = $_GET['item_number'];

if ($user_list != 'error' && $user_list != 'empty'){
    $user_id = $user_list[0]['id'];
    
} else {
    Redirect('/auth/login.php', false);
    die();
}


$connection->beginTransaction();
$query= 'SELECT count(*) as count FROM log_payment WHERE userId=?';
$banner_list=pdoSelect($query, array($user_id));

$count = $banner_list[0]['count'];

$query= 'SELECT * FROM payment_user_group WHERE userid=?';
$group_id=pdoSelect($query, array($user_id));

$group = $group_id[0]['paymentgroupid'];
?>
<?php
switch ($group) {
    /*free banners group */
    case 1:
        if($count < 3){
          $query='SELECT * FROM banners WHERE id=? AND userId=? AND paid=0';
          $productResult=pdoSelect($query, array($banner_id, $user_id));

        	$query='UPDATE banners SET paid=? WHERE hash=?';
        	$result=pdoSet($query,array(1, $productResult[0]['hash']));
        	 
            $query='INSERT INTO log_payment(userid, paymentgroupid, hash)  VALUES(?, ?, ?)';
            $result = pdoSet($query, array($user_id,$group,$productResult[0]['hash']));          	
        	
        	$connection->commit();
        	
        	Redirect('/banner-creator/my-banners/?success='.$productResult[0]['hash'], false);
            die();
                   
        } else {
?> 
            <div id="boxes">
              <div id="dialog" class="window">
                 <h1>Aprovecha nuestras promociones</h1>
                 <br>
                 <img src="https://nonstopgroup.net/images/logo.png">
                <div class="row">
              <div class="column" >
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" class="inline">
                       <div class="pricing__item">
                            <h3 class="pricing__title">Plan 10 banners</h3>
                            <div class="pricing__price"><span class="pricing__currency">$</span>4.99</div>
                            <div class="pricing__sentense"></div>
                            <ul class="pricing__feature-list">
                                <li>+1000 plantillas</li><li>Exporta hasta 10 banners</li>                            </ul>
                                           <!-- Specify URLs -->
                <input type='hidden' name='cancel_return' value='https://nonstopgroup.net/pay/success.php'>
                <input type='hidden' name='return' value='https://nonstopgroup.net/pay/success.php'>
                <button type="submit" class="stripe-button-el blue" style="visibility: visible; background-color: #339999">
                    <span style="background-color: #339999; color: white; font-weight: bold;">Comprar</span>
                </button>
                       </div>
              <!-- Identify your business so that you can collect the payments. -->
              <input type="hidden" name="business" value="paypal@klobic.com">
            
              <!-- Specify a Buy Now button. -->
              <input type="hidden" name="cmd" value="_xclick">
            
              <!-- Specify details about the item that buyers will purchase. -->
              <input type="hidden" name="item_name" value="10 Banners">
              <input type="hidden" name="amount" value="4.99">
              <input type="hidden" name="currency_code" value="USD">
            
              <!-- Display the payment button. -->
              <img alt="" border="0" width="1" height="1"
              src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
            
              <!-- Specify details about the item that buyers will purchase. -->
                <input type="hidden" name="item_plan" value="2">
                <input type="hidden" name="item_user" value="<?php echo $user_id; ?>">
                
            </form>
              </div>
<div class="column" >
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" class="inline">
                       <div class="pricing__item">
                            <h3 class="pricing__title">Plan 20 banners</h3>
                            <div class="pricing__price"><span class="pricing__currency">$</span>9.99</div>
                            <div class="pricing__sentense"></div>
                            <ul class="pricing__feature-list">
                                <li>+1000 plantillas</li><li>Exporta hasta 20 banners</li>                            </ul>
                                           <!-- Specify URLs -->
                <input type='hidden' name='cancel_return' value='https://nonstopgroup.net/pay/success.php'>
                <input type='hidden' name='return' value='https://nonstopgroup.net/pay/success.php'>
                <button type="submit" class="stripe-button-el blue" style="visibility: visible; background-color: #339999">
                    <span style="background-color: #339999; color: white; font-weight: bold;">Comprar</span>
                </button>
                       </div>
              <!-- Identify your business so that you can collect the payments. -->
              <input type="hidden" name="business" value="paypal@klobic.com">
            
              <!-- Specify a Buy Now button. -->
              <input type="hidden" name="cmd" value="_xclick">
            
              <!-- Specify details about the item that buyers will purchase. -->
              <input type="hidden" name="item_name" value="20 Banners">
              <input type="hidden" name="amount" value="9.99">
              <input type="hidden" name="currency_code" value="USD">
            
              <!-- Display the payment button. -->
              <img alt="" border="0" width="1" height="1"
              src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
            
              <!-- Specify details about the item that buyers will purchase. -->
                <input type="hidden" name="item_plan" value="2">
                <input type="hidden" name="item_user" value="<?php echo $user_id; ?>">
                
            </form>
              </div>
<div class="column" >
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" class="inline">
                       <div class="pricing__item">
                            <h3 class="pricing__title">Plan Ilimitado</h3>
                            <div class="pricing__price"><span class="pricing__currency">$</span>20</div>
                            <div class="pricing__sentense"></div>
                            <ul class="pricing__feature-list">
                                <li>+1000 plantillas</li><li>Exporta banners ilimitados</li>                            </ul>
                                           <!-- Specify URLs -->
                <input type='hidden' name='cancel_return' value='https://nonstopgroup.net/pay/success.php'>
                <input type='hidden' name='return' value='https://nonstopgroup.net/pay/success.php'>
                <button type="submit" class="stripe-button-el blue" style="visibility: visible; background-color: #339999">
                    <span style="background-color: #339999; color: white; font-weight: bold;">Comprar</span>
                </button>
                       </div>
              <!-- Identify your business so that you can collect the payments. -->
              <input type="hidden" name="business" value="paypal@klobic.com">
            
              <!-- Specify a Buy Now button. -->
              <input type="hidden" name="cmd" value="_xclick">
            
              <!-- Specify details about the item that buyers will purchase. -->
              <input type="hidden" name="item_name" value="Ilimitado">
              <input type="hidden" name="amount" value="20">
              <input type="hidden" name="currency_code" value="USD">
            
              <!-- Display the payment button. -->
              <img alt="" border="0" width="1" height="1"
              src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
            
              <!-- Specify details about the item that buyers will purchase. -->
                <input type="hidden" name="item_plan" value="2">
                <input type="hidden" name="item_user" value="<?php echo $user_id; ?>">
                
            </form>
              </div>              
            </div>
                <br><br><br>
                <div id="popupfoot"> <a class="close"style="color:red;" href="#">Close</a> </div>
              </div>
              <div id="mask"></div>
            </div>
<?php
        }
        break;
    /* 10 banners group */
    case 2:
        if($count < 13){
          $query='SELECT * FROM banners WHERE id=? AND userId=? AND paid=0';
          $productResult=pdoSelect($query, array($banner_id, $user_id));

        	$query='UPDATE banners SET paid=? WHERE hash=?';
        	$result=pdoSet($query,array(1, $productResult[0]['hash']));
        	
            $query='INSERT INTO log_payment(userid, paymentgroupid, hash)  VALUES(?, ?, ?)';
            $result = pdoSet($query, array($user_id,$group,$productResult[0]['hash']));        	
        	
        	$connection->commit(); 
        	        	
        	Redirect('/banner-creator/my-banners/?success='.$productResult[0]['hash'], false);
            die();
                   
        } else {

?> 
            <div id="boxes">
              <div id="dialog" class="window">
                 <h1>Aprovecha nuestras promociones</h1>
                 <br>
                 <img src="https://nonstopgroup.net/images/logo.png">
                <div class="row">
              <div class="column" >
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" class="inline">
                       <div class="pricing__item">
                            <h3 class="pricing__title">Plan 10 banners</h3>
                            <div class="pricing__price"><span class="pricing__currency">$</span>4.99</div>
                            <div class="pricing__sentense"></div>
                            <ul class="pricing__feature-list">
                                <li>+1000 plantillas</li><li>Exporta hasta 10 banners</li>                            </ul>
                                           <!-- Specify URLs -->
                <input type='hidden' name='cancel_return' value='https://nonstopgroup.net/pay/success.php'>
                <input type='hidden' name='return' value='https://nonstopgroup.net/pay/success.php'>

                       </div>
              <!-- Identify your business so that you can collect the payments. -->
              <input type="hidden" name="business" value="paypal@klobic.com">
            
              <!-- Specify a Buy Now button. -->
              <input type="hidden" name="cmd" value="_xclick">
            
              <!-- Specify details about the item that buyers will purchase. -->
              <input type="hidden" name="item_name" value="10 Banners">
              <input type="hidden" name="amount" value="4.99">
              <input type="hidden" name="currency_code" value="USD">
            
              <!-- Display the payment button. -->
              <img alt="" border="0" width="1" height="1"
              src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
            
              <!-- Specify details about the item that buyers will purchase. -->
                <input type="hidden" name="item_plan" value="2">
                <input type="hidden" name="item_user" value="<?php echo $user_id; ?>">
                
            </form>
              </div>
<div class="column" >
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" class="inline">
                       <div class="pricing__item">
                            <h3 class="pricing__title">Plan 20 banners</h3>
                            <div class="pricing__price"><span class="pricing__currency">$</span>9.99</div>
                            <div class="pricing__sentense"></div>
                            <ul class="pricing__feature-list">
                                <li>+1000 plantillas</li><li>Exporta hasta 20 banners</li>                            </ul>
                                           <!-- Specify URLs -->
                <input type='hidden' name='cancel_return' value='https://nonstopgroup.net/pay/success.php'>
                <input type='hidden' name='return' value='https://nonstopgroup.net/pay/success.php'>
                <button type="submit" class="stripe-button-el blue" style="visibility: visible; background-color: #339999">
                    <span style="background-color: #339999; color: white; font-weight: bold;">Comprar</span>
                </button>
                       </div>
              <!-- Identify your business so that you can collect the payments. -->
              <input type="hidden" name="business" value="paypal@klobic.com">
            
              <!-- Specify a Buy Now button. -->
              <input type="hidden" name="cmd" value="_xclick">
            
              <!-- Specify details about the item that buyers will purchase. -->
              <input type="hidden" name="item_name" value="20 Banners">
              <input type="hidden" name="amount" value="9.99">
              <input type="hidden" name="currency_code" value="USD">
            
              <!-- Display the payment button. -->
              <img alt="" border="0" width="1" height="1"
              src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
            
              <!-- Specify details about the item that buyers will purchase. -->
                <input type="hidden" name="item_plan" value="3">
                <input type="hidden" name="item_user" value="<?php echo $user_id; ?>">
                
            </form>
              </div>
<div class="column" >
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" class="inline">
                       <div class="pricing__item">
                            <h3 class="pricing__title">Plan Ilimitado</h3>
                            <div class="pricing__price"><span class="pricing__currency">$</span>20</div>
                            <div class="pricing__sentense"></div>
                            <ul class="pricing__feature-list">
                                <li>+1000 plantillas</li><li>Exporta banners ilimitados</li>                            </ul>
                                           <!-- Specify URLs -->
                <input type='hidden' name='cancel_return' value='https://nonstopgroup.net/pay/success.php'>
                <input type='hidden' name='return' value='https://nonstopgroup.net/pay/success.php'>
                <button type="submit" class="stripe-button-el blue" style="visibility: visible; background-color: #339999">
                    <span style="background-color: #339999; color: white; font-weight: bold;">Comprar</span>
                </button>
                       </div>
              <!-- Identify your business so that you can collect the payments. -->
              <input type="hidden" name="business" value="paypal@klobic.com">
            
              <!-- Specify a Buy Now button. -->
              <input type="hidden" name="cmd" value="_xclick">
            
              <!-- Specify details about the item that buyers will purchase. -->
              <input type="hidden" name="item_name" value="Ilimitado">
              <input type="hidden" name="amount" value="20">
              <input type="hidden" name="currency_code" value="USD">
            
              <!-- Display the payment button. -->
              <img alt="" border="0" width="1" height="1"
              src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
            
              <!-- Specify details about the item that buyers will purchase. -->
                <input type="hidden" name="item_plan" value="3">
                <input type="hidden" name="item_user" value="<?php echo $user_id; ?>">
                
            </form>
              </div>              
            </div>
                <br><br><br>
                <div id="popupfoot"> <a class="close"style="color:red;" href="#">Close</a> </div>
              </div>
              <div id="mask"></div>
            </div>
<?php
        }
        break;
    /* 20 banners group */
    case 3:
        if($count < 23){
          $query='SELECT * FROM banners WHERE id=? AND userId=? AND paid=0';
          $productResult=pdoSelect($query, array($banner_id, $user_id));

        	$query='UPDATE banners SET paid=? WHERE hash=?';
        	$result=pdoSet($query,array(1, $productResult[0]['hash']));
        	
            $query='INSERT INTO log_payment(userid, paymentgroupid, hash)  VALUES(?, ?, ?)';
            $result = pdoSet($query, array($user_id,$group,$productResult[0]['hash']));        	
        	
        	$connection->commit(); 
        	
        	Redirect('/banner-creator/my-banners/?success='.$productResult[0]['hash'], false);
            die();
                   
        } else {
?> 
            <div id="boxes">
              <div id="dialog" class="window">
                 <h1>Aprovecha nuestras promociones</h1>
                 <br>
                 <img src="https://nonstopgroup.net/images/logo.png">
                <div class="row">
              <div class="column" >
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" class="inline">
                       <div class="pricing__item">
                            <h3 class="pricing__title">Plan 10 banners</h3>
                            <div class="pricing__price"><span class="pricing__currency">$</span>4.99</div>
                            <div class="pricing__sentense"></div>
                            <ul class="pricing__feature-list">
                                <li>+1000 plantillas</li><li>Exporta hasta 10 banners</li>                            </ul>
                                           <!-- Specify URLs -->
                <input type='hidden' name='cancel_return' value='https://nonstopgroup.net/pay/success.php'>
                <input type='hidden' name='return' value='https://nonstopgroup.net/pay/success.php'>

                       </div>
              <!-- Identify your business so that you can collect the payments. -->
              <input type="hidden" name="business" value="paypal@klobic.com">
            
              <!-- Specify a Buy Now button. -->
              <input type="hidden" name="cmd" value="_xclick">
            
              <!-- Specify details about the item that buyers will purchase. -->
              <input type="hidden" name="item_name" value="10 Banners">
              <input type="hidden" name="amount" value="4.99">
              <input type="hidden" name="currency_code" value="USD">
            
              <!-- Display the payment button. -->
              <img alt="" border="0" width="1" height="1"
              src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
            
              <!-- Specify details about the item that buyers will purchase. -->
                <input type="hidden" name="item_plan" value="4">
                <input type="hidden" name="item_user" value="<?php echo $user_id; ?>">
                
            </form>
              </div>
<div class="column" >
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" class="inline">
                       <div class="pricing__item">
                            <h3 class="pricing__title">Plan 20 banners</h3>
                            <div class="pricing__price"><span class="pricing__currency">$</span>9.99</div>
                            <div class="pricing__sentense"></div>
                            <ul class="pricing__feature-list">
                                <li>+1000 plantillas</li><li>Exporta hasta 20 banners</li>                            </ul>
                                           <!-- Specify URLs -->
                <input type='hidden' name='cancel_return' value='https://nonstopgroup.net/pay/success.php'>
                <input type='hidden' name='return' value='https://nonstopgroup.net/pay/success.php'>

                       </div>
              <!-- Identify your business so that you can collect the payments. -->
              <input type="hidden" name="business" value="paypal@klobic.com">
            
              <!-- Specify a Buy Now button. -->
              <input type="hidden" name="cmd" value="_xclick">
            
              <!-- Specify details about the item that buyers will purchase. -->
              <input type="hidden" name="item_name" value="20 Banners">
              <input type="hidden" name="amount" value="9.99">
              <input type="hidden" name="currency_code" value="USD">
            
              <!-- Display the payment button. -->
              <img alt="" border="0" width="1" height="1"
              src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
            
              <!-- Specify details about the item that buyers will purchase. -->
                <input type="hidden" name="item_plan" value="4">
                <input type="hidden" name="item_user" value="<?php echo $user_id; ?>">
                
            </form>
              </div>
<div class="column" >
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" class="inline">
                       <div class="pricing__item">
                            <h3 class="pricing__title">Plan Ilimitado</h3>
                            <div class="pricing__price"><span class="pricing__currency">$</span>20</div>
                            <div class="pricing__sentense"></div>
                            <ul class="pricing__feature-list">
                                <li>+1000 plantillas</li><li>Exporta banners ilimitados</li>                            </ul>
                                           <!-- Specify URLs -->
                <input type='hidden' name='cancel_return' value='https://nonstopgroup.net/pay/success.php'>
                <input type='hidden' name='return' value='https://nonstopgroup.net/pay/success.php'>
                <button type="submit" class="stripe-button-el blue" style="visibility: visible; background-color: #339999">
                    <span style="background-color: #339999; color: white; font-weight: bold;">Comprar</span>
                </button>
                       </div>
              <!-- Identify your business so that you can collect the payments. -->
              <input type="hidden" name="business" value="paypal@klobic.com">
            
              <!-- Specify a Buy Now button. -->
              <input type="hidden" name="cmd" value="_xclick">
            
              <!-- Specify details about the item that buyers will purchase. -->
              <input type="hidden" name="item_name" value="Ilimitado">
              <input type="hidden" name="amount" value="20">
              <input type="hidden" name="currency_code" value="USD">
            
              <!-- Display the payment button. -->
              <img alt="" border="0" width="1" height="1"
              src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
            
              <!-- Specify details about the item that buyers will purchase. -->
                <input type="hidden" name="item_plan" value="4">
                <input type="hidden" name="item_user" value="<?php echo $user_id; ?>">
                
            </form>
              </div>              
            </div>
                <br><br><br>
                <div id="popupfoot"> <a class="close"style="color:red;" href="#">Close</a> </div>
              </div>
              <div id="mask"></div>
            </div>
<?php
        }
        break;
        break;
    /* All banners group */    
    case 4:
          $query='SELECT * FROM banners WHERE id=? AND userId=? AND paid=0';
          $productResult=pdoSelect($query, array($banner_id, $user_id));

        	$query='UPDATE banners SET paid=? WHERE hash=?';
        	$result=pdoSet($query,array(1, $productResult[0]['hash']));
        	
             $query='INSERT INTO log_payment(userid, paymentgroupid, hash)  VALUES(?, ?, ?)';
            $result = pdoSet($query, array($user_id,$group,$productResult[0]['hash'])); 
            
        	$connection->commit(); 
        	
        	Redirect('/banner-creator/my-banners/?success='.$productResult[0]['hash'], false);
            die();
        break;        
}






if (!empty($banner_id)){
    $query='SELECT * FROM banners WHERE id=? AND userId=? AND paid=0';
    $banner_list=pdoSelect($query, array($banner_id, $user_id));
}

if ($banner_list == 'empty'){
    Redirect('/', false);
    die();
}

require_once($_SERVER['DOCUMENT_ROOT'].'/views/tpl/head.php');
?>
</head>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'].'/views/tpl/navbar.php')?>
    <!-- Example row of columns -->
    <div class="main-holder col-md-offset-2 col-md-8 text-center" style="padding:30px;background:#fff;">
        <div class="col-md-12">
            <h2>Opciones de Pago</h2>
            <br/>
            <h4 class="text-muted">
                Compra el banner para <b>remover la marca de agua.</b>
                <br/>Luego podrá <b>descargar el banner como JPG, PNG o Gif file</b>, sin la marca de agua.
                <br/>
                <h3 class="text-muted"><b>Sólo por 0.99$!</b></h3>
            </h4>
            
            <?php if(!empty($_GET['error'])){ ?>
                <h5 style="color:red;"><?php echo $_GET['error']; ?></h5>
            <?php } ?>
            
            <form action="<?php echo $paypalURL; ?>" method="post" class="inline">
                
            	<?php if($hosted_button_id){ ?>
            	    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="<?php echo $hosted_button_id; ?>">
                    <input type="hidden" name="amount" value="15.00">
                    <input type="image" src="<?php echo $paypalGifBtn; ?>" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" style="display:none;visibility:hidden;">
                    <img alt="" border="0" src="<?php echo $paypalGifPixel; ?>" width="1" height="1" style="display:none;visibility:hidden;">
                    
            	<?php } else { ?>
                    <!-- Specify a Buy Now button. -->
                    <input type="hidden" name="cmd" value="_xclick">
                    
                	<!-- Identify your business so that you can collect the payments. -->
            	    <input type="hidden" name="business" value="<?php echo $paypalID; ?>">
            	<?php } ?>
            	
                <!-- Specify details about the item that buyers will purchase. -->
                <input type="hidden" name="item_name" value="<?php echo $banner_list[0]['name'].' ('.$banner_list[0]['hash'].')'; ?>">
                <input type="hidden" name="item_number" value="<?php echo $banner_list[0]['id']; ?>">
                
                <input type="hidden" name="amount" value="<?php echo $productPrice; ?>">
                <input type="hidden" name="currency_code" value="USD">
                
                <!-- Specify URLs -->
                <input type='hidden' name='cancel_return' value='<?php echo DOMAIN_NAME; ?>pay/success.php'>
                <input type='hidden' name='return' value='<?php echo DOMAIN_NAME; ?>pay/success.php'>
                <button type="submit"  style="visibility: visible;     background-color: darkblue; color: white; font-weight: bold;">
                    <span style="display: block; min-height: 20px;     background-color: darkblue; color: white; font-weight: bold;">Paga con  Paypal</span>
                </button>
            </form>
        </div>
        <div class="col-md-12">
             <img src="/banners/<?php echo $banner_list[0]['hash']; ?>/images/png?_=1493766842" width="100%"/>
        </div>
    </div>
        
    <?php include($_SERVER['DOCUMENT_ROOT'].'/views/tpl/footer.php'); ?>
    <!-- /container -->
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script>
<script>
$(document).ready(function() {	

var id = '#dialog';
	
//Get the screen height and width
var maskHeight = $(document).height()+300;
var maskWidth = $(window).width();
	
//Set heigth and width to mask to fill up the whole screen
$('#mask').css({'width':maskWidth,'height':maskHeight});

//transition effect
$('#mask').fadeIn(500);	
$('#mask').fadeTo("slow",0.9);	
	
//Get the window height and width
var winH = $(window).height();
var winW = $(window).width();
              
//Set the popup window to center
$(id).css('top',  150);
$(id).css('left', winW/2-$(id).width()/2);
	
//transition effect
$(id).fadeIn(2000); 	
	
//if close button is clicked
$('.window .close').click(function (e) {
//Cancel the link behavior
e.preventDefault();

$('#mask').hide();
$('.window').hide();
});

//if mask is clicked
$('#mask').click(function () {
$(this).hide();
$('.window').hide();
});
	
});
</script>
</html>