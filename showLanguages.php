<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include "config.php";

$sql = $sql = "SELECT 
            language.languageImage,
            language.language,
            language.langbg,
            songs.songName,
            songs.Duration,
            songs.songImage,
            songs.filePath
        FROM language 
        LEFT JOIN songs ON language.language = songs.language";

$result = mysqli_query($conn, $sql) or die("Connection failed");

if (mysqli_num_rows($result) > 0) {
    $output = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $language = $row['language'];
        if (!isset($output[$language])) {
            $output[$language] = array(
                'languageImage' => $row['languageImage'],
                'language' => $row['language'],
                'langbg' => $row['langbg'],
                'songs' => array()
            );
        }

        $output[$language]['songs'][] = array(
            'songName' => $row['songName'],
            'Duration' => $row['Duration'],
            'songImage' => $row['songImage'],
            'filePath' => $row['filePath']
        );
    }
  foreach ($output as &$language) {
        shuffle($language['songs']);
    }

    echo json_encode(array_values($output));
} else {
    echo json_encode(array('message' => 'No Record Found', 'status' => false));
}
?>
