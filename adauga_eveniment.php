<?php
$page_title = 'Adaugă Eveniment Nou | Descoperă Brăila';
include 'header.php';
require_once 'db_connect.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("<div style='text-align:center; padding: 100px;'><h3>Acces interzis!</h3></div>");
}

$mesaj = '';
$categorie_preselectata = isset($_GET['categorie']) ? $_GET['categorie'] : 'cultural';

// Sanitizăm categoria ca să fie doar una dintre valorile așteptate
$categorii_valide = ['cultural', 'sportiv'];
if (!in_array($categorie_preselectata, $categorii_valide)) {
    $categorie_preselectata = 'cultural';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titlu          = trim($_POST['titlu']);
    $descriere      = trim($_POST['descriere']);
    $data_eveniment = $_POST['data_eveniment'];
    $locatie        = trim($_POST['locatie']);
    $categorie      = $_POST['categorie'];

    // Validăm că și categoria din POST e validă
    if (!in_array($categorie, $categorii_valide)) {
        $categorie = 'cultural';
    }

    $stmt = $conn->prepare('INSERT INTO evenimente (titlu, descriere, data_eveniment, locatie, categorie) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sssss', $titlu, $descriere, $data_eveniment, $locatie, $categorie);

    if ($stmt->execute()) {
        $mesaj = "<div style='color: green; background: #d4edda; padding: 15px; border-radius: 5px; margin-bottom: 20px;'>✅ Evenimentul a fost adăugat cu succes!</div>";
    } else {
    error_log("Eroare adaugare eveniment: " . $stmt->error);
    $mesaj = "<div style='color: red; background: #f8d7da; padding: 15px; border-radius: 5px; margin-bottom: 20px;'>❌ A apărut o eroare. Încearcă din nou.</div>";
}
    $stmt->close();
}
?>

<section class="form-admin-section">
    <h2>➕ Adaugă Eveniment Nou</h2>

    <?= $mesaj ?>

    <form action="adauga_eveniment.php?categorie=<?= htmlspecialchars($categorie_preselectata) ?>" method="POST" style="background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">

        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px;">Titlu Eveniment:</label>
            <input type="text" name="titlu" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px;">Categorie:</label>
            <select name="categorie" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                <option value="cultural"  <?= $categorie_preselectata === 'cultural'  ? 'selected' : '' ?>>Cultural</option>
                <option value="sportiv"   <?= $categorie_preselectata === 'sportiv'   ? 'selected' : '' ?>>Sportiv</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px;">Data Eveniment:</label>
            <input type="date" name="data_eveniment" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px;">Locație:</label>
            <input type="text" name="locatie" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px;">Descriere:</label>
            <textarea name="descriere" rows="5" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;"></textarea>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center;">
            <!-- FIX: link înapoi corect spre pagina de evenimente care există -->
            <a href="evenimente.php" style="color: #555; text-decoration: none;">⬅️ Înapoi la Evenimente</a>
            <button type="submit" style="background: #28a745; color: white; border: none; padding: 12px 25px; border-radius: 5px; font-weight: bold; cursor: pointer;">💾 Salvează Evenimentul</button>
        </div>
    </form>
</section>

<?php include 'footer.php'; ?>