<?php
foreach($rows_limit_logs as $row):
    $log_id = $row['log_id'];
    $id_no = $row['id_no'];
    $fname = $row['fname'];
    $lname = $row['lname'];
    $name = $fname.' '.$lname;
    $book_id = $row['book_id'];
    $title = $row['title'];
    $price = $row['price'];
    $borrowed_datetime = $row['borrowed_datetime'];
    $returned_datetime = $row['returned_datetime'];
    $status = $row['status'];
    $paid = $row['paid'];

    $days = get_days_interval($borrowed_datetime, $returned_datetime, $status);

    $penalty = ($ppd*$days) - ($ppd*($pod-1));
    if ($penalty < 0) {
        $penalty = 0;
    }

    if ($status == 'lost') {
        $penalty = $price;
    } // end of if ($status == 'lost')
?>                    
    <tr id="log-id-<?php echo $log_id; ?>" class="log-row">
        <!-- <td><?php echo $log_id; ?></td> -->
        <td class="row-col-data"><span class="id-no"><?php echo $id_no; ?></span></td>
        <td><span class="name"><?php echo $name; ?></span></td>
        <td title="<?php echo $title; ?>">
            <input type="hidden" class="book-id" value="<?php echo $book_id; ?>">
            <span class="title">
                <?php
                if (strlen($title) > $title_length_limit) {
                    $shortened_title = substr($title, 0, strrpos(substr($title, 0, $title_length_limit), ' ')) . '...';
                    echo $shortened_title;
                } // end of if (strlen($title) > $title_length_limit)
                else {
                    echo $title;
                }
                ?>
            </span><!--/.title-->
        </td>
        <td>
            <input type="hidden" class="current-status" value="<?php echo $status; ?>">
            <div class="log-status row-col-data">
                <?php
                if ($status == 'lost') {
                    echo '<span class="text-danger" style="font-weight:bold;">'.$status.'</span>';
                }
                else {
                    echo $status;
                }
                ?>
            </div><!--/.log-status.row-col-data-->
            <select class="select-status form-control">                
                <option <?php if($status == 'borrowed') {echo 'selected';} ?> value="borrowed">Borrowed</option>                
                <option <?php if($status == 'returned') {echo 'selected';} ?> value="returned">Returned</option>
                <option <?php if($status == 'lost') {echo 'selected';} ?> value="lost">Lost</option>
            </select><!--/.select-status-->
        </td>
        <td>
            <span class="borrowed-datetime row-col-data"><?php echo format_display_date($borrowed_datetime); ?></span>
            <input class="input-borrowed-datetime form-control" type="text" value="<?php echo format_display_date($borrowed_datetime); ?>" <?php if(!$is_editable_date){echo 'readonly';} ?>>
        </td>
        <td>
            <span class="returned-datetime row-col-data">
                <?php
                if ($returned_datetime != '' || $returned_datetime != null) {
                    echo format_display_date($returned_datetime);    
                }                            
                ?>
            </span><!--/.returned-datetime-->
            <input class="input-returned-datetime form-control" type="text" value="<?php if ($returned_datetime != '' || $returned_datetime != null) { echo format_display_date($returned_datetime); } ?>" <?php if(!$is_editable_date){echo 'readonly';} ?>>
        </td>                                                
        <td class="col-days-interval">
            <div class="days-interval row-col-data">
                <?php
                if ($days >= $pod) {
                    echo '<span class="text-danger" style="font-weight: bold;">'.$days.'</span>';
                }
                else {
                    echo $days;
                }
                ?>
            </div>
        </td>
        <td class="col-penalty">
            <?php
            if ($penalty > 0) {
                echo $penalty;
            }            
            ?>
        </td>
        <td>
            <span class="paid row-col-data"><?php echo $paid; ?></span>
            <select class="select-paid form-control">
                <option value="">-</option>
                <option value="yes" <?php if($paid == 'yes') { echo 'selected'; } ?>>Yes</option>                                
            </select>
        </td>
        <td class="action">
            <a class="fa fa-pencil edit-log" href="#"></a>
            <a class="fa fa-trash delete-log" href="#"></a>
            <a class="fa fa-floppy-o save-log" href="#"></a>
        </td>
    </tr>
<?php endforeach; ?>