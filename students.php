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
    $query_students = "SELECT * FROM students
                       WHERE
                       id_no LIKE :id_no OR
                       fname LIKE :fname OR
                       lname LIKE :lname OR
                       course LIKE :course
                       ORDER BY fname, lname, course";
    
    $students = $pdo->prepare($query_students);
    $students->bindValue(':id_no', "%$search%", PDO::PARAM_STR);
    $students->bindValue(':fname', "%$search%", PDO::PARAM_STR);
    $students->bindValue(':lname', "%$search%", PDO::PARAM_STR);
    $students->bindValue(':course', "%$search%", PDO::PARAM_STR);
    
    $query_limit_students = "SELECT * FROM students
                             WHERE
                             id_no LIKE :id_no OR
                             fname LIKE :fname OR
                             lname LIKE :lname OR
                             course LIKE :course
                             ORDER BY fname, lname, course
                             LIMIT :offset, :count";
    
    $limit_students = $pdo->prepare($query_limit_students);    
    $limit_students->bindValue(':id_no', "%$search%", PDO::PARAM_STR);
    $limit_students->bindValue(':fname', "%$search%", PDO::PARAM_STR);
    $limit_students->bindValue(':lname', "%$search%", PDO::PARAM_STR);
    $limit_students->bindValue(':course', "%$search%", PDO::PARAM_STR);
    $limit_students->bindValue(':offset', $offset, PDO::PARAM_INT);
    $limit_students->bindValue(':count', $count, PDO::PARAM_INT);
    
    $query_utf8mb4 = "SET NAMES utf8mb4";
    $utf8mb4 = $pdo->prepare($query_utf8mb4);
    $utf8mb4->execute();
    
    $students->execute();
    $num_students = $students->rowCount();
    
    $limit_students->execute();
    $num_limit_students = $limit_students->rowCount();    
    $rows_limit_students = $limit_students->fetchAll(PDO::FETCH_ASSOC);
    
    $total_pages = ceil($num_students / $count);
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
    <title>Students - Library Gateway System</title>
    
    <!-- CSS -->
    <?php require_once('styles.inc.php'); ?>
    
    <!-- Favicons -->
    <?php include_once('favicons.inc.php'); ?>
    
    <!-- Google Fonts -->
    <?php include_once('google-fonts.inc.php'); ?>

    <!-- Head Scripts -->
    <?php require_once('head-scripts.inc.php'); ?>    
</head>

<body id="page-students" class="<?php echo $user_role; ?>">    
    
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
            
            <div id="students-message" class="message"></div>
            
            <div id="table-head-bar">
               
                <div class="pagination">                
                    <?php                    
                    $low_offset = $offset + 1;
                    $high_offset = $offset + $count;
                    
                    if ($page == $total_pages) {
                        if ($num_students % $count == 0) {
                            $high_offset = $offset + $count;
                        } // end of if ($num_products % $count == 0)
                        else {
                            $high_offset = $offset + ($num_students % $count);
                        }
                    } // end of if ($page == $total_pages)

                    if ($num_students >= 1) {
                        echo 'Showing '.$low_offset.' - '.$high_offset.' of '.$num_students.'<br>';
                        echo 'Page: ';
                        for ($i=1; $i<=$total_pages; $i++) {
                            echo '<a href="'.$php_self.'?search='.$search.'&page='.$i.'">'.$i.'</a>';
                        } 
                    } // end of if ($num_books >= 1) 
                
                    ?>
                </div><!--/.pagination-->
                
                <div id="search-wrap">
                    <a class="fa fa-plus-square add-student" href="add-student.php"></a>
                    <form id="search-form" action="<?php echo $php_self; ?>" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search">
                            <div class="input-group-addon"><i class="fa fa-search"></i></div>
                        </div><!--/.input-group-->
                    </form>
                </div><!--/search-wrap-->
                                
            </div><!--/table-head-bar-->            
                
            <div id="students-wrap" class="table-responsive">
                <table id="students" class="table table-hover">
                    <tr>
                        <th>ID No.</th>                        
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Course</th>                        
                        <th>&nbsp;</th>
                    </tr>
                    <?php
                    foreach($rows_limit_students as $row):
                        $student_id = $row['student_id'];
                        $id_no = $row['id_no'];
                        $fname = $row['fname'];
                        $lname = $row['lname'];
                        $name = $fname.' '.$lname;
                        $course = $row['course'];
                    ?>
                    <tr id="student-id-<?php echo $student_id; ?>" class="student-row">
                        <td>
                            <span class="id-no row-col-data"><?php echo $id_no; ?></span>
                            <input class="input-id-no form-control" type="text" value="<?php echo $id_no; ?>">
                        </td>
                        <td>
                            <span class="fname row-col-data"><?php echo $fname; ?></span>
                            <input class="input-fname form-control" type="text" value="<?php echo $fname; ?>">
                        </td>
                        <td>
                            <span class="lname row-col-data"><?php echo $lname; ?></span>
                            <input class="input-lname form-control" type="text" value="<?php echo $lname; ?>">
                        </td>
                        <td>
                            <span class="course row-col-data"><?php echo $course; ?></span>
                            <select class="select-course form-control">
                                <option value="">Course</option>
                                <option value="ABCOMM" <?php if($course=='ABCOMM'){echo 'selected';} ?>>ABCOMM</option>
                                <option value="ACT" <?php if($course=='ACT'){echo 'selected';} ?>>ACT</option>
                                <option value="BEED" <?php if($course=='BEED'){echo 'selected';} ?>>BEED</option>
                                <option value="BSBA" <?php if($course=='BSBA'){echo 'selected';} ?>>BSBA</option>
                                <option value="BSCS" <?php if($course=='BSCS'){echo 'selected';} ?>>BSCS</option>
                                <option value="BSED" <?php if($course=='BSED'){echo 'selected';} ?>>BSED</option>
                                <option value="BSHRM" <?php if($course=='BSHRM'){echo 'selected';} ?>>BSHRM</option>
                                <option value="BSIT" <?php if($course=='BSIT'){echo 'selected';} ?>>BSIT</option>
                                <option value="BSM" <?php if($course=='BSM'){echo 'selected';} ?>>BSM</option>
                                <option value="BSN" <?php if($course=='BSN'){echo 'selected';} ?>>BSN</option>
                                <option value="BSTM" <?php if($course=='BSTM'){echo 'selected';} ?>>BSTM</option>
                            </select>
                        </td>
                        <td class="action">
                            <a class="fa fa-pencil edit-student" href="#"></a>
                            <a class="fa fa-trash delete-student" href="#"></a>
                            <a class="fa fa-cart-plus borrow-book" title="Borrow" href="add-log.php?id_no=<?php echo $id_no; ?>"></a>
                            <a class="fa fa-floppy-o save-student" href="#"></a>
                        </td>                        
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