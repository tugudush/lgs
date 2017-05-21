<?php
session_start();
require_once('config.inc.php');
require_once('functions.inc.php');
$pdo = connect();
verify_session();
check_permissions();

$book_id = null;
if (isset($_REQUEST['book_id'])) {
    $book_id = $_REQUEST['book_id'];
    try {
        $query_book = "SELECT * FROM books WHERE
                       book_id = :book_id";
        $book = $pdo->prepare($query_book);
        $book->bindValue(':book_id', $book_id, PDO::PARAM_INT);
        $book->execute();
        $num_book = $book->rowCount();
        
        if ($num_book == 1) {
            $row_book = $book->fetch(PDO::FETCH_ASSOC);
        } // end of if ($num_book == 1)
        else {
            echo 'MySql Query Warning:<br>';
            echo '$num_book = '.$num_book.'. It must be 1.';
            exit;
        } // end of elseif ($num_book != 1)
    } // end of try
    catch(PDOException $e) {
        echo $e->getMessage();
        exit;
    } // end of catch(PDOException $e)
} // end ofif (isset($_REQUEST['book_id']))

$id_no = null;
if (isset($_REQUEST['id_no'])) {    
    $id_no = $_REQUEST['id_no'];    
    try {
        $query_student = "SELECT * FROM students
                          WHERE id_no = :id_no";
        $student = $pdo->prepare($query_student);
        $student->bindValue(':id_no', $id_no, PDO::PARAM_STR);
        $student->execute();
        $num_student = $student->rowCount();
        if ($num_student == 1) {
            $row_student = $student->fetch(PDO::FETCH_ASSOC);
            $name = $row_student['fname'].' '.$row_student['lname'];            
            $course = $row_student['course'];
            $college = get_college($course);
        } // end of if ($num_student == 1)
        else {
            echo 'MySql Query Warning:<br>';
            echo '$num_student = '.$num_student.'. It must be 1.';
            exit;
        } // end of elseif($num_student != 1)
    } // end of try
    catch(PDOException $e) {
        echo $e->getMessage();
        exit;
    } // end of catch(PDOException $e)
} // end of if (isset($_REQUEST['id_no']))

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('meta.inc.php'); ?>
    <meta name="description" content="Library Gateway System">
    <title>Add Log - Library Gateway System</title>
    
    <!-- CSS -->
    <?php require_once('styles.inc.php'); ?>
    
    <!-- Favicons -->
    <?php include_once('favicons.inc.php'); ?>
    
    <!-- Google Fonts -->
    <?php include_once('google-fonts.inc.php'); ?>

    <!-- Head Scripts -->
    <?php require_once('head-scripts.inc.php'); ?>    
</head>

<body id="page-add-log" class="<?php echo $user_role; ?>">    
    
    <?php include_once('header.inc.php'); ?>

    <div id="container">
        <div class="wrap">
            
            <div class="clearfix">
                
                <div id="add-log-wrap" class="add-wrap">
                    <?php include('includes/add-log.inc.php'); ?>
                </div><!--/add-log-wrap-->
                
            </div><!--/.clearfix-->
            

        </div><!--/.wrap-->        
    </div><!--/container-->

    <?php include_once('footer.inc.php'); ?>      
    
    <?php require_once('footer-scripts.inc.php'); ?>
    
</body>
</html>
   

   
   
