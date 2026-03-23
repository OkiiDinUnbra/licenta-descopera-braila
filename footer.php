<footer id="contact">
    <div class="container">
        <h2>Contact</h2>
        <ul class="contact-info">
            <li><a href="https://www.facebook.com/andrei.filote.50/" target="_blank">Facebook</a></li>
            <li><a href="https://www.instagram.com/fmandrei/" target="_blank">Instagram</a></li>
            <li><a href="https://x.com/MAFilot" target="_blank">X (Twitter)</a></li>
        </ul>
        <p class="copyright">© 2026 Descoperă Brăila.</p>
    </div>
</footer>

<div id="loginPopup" class="popup-overlay">
    <div class="popup-box">
        <span class="close-btn" onclick="closePopup('loginPopup')">&times;</span>
        <h2>Autentificare</h2>
        <form method="POST" action="login.php">
            <input type="email" name="email" placeholder="Email" required>
            <div style="position: relative; margin-bottom: 12px;">
                <input type="password" name="parola" id="loginParola" placeholder="Parolă" required style="margin-bottom: 0; padding-right: 40px; width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
                <span style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; user-select: none;" onclick="togglePassword('loginParola', this)">👁️</span>
            </div>
            <a href="#" class="forgot-link" style="margin-top: 5px;">Ai uitat parola?</a>
            <button type="submit">Autentifică-te</button>
        </form>
    </div>
</div>

<div id="registerPopup" class="popup-overlay">
     <div class="popup-box">
        <span class="close-btn" onclick="closePopup('registerPopup')">&times;</span>
        <h2>Înregistrare</h2>
        <form method="POST" action="register.php">
            <input type="text" name="nume" placeholder="Nume complet" required>
            <input type="email" name="email" placeholder="Email" required>
            
            <div style="position: relative; margin-bottom: 12px;">
                <input type="password" name="parola" id="regParola" placeholder="Parolă" required style="margin-bottom: 0; padding-right: 40px; width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
                <span style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; user-select: none;" onclick="togglePassword('regParola', this)">👁️</span>
            </div>
            
            <div style="position: relative; margin-bottom: 12px;">
                <input type="password" name="confirmare" id="regConfirmare" placeholder="Confirmare parolă" required style="margin-bottom: 0; padding-right: 40px; width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
                <span style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; user-select: none;" onclick="togglePassword('regConfirmare', this)">👁️</span>
            </div>

            <input type="text" name="telefon" placeholder="Număr de telefon" required>

            <div class="checkbox-wrapper">
                <label>
                    <input type="checkbox" name="newsletter" value="1">
                    Doresc să primesc noutăți pe email
                </label>
            </div>

            <button type="submit">Înregistrează-te</button>
        </form>
    </div>
</div>

<div id="contactPopup" class="popup-overlay">
    <div class="popup-box">
        <span class="close-btn" onclick="closePopup('contactPopup')">&times;</span>
        <h2>Contactează-ne</h2>
        <p>Urmărește-ne pe rețelele sociale:</p>
        <ul class="contact-info">
            <li><a href="https://www.facebook.com/andrei.filote.50/" target="_blank">Facebook</a></li>
            <li><a href="https://www.instagram.com/fmandrei/" target="_blank">Instagram</a></li>
            <li><a href="https://x.com/MAFilot" target="_blank">X (Twitter)</a></li>
        </ul>
    </div>
</div>

