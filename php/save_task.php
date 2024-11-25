<?php

include('./database.php');
session_start();

// Verbindung zur Datenbank herstellen
$conn = openDB();

// Überprüfen, ob das Formular gesendet wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_name = $_POST['task_name'];
    $user_id = $_SESSION['user_id'];

    if (strlen($task_name) <= 255) {
        // Aufgabe in die Datenbank einfügen
        $stmt = $conn->prepare("INSERT INTO tasks (task_name, user_id) VALUES (?, ?)");
        $stmt->bind_param("si", $task_name, $user_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Aufgabe erfolgreich hinzugefügt!";
        } else {
            $_SESSION['error'] = "Fehler beim Hinzufügen der Aufgabe: " . $stmt->error;
        }

        $stmt->close();
    }
    else {
        $_SESSION['error'] = "Aufgabenname ist zu lang.";
    }
}

$conn->close();

// Weiterleitung zurück zur Formularseite
header("Location: ./../index.php");
exit();
