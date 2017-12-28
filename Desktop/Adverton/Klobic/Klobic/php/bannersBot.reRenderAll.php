<?php
die();
require_once($_SERVER['DOCUMENT_ROOT'].'/php/header.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/helpers.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/libraries/simple_html_dom.php');

$loggedIn = $login->isUserLoggedIn();

if(isset($_SESSION['user_email'])){
    $email = $_SESSION['user_email'];
    $query='SELECT * FROM users WHERE email=? AND admin=?';
    $user_list=pdoSelect($query, array($email, 1));
}

if (empty($email) || $user_list == 'error' || $user_list == 'empty'){
    Redirect('/auth/login.php', false);
    die();
}


if(isset($_GET['hash'])) $getHash = $_GET['hash'];
if(!empty($getHash)){
        $hash = $getHash;

        require_once($_SERVER['DOCUMENT_ROOT'].'/php/saveImage.php');
        require_once($_SERVER['DOCUMENT_ROOT'].'/php/renderBanner.php');
        $render = new RenderBanner($hash);
        $image = $render->getImage(true);
	    $imageSaver = new SaveImage($image, '/photos/templates/'.$hash.'.png');

        echo $hash.' saved!</br>';
        die();
}else {
    $ipp = $_GET['ipp'];
    $p = $_GET['p'];

    // $limit = ($ipp * $p);
    // $limit = ($limit-$ipp) .','. $limit;
    // if($limit == 0) $limit = $ipp;

    $query = "SELECT COUNT(*) FROM templates";
    $count = pdoSelect($query, array());
    $count = $count[0]['COUNT(*)'];
    $totalPages = ceil($count/$ipp);

    $limit = $ipp .','. $count;
    echo 'Count '.$count.'</br>';
    echo 'Total pages '.$totalPages.'</br>';
    echo 'Limit '.$limit.'</br>';

    $query = "SELECT hash FROM templates LIMIT ".$limit;
    $banner_list=pdoSelect($query, array());

    $array = "[";
    if ($banner_list != 'error' && $banner_list != 'empty'){
        foreach($banner_list as $key=>$banner){
            $hash = $banner['hash'];
            $array .= "'$hash'";

            if($key-$ipp != $count){
                $array .= ", ";
            }
        }
    }
    $array .= "]";
?>
    <html>
    <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
    $(document).ready(function (){
        $('button').click(function (){
            var array = <?php echo $array; ?>;


            function getAllImages() {
                var imgCount = 0,
                    maxImages = array.length-1;

                function getNextImage() {
                    $.ajax({
                        url: '/php/bannersBot.reRenderAll.php?hash='+array[imgCount],
                        async: true,
                        success: function (){
                            if (imgCount <= maxImages) {
                                $('div').append( "<p>"+imgCount + " - "+array[imgCount]+"</p>" );
                                ++imgCount;
                                if(imgCount == maxImages){
                                    $('div').append( "<p>ALL DONE!</p>" );
                                }
                                getNextImage();
                            }
                        }
                    });
                }
                getNextImage();
            }

            // no while loop is needed
            // just call getAllImages() and pass it the
            // position and the maxImages you want to retrieve
            getAllImages();
        });
    });
    </script>
    </head>
    <body>
        SAVE ALL THE TEMPLATES SYNC 4444
        <br/>
        <br/>
        <button>START SAVING ALL</button>
        <br/>
        <div></div>
    </body>
    </html>
<?php } ?>
