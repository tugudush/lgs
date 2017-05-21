<?php
session_start();
require_once('../config.inc.php');
require_once('../functions.inc.php');
$pdo = connect();

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $id_no = $_POST['id_no'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $course = $_POST['course'];    
    
    //var_dump($_POST);
        
    try {
        
        $query = "INSERT INTO students
                  (id_no, fname, mname, lname, course)
                  VALUES (:id_no, :fname, :mname, :lname, :course)";
        $insert = $pdo->prepare($query);
        $insert->bindValue(':id_no', $id_no, PDO::PARAM_STR);
        $insert->bindValue(':fname', $fname, PDO::PARAM_STR);
        if ($mname == null) {
            $insert->bindValue(':mname', null, PDO::PARAM_STR);    
        } // end of if ($mname == null)
        else {
            $insert->bindValue(':mname', $mname, PDO::PARAM_STR);
        } // end of elseif ($mname != null)
        
        $insert->bindValue(':lname', $lname, PDO::PARAM_STR);
        $insert->bindValue(':course', $course, PDO::PARAM_STR);        
        
        $query_utf8mb4 = "SET NAMES utf8mb4";
        $utf8mb4 = $pdo->prepare($query_utf8mb4);
        $utf8mb4->execute();
        
        $insert->execute();
        $num_insert = $insert->rowCount();
        
        if ($num_insert == 1) {
            $response['is_success'] = true;
            $response['message'] = 'Student was successfully added.';
        } // end of if ($num_insert == 1)
        
        else {
            $response['is_success'] = false;
            $response['message'] = '$num_insert: '.$num_insert.'. It must be 1.';
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