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

<body id="page-register">

    <div id="container">
        
        <div class="wrap">            
            <h1>Register</h1>            
            <form id="register-form" class="lr-form">
                <div class="message">&nbsp;</div>
                <input class="form-control" type="text" id="username" name="username" placeholder="ID No." required>
                <input class="form-control" type="password" id="password" name="password" placeholder="Password" required>
                <input class="form-control" type="text" id="fname" name="fname" placeholder="First Name" required>
                <input class="form-control" type="text" id="mname" name="mname" placeholder="Middle Name">
                <input class="form-control" type="text" id="lname" name="lname" placeholder="Last Name" required>
                <select id="course" name="course" class="form-control" required>
                    <option value="">Course</option>
                    <option value="ABCOMM">ABCOMM</option>
                    <option value="ACT">ACT</option>
                    <option value="BEED">BEED</option>
                    <option value="BSBA">BSBA</option>
                    <option value="BSCS">BSCS</option>
                    <option value="BSED">BSED</option>
                    <option value="BSHRM">BSHRM</option>
                    <option value="BSIT">BSIT</option>
                    <option value="BSM">BSM</option>
                    <option value="BSN">BSN</option>
                    <option value="BSTM">BSTM</option>
                </select>
                <input class="form-control btn" type="submit" id="submit" name="submit" value="Register">
                <a href="login.php" style="display:block;text-align:center;">Back</a>
            </form><!--/register-form-->
                             
        </div><!--/.wrap-->        
    </div><!--/container-->

    <?php include_once('footer.inc.php'); ?>      
    
    <?php require_once('footer-scripts.inc.php'); ?>
    
</body>
</html>