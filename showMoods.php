<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include "config.php";

$sql = $sql = "SELECT 
            genre.genreImage,
            genre.genre,
            songs.songName,
            songs.Duration,
            songs.songImage,
            songs.filePath
        FROM genre 
        LEFT JOIN songs ON genre.genre = songs.genre";

$result = mysqli_query($conn, $sql) or die("Connection failed");

if (mysqli_num_rows($result) > 0) {
    $output = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $genre = $row['genre'];
        if (!isset($output[$genre])) {
            $output[$genre] = array(
                'genreImage' => $row['genreImage'],
                'genre' => $row['genre'],
                'songs' => array()
            );
        }

        $output[$genre]['songs'][] = array(
            'songName' => $row['songName'],
            'Duration' => $row['Duration'],
            'songImage' => $row['songImage'],
            'filePath' => $row['filePath']
        );
    }
    foreach ($output as &$genre) {
        shuffle($genre['songs']);
    }

    echo json_encode(array_values($output));
} else {
    echo json_encode(array('message' => 'No Record Found', 'status' => false));
}
?>
