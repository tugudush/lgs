<?php
session_start();
require_once('../config.inc.php');
require_once('../functions.inc.php');
$pdo = connect();

$verified = false;
$num_users = 0;
$user_role = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];
    
    try {
        $sql_users = "SELECT * FROM users WHERE username = :input_username";
        $users = $pdo->prepare($sql_users);
        $users->bindValue(':input_username', $input_username, PDO::PARAM_STR);
        
        $sql_utf8mb4 = "SET NAMES utf8mb4";
        $query_utf8mb4 = $GLOBALS["pdo"]->prepare($sql_utf8mb4);
        $query_utf8mb4->execute();
        
        $users->execute();
        $num_users = $users->rowCount();
        $rows_users = $users->fetch(PDO::FETCH_ASSOC);
        
        if ($num_users == 1) {
            $username = $rows_users['username'];
            $user_role = $rows_users['role'];
            $stored_password_hash = $rows_users['password'];
            $password_matched = password_verify($input_password, $stored_password_hash);
            
            if ($password_matched) {
                $verified = true;
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['user_role'] = $user_role;
            } // end of if ($password_matched)
        } // end of if ($num_users == 1)
        
        $response = array(
            'num_users' => $num_users,
            'verified' => $verified,
            'user_role' => $user_role
        );
        echo json_encode($response);
    } // end of try
    
    catch(PDOException $e) {
        echo 'PDOException : '.$e->getMessage();
    } // End of catch(PDOException $e)
    
    
} // end of if ($_SERVER['REQUEST_METHOD'] == 'POST') {

else {
    echo 'Thou shalt not pass!';
}

?>