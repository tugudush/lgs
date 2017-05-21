<?php
session_start();
require_once('../config.inc.php');
require_once('../functions.inc.php');
$pdo = connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $id_no = $_POST['id_no'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $course = $_POST['course'];  
    //var_dump($_POST);        
    try {        
        $query = "UPDATE students SET
                  id_no = :id_no,
                  fname = :fname,
                  mname = :mname,
                  lname = :lname,
                  course = :course                 
                  WHERE student_id = :student_id";
        $update = $pdo->prepare($query);        
        $update->bindValue(':id_no', $id_no, PDO::PARAM_STR);
        $update->bindValue(':fname', $fname, PDO::PARAM_STR);
        if ($mname == null) {
            $update->bindValue(':mname', null, PDO::PARAM_STR);    
        } // end of if ($mname == null)
        else {
            $update->bindValue(':mname', $mname, PDO::PARAM_STR);
        } // end of elseif ($mname != null)
        $update->bindValue(':lname', $lname, PDO::PARAM_STR);
        $update->bindValue(':course', $course, PDO::PARAM_INT);        
        $update->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        
        $query_utf8mb4 = "SET NAMES utf8mb4";
        $utf8mb4 = $pdo->prepare($query_utf8mb4);
        $utf8mb4->execute();
        
        $update->execute();        
        $num_update = $update->rowCount();
        
        if ($num_update == 0 || $num_update == 1) {
            $response['is_success'] = true;
            $response['message'] = 'Log entry was successfully updated!';
        }
        else {
            $response['is_success'] = false;
            $response['message'] = 'MySql Warning: $num_update = '.$num_update.' It should be 1 or 0.';
        }
        
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