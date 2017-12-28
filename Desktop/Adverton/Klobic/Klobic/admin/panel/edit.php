<?php 
// include the configs / constants for the database connection
require_once($_SERVER['DOCUMENT_ROOT'].'/views/tpl/head.php');

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
$where = '';

if($_GET['id'] != 'new') 
    $where = ' WHERE id='.$_GET['id'];

$query='DESCRIBE '.$type;
$keys=pdoSelect($query, array());
// print_r($keys);

if(isset($_POST['update-create'])){
    $values = array();
    $userToUpdate = array();
    $connection->beginTransaction();
    	    
    if(!empty($where)) {
        $query='SELECT * FROM '. $type .' WHERE id=?';
        $user_list=pdoSelect($query, array($_GET['id']));
        
        if ($user_list != 'error' && $user_list != 'empty'){
            $userToUpdate = $user_list[0];
        }
            
	    $query='UPDATE '.$type.' SET ';
    } else {
        $query = 'INSERT INTO '.$type.' (';
    }
    
    $count = 0;
    
    foreach($keys as $key){
        if(isset($_POST[$key['Field']]))
            $value = $_POST[$key['Field']];
        else
            $value = null;
        
        if($key['Type'] == 'tinyint(1)' && empty($value))
            $value = 'off';
            
        // if (($_GET['id'] != 'new' && $value != $userToUpdate[$key['Field']]))
        
        if(!empty($value))
            if($key['Field'] != 'update-create' && $key['Field'] != 'csrf_token' && $key['Field'] != 'id'){
                if($_GET['id'] == 'new' || ($_GET['id'] != 'new' && count($userToUpdate) > 0 && $value != $userToUpdate[$key['Field']])){
                
                    // echo $key;
                    // echo $value;
                    // echo '<br />';
                    if($value == 'off')
                        $value = '0';
                    
                    if(!empty($where)) {
                	    $query .= $key['Field'].'=?,';
                    } else {
                        $query .= $key['Field'].',';
                    }
                    
                    array_push($values, $value);
                
                    $count++;
                }
            }
    }
    
    $query = rtrim($query, ",");
    	    
    if(!empty($where)) {
        $query .= ' WHERE id=?';
        array_push($values, $_GET['id']);
    } else {
        // echo 'COUNT' .$count;
        // if(empty($_POST['password_hash']))
        //     $count = count($_POST)-3;
        // else
        //     $count = count($_POST)-2;
        
        $query .= ') VALUES (';
        for($i=0; $i<$count; $i++){
            if($i < $count-1)
                $query .= '?,';
            else
                $query .= '?';
        }
        
        $query .= ')';
    }
    
    // echo $query;
    // print_r($values);
    // echo $query;
    
    if(count($values) > 1){
    	$result = pdoSet($query, $values);
        $connection->commit();
    } else $result = 0;
    // echo $result;
    
	if ($result != 'error' && empty($where)){
        Redirect('/admin/'. $type .'/edit.php?id='. $result, false);
        die();
	}
}

?>
<script src="actions.js"></script>
</head>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'].'/views/tpl/navbar.php')?>
    <!-- Example row of columns -->
    <div class="main-holder">
        <?php 
            if($_GET['id'] != 'new'){
                $query='SELECT * FROM '. $type . $where;
                $user_list=pdoSelect($query, array());
                $info = $user_list[0];
                $info['password_hash'] = '';
                
            } else $info = array();
            
            if(isset($_POST['update-create'])){
                $info = $_POST;
            }
            
            if (($user_list == 'error' || $user_list == 'empty') && !empty($where)){
        ?>    
            <div class="text-center" style="padding-top:40px;">
                That page doesnt exist.
            </div>
        <?php } else { ?>
            <form class="form-horizontal" method="POST">
                <div class="login-box">
                    <div>
                        <a href="/admin/<?php echo $type; ?>" class="button gray-color">
                            << Back
                        </a>
                            <?php if(empty($where)) { ?>
                                <h1>Create new</h1>
                                
                            <?php } else { ?>
                                <h1>Edit</h1>
                            
                            <?php } ?>
                    </div>
                    
                    <div id="errors">
                        <?php
                        if(isset($result))
                            if($result != 'error'){
                        ?>
                                Saved!   
                        <?php 
                            } else { 
                        ?>
                            Something went wrong
                        <?php } ?>
                    </div>
                    <?php for ($i=0; $i<count($keys); $i++){ ?>
                        <!--if($keys[$i]['Field'] !== 'password_hash'){-->
                        <?php if($keys[$i]['Field'] == 'id') { ?>
                        <?php } elseif($keys[$i]['Type'] == 'tinyint(1)') { ?>
                            <div class="checkbox">
                                <label class="remember" for="<?php echo $keys[$i]['Field']; ?>">
                                    <input type="checkbox" id="<?php echo $keys[$i]['Field']; ?>" value="1" name="<?php echo $keys[$i]['Field']; ?>" <?php if(!empty($info[$keys[$i]['Field']]) && $info[$keys[$i]['Field']] == '1') echo 'checked';?>>
                                    <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                    <?php echo $keys[$i]['Field']; ?>
                                </label>
                            </div>
                        
                        <?php } else if(substr($keys[$i]['Field'], -2) != 'at'){ ?>
                            <?php if($keys[$i]['Field'] == 'password_hash') $type = 'password'; 
                                else if($keys[$i]['Field'] == 'email') $type = 'email';
                                else $type = 'text'; 
                            ?>
                            <div class="form-group">
                                <input type='<?php echo $type; ?>' name="<?php echo $keys[$i]['Field']; ?>" class="form-control" placeholder="<?php echo $keys[$i]['Field']; ?>" value="<?php if(!empty($info[$keys[$i]['Field']])) echo $info[$keys[$i]['Field']]; ?>" />
                            </div>
                        
                        <?php } ?>
                    <?php } ?>
                    <button type="submit" name="update-create" class="form-submit">
                        <?php if(empty($where)) { ?>
                            Create new
                            
                        <?php } else { ?>
                            Save
                        
                        <?php } ?>
                    </button>
                    
                    <?php $token = NoCSRF::generate( 'csrf_token' ); ?>
            	    <input type="hidden" name="csrf_token" value="<?php echo $token; ?>" />
                </div>
            </form>
        <?php } ?>
    </div>
        
    <?php include($_SERVER['DOCUMENT_ROOT'].'/views/tpl/footer.php'); ?>
    <!-- /container -->
</body>

</html>