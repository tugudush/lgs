<?php
session_start();
require_once('../config.inc.php');
require_once('../functions.inc.php');
$pdo = connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    $id_no = $_POST['id_no'];
    
    try {
        $query = "SELECT * FROM students
                  WHERE id_no = :id_no";
        $student = $pdo->prepare($query);
        $student->bindValue(':id_no', $id_no, PDO::PARAM_STR);        
        $student->execute();
        $num_student = $student->rowCount();
        $rows_student = $student->fetchAll(PDO::FETCH_ASSOC);
        
        if ($num_student >= 1) {
            $response['has_duplicate'] = true;
            foreach($rows_student as $row) {
                $fname = $row['fname'];
                $lname = $row['lname'];
                $name = $fname.' '.$lname;
            } // end of foreach($rows_student as $row)
            $response['name'] = $name;
        } // end of if ($num_student >= 1)
        
        else {
            $response['has_duplicate'] = false;
        } // end of elseif ($num_student == 0)
        
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