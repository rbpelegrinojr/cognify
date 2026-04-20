<?php
$host = 'localhost';
$user = 'capsupon_cognify';
$pass = 'Sw0rdf1sh@214';
$dbname = 'capsupon_cognify';

$con = mysqli_connect($host, $user, $pass, $dbname);
if (!$con) {
    die('Database connection failed: ' . mysqli_connect_error());
}
mysqli_set_charset($con, 'utf8');

require_once __DIR__ . '/helpers.php';
?>