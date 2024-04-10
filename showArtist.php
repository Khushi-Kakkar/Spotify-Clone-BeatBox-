<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include "config.php";

$sql = "SELECT 
            artist.artist_ID,
            artist.artistImage,
            artist.first_Name, 
            artist.last_Name,
            artist.Img2,
            artist.artistInfo,
            artist.artistDOB,
            artist.artistOrigin,
            artist.artistLang,
            songs.songName,
            songs.Duration,
            songs.songImage,
            songs.filePath
        FROM artist 
        LEFT JOIN songs ON artist.artist_ID = songs.artist_ID";

$result = mysqli_query($conn, $sql) or die("Connection failed");

if (mysqli_num_rows($result) > 0) {
    $output = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $artist_ID = $row['artist_ID'];
        if (!isset($output[$artist_ID])) {
            $output[$artist_ID] = array(
                'artistImage' => $row['artistImage'],
                'first_Name' => $row['first_Name'],
                'last_Name' => $row['last_Name'],
                'bgimg'=> $row['Img2'],
                'artistInfo' => $row['artistInfo'],
                'artistDOB' => $row['artistDOB'],
                'artistOrigin' => $row['artistOrigin'],
                'artistLang' => $row['artistLang'],
                'songs' => array()
            );
        }

        $output[$artist_ID]['songs'][] = array(
            'songName' => $row['songName'],
            'Duration' => $row['Duration'],
            'songImage' => $row['songImage'],
            'filePath' => $row['filePath']
        
        );
    }
    foreach ($output as &$artist) {
        shuffle($artist['songs']);
    }

    echo json_encode(array_values($output));
} else {
    echo json_encode(array('message' => 'No Record Found', 'status' => false));
}
?>
