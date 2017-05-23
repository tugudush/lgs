<?php
session_start();
require_once('../config.inc.php');
require_once('../functions.inc.php');
$pdo = connect();
verify_session();
check_permissions();

try {
    $query = "SELECT * FROM
              logs INNER JOIN books ON
              logs.book_id = books.book_id
              INNER JOIN students ON
              logs.student_id = students.student_id
              WHERE status = 'lost'
              ORDER BY borrowed_datetime DESC";
    $logs = $pdo->prepare($query);
    $logs->execute();
    $num_logs = $logs->rowCount();
    $row_logs = $logs->fetchAll(PDO::FETCH_ASSOC);
}

catch(PDOException $e) {
    echo 'PDOException: '.$e->getMessage();
}
?>

<h1><span style="font-size: 20px">Lost</span></h1>
 <input type="hidden" id="pod" name="pod" value="<?php echo $pod; ?>">
            <div id="total-penalties">                
                Unpaid Penalties:<span id="total-payables"></span><br>
                Paid Penalties: <span id="total-paid"></span><br>
                <!-- Total Penalties:<span id="combined-penalties"></span> --> 
                </div><!--/total-penalties-->
<div id="table-head-bar">
    <div class="pull-left">
        Results: <span id="reports-total-results"><?php echo $num_logs; ?></span>
    </div><!--/.pull-left-->
    <div class="pull-right">
        <input type="button" id="print-report" class="print btn btn-success" value="Print">
    </div><!--/.pull-right-->
</div><!--/table-head-bar-->

<div id="logs-wrap" class="table-responsive">
    <table id="logs" class="table table-hover">
        <tr>            
            <th>ID No.</th>
            <th>Name</th>                        
            <th>Book</th>            
            <th>Borrowed</th>
            <th>Days Interval</th>            
            <th>Penalty</th>
            <th>Paid</th>            
        </tr>
        <?php
        foreach($row_logs as $row):
            $log_id = $row['log_id'];
            $id_no = $row['id_no'];
            $fname = $row['fname'];
            $lname = $row['lname'];
            $name = $fname.' '.$lname;
            $book_id = $row['book_id'];
            $title = $row['title'];
            $price = $row['price'];
            $borrowed_datetime = $row['borrowed_datetime'];
            $returned_datetime = $row['returned_datetime'];
            $status = $row['status'];
            $paid = $row['paid'];
        
            $days = get_days_interval($borrowed_datetime, $returned_datetime, $status);

            $penalty = ($ppd*$days) - ($ppd*($pod-1));
            if ($penalty < 0) {
                $penalty = 0;
            }

            if ($status == 'lost') {
                $penalty = $price;
            } // end of if ($status == 'lost')
        ?>
            <tr class="log-row">
                <td><?php echo $id_no; ?></td>
                <td><?php echo $name; ?></td>
                <td><?php echo $title; ?></td>
                <td><?php echo $borrowed_datetime; ?></td>                
                <td class="row-col-days"><?php echo $days; ?></td>
                <td class="row-col-penalty"><?php echo $penalty; ?></td>
                <td class="row-col-paid"><?php echo $paid; ?></td>
            </tr>
        <?php
        endforeach;
        ?>
    </table><!--/products-->
</div><!--/logs-wrap-->