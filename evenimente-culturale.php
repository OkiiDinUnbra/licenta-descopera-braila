<?php 
$page_title = "Evenimente Culturale | Descoperă Brăila";
$needs_calendar = true; 
include 'header.php'; 
?>

<style>
    .hero-culturale { background: url('img/cultural-bg.jpg') no-repeat center center/cover; color: white; padding: 100px 20px; text-align: center; margin-top: 80px; }
    .hero-culturale h1 { font-size: 48px; text-shadow: 2px 2px 4px rgba(0,0,0,0.7); }
    .calendar-section { background: #f7f2eb; padding: 60px 20px; text-align: center; }

    /* Fix pentru afișarea textului complet în calendar */
    .fc-event-title {
        white-space: normal !important;
        word-wrap: break-word !important;
        font-size: 13px;
        line-height: 1.2;
    }
    .fc-event {
        cursor: pointer; /* Arată o mânuță când pui mouse-ul pe eveniment */
        padding: 2px 4px;
    }
</style>

<section class="hero-culturale">
    <h1>Evenimente Culturale în Brăila</h1>
</section>

<section class="calendar-section">
    <h2>Calendar Cultural</h2>
    
    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
    <div style="max-width: 900px; margin: 0 auto 15px auto; text-align: right;">
        <a href="adauga_eveniment.php?categorie=cultural" style="background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: 0.3s;">
            ➕ Adaugă Eveniment Cultural
        </a>
    </div>
    <?php endif; ?>

    <div id="calendar" style="max-width: 900px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);"></div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            events: 'api_evenimente.php?categorie=cultural', // Tragem datele
            eventClick: function(info) {
                info.jsEvent.preventDefault(); // Previne comportamente ciudate ale browserului
                
                // Extragem ID-ul și restul datelor din evenimentul curent de pe care am dat click
                const id = info.event.id || ''; // Preia ID-ul
                const title = info.event.title || 'Fără titlu';
                
                let formattedDate = 'Dată necunoscută';
                if (info.event.start) {
                    formattedDate = info.event.start.toLocaleDateString('ro-RO', { day: 'numeric', month: 'long', year: 'numeric' });
                }
                
                const location = (info.event.extendedProps && info.event.extendedProps.location) ? info.event.extendedProps.location : 'Nespecificat';
                const description = (info.event.extendedProps && info.event.extendedProps.description) ? info.event.extendedProps.description : 'Nu există detalii suplimentare.';

                // Apelăm funcția din footer.php trimițând și ID-ul (este primul paramentru)!
                if (typeof openEventPopup === "function") {
                    openEventPopup(id, title, formattedDate, location, description);
                } else {
                    console.error("Eroare: Funcția openEventPopup nu a fost găsită în pagină.");
                }
            }
        });
        calendar.render();
    });
</script>

<?php include 'footer.php'; ?>