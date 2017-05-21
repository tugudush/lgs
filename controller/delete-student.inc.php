<?php
session_start();
require_once('../config.inc.php');
require_once('../functions.inc.php');
$pdo = connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {       
    
    $id_no = $_POST['id_no'];
    
    try {
        $query = "DELETE FROM students
                  WHERE id_no = :id_no";
        $delete = $pdo->prepare($query);
        $delete->bindValue(':id_no', $id_no, PDO::PARAM_STR);                
        $delete->execute();
        $num_delete = $delete->rowCount();
        
        if ($num_delete == 1) {
            $response['is_success'] = true;
            $response['message'] = 'Student deleted!';
        } // end of if ($num_logs == 1)
        else {
            $response['is_success'] = false;            
            $response['message'] = 'MySql Warning: $num_delete = '.$num_delete.' It should be 1.';
        } // end of elseif ($num_logs != 1)        
        
        $query_delete_user = "DELETE FROM users
                              WHERE username = :username";
        $delete_user = $pdo->prepare($query_delete_user);
        $delete_user->bindValue(':username', $id_no, PDO::PARAM_STR);
        $delete_user->execute();        
        
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