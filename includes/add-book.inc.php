<form id="add-book">
    <div id="books-message" class="message"></div>
    <input id="title" name="title" class="form-control" type="text" placeholder="Title"  required>
    <input id="author" name="author" class="form-control" type="text" placeholder="Author" required>
    <input id="genre" name="genre" class="form-control" type="text" placeholder="Category" required>
    <input id="year" name="year" class="form-control" type="number" min="0" placeholder="Year" required>
    <input id="isbn" name="isbn" class="form-control" type="number" placeholder="ISBN">
    <input id="price" name="price" class="form-control" type="number" min="0" placeholder="Lost Penalty" required>
    <input id="qty" name="qty" class="form-control" type="number" min="0" placeholder="Qty" required>
    <input id="submit-book" name="submit_book" class="form-control btn btn-primary" type="submit" value="Submit">
</form><!--/add-book-->