<?php
$servername = "localhost";
$username = "root";
<<<<<<< HEAD
$password = "root";
=======
$password = "leahfaye";
>>>>>>> a38f70f24623a44c58665903208b36ce8ed93b3f
$dbname = "ipamis";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (Exception $e) {
    echo "Can't connect to database";
}
?>
