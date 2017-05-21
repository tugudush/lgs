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
    <title>Library Gateway System</title> 
    <?php require_once('styles.inc.php'); ?> 
    <?php include_once('favicons.inc.php'); ?> 
    <?php require_once('head-scripts.inc.php'); ?>    
</head>
<body id="page-admin-profile">    
    <?php include_once('header.inc.php'); ?>
    <div id="container">        
        <div class="wrap">                        
            <div class="message">&nbsp;</div>
            <h2>Change Password</h2>
            <form id="change-password">
                <input type="hidden" id="username" name="username" value="<?php echo $username; ?>">
                <input type="password" id="current-password" name="current_password" class="form-control" placeholder="Current Password" required>
                <input type="password" id="new-password" name="new_password" class="form-control" placeholder="New Password" required>
                <input type="submit" id="submit" name="submit" class="form-control btn btn-danger" value="Change">
                <div id="change-password-message"></div>
            </form><!--/change-password-->
        </div><!--/.wrap-->        
    </div><!--/container-->
    <?php include_once('footer.inc.php'); ?>
    <?php require_once('footer-scripts.inc.php'); ?>    
</body>
</html>