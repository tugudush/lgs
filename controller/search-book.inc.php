<?php
session_start();
require_once('../config.inc.php');
require_once('../functions.inc.php');
$pdo = connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $keyword = $_POST['keyword'];
    $response['keyword'] = $keyword;
    
    try {
        
        $query = "SELECT * FROM books WHERE
                  title LIKE :title OR
                  author LIKE :author OR
                  genre LIKE :genre OR
                  year LIKE :year OR
                  isbn LIKE :isbn";
        
        $books = $pdo->prepare($query);
        $books->bindValue(':title', "%$keyword%", PDO::PARAM_STR);
        $books->bindValue(':author', "%$keyword%", PDO::PARAM_STR);
        $books->bindValue(':genre', "%$keyword%", PDO::PARAM_STR);
        $books->bindValue(':year', "%$keyword%", PDO::PARAM_STR);
        $books->bindValue(':isbn', "%$keyword%", PDO::PARAM_STR);
        
        $query_utf8mb4 = "SET NAMES utf8mb4";
        $utf8mb4 = $pdo->prepare($query_utf8mb4);
        $utf8mb4->execute();
        
        $books->execute();
        $num_books = $books->rowCount();
        $rows_books = $books->fetchAll(PDO::FETCH_ASSOC);
        
        $response['num_books'] = $num_books;
        
        $i = 0;
        foreach($rows_books as $row) {
            $response['row'][$i]['book_id'] = $row['book_id'];
            $response['row'][$i]['title'] = $row['title'];
            $response['row'][$i]['author'] = $row['author'];
            $response['row'][$i]['genre'] = $row['genre'];
            $response['row'][$i]['year'] = $row['year'];
            $response['row'][$i]['isbn'] = $row['isbn'];
            $response['row'][$i]['qty'] = $row['qty'];
            $i++;
        } // end of foreach($rows_books as $row)
        
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