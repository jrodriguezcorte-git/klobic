<?php 
// include the configs / constants for the database connection
require_once($_SERVER['DOCUMENT_ROOT']."/views/tpl/head.php");

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

if (strpos($type, '?') !== false) {
    $type = substr($type, 0, strpos($type, "?"));
}

$q = '';
$where = '';
$whereArray = array();

if(isset($_GET['q'])) {
    $q = $_GET['q'];
    $where = ' WHERE ';
    // $where = ' WHERE (';

    $query='DESCRIBE '.$type;
    $keys=pdoSelect($query, array());
    $keysCount = count($keys);
    $countKeys = 0;
    
    foreach($keys as $key){
        if($key['Field'] != 'password_hash'){
            $where .= $key['Field'].'=?';
            if($countKeys < $keysCount-1) $where .= ' OR ';
            array_push($whereArray, $q);
        }
        $countKeys++;
    }
    // $where .= ') ';

}
// echo $where;
// die();

$ipp = 20;
$p = 1;

if(isset($_GET['ipp']) && $_GET['ipp'] > 0) $ipp = $_GET['ipp'];
if(isset($_GET['p']) && $_GET['p'] > 0) $p = $_GET['p'];
if(isset($_GET['order_by'])) {
    if(isset($_GET['order_sort']) && $_GET['order_sort'] === 'DESC') 
        $order_sort = 'DESC';
    else
        $order_sort = 'ASC';
        
    $order_by = ' ORDER BY ' . $_GET['order_by'] .' '. $order_sort;
    
} else {
    $order_by = '';
    $order_sort = '';
}

$query='SELECT COUNT(*) FROM '.$type.$where;
$count = pdoSelect($query, $whereArray);
$count = $count[0]['COUNT(*)'];

$totalPages = ceil($count/$ipp);

if($p > $totalPages) $p = $totalPages;
else if($totalPages < $p) $p = 1;

$limit = ($ipp * $p);
$limit = ($limit-$ipp) .','. $ipp;
if($limit == 0) $limit = $ipp;

?>
<?php if(PRODUCTION) { ?>
    <script type="text/javascript" charset="utf-8" src="/admin/actions.min.js"></script>
<?php } else { ?>
    <script type="text/javascript" charset="utf-8" src="/admin/actions.js"></script>
<?php } ?>
</head>

