<table id="logs" class="table table-hover">
    <tr>
        <!-- <th>Log #</th> -->
        <th>ID No.</th>
        <th>Name</th>
        <th>Course</th>
        <th>College</th>
        <th>Date</th>
        <th></th>
    </tr>
    <?php foreach($rows_limit_logs as $row_limit_log): ?>
        <tr id="log-id-<?php echo $row_limit_log['log_id']; ?>" class="log-row">
            <!-- <td class="log-id">
                <span class="col-val"><?php //echo $row_limit_log['log_id']; ?></span>                
            </td> -->
            <td class="id-no">
                <span class="col-val"><?php echo $row_limit_log['id_no']; ?></span>
                <input class="col-input form-control" type="text" value="<?php echo $row_limit_log['id_no']; ?>">
            </td>
            <td class="name">
                <span class="col-val col-val-fname"><?php echo $row_limit_log['fname']; ?></span>
                <span class="col-val col-val-lname"><?php echo $row_limit_log['lname']; ?></span>
                <input class="col-input col-input-fname form-control" type="text" value="<?php echo $row_limit_log['fname']; ?>">
                <input class="col-input col-input-lname form-control" type="text" value="<?php echo $row_limit_log['lname']; ?>">
            </td>
            <td class="course">
                <span class="col-val"><?php echo $row_limit_log['course']; ?></span>
                <input class="col-input form-control" type="text" value="<?php echo $row_limit_log['course']; ?>">
            </td>
            <td class="college">
                <span class="col-val"><?php echo $row_limit_log['college']; ?></span>
                <input class="col-input form-control" type="text" value="<?php echo $row_limit_log['college']; ?>">
            </td>
            <td class="log-date">
                <?php
                $log_date = $row_limit_log['log_date'];
                $formatted_display_date = format_display_date($log_date);
                ?>
                <span class="col-val"><?php echo $formatted_display_date; ?></span>
                <input class="col-input form-control" type="text" value="<?php echo $row_limit_log['log_date']; ?>">
            </td>
            <?php if ($user_role == 'admin'): ?>
            <td class="operations">
                <a class="fa fa-trash-o delete-log" aria-hidden="true" href="#"></a>                
            </td>
            <?php endif; ?>
        </tr><!--/product-id-->
    <?php endforeach; ?>
</table><!--/products-->