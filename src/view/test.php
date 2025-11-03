<?php
session_start();
var_dump($_SESSION);
$password = "admin123";
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo $hashedPassword . "\n" . $password . "\n";

?>