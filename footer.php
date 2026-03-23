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
        <h2 id="modalEventTitle" style="margin-bottom: 15px; text-align: center; color: #333;">Titlu Eveniment</h2>
        
        <p style="margin-bottom: 8px; font-size: 16px;"><strong>📅 Data:</strong> <span id="modalEventDate"></span></p>
        <p style="margin-bottom: 15px; font-size: 16px;"><strong>📍 Locație:</strong> <span id="modalEventLocation"></span></p>
        
        <hr style="margin: 15px 0; border: 0; border-top: 1px solid #ccc;">
        
        <p style="margin-bottom: 5px; font-size: 16px;"><strong>📝 Descriere:</strong></p>
        <p id="modalEventDescription" style="font-size: 15px; color: #555; line-height: 1.5;"></p>

        <div style="margin-top: 20px; padding-top: 15px; border-top: 1px dashed #ccc; text-align: right;">
            <a id="btnEditEvent" href="#" style="background-color: #ffc107; color: #333; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-weight: bold; margin-right: 10px;">✏️ Editează</a>
            <a id="btnDeleteEvent" href="#" style="background-color: #dc3545; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-weight: bold;" onclick="return confirm('Ești sigur că vrei să ștergi definitiv acest eveniment?');">🗑️ Șterge</a>
        </div>
        
    </div>
</div>
<script>
    // 1. Funcții generale pentru pop-up-uri
    function openPopup(id) {
        document.getElementById(id).style.display = 'flex';
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

</body>
</html>