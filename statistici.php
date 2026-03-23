<?php
$page_title = "Statistici Admin | Descoperă Brăila";
include 'header.php';

// Verificăm dacă utilizatorul este ADMIN
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    echo "<section style='margin-top: 150px; text-align: center; min-height: 50vh;'>
            <h2>Acces Interzis!</h2><p>Doar administratorii au acces la această pagină.</p>
            <a href='index.php' class='btn'>Înapoi acasă</a>
          </section>";
    include 'footer.php';
    exit;
}

// 1. STATISTICI UTILIZATORI
$res_useri = $conn->query("SELECT COUNT(*) as total FROM utilizatori");
$total_useri = $res_useri->fetch_assoc()['total'];

$res_useri_luna = $conn->query("SELECT COUNT(*) as total FROM utilizatori WHERE MONTH(data_creare) = MONTH(CURRENT_DATE()) AND YEAR(data_creare) = YEAR(CURRENT_DATE())");
$useri_luna = $res_useri_luna->fetch_assoc()['total'];

$res_news = $conn->query("SELECT COUNT(*) as total FROM utilizatori WHERE doreste_newsletter = 1");
$total_newsletter = $res_news->fetch_assoc()['total'];

// 2. STATISTICI EVENIMENTE
$res_ev = $conn->query("SELECT COUNT(*) as total FROM evenimente");
$total_ev = $res_ev->fetch_assoc()['total'];

$res_ev_luna = $conn->query("SELECT COUNT(*) as total FROM evenimente WHERE MONTH(data_eveniment) = MONTH(CURRENT_DATE())");
$ev_luna = $res_ev_luna->fetch_assoc()['total'];

// Top 5 Cele mai populare evenimente
$top_evenimente = [];
$res_top = $conn->query("SELECT titlu, vizualizari FROM evenimente ORDER BY vizualizari DESC LIMIT 5");
while($row = $res_top->fetch_assoc()) { $top_evenimente[] = $row; }

// 3. STATISTICI TRANSPORTURI (Bilete)
$res_bilete = $conn->query("SELECT COUNT(*) as total FROM bilete_achizitionate");
$total_bilete = $res_bilete->fetch_assoc()['total'] ?? 0;
$venituri_totale = $total_bilete * 2.50; // Prețul unui bilet

?>



<section class="stats-dashboard">
    <h1>📈 Panou de Control Administrator</h1>

    <div class="stats-grid">
        <div class="stat-card card-blue">
            <div class="stat-icon">👥</div>
            <div class="stat-value"><?= $total_useri ?></div>
            <div class="stat-title">Conturi Create</div>
            <div class="stat-subtitle">↗️ <?= $useri_luna ?> înregistrați luna aceasta</div>
        </div>

        <div class="stat-card card-purple">
            <div class="stat-icon">📅</div>
            <div class="stat-value"><?= $total_ev ?></div>
            <div class="stat-title">Evenimente Totale</div>
            <div class="stat-subtitle">📌 <?= $ev_luna ?> evenimente în luna curentă</div>
        </div>

        <div class="stat-card card-green">
            <div class="stat-icon">🎫</div>
            <div class="stat-value"><?= $total_bilete ?></div>
            <div class="stat-title">Bilete Vândute</div>
            <div class="stat-subtitle">💰 Venituri totale: <?= number_format($venituri_totale, 2) ?> RON</div>
        </div>

        <div class="stat-card card-orange">
            <div class="stat-icon">✉️</div>
            <div class="stat-value"><?= $total_newsletter ?></div>
            <div class="stat-title">Abonați Newsletter</div>
            <div class="stat-subtitle">Oameni interesați de noutăți</div>
        </div>
    </div>

    <h2 style="margin: 40px 0 20px; font-size: 24px;">🏆 Top 5 Cele mai vizualizate evenimente</h2>
    
    <table class="top-events-table">
        <thead>
            <tr>
                <th style="width: 50px;">#</th>
                <th>Nume Eveniment</th>
                <th style="text-align: right;">Vizualizări (Click-uri)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($top_evenimente)): ?>
                <tr><td colspan="3" style="text-align:center;">Nu există date suficiente încă. Dă click pe câteva evenimente!</td></tr>
            <?php else: ?>
                <?php foreach ($top_evenimente as $index => $ev): ?>
                    <tr>
                        <td><strong><?= $index + 1 ?></strong></td>
                        <td style="font-weight: 500;"><?= htmlspecialchars($ev['titlu']) ?></td>
                        <td style="text-align: right;"><span class="badge-views">👁️ <?= $ev['vizualizari'] ?> vizualizări</span></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</section>

<?php include 'footer.php'; ?>