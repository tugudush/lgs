<?php
session_start();
require_once('../config.inc.php');
require_once('../functions.inc.php');
$pdo = connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    $title = $_POST['title'];
    $author = $_POST['author'];
    
    try {        
        $query = "SELECT * FROM books
                  WHERE title = :title AND author = :author";
        $books = $pdo->prepare($query);
        $books->bindValue(':title', $title, PDO::PARAM_STR);
        $books->bindValue(':author', $author, PDO::PARAM_STR);        
        $books->execute();
        $num_books = $books->rowCount();
        $row_books = $books->fetchAll(PDO::FETCH_ASSOC);
        
        if ($num_books >= 1) {
            $response['has_duplicate'] = true;
        } // end of if ($num_books >= 1)
        else {
            $response['has_duplicate'] = false;
        } // end of elseif ($num_books == 0)
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