<?php
require_once('config.inc.php');
require_once('functions.inc.php');
$pdo = connect();
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
  

    <!-- Head Scripts -->
    <?php require_once('head-scripts.inc.php'); ?>    
</head>

<body id="page-login">

    <div id="container">
        
        <div class="wrap">            
            <h1>Library Gateway System</h1>
            <div class="message">&nbsp;</div>
            
            <form id="login-form" class="lr-form">
                <input class="form-control" type="text" id="username" name="username" placeholder="Username">
                <input class="form-control" type="password" id="password" name="password" placeholder="Password">                    
                <input class="form-control btn" type="button" id="submit" name="submit" value="Login">
                <div class="clearfix">
                    <div class="form-group pull-left">
                        <input type="checkbox" id="guest-login" name="guest_login" value="1"> Guest Login    
                    </div><!--/.form-group-->
                    <div class="pull-right">
                        <a href="register.php">Register</a>
                    </div><!--/.pull-right-->
                </div><!--/.clearfix-->
            </form><!--/login-form-->
            
        </div><!--/.wrap-->        
    </div><!--/container-->

    <?php include_once('footer.inc.php'); ?>      
    
    <?php require_once('footer-scripts.inc.php'); ?>
    
</body>
</html>