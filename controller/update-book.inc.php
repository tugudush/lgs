<?php
session_start();
require_once('../config.inc.php');
require_once('../functions.inc.php');
$pdo = connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];
    $isbn = $_POST['isbn'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    //var_dump($_POST);        
    try {        
        $query = "UPDATE books SET
                  title = :title,
                  author = :author,
                  genre = :genre,
                  year = :year,
                  isbn = :isbn,
                  price = :price,
                  qty = :qty
                  WHERE book_id = :book_id";
        $update = $pdo->prepare($query);        
        $update->bindValue(':title', $title, PDO::PARAM_STR);
        $update->bindValue(':author', $author, PDO::PARAM_STR);
        $update->bindValue(':genre', $genre, PDO::PARAM_STR);
        $update->bindValue(':year', $year, PDO::PARAM_INT);
        if ($isbn == null) {
            $update->bindValue(':isbn', null, PDO::PARAM_STR);
        } // end of if ($isbn == null)
        else {
            $update->bindValue(':isbn', $isbn, PDO::PARAM_STR);
        } // end of elseif ($isbn != null)
        $update->bindValue(':price', $price, PDO::PARAM_STR);
        $update->bindValue(':qty', $qty, PDO::PARAM_INT);
        $update->bindValue(':book_id', $book_id, PDO::PARAM_INT);
        
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