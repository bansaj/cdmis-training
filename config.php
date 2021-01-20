<?php
$host = "localhost";
$database = "cwone";
$username = "root";
$password = "";

$conx = mysqli_connect($host, $username, $password, $database);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
