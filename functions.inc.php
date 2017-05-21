<?php
$allowed_tags = '<h1><h2><h3><a><p><br><img><ul><ol><li><div><span>';

function clean_input($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
} // End of function clean_input

function clean_content($content) {
    global $allowed_tags;
    $content = trim($content);
    $content = strip_tags($content, $allowed_tags);
    return $content;
} // end of function clean_content($content)

function site_required_php_version() {
    if (version_compare(PHP_VERSION, '5.5.0', '<')) {
        echo 'This site requires PHP version 5.5.0 or higher.<br>';        
        exit;
    } // end of if (version_compare(PHP_VERSION, '5.5.0', '<'))
} // end of function site_required_php_version()

site_required_php_version();

function verify_session() {
    global $logged_in, $username, $user_role, $admin, $student;
    
    $logged_in = false;
    $user_role = null;
    
    if (isset($_SESSION['logged_in'])) {
        $logged_in = true;
        $username = $_SESSION['username'];
        $user_role = $_SESSION['user_role'];
        $admin = false;
        $student = false;
        if ($user_role == 'admin') {
            $admin = true;
        } // end of if ($user_role == 'admin')
        elseif ($user_role == 'student') {
            $student = true;
        } // end of if ($user_role == 'guest')
    } // end of if (isset($_SESSION['logged_in']))
    
    else {
        header('location: login.php');
        die();
    }
    
} // end of function verify_session()

function check_permissions() {
    global $php_page, $admin, $user_role;    
    $guest_allowed_pages = array('books.php');
    $student_allowed_pages = array('books.php', 'student-profile.php');
    
    if ($user_role == 'guest' && !in_array($php_page, $guest_allowed_pages)) {
        echo 'Access Denied';
        header('location: login.php');
        exit;
    } // end of if (!$admin)
    
    elseif ($user_role == 'student' && !in_array($php_page, $student_allowed_pages)) {
        echo 'Access Denied';
        header('location: login.php');
        exit;
    } // end of if (!$admin)
} // end of function admin_check()

function format_display_date($log_date) {
    $date_time = $log_date;
    $split_date_time = explode(' ', $date_time);
    $date = $split_date_time[0];
    $time = $split_date_time[1];
    $split_time = explode(':', $time);
    $time_h = $split_time[0];
    $time_m = $split_time[1];
    $formatted_time = $time_h.':'.$time_m;
    $formatted_date_time = $date.' '.$formatted_time;
    
    return $formatted_date_time;
}

function format_datetime($log_date) {
    $date_time = $log_date;
    $formatted_datetime = str_replace('/', '-', $date_time);
    
    return $formatted_datetime;
} // end of function format_log_date($log_date)

function format_date_ymd($log_date) {
    $date_time = $log_date;
    $split_date_time = explode(' ', $date_time);
    $date = $split_date_time[0];    
    return $date;
} // end of function format_date_ymd()

function get_days_interval($borrowed_datetime, $returned_datetime, $status) {
    $start_date = format_date_ymd($borrowed_datetime);
    $start_date = new DateTime($start_date);

    $end_date = date('Y-m-d');                    
    if ($status == 'returned') {
        $end_date = format_date_ymd($returned_datetime);
    }
    $end_date = new DateTime($end_date);

    $interval = new DateInterval("P1D");
    $dates = new DatePeriod($start_date, $interval, $end_date);

    $days = 0;
    foreach($dates as $date) {
        $days = $days + 1;
    } // end of foreach($dates as $date)
    
    return $days;
} // end of function get_days_interval()

function validator($data, $required_fields) {
    foreach($required_fields as $field) {
        if($data[$field] == "" || empty($data[$field])) {
            return false;
        }
    }
    return true;
} // end of function validator()

function get_college($course) {
    
    switch($course) {
        case 'BSN':
        case 'BSTM':
            $college = 'CAHS';
            break;
        case 'ABCOMM':
        case 'BSED':
        case 'BEED':
            $college = 'CEAS';
            break;
        case 'ACT':
        case 'BSCS':
        case 'BSIT':
            $college = 'CCS';
            break;
        case 'BSHRM':
        case 'BSBA':
            $college = 'CBA';
            break;
        default:
            $college = null;
    } // end of switch($course)
    
    return $college;
    
} // end of function get_college($course)

$is_editable_date = is_editable_date();
function is_editable_date() {
    $pdo = connect();
    try {
        $setting_name = 'editable_date';
        $query_editable_date = "SELECT setting_value FROM settings
                                WHERE setting_name = :setting_name";
        $editable_date = $pdo->prepare($query_editable_date);
        $editable_date->bindValue(':setting_name', $setting_name, PDO::PARAM_STR);
        $editable_date->execute();
        $row_editable_date = $editable_date->fetch(PDO::FETCH_ASSOC);
        $is_editable_date = $row_editable_date['setting_value'];
        $is_editable_date = filter_var($is_editable_date, FILTER_VALIDATE_BOOLEAN);
        return $is_editable_date;
    }
    catch(PDOException $e) {
        echo $e->getMessage();
        exit;
    }
} // end of function is_editable_date()
?>