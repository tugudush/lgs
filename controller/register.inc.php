<?php
session_start();
require_once('../config.inc.php');
require_once('../functions.inc.php');
$pdo = connect();

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username = $_POST['username'];
    $id_no = $username;
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $course = $_POST['course'];    
    
    //var_dump($_POST);
        
    try {        
        $query_students = "SELECT * FROM students
                           WHERE id_no = :id_no";
        $students = $pdo->prepare($query_students);
        $students->bindValue(':id_no', $id_no, PDO::PARAM_STR);
        $students->execute();
        $num_students = $students->rowCount();
        $row_student = $students->fetch(PDO::FETCH_ASSOC);
        $db_fname = $row_student['fname'];
        $db_mname = $row_student['mname'];
        $db_lname = $row_student['lname'];
        
        if ($num_students >=1) {
            $response['student_on_db'] = true;
            
            if ($fname == $db_fname && $lname == $db_lname) {
                $is_success = register_user($username, $password);
                $response['is_success'] = $is_success;
                $response['message'] = 'User successfully registered!';
            } //end of if ($fname == $db_fname && $lname == $db_lname)            
            else {
                $response['is_success'] = false;
                $response['message'] = "Name didn't matched on our students records. ID No. is owned by $db_fname $db_lname";
            } // end of if ($fname != $db_fname && $lname != $db_lname)
            
        } // end of if ($num_students >=1)
        else {
            $response['student_on_db'] = false;
            
            $success_counter = 0;
            $register_user_success = register_user($username, $password);
            $register_student_success = register_student($id_no, $fname, $mname, $lname, $course);
            
            if ($register_user_success) {
                $success_counter++;
            }
            if ($register_student_success) {
                $success_counter++;
            }            
            if ($success_counter >= 2) {
                $response['is_success'] = true;
                $response['message'] = 'User successfully registered!';
            }
        } // end of elseif($num_students == 0)
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

function register_user($username, $password) {
    global $pdo, $response;
    try {
        $query_insert_user = "INSERT INTO users
                              (username, password)
                              VALUES (:username, :password)";
        $insert_user = $pdo->prepare($query_insert_user);
        $insert_user->bindValue(':username', $username, PDO::PARAM_STR);
        $insert_user->bindValue(':password', $password, PDO::PARAM_STR);
        $is_success = $insert_user->execute();
        return $is_success;
    } // end of try
    catch(PDOException $e) {
        $response['is_success'] = false;
        $response['message'] = 'PDOException : '.$e->getMessage();
    } 
} // end of function register_user()

function register_student($id_no, $fname, $mname, $lname, $course) {
    global $pdo, $response;
    try {
        $query_insert_student = "INSERT INTO students
                                 (id_no, fname, mname, lname, course)
                                 VALUES (:id_no, :fname, :mname, :lname, :course)";
        $insert_student = $pdo->prepare($query_insert_student);
        $insert_student->bindValue(':id_no', $id_no, PDO::PARAM_STR);
        $insert_student->bindValue(':fname', $fname, PDO::PARAM_STR);
        if ($mname == null) {
            $insert_student->bindValue(':mname', null, PDO::PARAM_STR);    
        } // end of if ($mname == null)
        else {
            $insert_student->bindValue(':mname', $mname, PDO::PARAM_STR);
        } // end of elseif ($mname != null)
        $insert_student->bindValue(':lname', $lname, PDO::PARAM_STR);
        $insert_student->bindValue(':course', $course, PDO::PARAM_STR);
        $is_success = $insert_student->execute();
        return $is_success;
    } // end of try
    catch(PDOException $e) {
        $response['is_success'] = false;
        $response['message'] = 'PDOException : '.$e->getMessage();
    } 
} // end of function register_student()

?>