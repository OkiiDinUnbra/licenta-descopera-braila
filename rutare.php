<?php
$page_title = "Planificator Rută | Descoperă Brăila";
include 'header.php';

$mesaj_eroare = "";
$rezultate = [];
$nume_plecare = "";
$nume_destinatie = "";

if (isset($_GET['plecare']) && isset($_GET['destinatie'])) {
    $id_plecare = intval($_GET['plecare']);
    $id_destinatie = intval($_GET['destinatie']);

    if ($id_plecare === $id_destinatie) {
        $mesaj_eroare = "Ai selectat aceeași stație pentru plecare și sosire.";
    } else {
        // 1. Luăm numele stațiilor
        $stmt_nume = $conn->prepare("SELECT id, nume_statie FROM transport_statii WHERE id IN (?, ?)");
        $stmt_nume->bind_param("ii", $id_plecare, $id_destinatie);
        $stmt_nume->execute();
        $res_nume = $stmt_nume->get_result();
        while ($row = $res_nume->fetch_assoc()) {
            if ($row['id'] == $id_plecare) $nume_plecare = $row['nume_statie'];
            if ($row['id'] == $id_destinatie) $nume_destinatie = $row['nume_statie'];
        }

        // 2. Algoritm Rutare + Extragere stații intermediare
        $sql_rutare = "
            SELECT 
                l.numar_linia, l.tip_vehicul, d.nume_directie, d.id as directie_id,
                r1.ordine AS ordine_plecare, r2.ordine AS ordine_destinatie,
                (r2.ordine - r1.ordine) AS numar_statii
            FROM transport_rute r1
            JOIN transport_rute r2 ON r1.directie_id = r2.directie_id
            JOIN transport_directii d ON r1.directie_id = d.id
            JOIN transport_linii l ON d.linia_id = l.id
            WHERE r1.statie_id = ? AND r2.statie_id = ? AND r1.ordine < r2.ordine
            ORDER BY numar_statii ASC";

        $stmt = $conn->prepare($sql_rutare);
        $stmt->bind_param("ii", $id_plecare, $id_destinatie);
        $stmt->execute();
        $res = $stmt->get_result();

        while ($ruta = $res->fetch_assoc()) {
            // Pentru fiecare rută găsită, luăm lista de stații prin care trece
            $sql_statii = "
                SELECT s.nume_statie 
                FROM transport_rute r
                JOIN transport_statii s ON r.statie_id = s.id
                WHERE r.directie_id = ? AND r.ordine BETWEEN ? AND ?
                ORDER BY r.ordine ASC";
            
            $stmt_s = $conn->prepare($sql_statii);
            $stmt_s->bind_param("iii", $ruta['directie_id'], $ruta['ordine_plecare'], $ruta['ordine_destinatie']);
            $stmt_s->execute();
            $res_s = $stmt_s->get_result();
            
            $lista_statii = [];
            while($s = $res_s->fetch_assoc()) { $lista_statii[] = $s['nume_statie']; }
            $ruta['itinerariu'] = $lista_statii;
            $rezultate[] = $ruta;
        }
    }
}
?>

