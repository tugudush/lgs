<?php
session_start();
require_once('../config.inc.php');
require_once('../functions.inc.php');
$pdo = connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    $student_id = $_POST['student_id'];        
    //var_dump($_POST);
    
    try {        
        $query_logs = "SELECT * FROM logs
                       WHERE student_id = :student_id";
        $logs = $pdo->prepare($query_logs);
        $logs->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $logs->execute();
        $num_logs = $logs->rowCount();
        $rows_logs = $logs->fetchAll(PDO::FETCH_ASSOC);
              
    } // end of try

    catch(PDOException $e) {        
        $response['message'] = 'PDOException : '.$e->getMessage();
        //exit;
    } // End of catch(PDOException $e)
    
    $response['has_penalty'] = false;
    $penalty_counter = 0;
    foreach($rows_logs as $row_log) {
        $borrowed_datetime = $row_log['borrowed_datetime'];
        $returned_datetime = $row_log['returned_datetime'];
        $status = $row_log['status'];
        $days = get_days_interval($borrowed_datetime, $returned_datetime, $status);
        $paid = $row_log['paid'];
        
        if (($status == 'lost' && $paid != 'yes') || ($status == 'borrowed' && $days >= 4 && $paid != 'yes')) {
            $penalty_counter++;
        } // end of if (($status == 'lost' && $paid == 'no') || ($status == 'borrowed' && $days >= 4 && $paid == 'no'))
    } // end of foreach($rows_logs as $row_log)
    
    if ($penalty_counter >= 1) {
        $response['has_penalty'] = true;
    } // end of if ($penalty_counter >= 1)    
    
    echo json_encode($response);
    
} // end of if ($_SERVER['REQUEST_METHOD'] == 'POST') {

else {    
    echo 'Thou shalt not pass!';
}

?>
