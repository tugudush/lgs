<?php
session_start();
require_once('../config.inc.php');
require_once('../functions.inc.php');
$pdo = connect();

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];
    $isbn = $_POST['isbn'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    
    //var_dump($_POST);
        
    try {
        
        $query = "INSERT INTO books
                  (title, author, genre, year, isbn, price, qty)
                  VALUES (:title, :author, :genre, :year, :isbn, :price, :qty)";
        $insert = $pdo->prepare($query);
        $insert->bindValue(':title', $title, PDO::PARAM_STR);
        $insert->bindValue(':author', $author, PDO::PARAM_STR);
        $insert->bindValue(':genre', $genre, PDO::PARAM_STR);
        $insert->bindValue(':year', $year, PDO::PARAM_STR);
        if ($isbn == null) {
            $insert->bindValue(':isbn', null, PDO::PARAM_STR);
        } // end of if ($isbn == null)
        else {
            $insert->bindValue(':isbn', $isbn, PDO::PARAM_STR);
        } // end of elseif ($isbn != null)
        $insert->bindValue(':price', $price, PDO::PARAM_STR);
        $insert->bindValue(':qty', $qty, PDO::PARAM_INT);
        
        $query_utf8mb4 = "SET NAMES utf8mb4";
        $utf8mb4 = $pdo->prepare($query_utf8mb4);
        $utf8mb4->execute();
        
        $insert->execute();
        $num_insert = $insert->rowCount();
        
        if ($num_insert == 1) {
            $response['is_success'] = true;
            $response['message'] = 'Book entry was successfully added.';
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