<?php
session_start();
require_once('../config.inc.php');
require_once('../functions.inc.php');
$pdo = connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    $username = $_POST['username'];
    
    try {
        $query = "SELECT * FROM users
                  WHERE username = :username";
        $users = $pdo->prepare($query);
        $users->bindValue(':username', $username, PDO::PARAM_STR);        
        $users->execute();
        $num_users = $users->rowCount();      
        
        if ($num_users >= 1) {
            $response['has_duplicate'] = true;                   
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