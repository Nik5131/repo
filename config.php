<?php
  $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname ="films";

    $conn = new mysqli($servername, $username, $password, $dbname);

    require __DIR__ . '/../vendor/autoload.php';
?>