<style>
    :root { --primary: #0056b3; --accent: #ffd700; --bg: #f8f9fa; }
    .rutare-page { background: var(--bg); padding-top: 100px; min-height: 100vh; font-family: 'Segoe UI', sans-serif; }
    .container { max-width: 900px; margin: 0 auto; padding: 20px; }
    
    /* Header Vizual */
    .route-summary { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px; border-bottom: 4px solid var(--accent); }
    .route-nodes { display: flex; align-items: center; justify-content: space-between; position: relative; }
    .node { text-align: center; flex: 1; }
    .node i { font-size: 24px; color: var(--primary); display: block; margin-bottom: 5px; }
    .node span { font-weight: 700; font-size: 1.1rem; color: #333; }
    .connector { flex: 0.5; height: 2px; background: #ddd; position: relative; margin-top: 10px; }
    .connector::after { content: '➔'; position: absolute; top: -10px; left: 45%; color: #bbb; }

    /* Card Rezultat */
    .card-route { background: white; border-radius: 12px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: transform 0.2s; }
    .card-route:hover { transform: translateY(-3px); }
    .route-header { padding: 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; }
    .line-badge { background: var(--primary); color: white; padding: 8px 15px; border-radius: 8px; font-weight: 800; font-size: 1.2rem; display: flex; align-items: center; gap: 10px; }
    
    /* Itinerariu (Timeline) */
    .itinerary { padding: 20px; background: #fff; }
    .timeline { position: relative; padding-left: 30px; list-style: none; }
    .timeline::before { content: ''; position: absolute; left: 7px; top: 5px; width: 2px; height: 90%; background: #e0e0e0; }
    .timeline-item { position: relative; margin-bottom: 15px; font-size: 0.95rem; color: #555; }
    .timeline-item::before { content: ''; position: absolute; left: -28px; top: 4px; width: 12px; height: 12px; background: white; border: 2px solid var(--primary); border-radius: 50%; z-index: 2; }
    .timeline-item.active { color: var(--primary); font-weight: bold; }
    .timeline-item.active::before { background: var(--primary); }

    .route-footer { padding: 15px 20px; background: #fefefe; display: flex; justify-content: space-between; align-items: center; }
    .est-time { color: #666; font-size: 0.9rem; }
    .btn-ticket { background: #28a745; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: 0.3s; }
    .btn-ticket:hover { background: #218838; box-shadow: 0 3px 10px rgba(40, 167, 69, 0.3); }
</style>

<div class="rutare-page">
    <div class="container">
        <?php if ($mesaj_eroare): ?>
            <div class="alert alert-danger"><?= $mesaj_eroare ?></div>
        <?php else: ?>
            
            <div class="route-summary">
                <div class="route-nodes">
                    <div class="node">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?= htmlspecialchars($nume_plecare) ?></span>
                    </div>
                    <div class="connector"></div>
                    <div class="node">
                        <i class="fas fa-flag-checkered"></i>
                        <span><?= htmlspecialchars($nume_destinatie) ?></span>
                    </div>
                </div>
            </div>

            <?php if (empty($rezultate)): ?>
                <div class="text-center p-5 bg-white rounded shadow-sm">
                    <img src="assets/img/no-route.svg" style="width: 150px; opacity: 0.5;">
                    <h3 class="mt-4 text-muted">Nu există legătură directă</h3>
                    <p>Momentan căutăm doar rute fără schimbare. Încearcă o stație majoră ca punct intermediar.</p>
                    <a href="transport.php" class="btn btn-primary mt-3">Înapoi la căutare</a>
                </div>
            <?php else: ?>
                <h4 class="mb-4">Rute Directe Disponibile (<?= count($rezultate) ?>)</h4>
                
                <?php foreach ($rezultate as $index => $ruta): ?>
                    <div class="card-route">
                        <div class="route-header">
                            <div class="line-badge">
                                <span><?= $ruta['tip_vehicul'] == 'autobuz' ? '🚌' : '🚋' ?></span>
                                <span>Linia <?= htmlspecialchars($ruta['numar_linia']) ?></span>
                            </div>
                            <div class="est-time">
                                <i class="far fa-clock"></i> Estimat: <?= $ruta['numar_statii'] * 3 ?> min
                            </div>
                        </div>

                        <div class="itinerary">
                            <p class="text-muted small mb-3">Direcția: <strong><?= htmlspecialchars($ruta['nume_directie']) ?></strong></p>
                            <ul class="timeline">
                                <?php foreach ($ruta['itinerariu'] as $i => $statie): ?>
                                    <li class="timeline-item <?= ($i == 0 || $i == count($ruta['itinerariu'])-1) ? 'active' : '' ?>">
                                        <?= htmlspecialchars($statie) ?>
                                        <?php if($i == 0) echo ' <small class="text-success">(Urcă aici)</small>'; ?>
                                        <?php if($i == count($ruta['itinerariu'])-1) echo ' <small class="text-danger">(Coboară aici)</small>'; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="route-footer">
    <span class="text-muted"><i class="fas fa-info-circle"></i> <?= $ruta['numar_statii'] ?> stații de parcurs</span>
    <a href="adauga_in_cos.php?linia=<?= $ruta['numar_linia'] ?>&tip=<?= $ruta['tip_vehicul'] ?>" class="btn-ticket">
        <i class="fas fa-cart-plus"></i> Adaugă în Coș - 3.25 RON
    </a>
</div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>