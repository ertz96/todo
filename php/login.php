<?php

include('./database.php');
session_start();

// Connect to database
$conn = openDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Get userdata
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Check password
        if (password_verify($password, $hashed_password)) {
            // Set session variable
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user_id; // Benutzer-ID in der Session speichern
            $_SESSION['message'] = "Anmeldung erfolgreich! Willkommen, " . htmlspecialchars($username) . ".";
        } else {
            $_SESSION['error'] = "Ungültiger Benutzername oder Passwort.";
        }
    } else {
        $_SESSION['error'] = "Ungültiger Benutzername oder Passwort.";
    }

    $stmt->close();
}

$conn->close();
header("Location: ./../index.php");
