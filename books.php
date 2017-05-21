<?php
session_start();
require_once('config.inc.php');
require_once('functions.inc.php');
$pdo = connect();
verify_session();
check_permissions();

$offset = 0;
$limit_offset = 0;
$count = 10;
$page = 1;

if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
    $offset = $page * $count - $count;
} // end of if ($_REQUEST['p'])

$search = '';

if (isset($_REQUEST['search'])) {
    $search = $_REQUEST['search'];    
} // end of if ($_REQUEST['p'])

try {    
    $query_books = "SELECT * FROM books
                    WHERE
                    title LIKE :title OR
                    author LIKE :author OR
                    genre LIKE :genre OR
                    year LIKE :year OR
                    isbn LIKE :isbn
                    ORDER BY title, author, year DESC, genre";
    
    $books = $pdo->prepare($query_books);
    $books->bindValue(':title', "%$search%", PDO::PARAM_STR);
    $books->bindValue(':author', "%$search%", PDO::PARAM_STR);
    $books->bindValue(':genre', "%$search%", PDO::PARAM_STR);
    $books->bindValue(':year', "%$search%", PDO::PARAM_STR);
    $books->bindValue(':isbn', "%$search%", PDO::PARAM_STR);
    
    $query_limit_books = "SELECT * FROM books
                          WHERE
                          title LIKE :title OR
                          author LIKE :author OR
                          genre LIKE :genre OR
                          year LIKE :year OR
                          isbn LIKE :isbn
                          ORDER BY title, author, year DESC, genre
                          LIMIT :offset, :count";
    
    $limit_books = $pdo->prepare($query_limit_books);    
    $limit_books->bindValue(':title', "%$search%", PDO::PARAM_STR);
    $limit_books->bindValue(':author', "%$search%", PDO::PARAM_STR);
    $limit_books->bindValue(':genre', "%$search%", PDO::PARAM_STR);
    $limit_books->bindValue(':year', "%$search%", PDO::PARAM_STR);
    $limit_books->bindValue(':isbn', "%$search%", PDO::PARAM_STR);
    $limit_books->bindValue(':offset', $offset, PDO::PARAM_INT);
    $limit_books->bindValue(':count', $count, PDO::PARAM_INT);
    
    $query_utf8mb4 = "SET NAMES utf8mb4";
    $utf8mb4 = $pdo->prepare($query_utf8mb4);
    $utf8mb4->execute();
    
    $books->execute();
    $num_books = $books->rowCount();
    
    $limit_books->execute();
    $num_limit_books = $limit_books->rowCount();    
    $rows_limit_books = $limit_books->fetchAll(PDO::FETCH_ASSOC);
    
    $total_pages = ceil($num_books / $count);
    //$limit_total_pages = ceil($num_limit_books / $count);
} // end of try
catch(PDOException $e) {
    echo 'PDOException : '.$e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('meta.inc.php'); ?>
    <meta name="description" content="Library Gateway System">
    <title>Books - Library Gateway System</title>
    
    <!-- CSS -->
    <?php require_once('styles.inc.php'); ?>
    
    <!-- Favicons -->
    <?php include_once('favicons.inc.php'); ?>
    
    <!-- Google Fonts -->
    <?php include_once('google-fonts.inc.php'); ?>

    <!-- Head Scripts -->
    <?php require_once('head-scripts.inc.php'); ?>    
</head>

<body id="page-books" class="<?php echo $user_role; ?>">    
    
    <?php include_once('header.inc.php'); ?>

    <div id="container">
      
        <div id="delete-log-dialog" class="dialog">            
            <div class="box-wrap">
                <div class="box">
                    <span class="dialog-msg"></span>
                    <div class="dialog-btns" class="clearfix">
                        <a class="btn btn-default btn-no">No</a>
                        <a class="btn btn-success btn-yes">Yes</a>
                    </div><!--/dialog-btns-->
                </div><!--/.box-->
            </div><!--/.box-wrap-->
        </div><!--/delete-log-dialog-->
        
        <div class="wrap">
            <?php //display_paths(); ?>
            
            <div id="books-message" class="message"></div>
            
            <div id="table-head-bar">
               
                <div class="pagination">                
                    <?php                    
                    $low_offset = $offset + 1;
                    $high_offset = $offset + $count;
                    
                    if ($page == $total_pages) {
                        if ($num_books % $count == 0) {
                            $high_offset = $offset + $count;
                        } // end of if ($num_products % $count == 0)
                        else {
                            $high_offset = $offset + ($num_books % $count);
                        }
                    } // end of if ($page == $total_pages)

                    if ($num_books >= 1) {
                        echo 'Showing '.$low_offset.' - '.$high_offset.' of '.$num_books.'<br>';
                        echo 'Page: ';
                        for ($i=1; $i<=$total_pages; $i++) {
                            echo '<a href="'.$php_self.'?search='.$search.'&page='.$i.'">'.$i.'</a>';
                        } 
                    } // end of if ($num_books >= 1) 
                
                    ?>
                </div><!--/.pagination-->
                
                <div id="search-wrap">
                    <?php if ($admin): ?>
                        <a class="fa fa-plus-square add-book" href="add-book.php"></a>
                    <?php endif; ?>
                    <form id="search-form" action="<?php echo $php_self; ?>" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search">
                            <div class="input-group-addon"><i class="fa fa-search"></i></div>
                        </div><!--/.input-group-->
                    </form>
                </div><!--/search-wrap-->
                                
            </div><!--/table-head-bar-->            
                
            <div id="books-wrap" class="table-responsive">
                <table id="books" class="table table-hover">
                    <tr>
                        <th>ISBN</th>
                        <th>Title</th>                        
                        <th>Author</th>
                        <th>Category</th>
                        <th>Year</th>                        
                        <th>Lost Penalty</th>
                        <th>Qty</th>
                        <?php if ($admin): ?>
                            <th>&nbsp;</th>
                        <?php endif; ?>
                    </tr>
                    <?php
                    foreach($rows_limit_books as $row):
                        $book_id = $row['book_id'];
                        $title = $row['title'];
                        $author = $row['author'];
                        $genre = $row['genre'];
                        $year = $row['year'];
                        $isbn = $row['isbn'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                    ?>
                    <tr id="book-id-<?php echo $book_id; ?>" class="book-row">
                        <td>
                            <span class="isbn row-col-data"><?php echo $isbn; ?></span>
                            <input class="input-isbn form-control" type="text" value="<?php echo $isbn; ?>">
                        </td>
                        <td>
                            <span class="title row-col-data"><?php echo $title; ?></span>
                            <input class="input-title form-control" type="text" value="<?php echo $title; ?>">
                        </td>
                        <td>
                            <span class="author row-col-data"><?php echo $author; ?></span>
                            <input class="input-author form-control" type="text" value="<?php echo $author; ?>">
                        </td>
                        <td>
                            <span class="genre row-col-data"><?php echo $genre; ?></span>
                            <input class="input-genre form-control" type="text" value="<?php echo $genre; ?>">
                        </td>
                        <td>
                            <span class="year row-col-data"><?php echo $year; ?></span>
                            <input class="input-year form-control" type="text" value="<?php echo $year; ?>">
                        </td>                        
                        <td>
                            <span class="price row-col-data"><?php echo $price; ?></span>
                            <input class="input-price form-control" type="text" value="<?php echo $price; ?>">
                        </td>
                        <td>
                            <span class="qty row-col-data"><?php echo $qty; ?></span>
                            <input class="input-qty form-control" type="number" value="<?php echo $qty; ?>">
                        </td>
                        <?php if ($admin): ?>
                            <td class="action">
                                <a class="fa fa-pencil edit-book" href="#"></a>
                                <a class="fa fa-trash delete-book" href="#"></a>
                                <a class="fa fa-floppy-o save-book" href="#"></a>
                                <a class="fa fa-cart-plus borrow-book" title="Borrow" href="add-log.php?book_id=<?php echo $book_id; ?>"></a>
                            </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </table><!--/products-->
            </div><!--/logs-wrap-->

        </div><!--/.wrap-->        
    </div><!--/container-->

    <?php include_once('footer.inc.php'); ?>      
    
    <?php require_once('footer-scripts.inc.php'); ?>
    
</body>
</html>