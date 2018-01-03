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
  height: 300px;
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
  left: 250px;
}

.close {
  float: inherit !important;   
  margin-bottom: 10px;
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
$query= 'SELECT count(*) as count FROM banners WHERE userId=? AND paid=0';
$banner_list=pdoSelect($query, array($user_id));

$count = $banner_list[0]['count'];


if($count < 3){
        $query='SELECT * FROM banners WHERE id=? AND userId=? AND paid=0';
        $productResult=pdoSelect($query, array($banner_id, $user_id));
        /*
    	$query='UPDATE banners SET paid=? WHERE hash=?';
    	$result=pdoSet($query,array(1, $productResult[0]['hash']));
    	$connection->commit(); 
    	
    	Redirect('/banner-creator/my-banners/?success='.$productResult[0]['hash'], false);
        die();
        */
        die(var_dump("opcion 1"));
} else {
//    die(var_dump("opcion 2"));
?>    
<div id="boxes">
  <div id="dialog" class="window">
    Your Content Goes Here
    <div id="popupfoot"> <a class="close"style="color:red;" href="#">Close</a> </div>
  </div>
  <div id="mask"></div>
</div>  
<?php    
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
            <h2>Payment options</h2>
            <br/>
            <h4 class="text-muted">
                Buy the banner to <b>remove the watermark.</b>
                <br/>Then you can <b>download the banner as a JPG, PNG or Gif file</b>, without the watermark.
                <br/>
                <h3 class="text-muted"><b>Just for 0.99$!</b></h3>
            </h4>
            
            <?php if(!empty($_GET['error'])){ ?>
                <h5 style="color:red;"><?php echo $_GET['error']; ?></h5>
            <?php } ?>
            
            <form action="/pay/stripe.php?item_name=<?php echo $_GET['item_name']; ?>&item_number=<?php echo $_GET['item_number']; ?>" method="post" class="inline">
                <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="<?php echo $stripe['publishable_key']; ?>"
                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                    data-name="Klobic"
                    data-description="Banner <?php echo $banner_list[0]['name'].' ('.$banner_list[0]['hash'].')'; ?>"
                    data-amount="<?php echo str_replace(".", "0", $productPrice); ?>"
                    data-locale="auto"
                    data-email="<?php echo $email; ?>"></script>
            </form>
            <form action="<?php echo $paypalURL; ?>" method="post" class="inline">
                
            	<?php if($hosted_button_id){ ?>
            	    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="<?php echo $hosted_button_id; ?>">
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
                <button type="submit" class="stripe-button-el blue" style="visibility: visible;">
                    <span style="display: block; min-height: 30px;">Pay with Paypal</span>
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
var maskHeight = $(document).height();
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
$(id).css('top',  winH/8-$(id).height());
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