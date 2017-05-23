<div id="header">
           
    <nav class="navbar navbar-default">

        <div class="navbar-wrap">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            </div>
 
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <?php if ($admin): ?>
                        <li><a class="fa fa-file-text" href="index.php" title="Logs"> Logs </a></li>
                    <?php endif; ?>
                    <?php if ($admin || $student): ?>
                        <li><a class="fa fa-book" href="books.php" title="Books"> Books </a></li>
                    <?php endif; ?>
                    <?php if ($admin): ?>
                        <li><a class="fa fa-address-book" href="students.php" title="Students"> Students</a></li>
                        <li><a class="fa fa-print" href="reports.php" title="Reports"> Reports </a></li>
                    <?php endif; ?>
                    
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <?php if ($admin): ?>
                        <li><a class="fa fa-user" href="admin-profile.php" title="Admin Profile"> Admin Profile</a></li>
                    <?php elseif ($student): ?>
                        <li><a class="fa fa-user" href="student-profile.php" title="Student Profile"> Student Profile</a></li>
                    <?php endif; ?>
                        <li><a class="fa fa-sign-out" href="logout.php" title="Logout"> Logout</a></li>
                </ul>
            </div>
            <!--/.nav-collapse -->

        </div>
        <!--/.navbar-wrap-->
    </nav>
            <div id = "Title-navbar">
                    
                       Library Borrowing System                
            </div>


</div>
<!--/header-->
       <!-- <div class = "format-print">
                    Republic of the Philippines
                         City of Olongapo  
            </div> -->