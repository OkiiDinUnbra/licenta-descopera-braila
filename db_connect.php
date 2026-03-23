<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Genereaza token CSRF daca nu exista
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

date_default_timezone_set('Europe/Bucharest');

$env = parse_ini_file(__DIR__ . '/.env');
$conn = new mysqli($env['DB_HOST'], $env['DB_USER'], $env['DB_PASS'], $env['DB_NAME']);

if ($conn->connect_error) {
    error_log("DB connection failed: " . $conn->connect_error);
    die("A apărut o eroare internă. Încearcă mai târziu.");
}
?>