<?php
$servername = "localhost";
$username = "root";
$password = "@#shekinah2004@#";
$dbname = "ipamis";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (Exception $e) {
    echo "Can't connect to database";
}
?>
