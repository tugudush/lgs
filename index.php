<?php
session_start();
require_once('config.inc.php');
require_once('functions.inc.php');
$pdo = connect();
verify_session();
check_permissions();

$offset = 0;
$count = 10;
$page = 1;

if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
    $offset = $page * $count - $count;
} // end of if ($_REQUEST['page'])

$search = '';

if (isset($_REQUEST['search'])) {
    $search = $_REQUEST['search'];    
} // end of if ($_REQUEST['search'])

$status = '';
$overdue = false;
if (isset($_REQUEST['status'])) {
    $status = $_REQUEST['status'];
    if ($status == 'overdue') {
        $status = 'borrowed';
        $overdue = true;
    } // end of if ($status == 'overdue')
} // end of if ($_REQUEST['status'])

try {    
    $query_logs = "SELECT * FROM
                   logs INNER JOIN books ON
                   logs.book_id = books.book_id
                   INNER JOIN students ON
                   logs.student_id = students.student_id
                   WHERE
                   (
                   id_no LIKE :id_no OR
                   title LIKE :title OR
                   fname LIKE :fname OR
                   lname LIKE :lname OR
                   borrowed_datetime LIKE :borrowed_datetime OR
                   returned_datetime like :returned_datetime
                   )
                   AND status LIKE :status
                   ORDER BY
                   borrowed_datetime DESC, returned_datetime DESC, lname ASC, fname ASC, title ASC";
    
    $logs = $pdo->prepare($query_logs);
    $logs->bindValue(':id_no', "%$search%", PDO::PARAM_STR);
    $logs->bindValue(':title', "%$search%", PDO::PARAM_STR);
    $logs->bindValue(':fname', "%$search%", PDO::PARAM_STR);
    $logs->bindValue(':lname', "%$search%", PDO::PARAM_STR);
    $logs->bindValue(':borrowed_datetime', "%$search%", PDO::PARAM_STR);
    $logs->bindValue(':returned_datetime', "%$search%", PDO::PARAM_STR);
    $logs->bindValue(':status', "%$status%", PDO::PARAM_STR);
    
    $query_limit_logs = "SELECT * FROM
                         logs INNER JOIN books ON
                         logs.book_id = books.book_id
                         INNER JOIN students ON
                         logs.student_id = students.student_id
                         WHERE
                         (
                         id_no LIKE :id_no OR  
                         title LIKE :title OR
                         fname LIKE :fname OR
                         lname LIKE :lname OR
                         borrowed_datetime LIKE :borrowed_datetime OR
                         returned_datetime like :returned_datetime
                         )
                         AND status LIKE :status
                         ORDER BY
                         borrowed_datetime DESC, returned_datetime DESC, lname ASC, fname ASC, title ASC
                         LIMIT :offset, :count";
    
    $limit_logs = $pdo->prepare($query_limit_logs);
    
    $limit_logs->bindValue(':id_no', "%$search%", PDO::PARAM_STR);
    $limit_logs->bindValue(':title', "%$search%", PDO::PARAM_STR);
    $limit_logs->bindValue(':fname', "%$search%", PDO::PARAM_STR);
    $limit_logs->bindValue(':lname', "%$search%", PDO::PARAM_STR);
    $limit_logs->bindValue(':borrowed_datetime', "%$search%", PDO::PARAM_STR);
    $limit_logs->bindValue(':returned_datetime', "%$search%", PDO::PARAM_STR);
    $limit_logs->bindValue(':status', "%$status%", PDO::PARAM_STR);
    $limit_logs->bindValue(':offset', $offset, PDO::PARAM_INT);
    $limit_logs->bindValue(':count', $count, PDO::PARAM_INT);
    
    $query_utf8mb4 = "SET NAMES utf8mb4";
    $utf8mb4 = $pdo->prepare($query_utf8mb4);
    $utf8mb4->execute();
    
    $logs->execute();
    $num_logs = $logs->rowCount();
    
    $limit_logs->execute();
    $rows_limit_logs = $limit_logs->fetchAll(PDO::FETCH_ASSOC);
    
    $total_pages = ceil($num_logs / $count);
} // end of try
catch(PDOException $e) {
    echo 'PDOException: '.$e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('meta.inc.php'); ?>
    <meta name="description" content="Library Gateway System">
    <title>Library Gateway/Borrowing System</title>
    
    <!-- CSS -->
    <?php require_once('styles.inc.php'); ?>
    
    <!-- Favicons -->
    <?php include_once('favicons.inc.php'); ?>
    
    <!-- Google Fonts -->
    <?php include_once('google-fonts.inc.php'); ?>

    <!-- Head Scripts -->
    <?php require_once('head-scripts.inc.php'); ?>    
</head>

<body id="page-logs" class="user-role-<?php echo $user_role; ?>">    
    
    <?php include_once('header.inc.php'); ?>

    <div id="container">
      
        <div id="delete-log-dialog" class="dialog">            
            <div class="box-wrap">
                <div class="box">
                    <span class="dialog-msg"></span>
                    <div class="dialog-btns" class="clearfix">
                        <a class="btn btn-default btn-no">No</a>
                        <a class="btn btn-success btn-yes">Yes</a>
                    </div><!--/dialog-btns-->
                </div><!--/.box-->
            </div><!--/.box-wrap-->
        </div><!--/delete-log-dialog-->
        
        <div class="wrap">
            <?php //display_paths(); ?>
            
            <div id="logs-message" class="message"></div>
            
            <div id="table-head-bar">
               
                <div class="pagination">                
                    <?php
                    $low_offset = $offset + 1;
                    $high_offset = $offset + $count;

                    if ($page == $total_pages) {

                        if ($num_logs % $count == 0) {
                            $high_offset = $offset + $count;
                        } // end of if ($num_products % $count == 0)

                        else {
                            $high_offset = $offset + ($num_logs % $count);
                        }
                    } // end of if ($page == $total_pages)
                    
                    if ($num_logs >= 1) {
                        echo 'Showing '.$low_offset.' - '.$high_offset.' of '.$num_logs.'<br>';
                        echo 'Page: ';
                        for ($i=1; $i<=$total_pages; $i++) {
                            echo '<a href="'.$php_self.'?search='.$search.'&page='.$i.'">'.$i.'</a>';
                        } 
                    } // end of if ($num_logs >= 1)                    
                    ?>
                </div><!--/.pagination-->
                
                <div id="search-wrap">
                    <a class="fa fa-plus-square add-log" href="add-log.php"></a>
                    <form id="search-form" action="<?php echo $php_self; ?>" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search" <?php if (isset($_REQUEST['search'])) { echo 'value="'.$search.'"'; } ?>>
                            <div class="input-group-addon"><i class="fa fa-search"></i></div>
                        </div><!--/.input-group-->
                    </form>
                    <select id="filter-status" class="form-control">
                        <option value="" <?php if($status == '') { echo 'selected'; } ?>>All</option>
                        <option value="borrowed" <?php if($status == 'borrowed') { echo 'selected'; } ?>>Borrowed</option>
                        <option value="overdue" <?php if($overdue) { echo 'selected'; } ?>>Borrowed (Overdue)</option>
                        <option value="returned" <?php if($status == 'returned') { echo 'selected'; } ?>>Returned</option>
                        <option value="lost" <?php if($status == 'lost') { echo 'selected'; } ?>>Lost</option>
                    </select>
                    <!-- <a class="fa fa-print generate-report" href="#"></a> -->
                </div><!--/search-wrap-->
                                
            </div><!--/table-head-bar-->            
                
            <div id="logs-wrap" class="table-responsive">
                <table id="logs" class="table table-hover">
                    <tr>                        
                        <!-- <th>Log ID</th> -->
                        <th>ID No.</th>
                        <th>Name</th>                        
                        <th>Book</th>
                        <th>Status</th>
                        <th>Borrowed</th>
                        <th>Returned</th>                                                
                        <th>Days Interval</th>
                        <th>Penalty</th>
                        <th>Paid</th>
                        <th>&nbsp;</th>
                    </tr>
                    <?php
                    if ($overdue) {
                        include('includes/index-rows-overdue.inc.php');
                    } // end of if ($overdue)
                    else {
                        include('includes/index-rows-default.inc.php');
                    } // end of eleseif(!$overdue)
                    ?>
                </table><!--/products-->
            </div><!--/logs-wrap-->

        </div><!--/.wrap-->        
    </div><!--/container-->

    <?php include_once('footer.inc.php'); ?>      
    
    <?php require_once('footer-scripts.inc.php'); ?>
    
</body>
</html>