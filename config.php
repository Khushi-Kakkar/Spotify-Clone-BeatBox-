
<?php
$servername = "Localhost";
$username = "id21959871_khushi";
$password = "Krisha@11J";
$database = "id21959871_trackdeets";

// Attempt to connect to MySQL database
try
{
    $conn = mysqli_connect($servername, $username, $password, $database);
}

catch(Exception $e)

{
    echo "". $e->getMessage();
}

?>

