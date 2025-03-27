<?php
function openDB()
{
    $env = parse_ini_file(__DIR__ . '/../.env');
    // var_dump($env);

    $servername = $env['DB_SERVER'];
    $username = $env['DB_USERNAME'];
    $password = $env['DB_PASSWORD']; 
    $dbname = $env['DB_NAME']; 

    // Connect to database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        $_SESSION['error'] = "Verbindung fehlgeschlagen: " . $conn->connect_error;
        die("Verbindung fehlgeschlagen: " . $conn->connect_error);
    }
    // echo "Verbunden zur Datenbank!";

    return $conn;
}
