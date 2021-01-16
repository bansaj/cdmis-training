<?php
$host = "127.0.0.1";
$database = "cwone";
$username = "root";
$password = "root";

$conx = mysqli_connect($host, $username, $password, $database);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
