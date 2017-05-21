<?php
session_start();
require_once('../config.inc.php');
require_once('../functions.inc.php');
$pdo = connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $log_id = $_POST['log_id'];
    $book_id = $_POST['book_id'];
    $borrowed_datetime = $_POST['borrowed_datetime'];
    $returned_datetime = $_POST['returned_datetime'];    
    $current_status = $_POST['current_status'];
    $new_status = $_POST['new_status'];
    $paid = $_POST['paid'];
    
    if ($paid == null) {
        $response['paid_is_null'] = true;
    }
    else {
        $response['paid_is_null'] = false;
    }    
    
    //var_dump($_POST);
        
    try {        
        $query_logs = "UPDATE logs SET
                       borrowed_datetime = :borrowed_datetime,
                       returned_datetime = :returned_datetime,
                       status = :new_status,
                       paid = :paid
                       WHERE log_id = :log_id";
        $update_log = $pdo->prepare($query_logs);
        $update_log->bindValue(':borrowed_datetime', $borrowed_datetime, PDO::PARAM_STR);
        
        if ($returned_datetime == null) {
            $update_log->bindValue(':returned_datetime', null, PDO::PARAM_STR);    
        }
        else {
            $update_log->bindValue(':returned_datetime', $returned_datetime, PDO::PARAM_STR);
        }
        
        if ($paid== null) {
            $update_log->bindValue(':paid', null, PDO::PARAM_STR);    
        }
        else {
            $update_log->bindValue(':paid', $returned_datetime, PDO::PARAM_STR);
        }
        
        $update_log->bindValue(':new_status', $new_status, PDO::PARAM_STR);
        $update_log->bindValue(':paid', $paid, PDO::PARAM_STR);
        $update_log->bindValue(':log_id', $log_id, PDO::PARAM_INT);        
        
        $query_utf8mb4 = "SET NAMES utf8mb4";
        $utf8mb4 = $pdo->prepare($query_utf8mb4);
        $utf8mb4->execute();        
        
        $update_log->execute();        
        $num_update_log = $update_log->rowCount();
        
        if ($num_update_log == 0 || $num_update_log == 1) {
            $response['is_success'] = true;
            $response['message'] = 'Log entry was successfully updated!';
            
            if (($current_status == 'borrowed' || $current_status == 'lost') && $new_status == 'returned') {
                $query_update_book = "UPDATE books
                                      SET qty = qty + 1
                                      WHERE book_id = :book_id";
                $update_book = $pdo->prepare($query_update_book);
                $update_book->bindValue(':book_id', $book_id, PDO::PARAM_INT);
                $update_book->execute();
                $num_update_book = $update_book->rowCount();

                if ($num_update_book == 0 || $num_update_book == 1) {
                    $response['is_success'] = true;
                    $response['message'] = 'Log entry was successfully updated!';
                } // end of if ($num_update_log == 0 || $num_update_log == 1)
                else {
                    $response['is_success'] = false;
                    $response['message'] = 'MySql Warning: $num_update = '.$num_update_book.' It should be 1 or 0.';
                } // end of elseif ($num_update_log > 1)

            } // end of if (($current_status == 'borrowed' || $current_status == 'lost') && $new_status == 'returned')
            
            elseif ($current_status == 'returned' && ($new_status == 'borrowed' || $new_status == 'lost')) {
                $query_update_book = "UPDATE books
                                      SET qty = qty - 1
                                      WHERE book_id = :book_id";
                $update_book = $pdo->prepare($query_update_book);
                $update_book->bindValue(':book_id', $book_id, PDO::PARAM_INT);
                $update_book->execute();
                $num_update_book = $update_book->rowCount();

                if ($num_update_book == 0 || $num_update_book == 1) {
                    $response['is_success'] = true;
                    $response['message'] = 'Log entry was successfully updated!';
                } // end of if ($num_update_log == 0 || $num_update_log == 1)
                else {
                    $response['is_success'] = false;
                    $response['message'] = 'MySql Warning: $num_update = '.$num_update_book.' It should be 1 or 0.';
                } // end of elseif ($num_update_log > 1)

            } // end of if (($current_status == 'borrowed' || $current_status == 'lost') && $new_status == 'returned')
            
        } // end of if ($num_update_log == 0 || $num_update_log == 1)
        else {
            $response['is_success'] = false;
            $response['message'] = 'MySql Warning: $num_update = '.$num_update_log.' It should be 1 or 0.';
        } // end of elseif ($num_update_log > 1)
        
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