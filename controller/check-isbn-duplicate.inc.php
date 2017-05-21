<?php
session_start();
require_once('../config.inc.php');
require_once('../functions.inc.php');
$pdo = connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    $isbn = $_POST['isbn'];
    
    try {        
        $query = "SELECT * FROM books
                  WHERE isbn = :isbn";
        $books = $pdo->prepare($query);
        $books->bindValue(':isbn', $isbn, PDO::PARAM_STR);        
        $books->execute();
        $num_books = $books->rowCount();
        $row_book = $books->fetch(PDO::FETCH_ASSOC);
        $title = $row_book['title'];
        
        if ($num_books >= 1) {
            $response['has_duplicate'] = true;
            $response['title'] = $title;
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