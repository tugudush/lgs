<?php
header('Content-Type: text/html; charset=utf-8');
ini_set("default_charset", "UTF-8");
mb_internal_encoding("UTF-8");

$isSecure = false;

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $isSecure = true;
}

elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
    $isSecure = true;
}

$request_protocol = $isSecure ? 'https' : 'http';

$protocol = $request_protocol.'://';
$http_post = $_SERVER['HTTP_HOST'];
$server_name = $_SERVER['SERVER_NAME'];
$php_self = $_SERVER['PHP_SELF'];
$php_page = get_php_page($php_self);
$dirnamephpself = str_replace('\\','',dirname($php_self));
$request_uri = $_SERVER['REQUEST_URI'];
$base_url = $protocol.$server_name;
$site_url = $protocol.$server_name.$dirnamephpself;
$site_url = rtrim($site_url, '/\\'); //strip both forward and back slashes
$page_url = $protocol.$server_name.$request_uri;

function get_php_page($php_self) {
    $split_php_self = explode('/', $php_self);
    end($split_php_self);
    $key = key($split_php_self);
    $php_page = $split_php_self[$key];
    return $php_page;
} // end of function get_php_page()

function display_paths() {
    global $protocol, $http_post, $server_name, $php_self, $php_page, $dirnamephpself,
    $request_uri, $base_url, $site_url, $page_url;
    
    echo 'protocol: '.$protocol.'<br>';
    echo 'http_post: '.$http_post.'<br>';
    echo 'server_name: '.$server_name.'<br>';
    echo 'php_self: '.$php_self.'<br>';
    echo 'php_page: '.$php_page.'<br>';
    echo 'dirnamephpself: '.$dirnamephpself.'<br>';
    echo 'request_uri: '.$request_uri.'<br>';
    echo 'base_url: '.$base_url.'<br>';
    echo 'site_url: '.$site_url.'<br>';
    echo 'page_url: '.$page_url.'<br>';
} // end of function display_paths()

$debug_mode = 1; // 1 or true  = ON; 2 or false = OFF

if ($debug_mode) {
    error_reporting(E_ALL);    
} // end of if ($debug_mode)

else {    
    error_reporting(E_ERROR | E_PARSE);
}

ini_set("display_errors", 1);

date_default_timezone_set('Asia/Manila');

function connect() {
    $host = "localhost";
    $db_name = "lgs";
    $charset = "utf8mb4";
    $db_user = "root";
    $db_password = "";
    $db = new PDO('mysql:host='.$host.';dbname='.$db_name.';charset='.$charset, $db_user, $db_password,
                  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $db;
} // end of function connect()

$title_length_limit = 30;
$ppd = 50; // penalty per day
$pod = 4; // penalty starts on day 4

$webmaster = 'jerome2kph@gmail.com';
?>