<div id="eventDetailsPopup" class="popup-overlay">
    <div class="popup-box" style="width: 450px; text-align: left;">
        <span class="close-btn" onclick="closePopup('eventDetailsPopup')">&times;</span>
        <h2 id="modalEventTitle" style="margin-bottom: 15px; text-align: center; color: #333; font-weight: 700;">Titlu Eveniment</h2>
        
        <div style="background: #f8f9fa; padding: 15px; border-radius: 12px; margin-bottom: 15px;">
            <p style="margin-bottom: 8px; font-size: 16px;"><strong>📅 Data:</strong> <span id="modalEventDate" style="color: #0056b3;"></span></p>
            <p style="margin-bottom: 0; font-size: 16px; display: flex; justify-content: space-between; align-items: center;">
                <span><strong>📍 Locație:</strong> <span id="modalEventLocation"></span></span>
                <a id="btnMapEvent" href="#" target="_blank" style="background: #eef5ff; color: #0056b3; padding: 6px 12px; border-radius: 20px; text-decoration: none; font-size: 13px; font-weight: bold; border: 1px solid #cce5ff; transition: 0.2s;">🗺️ Deschide Harta</a>
            </p>
        </div>
        
        <p style="margin-bottom: 5px; font-size: 16px; font-weight: bold;">📝 Descriere:</p>
        <p id="modalEventDescription" style="font-size: 15px; color: #555; line-height: 1.6;"></p>

        <div id="adminEventControls" style="margin-top: 20px; padding-top: 15px; border-top: 1px dashed #ccc; text-align: right; display: none;">
            <a id="btnEditEvent" href="#" style="background-color: #ffc107; color: #333; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-weight: bold; margin-right: 10px; transition: 0.3s;">✏️ Editează</a>
            <a id="btnDeleteEvent" href="#" style="background-color: #dc3545; color: white; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-weight: bold; transition: 0.3s;" onclick="return confirm('Ești sigur că vrei să ștergi definitiv acest eveniment?');">🗑️ Șterge</a>
        </div>
    </div>
</div>

<script>
    // 1. Funcții generale pentru pop-up-uri cu animație modernă
    function openPopup(id) {
        const popup = document.getElementById(id);
        popup.style.display = 'flex';
        // Forțăm reflow-ul pentru a porni animația CSS
        setTimeout(() => {
            popup.classList.add('active');
        }, 10);
    }
    
    function closePopup(id) {
        const popup = document.getElementById(id);
        popup.classList.remove('active');
        // Așteptăm să se termine animația înainte să ascundem div-ul
        setTimeout(() => {
            popup.style.display = 'none';
        }, 300);
    }

    // 2. Funcția pentru arătat/ascuns parola
    function togglePassword(inputId, icon) {
        const input = document.getElementById(inputId);
        if (input.type === "password") {
            input.type = "text";
            icon.innerText = "🙈";
        } else {
            input.type = "password";
            icon.innerText = "👁️";
        }
    }

    // 3. Funcția care populează fereastra de eveniment
    function openEventPopup(id, title, date, location, description) {
        document.getElementById('modalEventTitle').innerText = title;
        document.getElementById('modalEventDate').innerText = date;
        document.getElementById('modalEventLocation').innerText = location || 'Nespecificat';
        document.getElementById('modalEventDescription').innerText = description || 'Nu există o descriere pentru acest eveniment.';
        
        // --- LOGICA PENTRU BUTONUL DE HARTĂ ---
        let mapBtn = document.getElementById('btnMapEvent');
        if (location && location !== 'Nespecificat') {
            mapBtn.style.display = 'inline-block';
            // Construim link-ul de căutare Google Maps (Adăugăm "Braila" ca să caute precis în oraș)
           mapBtn.href = 'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(location + ', Braila, Romania');
        } else {
            mapBtn.style.display = 'none';
        }

        // --- LOGICA PENTRU BUTOANELE DE ADMIN ---
        let adminControls = document.getElementById('adminEventControls');
        let btnEdit = document.getElementById('btnEditEvent');
        let btnDelete = document.getElementById('btnDeleteEvent');
        
        // Verificăm dacă suntem logați ca admin (dacă butoanele există în sesiune)
        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
            adminControls.style.display = 'block';
            if (btnEdit && btnDelete) {
                btnEdit.href = 'editeaza_eveniment.php?id=' + id;
                btnDelete.href = 'sterge_eveniment.php?id=' + id;
            }
        <?php else: ?>
            adminControls.style.display = 'none';
        <?php endif; ?>
        
        openPopup('eventDetailsPopup');
    }
