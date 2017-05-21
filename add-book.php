<?php
session_start();
require_once('config.inc.php');
require_once('functions.inc.php');
$pdo = connect();
verify_session();
check_permissions();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('meta.inc.php'); ?>
    <meta name="description" content="Library Gateway System">
    <title>Add Book - Library Gateway System</title>
    
    <!-- CSS -->
    <?php require_once('styles.inc.php'); ?>
    
    <!-- Favicons -->
    <?php include_once('favicons.inc.php'); ?>
    
    <!-- Google Fonts -->
    <?php include_once('google-fonts.inc.php'); ?>

    <!-- Head Scripts -->
    <?php require_once('head-scripts.inc.php'); ?>    
</head>

<body id="page-add-book" class="<?php echo $user_role; ?>">    
    
    <?php include_once('header.inc.php'); ?>

    <div id="container">
        <div class="wrap">
            
            <div class="clearfix">
                
                <div id="add-book-wrap" class="add-wrap">
                    <?php include('includes/add-book.inc.php'); ?>
                </div><!--/add-book-wrap-->
                
            </div><!--/.clearfix-->
            

        </div><!--/.wrap-->        
    </div><!--/container-->

    <?php include_once('footer.inc.php'); ?>      
    
    <?php require_once('footer-scripts.inc.php'); ?>
    
</body>
</html>