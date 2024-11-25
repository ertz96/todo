<?php
include('./php/database.php');

if (isset($_SESSION["user_id"])) {
    // Verbindung zur Datenbank herstellen
    $conn = openDB();

    // Angenommen, die Benutzer-ID ist in der Session gespeichert
    $user_id = $_SESSION['user_id']; // Benutzer-ID aus der Session

    // Aufgaben aus der Datenbank abrufen
    $result = $conn->query("SELECT * FROM tasks WHERE user_id = $user_id ORDER BY created_at DESC");

    $conn->close();
    return $result;
}
