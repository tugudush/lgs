<?php
session_start();
require_once('../config.inc.php');
require_once('../functions.inc.php');
$pdo = connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $id_no = $_POST['id_no'];    
    
    try {
        $query = "SELECT * FROM students WHERE id_no = :id_no";
        $students = $pdo->prepare($query);
        $students->bindValue(':id_no', $id_no, PDO::PARAM_STR);
        
        $query_utf8mb4 = "SET NAMES utf8mb4";
        $utf8mb4 = $pdo->prepare($query_utf8mb4);
        $utf8mb4->execute();
        
        $students->execute();
        $num_students = $students->rowCount();
        $row = $students->fetch(PDO::FETCH_ASSOC);
        
        if ($num_students == 1) {
            $response['student_id'] = $row['student_id'];
            $response['name'] = $row['fname'].' '.$row['lname'];
            $response['course'] = $row['course'];
            
            $course = $row['course'];
            $college = get_college($course);
            
            $response['college'] = $college;
            $response['is_verified'] = true;
        }
        else {
            $response['is_verified'] = false;
        }
    } // end of try
    
    catch(PDOException $e) {
        $response['message'] = $e->getMessage();
    } // End of catch(PDOException $e)
    
    echo json_encode($response);
} // end of if ($_SERVER['REQUEST_METHOD'] == 'POST')

else {
    echo 'Thou shalt not pass!';    
}
?>