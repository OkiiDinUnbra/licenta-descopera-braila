<?php
$page_title = "Editează Eveniment";
include 'header.php'; // Header-ul tău care include session_start() și config.php

// Măsuri de securitate: Doar adminii au voie
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("<div style='text-align:center; padding: 100px;'><h3>Acces interzis! Trebuie să fii administrator.</h3></div>");
}

$mesaj = "";
$eveniment = null;

// Dacă am primit date din formular (S-a apăsat butonul de Salvare)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $titlu = trim($_POST['titlu']);
    $descriere = trim($_POST['descriere']);
    $data_eveniment = $_POST['data_eveniment'];
    $locatie = trim($_POST['locatie']);

    $stmt_update = $conn->prepare("UPDATE evenimente SET titlu = ?, descriere = ?, data_eveniment = ?, locatie = ? WHERE id = ?");
    $stmt_update->bind_param("ssssi", $titlu, $descriere, $data_eveniment, $locatie, $id);
    
    if ($stmt_update->execute()) {
        $mesaj = "<div style='color: green; background: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 20px;'>Eveniment actualizat cu succes!</div>";
    } else {
        $mesaj = "<div style='color: red; background: #f8d7da; padding: 10px; border-radius: 5px; margin-bottom: 20px;'>Eroare la actualizare!</div>";
    }
    $stmt_update->close();
}

// Preluăm datele curente ale evenimentului pentru a precompleta formularul
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM evenimente WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $eveniment = $result->fetch_assoc();
    } else {
        die("<div style='text-align:center; padding: 100px;'>Evenimentul nu există!</div>");
    }
    $stmt->close();
}
?>

<section style="padding: 120px 20px 60px; max-width: 600px; margin: auto; min-height: 70vh;">
    <h2>✏️ Editează Evenimentul</h2>
    
    <?= $mesaj ?>

    <?php if ($eveniment): ?>
    <form action="editeaza_eveniment.php?id=<?= $eveniment['id'] ?>" method="POST" style="background: #f9f9f9; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        
        <input type="hidden" name="id" value="<?= $eveniment['id'] ?>">

        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px;">Titlu Eveniment:</label>
            <input type="text" name="titlu" value="<?= htmlspecialchars($eveniment['titlu']) ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px;">Data Eveniment:</label>
            <input type="date" name="data_eveniment" value="<?= htmlspecialchars($eveniment['data_eveniment']) ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px;">Locație:</label>
            <input type="text" name="locatie" value="<?= htmlspecialchars($eveniment['locatie']) ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px;">Descriere:</label>
            <textarea name="descriere" rows="5" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;"><?= htmlspecialchars($eveniment['descriere']) ?></textarea>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center;">
            <a href="evenimente.php" style="color: #555; text-decoration: none;">⬅️ Înapoi la Evenimente</a>
            <button type="submit" style="background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 5px; font-weight: bold; cursor: pointer;">💾 Salvează Modificările</button>
        </div>
    </form>
    <?php endif; ?>
</section>

<?php include 'footer.php'; ?>