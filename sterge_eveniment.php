<?php
session_start();
// AICI ERA GREȘEALA: Trebuie db_connect.php, nu config.php!
require_once 'db_connect.php'; 

// Verificăm dacă am primit un ID valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Pregătim interogarea pentru a preveni SQL Injection
    $stmt = $conn->prepare("DELETE FROM evenimente WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirecționăm înapoi la pagina de unde a venit utilizatorul
        $pagina_anterioara = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'evenimente.php';
        header("Location: " . $pagina_anterioara);
        exit();
    } else {
        echo "A apărut o eroare la ștergerea evenimentului: " . $conn->error;
    }
    $stmt->close();
} else {
    echo "ID invalid.";
}
?>