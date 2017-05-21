<?php
$password = 'test12345';
echo 'password: '.$password.'<br>';

$generated_hash = password_hash($password, PASSWORD_DEFAULT);
echo 'generated hash: '.$generated_hash;
?>