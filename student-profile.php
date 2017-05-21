<?php
session_start();
require_once('config.inc.php');
require_once('functions.inc.php');
$pdo = connect();
verify_session();
check_permissions();

$id_no = $username;
if (isset($_GET['id_no'])) {
    $id_no = $_GET['id_no'];
} // end of if (isset($_GET['id_no']))

try {
    $query_student = "SELECT * FROM students WHERE id_no = :id_no";
    $student = $pdo->prepare($query_student);
    $student->bindValue(':id_no', $id_no, PDO::PARAM_STR);
    $student->execute();
    $row_student = $student->fetch(PDO::FETCH_ASSOC);
    $fname = $row_student['fname'];
    $lname = $row_student['lname'];
    $name = $fname.' '.$lname;
    $course = $row_student['course'];
    
    $query_logs = "SELECT * FROM
                   logs INNER JOIN books ON
                   logs.book_id = books.book_id
                   INNER JOIN students ON
                   logs.student_id = students.student_id
                   WHERE id_no = :id_no                                      
                   ORDER BY
                   borrowed_datetime DESC, returned_datetime DESC";
        
    $logs = $pdo->prepare($query_logs);
    $logs->bindValue(':id_no', $id_no, PDO::PARAM_STR);
    $logs->execute();
    $rows_logs = $logs->fetchAll(PDO::FETCH_ASSOC);    
}
catch(PDOException $e) {
    echo $e->getMessage();
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
  

    <!-- Head Scripts -->
    <?php require_once('head-scripts.inc.php'); ?>    
</head>

<body id="page-student-profile">
    
    <?php include_once('header.inc.php'); ?>

    <div id="container">
        
        <div class="wrap">            
            <h1>Profile</h1>
            <div class="message">&nbsp;</div>
            
            <div id="student-profile">
                ID No: <?php echo $id_no; ?><br>
                Name: <?php echo $name; ?><br>
                Course: <?php echo $course; ?>
            </div><!--/student-profile-->
            
            <h2>Change Password</h2>
            <form id="change-password">
                <input type="hidden" id="username" name="username" value="<?php echo $username; ?>">
                <input type="password" id="current-password" name="current_password" class="form-control" placeholder="Current Password" required>
                <input type="password" id="new-password" name="new_password" class="form-control" placeholder="New Password" required>
                <input type="submit" id="submit" name="submit" class="form-control btn btn-danger" value="Change">
                <div id="change-password-message">&nbsp;</div>
            </form><!--/change-password-->
            
            <h2>Transactions</h2>
            <div id="logs-wrap" class="table-responsive">
                <table id="logs" class="table table-hover">
                    <tr>                        
                        <th>Book</th>
                        <th>Status</th>
                        <th>Borrowed</th>
                        <th>Returned</th>                                                
                        <th>Days Interval</th>
                        <th>Penalty</th>
                        <th>Paid</th>                        
                    </tr>
                    <?php
                    foreach($rows_logs as $row_log):
                        $log_id = $row_log['log_id'];
                        $id_no = $row_log['id_no'];
                        $book_id = $row_log['book_id'];
                        $title = $row_log['title'];
                        $price = $row_log['price'];
                        $borrowed_datetime = $row_log['borrowed_datetime'];
                        $returned_datetime = $row_log['returned_datetime'];
                        $status = $row_log['status'];
                        $paid = $row_log['paid'];                    
                        $days = get_days_interval($borrowed_datetime, $returned_datetime, $status);
                        $penalty = ($ppd*$days) - ($ppd*($pod-1));
                        if ($penalty < 0) {
                            $penalty = 0;
                        }
                        if ($status == 'lost') {
                            $penalty = $price;
                        } // end of if ($status == 'lost')
                    ?>
                    <tr>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $status; ?></td>
                        <td><?php echo $borrowed_datetime; ?></td>
                        <td><?php echo $returned_datetime; ?></td>
                        <td><?php echo $days; ?></td>
                        <td><?php echo $penalty; ?></td>
                        <td><?php echo $paid; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table><!--/logs-->
            </div><!--/logs-wrap-->
            
        </div><!--/.wrap-->        
    </div><!--/container-->

    <?php include_once('footer.inc.php'); ?>      
    
    <?php require_once('footer-scripts.inc.php'); ?>
    
</body>
</html>