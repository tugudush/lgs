<div id="add-log-message" class="message">&nbsp;</div>
<form id="add-log">
    
    <input type="hidden" id="student-id" name="student_id" value="<?php if($id_no){echo $row_student['student_id'];} ?>">
    <input type="number" min="0" class="form-control" style="margin-top:0;" id="id-no" name="id_no" placeholder="ID No." value="<?php if ($id_no){echo $id_no;} ?>" required>
    <input type="text" class="form-control" id="search-book" name="search_book" placeholder="Search Book, Author, Genre, Year, ISBN, etc" value="<?php if($book_id) {echo $row_book['title'];} ?>" required>    
    <input type="hidden" id="book-id" name="book_id" value="<?php if($book_id) {echo $book_id;} ?>">
    <input type="text" class="form-control <?php if($is_editable_date){echo 'date-time-picker';} ?>" id="borrowed-datetime" name="borrowed_datetime" placeholder="Date &amp Time" value="<?php echo date('Y/m/d H:i'); ?>" <?php if(!$is_editable_date){echo 'readonly';} ?> required>    
    <input type="submit" class="form-control btn btn-success" id="submit-log" name="submit_log" value="Submit">
    
    <div class="notice"></div>
    
</form><!--/add-log-->


<div id="log-preview">
    <div id="student-details">
        <h3>Student Details</h3>
        Name: <span id="preview-student-name"><?php if($id_no){echo $name;} ?></span><br>
        Course: <span id="preview-student-course"><?php if($id_no) {echo $course;} ?></span><br>
        College: <span id="preview-student-college"><?php if($id_no) {echo $college;} ?></span><br>
    </div><!--/student-details-->
    <div id="book-details">
        <h3>Book Details</h3>
        <!-- Book ID: <span id="preview-book-id"></span><br> -->
        Title: <span id="preview-book-title"><?php if($book_id){echo $row_book['title'];} ?></span><br>
        Author: <span id="preview-book-author"><?php if($book_id){echo $row_book['author'];} ?></span><br>
        Genre: <span id="preview-book-genre"><?php if($book_id){echo $row_book['genre'];} ?></span><br>
        Year: <span id="preview-book-year"><?php if($book_id){echo $row_book['year'];} ?></span><br>        
        ISBN: <span id="preview-book-isbn"><?php if($book_id){echo $row_book['isbn'];} ?></span><br>
    </div><!--/book-details-->
</div><!--/log-preview-->


<table id="search-book-results" class="table table-hover clear">
    <tr class="heading">
        <!-- <th>Book ID</th> -->
        <th>Title</th>
        <th>Author</th>
        <th>Genre</th>
        <th>Year</th>
        <th>ISBN</th>
        <th>Qty</th>
    </tr>    
</table><!--/search-book-results-->