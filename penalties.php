<?php
session_start();
require_once('config.inc.php');
require_once('functions.inc.php');
$pdo = connect();
verify_session();

$offset = 0;
$count = 10;
$page = 1;

if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
    $offset = $page * $count - $count;
} // end of if ($_REQUEST['p'])

$search = '';

if (isset($_REQUEST['search'])) {
    $search = $_REQUEST['search'];    
} // end of if ($_REQUEST['p'])

try {
    
} // end of try

catch(PDOException $e) {
    echo 'PDOException : '.$e->getMessage();
} // end of catch(PDOException $e)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('meta.inc.php'); ?>
    <meta name="description" content="Library Gateway System">
    <title>Library Gateway System</title>    
    <!-- CSS -->
    <?php require_once('styles.inc.php'); ?>    
    <!-- Favicons -->
    <?php include_once('favicons.inc.php'); ?>    
    <!-- Google Fonts -->
    <?php include_once('google-fonts.inc.php'); ?>
    <!-- Head Scripts -->
    <?php require_once('head-scripts.inc.php'); ?>    
</head>
<body id="page-logs" class="<?php echo $user_role; ?>">
    <?php include_once('header.inc.php'); ?>

    <div id="container">        
        <div class="wrap">            

        </div><!--/.wrap-->        
    </div><!--/container-->

    <?php include_once('footer.inc.php'); ?>    
    <?php require_once('footer-scripts.inc.php'); ?>    
</body>
</html>