<body>
    <?php include($_SERVER['DOCUMENT_ROOT'].'/views/tpl/navbar.php')?>
    <!-- Example row of columns -->
    <div class="main-holder">
        <?php 
            $query='SELECT * FROM '.$type . $where . $order_by .' LIMIT '. $limit;
            $user_list=pdoSelect($query, $whereArray);
            
            if ($user_list != 'error' && $user_list != 'empty'){
                $key = array_keys($user_list[0]);
                
                if($type == 'users') {
                    array_push($key, 'banners');
                    array_push($key, 'paid_banners');
                }
        ?>    
            <div class="text-center">
                <a href="/admin/" class="button gray-color">
                    << Back
                </a>
                <a href="/admin/<?php echo $type; ?>/edit.php?id=new" class="button normal-color">
                    Add new
                </a>
                <form action="<?php echo $type; ?>" method="get">
                    <input type='text' name='q' placeholder="Search" value="<?php echo $q; ?>"/>
                    <input type='hidden' name='p' value="1" />
                    <input type='hidden' name='ipp' value="<?php echo $ipp; ?>" />
                </form>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <?php 
                            $total = count($key);
                            for ($i=0; $i<$total; $i++){
                                if($key[$i] !== 'password_hash'){ 
                        ?>
                                <td style="text-transform: uppercase;">
                                    <h4>
                                        <?php if($key[$i] === 'banners' || $key[$i] === 'paid_banners'){ 
                                                echo $key[$i];
                                            } else { ?>
                                            <a href="/admin/<?php echo $type; ?>?order_by=<?php echo $key[$i];?>&order_sort=<?php if(isset($_GET['order_by']) && $_GET['order_by'] == $key[$i] && $order_sort === 'DESC') echo 'ASC'; else echo 'DESC'; ?><?php if(!empty($p)) echo "&p=".$p; ?><?php if(!empty($ipp)) echo "&ipp=".$ipp; ?><?php if(!empty($q)) echo "&q=".$q; ?>">
                                                <?php echo $key[$i]; ?>
                                                <?php if(isset($_GET['order_by']) && $_GET['order_by'] == $key[$i] && $order_sort === 'DESC') { ?>
                                                    <i class="fa fa-sort-asc"></i>
                                                <?php } else if(isset($_GET['order_by']) && $_GET['order_by'] == $key[$i] && $order_sort === 'ASC') { ?>
                                                    <i class="fa fa-sort-desc"></i>
                                                <?php } else { ?>
                                                    <i class="fa fa-sort"></i>
                                                <?php } ?>
                                            </a>
                                        <?php } ?>
                                    </h4>
                                </td>
                            <?php   
                                }
                            } ?>
                        <td style="text-transform: uppercase;" colspan="2">
                            <h4>Actions</h4>
                        </td>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="<?php echo $total; ?>" class="text-center">
                            <div>
                                <?php if($p == 1) $class = 'PaginatorItem__disabled';
                                        else $class = null;
                                ?>
                                <?php if($class == null){ ?>
                                    <a href="/admin/<?php echo $type; ?>?p=1&ipp=<?php echo $ipp; ?><?php if(!empty($q)) echo "&q=".$q; ?><?php if(isset($_GET['order_by'])) echo '&order_by='.$_GET['order_by']; ?><?php if(isset($_GET['order_sort'])) echo '&order_sort='.$_GET['order_sort']; ?>">
                                <?php } ?>
                                        <span class="PaginatorItem__item <?php echo $class; ?>">
                                            <div class="PaginatorItem__first">
                                                <div class="BaseIcon__iconComponent BaseIcon__small">
                                                    <svg viewBox="0 0 18 18"><rect width="18" height="2"></rect><polygon points="15.25 13 9 4.96 2.75 13 15.25 13"></polygon></svg>
                                                </div>
                                            </div>
                                        </span>
                                <?php if($class == null){ ?>
                                    </a>
                                    <a href="/admin/<?php echo $type; ?>?p=<?php echo $p-1; ?><?php if(!empty($ipp)) echo "&ipp=".$ipp; ?><?php if(!empty($q)) echo "&q=".$q; ?><?php if(isset($_GET['order_by'])) echo '&order_by='.$_GET['order_by']; ?><?php if(isset($_GET['order_sort'])) echo '&order_sort='.$_GET['order_sort']; ?>">
                                <?php } ?>
                                        <span class="PaginatorItem__item <?php echo $class; ?>">
                                            <div class="PaginatorItem__back">
                                                <div class="BaseIcon__iconComponent BaseIcon__small">
                                                    <svg viewBox="0 0 18 18"><polygon points="15.25 13 9 4.96 2.75 13 15.25 13"></polygon></svg>
                                                </div>
                                            </div>
                                        </span>
                                <?php if($class == null){ ?>
                                    </a>
                                <?php } ?>
                                
                                <?php 
                                    
                                    for ($iC=0; $iC<$totalPages; $iC++){ 
                                        $class = 'PaginatorItem__item';
                                        if($iC == $p-1) $class .= ' PaginatorItem__active';
                                ?>
                                        <!--<span class="PaginatorItem__item PaginatorItem__active">1</span>-->
                                        <?php if($class == 'PaginatorItem__item'){ ?>
                                            <a href="/admin/<?php echo $type; ?>?p=<?php echo $iC+1; ?><?php if(!empty($ipp)) echo "&ipp=".$ipp; ?><?php if(!empty($q)) echo "&q=".$q; ?><?php if(isset($_GET['order_by'])) echo '&order_by='.$_GET['order_by']; ?><?php if(isset($_GET['order_sort'])) echo '&order_sort='.$_GET['order_sort']; ?>">
                                        <?php } ?>
                                                <span class="<?php echo $class; ?>"><?php echo $iC+1; ?></span>
                                        <?php if($class == 'PaginatorItem__item'){ ?>
                                            </a>
                                        <?php } ?>
                                <?php } ?>
                                
                                <?php if($p == $totalPages) $class = 'PaginatorItem__disabled';
                                        else $class = null;
                                ?>
                                <?php if($class == null){ ?>
                                    <a href="/admin/<?php echo $type; ?>?p=<?php echo $p+1; ?><?php if(!empty($ipp)) echo "&ipp=".$ipp; ?><?php if(!empty($q)) echo "&q=".$q; ?><?php if(isset($_GET['order_by'])) echo '&order_by='.$_GET['order_by']; ?><?php if(isset($_GET['order_sort'])) echo '&order_sort='.$_GET['order_sort']; ?>">
                                <?php } ?>
                                        <span class="PaginatorItem__item <?php echo $class; ?>">
                                            <div class="PaginatorItem__next">
                                                <div class="BaseIcon__iconComponent BaseIcon__small">
                                                    <svg viewBox="0 0 18 18"><polygon points="15.25 13 9 4.96 2.75 13 15.25 13"></polygon></svg>
                                                </div>
                                            </div>
                                        </span>
                                <?php if($class == null){ ?>
                                    </a>
                                    <a href="/admin/<?php echo $type; ?>?<?php if(!empty($totalPages)) echo "p=".$totalPages; ?><?php if(!empty($ipp)) echo "&ipp=".$ipp; ?><?php if(!empty($q)) echo "&q=".$q; ?><?php if(isset($_GET['order_by'])) echo '&order_by='.$_GET['order_by']; ?><?php if(isset($_GET['order_sort'])) echo '&order_sort='.$_GET['order_sort']; ?>">
                                <?php } ?>
                                        <span class="PaginatorItem__item <?php echo $class; ?>">
                                            <div class="PaginatorItem__last">
                                                <div class="BaseIcon__iconComponent BaseIcon__small">
                                                    <svg viewBox="0 0 18 18"><rect width="18" height="2"></rect><polygon points="15.25 13 9 4.96 2.75 13 15.25 13"></polygon></svg>
                                                </div>
                                            </div>
                                        </span>
                                <?php if($class == null){ ?>
                                    </a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php $totalUsers = count($user_list);
                    
                        for ($i=0; $i<$totalUsers; $i++){ ?>
                        <tr id="<?php echo $user_list[$i]['id']; ?>">
                            <?php 
                                // TEMPLATES COUNT PER USERS
                                if($type == 'users') {
                                    $query='SELECT COUNT(*) FROM banners WHERE userId=?';
                                    $count = pdoSelect($query, array($user_list[$i]['id']));
                                    $count = $count[0]['COUNT(*)'];
                                    
                                    $user_list[$i]['banners'] = $count;
                                    
                                    
                                    $query='SELECT COUNT(*) FROM banners WHERE userId=? AND paid=?';
                                    $count = pdoSelect($query, array($user_list[$i]['id'], true));
                                    $count = $count[0]['COUNT(*)'];
                                    
                                    $user_list[$i]['paid_banners'] = $count;
                                }
                                
                                $totalUser = count($user_list[$i]);
                                
                                for ($in=0; $in<$totalUser; $in++){
                                    if($key[$in] !== 'password_hash'){ 
                            ?>    
                                <?php if(substr($key[$in], -2) === 'at'){ ?>
                                    <td><?php echo humanTiming($user_list[$i][$key[$in]]); ?></td>
                                <?php } else if($key[$in] !== 'id' && $key[$in] !== 'banners' && $key[$in] !== 'paid_banners' && ($user_list[$i][$key[$in]] === '0' || $user_list[$i][$key[$in]] === '1')){ ?>
                                    <?php if($user_list[$i][$key[$in]] == 1){ ?>
                                        <td>Yes</td>
                                    <?php } else { ?>
                                        <td>No</td>
                                    <?php } ?>
                                <?php } else { ?>
                                    <td><?php echo $user_list[$i][$key[$in]]; ?></td>
                                <?php } ?>
                            <?php   }
                                } ?>
                            <td><a href="/admin/<?php echo $type; ?>/edit?id=<?php echo $user_list[$i]['id']; ?>">Edit</a></td>
                            <td><a href="#" onClick="deleteByID(<?php echo $user_list[$i]['id']; ?>, '<?php echo $type; ?>')">Delete</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            
            <?php 
            } else if($user_list == 'empty') {
            ?>
                <div class="text-center" style="padding-top:40px;">
                    <?php echo 'There is not any '.$type.'.'; ?>
                    <br />
                    <br />
                    <a href="/admin/" class="button gray-color">
                        << Back
                    </a>
                    <a href="/admin/<?php echo $type; ?>/edit.php?id=new" class="button normal-color">
                        Add new
                    </a>
                </div>
        <?php } else { ?>
            <div class="text-center" style="padding-top:40px;">
                That page doesnt exist.
            </div>
        <?php } ?>
    </div>
        
    <?php include($_SERVER['DOCUMENT_ROOT'].'/views/tpl/footer.php'); ?>
    <!-- /container -->
</body>

</html>