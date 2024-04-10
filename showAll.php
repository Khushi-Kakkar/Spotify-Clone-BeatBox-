<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include "config.php";

$sql = "SELECT songs.songName,
               songs.songImage,
               artist.first_Name, 
               artist.last_Name,
               songs.duration,
               songs.filePath
        FROM songs 
        JOIN artist ON songs.artist_ID = artist.artist_ID 
        ORDER BY RAND()";
        

$result = mysqli_query($conn, $sql) or die("Connection failed");

if (mysqli_num_rows($result) > 0) {
    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($output);
    
} else {
    echo json_encode(array('message' => 'No Record Found', 'status' => false));
}

?>