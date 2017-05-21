<?php
session_start();
require_once('../config.inc.php');
require_once('../functions.inc.php');
$pdo = connect();

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $book_id = $_POST['book_id'];
    $student_id = $_POST['student_id'];
    $borrowed_datetime = $_POST['borrowed_datetime'].':'.$_POST['current_seconds'];
    $borrowed_datetime = format_datetime($borrowed_datetime);
        
    try {
        
        $query = "INSERT INTO logs
                  (book_id, student_id, borrowed_datetime)
                  VALUES (:book_id, :student_id, :borrowed_datetime)";
        $insert = $pdo->prepare($query);
        $insert->bindValue(':book_id', $book_id, PDO::PARAM_INT);
        $insert->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $insert->bindValue(':borrowed_datetime', $borrowed_datetime, PDO::PARAM_STR);
        
        $update_query = "UPDATE books
                         SET qty = qty - 1
                         WHERE book_id = :book_id";
        $update = $pdo->prepare($update_query);
        $update->bindValue(':book_id', $book_id, PDO::PARAM_INT);
        
        $query_utf8mb4 = "SET NAMES utf8mb4";
        $utf8mb4 = $pdo->prepare($query_utf8mb4);
        $utf8mb4->execute();
        
        $insert_success = $insert->execute();
        $update_success = $update->execute();
         
        if ($insert_success && $update_success) {
            $response['is_success'] = true;
            $response['message'] = 'Log Added!';
        } // end of if ($num_insert == 1)
        
        else {
            $response['is_success'] = false;
            $response['message'] = 'MySql Insert and Update Error!';
        } // end of elseif($num_insert != 1)
        
    } // end of try

    catch(PDOException $e) {
        $response['is_success'] = false;
        $response['message'] = 'PDOException : '.$e->getMessage();            
    } // End of catch(PDOException $e)
    
    echo json_encode($response);
    
} // end of if ($_SERVER['REQUEST_METHOD'] == 'POST') {

else {    
    echo 'Thou shalt not pass!';
}

?>