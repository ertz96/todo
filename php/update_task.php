<?php
include('./database.php');
session_start();

// Verbindung zur Datenbank herstellen
$conn = openDB();

// Überprüfen, ob die Aufgabe-ID gesendet wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];

    // Status der Aufgabe umschalten
    $stmt = $conn->prepare("UPDATE tasks SET status = NOT status WHERE id = ?");
    $stmt->bind_param("i", $task_id);

    if ($stmt->execute()) {
        // Optionally, you can set a success message
        $_SESSION['message'] = "Aufgabe erfolgreich aktualisiert!";
    } else {
        $_SESSION['error'] = "Fehler beim Aktualisieren der Aufgabe: " . $stmt->error;
    }

    $stmt->close();
    // Redirect back to the main page
    header("Location: ./../index.php");
    exit();
}

$conn->close();
?>