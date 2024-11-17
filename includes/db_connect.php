<?php
$servername = "localhost";
$username = "root";
<<<<<<< HEAD
$password = "@#shekinah2004@#";
=======
$password = "aynstayn21";
>>>>>>> d837a33f9f071523b88d67727554f55f5f26304a
$dbname = "ipamis";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (Exception $e) {
    echo "Can't connect to database";
}
?>
