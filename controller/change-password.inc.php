<?php
session_start();
require_once('../config.inc.php');
require_once('../functions.inc.php');
$pdo = connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    //var_dump($_POST);        
    try {
        $query_user = "SELECT * FROM users WHERE
                       username = :username";
        $user = $pdo->prepare($query_user);
        $user->bindValue(':username', $username, PDO::PARAM_STR);        
        $user->execute();
        $num_user = $user->rowCount();
        $row_user = $user->fetch(PDO::FETCH_ASSOC);
        $stored_password_hash = $row_user['password'];
        if ($num_user == 1) {
            $password_matched = password_verify($current_password, $stored_password_hash);
            
            if ($password_matched) {
                $is_success = change_password($username, $new_password);
                if ($is_success) {
                    $response['is_success'] = true;
                    $response['message'] = 'Password successfully changed!';
                } // end of if ($is_success)
                else {
                    $response['is_success'] = false;
                    $response['message'] = 'MySql execute error!';
                } // end of elseif (!$is_success)
            } // end of if ($password_matched)
            else {
                $response['is_success'] = false;
                $response['message'] = 'Incorrect current password!';
            } // end of elseif (!$password_matched)
        } // end of if ($num_user == 1)
        else {
            $response['is_success'] = false;
            $response['message'] = 'User not found!';
        } // end of elseif ($num_user == 0)
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

function change_password($username, $new_password) {
    global $pdo, $response;
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    try {
        $query = "UPDATE users
                  SET password = :password
                  WHERE username = :username";
        $update = $pdo->prepare($query);
        $update->bindValue(':username', $username, PDO::PARAM_STR);
        $update->bindValue(':password', $new_password_hash, PDO::PARAM_STR);
        $is_success = $update->execute();
        return $is_success;
    } // end of try
     catch(PDOException $e) {
        $response['is_success'] = false;
        $response['message'] = 'PDOException : '.$e->getMessage();            
    } // End of catch(PDOException $e) 
} // end of function change_password($username, $new_password)
?>