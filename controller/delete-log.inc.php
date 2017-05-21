<?php
session_start();
require_once('../config.inc.php');
require_once('../functions.inc.php');
$pdo = connect();

$response['is_success'] = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {       
    
    $log_id = $_POST['log_id'];
    
    try {
        $sql_logs = "DELETE FROM logs
                     WHERE log_id = :log_id";
        $logs = $pdo->prepare($sql_logs);
        $logs->bindValue(':log_id', $log_id, PDO::PARAM_INT);        
        
        $sql_utf8mb4 = "SET NAMES utf8mb4";
        $utf8mb4 = $pdo->prepare($sql_utf8mb4);
        $utf8mb4->execute();
        
        $logs->execute();
        $num_logs = $logs->rowCount();
        
        if ($num_logs == 1) {
            $response['is_success'] = true;
            $response['message'] = 'Log deleted!';
        } // end of if ($num_logs == 1)
        else {
            $response['is_success'] = false;            
            $response['message'] = 'MySql Warning: $num_logs = '.$num_logs.' It should be 1.';
        } // end of elseif ($num_logs != 1)
        
    } // end of try
    
    catch(PDOException $e) {
        $response['is_success'] = false;
        $response['message'] = 'PDOException : '.$e->getMessage();        
    } // end of catch(PDOException $e)
    
    echo json_encode($response);
    
} // end of if ($_SERVER['REQUEST_METHOD'] == 'POST') {

else {    
    echo 'Thou shalt not pass!';
}
?>