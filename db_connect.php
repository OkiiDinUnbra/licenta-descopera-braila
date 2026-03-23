<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Europe/Bucharest');
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "web_braila";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Eroare conectare DB: " . $conn->connect_error);
}
?>
