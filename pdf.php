<?php
session_start();
require_once 'config.php'; 
use Dompdf\Dompdf;


$stmt = $conn->prepare("SELECT titel, genre, tijd FROM film");
$stmt->execute();
$result = $stmt->get_result();
$films = $result->fetch_all(MYSQLI_ASSOC);


$html = '<h1>Film Lijst</h1><table border="1" cellpadding="5">';
$html .= '<tr><th>Titel</th><th>Genre</th><th>Tijd</th></tr>';

foreach ($films as $film) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($film['titel']) . '</td>';
    $html .= '<td>' . htmlspecialchars($film['genre']) . '</td>';
    $html .= '<td>' . htmlspecialchars($film['tijd']) . '</td>';
    $html .= '</tr>';
}

$html .= '</table>';


$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();


$dompdf->stream();
exit; 
http://localhost:8888/Gegevensverzameling/src/pdf.php