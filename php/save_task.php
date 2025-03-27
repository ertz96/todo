<?php

include('./database.php');
session_start();

// Connect to database
$conn = openDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_name = $_POST['task_name'];
    $user_id = $_SESSION['user_id'];

    if (strlen($task_name) <= 255) {
        // Add task to DB
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

// Redirect to main page after adding task
header("Location: ./../index.php");
exit();
