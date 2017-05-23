<form id="add-student">
    <div id="students-message" class="message" required></div>    
    <input id="id-no" name="id_no" class="form-control" type="text" min="0" placeholder="ID No." required>
    <input id="fname" name="fname" class="form-control" type="text" placeholder="First Name" required>
    <input id="mname" name="mname" class="form-control" type="text" placeholder="Middle Name">
    <input id="lname" name="lname" class="form-control" type="text" placeholder="Last Name" required>
    <select id="course" name="course" class="form-control" required>
        <option value="">Course</option>
        <option value="ABCOMM">ABCOMM</option>
        <option value="ACT">ACT</option>
        <option value="BEED">BEED</option>
        <option value="BSBA">BSBA</option>
        <option value="BSCS">BSCS</option>
        <option value="BSED">BSED</option>
        <option value="BSHRM">BSHRM</option>
        <option value="BSIT">BSIT</option>
        <option value="BSM">BSM</option>
        <option value="BSN">BSN</option>
        <option value="BSTM">BSTM</option>
    </select>
    <input id="submit-student" name="submit_student" class="form-control btn btn-primary" type="submit" value="Submit">
</form><!--/add-book-->