</script>
<script>
    // 1. Funcții generale pentru pop-up-uri
   function openPopup(id) {
    const popup = document.getElementById(id);
    popup.style.display = 'flex';
    setTimeout(() => {
        popup.classList.add('active');
    }, 10);
}
    
    function closePopup(id) {
        document.getElementById(id).style.display = 'none';
    }

    // 2. Funcția pentru arătat/ascuns parola
    function togglePassword(inputId, icon) {
        const input = document.getElementById(inputId);
        if (input.type === "password") {
            input.type = "text";
            icon.innerText = "🙈";
        } else {
            input.type = "password";
            icon.innerText = "👁️";
        }
    }

    // 3. Funcția care populează fereastra de eveniment și îi setează ID-ul pentru admin
    function openEventPopup(id, title, date, location, description) {
        document.getElementById('modalEventTitle').innerText = title;
        document.getElementById('modalEventDate').innerText = date;
        document.getElementById('modalEventLocation').innerText = location || 'Nespecificat';
        document.getElementById('modalEventDescription').innerText = description || 'Nu există o descriere pentru acest eveniment.';
        
        // --- LOGICA PENTRU BUTOANELE DE ADMIN ---
        let btnEdit = document.getElementById('btnEditEvent');
        let btnDelete = document.getElementById('btnDeleteEvent');
        
        // Dacă butoanele există în HTML (adică ești logat ca admin)
        if (btnEdit && btnDelete) {
            btnEdit.href = 'editeaza_eveniment.php?id=' + id;
            btnDelete.href = 'sterge_eveniment.php?id=' + id;
        }
        
        openPopup('eventDetailsPopup');
    }
</script>

<style>
    #toast-container {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 10000;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .toast-msg {
        min-width: 250px;
        padding: 15px 20px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.4s ease-in-out;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 15px;
    }
    .toast-msg.show {
        opacity: 1;
        transform: translateX(0);
    }
    .toast-success { background: #28a745; } /* Verde */
    .toast-error { background: #dc3545; }   /* Roșu */
</style>

<div id="toast-container"></div>

<script>
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `toast-msg toast-${type}`;
        
        let icon = type === 'success' ? '✅' : '❌';
        toast.innerHTML = `<span style="font-size: 18px;">${icon}</span> <span>${message}</span>`;
        container.appendChild(toast);

        // Declanșăm animația de intrare
        setTimeout(() => toast.classList.add('show'), 100);

        // Curățăm notificarea după 4 secunde
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 400); 
        }, 4000);
    }

    // Așteptăm să se încarce pagina și citim URL-ul
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        
        // --- MESAJE PENTRU LOGIN ---
        if (urlParams.get('login') === 'eroare_parola') {
            showToast('Parola introdusă este incorectă!', 'error');
            openPopup('loginPopup'); // Îi deschidem automat pop-up-ul iar
        }
        if (urlParams.get('login') === 'eroare_email') {
            showToast('Nu am găsit niciun cont cu acest email.', 'error');
            openPopup('loginPopup');
        }
        if (urlParams.get('login') === 'succes') {
            showToast('Te-ai autentificat cu succes!', 'success');
        }

        // --- MESAJE PENTRU ÎNREGISTRARE ---
        if (urlParams.get('register') === 'succes') {
            showToast('Cont creat cu succes! Acum te poți autentifica.', 'success');
            openPopup('loginPopup'); // Îl invităm să se logheze direct
        }
        if (urlParams.get('register') === 'eroare_parole') {
            showToast('Parolele introduse nu se potrivesc.', 'error');
            openPopup('registerPopup');
        }
        if (urlParams.get('register') === 'eroare_duplicat') {
            showToast('Acest email este deja folosit.', 'error');
            openPopup('registerPopup');
        }

        // Ștergem parametrii din URL ca să nu apară mesajul din nou dacă dă refresh
        if(window.history.replaceState && (urlParams.has('login') || urlParams.has('register'))) {
            window.history.replaceState(null, null, window.location.pathname);
        }
    });
</script>
</body>
</html>
