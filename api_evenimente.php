<?php
// Oprim erorile de PHP care ar putea strica formatul JSON
error_reporting(0);
include 'db_connect.php';

$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : '';
$sql = "SELECT id, titlu as title, data_eveniment as start, descriere, locatie FROM evenimente";

if ($categorie) {
    // Folosim LIKE pentru a ignora diferențele de litere mari/mici
    $stmt = $conn->prepare($sql . " WHERE categorie LIKE ?");
    $cat_param = "%" . $categorie . "%"; 
    $stmt->bind_param("s", $cat_param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

$evenimente_array = array();

if ($result) {
    while($row = $result->fetch_assoc()) {
        $evenimente_array[] = array(
            'id' => $row['id'],
            'title' => $row['title'],
            'start' => $row['start'],
            'extendedProps' => array(
                'description' => $row['descriere'],
                'location' => $row['locatie']
            )
        );
    }
}

// Afișăm JSON-ul curat
header('Content-Type: application/json; charset=utf-8');
echo json_encode($evenimente_array);
exit;
?>