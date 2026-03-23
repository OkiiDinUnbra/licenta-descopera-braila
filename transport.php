<?php 
$page_title = "Transport Public | Descoperă Brăila";
include 'header.php'; 

// Extragem toate stațiile din baza de date, ordonate alfabetic pentru meniul derulant
$statii_query = $conn->query("SELECT id, nume_statie FROM transport_statii ORDER BY nume_statie ASC");
$toate_statiile = [];
while($row = $statii_query->fetch_assoc()) {
    $toate_statiile[] = $row;
}
?>

<style>
    .hero-transport { background: url('img/hero-braila.jpg') no-repeat center center/cover; color: white; padding: 100px 20px 60px; text-align: center; margin-top: 70px; position: relative; }
    .hero-transport::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 1; }
    .hero-transport > * { position: relative; z-index: 2; }
    .hero-transport h1 { font-size: 42px; margin-bottom: 15px; }
    
    .transport-container { display: flex; flex-wrap: wrap; gap: 30px; justify-content: center; padding: 40px 20px; max-width: 1200px; margin: auto; }
    
    .card-modul { background: #fff; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); padding: 30px; flex: 1; min-width: 300px; max-width: 500px; }
    .card-modul h2 { font-size: 24px; margin-bottom: 20px; color: #333; border-bottom: 2px solid #ffd700; padding-bottom: 10px; }
    
    .form-group { margin-bottom: 15px; text-align: left; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: 500; }
    .form-group select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 15px; }
    
    .btn-full { display: block; width: 100%; background: #ffd700; color: #000; padding: 12px; text-align: center; font-weight: bold; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; transition: 0.3s; margin-top: 10px; text-decoration: none;}
    .btn-full:hover { background: #e6c200; }

    .ticket-demo { background: #f9f9f9; border: 2px dashed #ccc; padding: 20px; text-align: center; border-radius: 10px; margin-top: 20px; }
    .bilet-info { font-size: 14px; color: #666; margin-bottom: 15px; }
</style>

<section class="hero-transport">
    <h1>Smart Transit Brăila</h1>
    <p style="font-size: 18px;">Găsește traseul optim și achiziționează bilete digitale instant.</p>
</section>

<div class="transport-container">
    
    <div class="card-modul">
        <h2>📍 Planifică-ți Călătoria</h2>
        <form method="GET" action="rutare.php">
            <div class="form-group">
                <label>Punct de plecare:</label>
                <select name="plecare" required>
                    <option value="">-- Alege stația de plecare --</option>
                    <?php foreach($toate_statiile as $statie): ?>
                        <option value="<?= $statie['id'] ?>"><?= htmlspecialchars($statie['nume_statie']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Destinație:</label>
                <select name="destinatie" required>
                    <option value="">-- Alege destinația --</option>
                    <?php foreach($toate_statiile as $statie): ?>
                        <option value="<?= $statie['id'] ?>"><?= htmlspecialchars($statie['nume_statie']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <button type="submit" class="btn-full">🔍 Caută Traseul</button>
        </form>
    </div>

    <div class="card-modul">
        <h2>🎫 Bilet Digital (60 min)</h2>
        <?php if(isset($_SESSION['user_id'])): ?>
            <p class="bilet-info">Biletul tău va fi valabil 60 de minute pe orice linie Braicar din momentul achiziției. Plata se face securizat.</p>
            
            <div class="ticket-demo">
                <h3 style="margin-bottom: 10px;">Preț: 2.50 RON</h3>
                <form method="POST" action="genereaza_bilet.php">
                    <button type="submit" class="btn-full" style="background: #28a745; color: white;">💳 Cumpără Bilet Acum</button>
                </form>
            </div>
        <?php else: ?>
            <div class="ticket-demo">
                <p style="color: #dc3545; font-weight: bold; margin-bottom: 15px;">Trebuie să fii autentificat pentru a cumpăra bilete.</p>
                <button onclick="openPopup('loginPopup')" class="btn-full">🔒 Login pentru achiziție</button>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php include 'footer.php'; ?>