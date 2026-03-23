<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nume = trim($_POST['nume']);
    $email = trim($_POST['email']);
    $parola = $_POST['parola'];
    $confirmare = $_POST['confirmare'];
    $telefon = trim($_POST['telefon']);
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;

    if ($parola !== $confirmare) {
        die("Parolele nu se potrivesc. <a href='index.php'>Înapoi</a>");
    }

    $hash = password_hash($parola, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO utilizatori (nume, email, parola, telefon, doreste_newsletter) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $nume, $email, $hash, $telefon, $newsletter);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Eroare: " . $stmt->error;
    }

    $stmt->close();
}
?>
