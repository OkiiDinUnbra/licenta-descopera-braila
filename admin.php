<?php
$page_title = "Panou Admin | Descoperă Brăila";
include 'header.php';

// Dacă utilizatorul nu e logat sau nu e admin, îl dăm afară de pe pagină
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    die("<div style='margin-top:150px; text-align:center;'><h2>Nu ai acces la această pagină!</h2></div>");
}

$mesaj = "";

// Dacă am trimis formularul de adăugare eveniment
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['adauga_eveniment'])) {
    $titlu = $_POST['titlu'];
    $descriere = $_POST['descriere'];
    $data_ev = $_POST['data_eveniment'];
    $categorie = $_POST['categorie'];
    $locatie = $_POST['locatie'];

    $stmt = $conn->prepare("INSERT INTO evenimente (titlu, descriere, data_eveniment, categorie, locatie) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $titlu, $descriere, $data_ev, $categorie, $locatie);

    if ($stmt->execute()) {
        $mesaj = "<p style='color: green;'>Eveniment adăugat cu succes!</p>";
    } else {
        $mesaj = "<p style='color: red;'>Eroare la adăugare.</p>";
    }
    $stmt->close();
}
?>

<section style="margin-top: 120px; min-height: 60vh;">
    <div class="container" style="max-width: 600px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <h2>Adaugă un Eveniment Nou</h2>
        <?= $mesaj ?>
        
        <form method="POST" action="">
            <input type="hidden" name="adauga_eveniment" value="1">
            
            <div style="margin-bottom: 15px;">
                <label>Titlu Eveniment</label>
                <input type="text" name="titlu" required style="width: 100%; padding: 8px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label>Descriere</label>
                <textarea name="descriere" rows="4" style="width: 100%; padding: 8px;"></textarea>
            </div>
            
            <div style="margin-bottom: 15px;">
                <label>Data</label>
                <input type="date" name="data_eveniment" required style="width: 100%; padding: 8px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label>Categorie</label>
                <select name="categorie" style="width: 100%; padding: 8px;">
                    <option value="cultural">Cultural</option>
                    <option value="sportiv">Sportiv</option>
                </select>
            </div>
            
            <div style="margin-bottom: 15px;">
                <label>Locație</label>
                <input type="text" name="locatie" style="width: 100%; padding: 8px;">
            </div>
            
            <button type="submit" class="btn" style="width: 100%; border:none; cursor:pointer;">Salvează Evenimentul</button>
        </form>
    </div>
</section>

<?php include 'footer.php'; ?>