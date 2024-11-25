<?php
function openDB()
{
    $servername = "localhost";
    $username = "root"; // Ihr MySQL-Benutzername
    $password = "12@34"; // Ihr MySQL-Passwort
    $dbname = "todo_list"; // Der Name Ihrer Datenbank

    // Verbindung zur Datenbank herstellen
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Überprüfen der Verbindung
    if ($conn->connect_error) {
        $_SESSION['error'] = "Verbindung fehlgeschlagen: " . $conn->connect_error;
        die("Verbindung fehlgeschlagen: " . $conn->connect_error);
    }
    // echo "Verbunden zur Datenbank!";

    return $conn;
}
