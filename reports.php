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
    
    <!-- CSS -->
    <?php require_once('styles.inc.php'); ?>
    
    <!-- Favicons -->
    <?php include_once('favicons.inc.php'); ?>
    
    <!-- Google Fonts -->
    <?php include_once('google-fonts.inc.php'); ?>

    <!-- Head Scripts -->
    <?php require_once('head-scripts.inc.php'); ?>    
</head>

<body id="page-reports" class="user-role-<?php echo $user_role; ?>">        
    <?php include_once('header.inc.php'); ?>
    <div id="container">        
        <div class="wrap">
            <?php //display_paths(); ?>            
            <div id="logs-message" class="message"></div>
            
            <div id="reports-header" class="clearfix">
                <img id="reports-logo" src="images/gc-logo.png">            
                <h1>Gordon College<br>Library Log Reports</h1>
            </div><!--/reports-header-->            
            
            <form id="report-form">
                <div class="inner">
                    <select id="select-report" name="select_report" class="form-control">
                        <option value="all">All</option>
                        <option value="borrowed">Borrowed</option>
                        <option value="overdue">Borrowed (Overdue)</option>
                        <option value="returned">Returned</option>
                        <option value="lost">Lost</option>
                        <option value="lost-unpaid">Lost (Unpaid)</option>
                        <option value="daily">Daily</option>
                    </select><!--/select-report-->
                    <input type="text" id="daily-report-date" name="daily_report_date" class="form-control date-picker" placeholder="Date" value="<?php echo date('Y/m/d'); ?>">
                    <input type="submit" id="submit" name="submit" class="form-control btn btn-primary" value="Generate">
                </div><!--/.inner-->
            </form>
            <input type="hidden" id="pod" name="pod" value="<?php echo $pod; ?>">
            <div id="total-penalties">                
                Unpaid Penalties: <span id="total-payables"></span><br>
                Paid Penalties: <span id="total-paid"></span><br>
                Total Penalties: <span id="combined-penalties"></span>
            </div><!--/total-penalties-->
            
            <div id="load-report">
                
            </div><!--/load-report-->
        </div><!--/.wrap-->        
    </div><!--/container-->

    <?php include_once('footer.inc.php'); ?>          
    <?php require_once('footer-scripts.inc.php'); ?>    
</body>
</html>