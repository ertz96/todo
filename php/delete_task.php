<?php
include('./database.php');
session_start();

// Connect to database
$conn = openDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];

    // Delete task
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $task_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Aufgabe erfolgreich gelöscht!";
    } else {
        $_SESSION['error'] = "Fehler beim Löschen der Aufgabe: " . $stmt->error;
    }

    $stmt->close();
    // Redirect back to the main page
    header("Location: ./../index.php");
    exit();
}

$conn->close();
?>