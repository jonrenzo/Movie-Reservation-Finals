<?php
session_start();
require_once '../includes/config.php';

$movie_reservations = [];
$sql_movies = "SELECT m.movie_id, m.movie_name, COUNT(r.reservation_id) as reservation_count
               FROM movie m
               LEFT JOIN reservation r ON m.movie_id = r.movie_id
               GROUP BY m.movie_id, m.movie_name";
$stmt_movies = $con->prepare($sql_movies);
$stmt_movies->execute();
$stmt_movies->bind_result($movie_id, $movie_name, $reservation_count);
while ($stmt_movies->fetch()) {
    $movie_reservations[] = [
        'movie_id' => $movie_id,
        'movie_name' => $movie_name,
        'reservation_count' => $reservation_count
    ];
}
$stmt_movies->close();

function exportToCSV($data, $filename)
{
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=' . $filename);

    $output = fopen('php://output', 'w');
    fputcsv($output, array_keys($data[0]));

    foreach ($data as $row) {
        fputcsv($output, $row);
    }

    fclose($output);
    exit();
}

function exportToExcelHTML($data, $filename)
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename=' . $filename);

    echo '<table border="1">';
    echo '<tr>';
    foreach (array_keys($data[0]) as $header) {
        echo '<th>' . htmlspecialchars($header) . '</th>';
    }
    echo '</tr>';

    foreach ($data as $row) {
        echo '<tr>';
        foreach ($row as $cell) {
            echo '<td>' . htmlspecialchars($cell) . '</td>';
        }
        echo '</tr>';
    }

    echo '</table>';
    exit();
}

// Determine the export format
$format = isset($_GET['format']) ? $_GET['format'] : 'csv';
$filename = 'reservations_report.' . ($format === 'csv' ? 'csv' : 'xls');

if ($format === 'csv') {
    exportToCSV($movie_reservations, $filename);
} else {
    exportToExcelHTML($movie_reservations, $filename);
}
