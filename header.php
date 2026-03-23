<?php
require_once 'db_connect.php'; 

$page_title = isset($page_title) ? $page_title : "Descoperă Brăila";
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <!-- NOU -->
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    
    <?php if(isset($needs_calendar) && $needs_calendar): ?>
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <?php endif; ?>
</head>
<body>

<header>
    <div class="container">
        <h1 class="logo"><a href="index.php">Descoperă Brăila</a></h1>
        <nav>
           <ul>
                <li><a href="index.php">Acasă</a></li>
                <li><a href="evenimente.php">Evenimente</a></li>
                <li><a href="ghid.php">Ghid Turistic</a></li>
                <li><a href="transport.php" style="color: #ffd700; font-weight: bold;">Transport</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="statistici.php">Statistici</a></li>
                <li><a href="#" onclick="openPopup('contactPopup')">Contact</a></li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="#">Salut, <?= htmlspecialchars($_SESSION['nume']) ?></a></li>
                    <li><a href="logout.php">Delogare</a></li>
                <?php else: ?>
                    <li><a href="#" onclick="openPopup('loginPopup')">Login</a></li>
                    <li><a href="#" onclick="openPopup('registerPopup')">Înregistrare</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>