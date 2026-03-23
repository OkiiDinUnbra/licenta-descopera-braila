<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $parola = $_POST['parola'];

    $stmt = $conn->prepare("SELECT id, nume, parola, rol FROM utilizatori WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($parola, $user['parola'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nume'] = $user['nume'];
            $_SESSION['rol'] = $user['rol']; // Aici se salvează rolul!
            
            header("Location: index.php");
            exit;
        } else {
            echo "<script>alert('Parolă incorectă.'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Utilizatorul nu a fost găsit.'); window.location.href='index.php';</script>";
    }
    $stmt->close();
}
?>