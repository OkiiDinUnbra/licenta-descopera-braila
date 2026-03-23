<?php
$page_title = "Biletul Tău | Descoperă Brăila";
include 'header.php';

// Verificăm dacă utilizatorul este logat
if (!isset($_SESSION['user_id'])) {
    echo "<section style='margin-top: 150px; text-align: center; min-height: 50vh;'>
            <h2>Trebuie să fii autentificat pentru a cumpăra un bilet!</h2>
            <a href='transport.php' class='btn'>Înapoi</a>
          </section>";
    include 'footer.php';
    exit;
}

$user_id = $_SESSION['user_id'];
$nume_utilizator = $_SESSION['nume'];

// 1. Generăm datele biletului
$cod_unic = 'BR_' . strtoupper(uniqid()) . '_' . rand(1000, 9999); // Ex: BR_65E4A..._4592
$data_achizitie = date('Y-m-d H:i:s');
$data_expirare = date('Y-m-d H:i:s', strtotime('+60 minutes')); // Valabil exact 60 de minute!

$mesaj_succes = false;

// 2. Inserăm biletul în baza de date
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("INSERT INTO bilete_achizitionate (user_id, cod_qr_unic, data_achizitie, data_expirare, status) VALUES (?, ?, ?, ?, 'activ')");
    $stmt->bind_param("isss", $user_id, $cod_unic, $data_achizitie, $data_expirare);
    
    if ($stmt->execute()) {
        $mesaj_succes = true;
    }
    $stmt->close();
}

// 3. API-ul care ne desenează codul QR pe baza codului unic
$qr_image_url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($cod_unic);
?>

<style>
    .bilet-container { padding: 120px 20px 60px; max-width: 600px; margin: auto; min-height: 70vh; text-align: center;}
    
    .loading-plata { display: none; margin-top: 50px; }
    .spinner { border: 6px solid #f3f3f3; border-top: 6px solid #28a745; border-radius: 50%; width: 50px; height: 50px; animation: spin 1s linear infinite; margin: 0 auto 20px; }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    
    .bilet-fizic { 
        background: #fff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); 
        padding: 0; margin-top: 30px; overflow: hidden; border: 2px solid #ddd;
    }
    .bilet-header { background: #28a745; color: white; padding: 20px; font-size: 22px; font-weight: bold; }
    .bilet-body { padding: 30px; }
    .qr-box { margin: 20px 0; padding: 10px; border: 4px dashed #eee; display: inline-block; }
    .detalii-bilet { text-align: left; background: #f9f9f9; padding: 15px; border-radius: 8px; font-size: 15px; margin-top: 20px;}
    .detalii-bilet p { margin-bottom: 8px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
    .detalii-bilet p:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    
    .timer { font-size: 24px; font-weight: bold; color: #dc3545; margin-top: 15px; }
</style>

<section class="bilet-container">

    <?php if (!$mesaj_succes): ?>
        <h2>A apărut o eroare la procesarea plății.</h2>
        <a href="transport.php" class="btn">Încearcă din nou</a>
    <?php else: ?>
        
        <div id="loadingSec" class="loading-plata" style="display: block;">
            <div class="spinner"></div>
            <h3>Procesăm plata sigură...</h3>
            <p style="color: #666;">Te rugăm să aștepți confirmarea băncii.</p>
        </div>

        <div id="biletSec" style="display: none;">
            <h2 style="color: #28a745;">✅ Plată acceptată! Biletul tău a fost emis.</h2>
            
            <div class="bilet-fizic">
                <div class="bilet-header">
                    🚌 Bilet Braicar (60 Min)
                </div>
                <div class="bilet-body">
                    <p style="font-size: 16px; color: #555;">Arată acest cod controlorului:</p>
                    
                    <div class="qr-box">
                        <img src="<?= $qr_image_url ?>" alt="Cod QR Bilet">
                    </div>
                    
                    <h3 style="margin-bottom: 10px; font-family: monospace; color: #333; letter-spacing: 2px;"><?= $cod_unic ?></h3>
                    
                    <div class="timer">
                        Expiră în: <span id="countdown">60:00</span>
                    </div>

                    <div class="detalii-bilet">
                        <p><strong>Călător:</strong> <?= htmlspecialchars($nume_utilizator) ?></p>
                        <p><strong>Emis la:</strong> <?= date('d/m/Y H:i', strtotime($data_achizitie)) ?></p>
                        <p><strong>Valabil până la:</strong> <?= date('d/m/Y H:i', strtotime($data_expirare)) ?></p>
                        <p><strong>Preț:</strong> 2.50 RON (Achitat Card)</p>
                    </div>
                </div>
            </div>
            
            <a href="transport.php" class="btn" style="margin-top: 30px; display: inline-block;">Înapoi la Rute</a>
        </div>

        <script>
            // Simulăm timpul de plată (2 secunde)
            setTimeout(function() {
                document.getElementById('loadingSec').style.display = 'none';
                document.getElementById('biletSec').style.display = 'block';
                startTimer();
            }, 2000);

            // Funcția pentru cronometrul de 60 de minute
            function startTimer() {
                // Setăm data expirării luată din PHP (trebuie transformată pt JS)
                var expireTime = new Date("<?= date('M d, Y H:i:s', strtotime($data_expirare)) ?>").getTime();
                
                var x = setInterval(function() {
                    var now = new Date().getTime();
                    var distance = expireTime - now;

                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Adăugăm un zero în față dacă e sub 10
                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;

                    document.getElementById("countdown").innerHTML = minutes + ":" + seconds;

                    if (distance < 0) {
                        clearInterval(x);
                        document.getElementById("countdown").innerHTML = "EXPIRAT";
                        document.getElementById("countdown").style.color = "gray";
                    }
                }, 1000);
            }
        </script>

    <?php endif; ?>

</section>

<?php include 'footer.php'; ?>