<?php
include('./database.php');
session_start();

// Connect to database
$conn = openDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password == $confirmPassword) {
        // Check if the username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Username already exists
            $_SESSION['error'] = "Benutzername bereits vergeben. Bitte wählen Sie einen anderen.";
        } else {
            // Passwort hashen
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Add user to DB
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Registrierung erfolgreich!";
            } else {
                $_SESSION['error'] = "Fehler bei der Registrierung: " . $stmt->error;
            }
        }
        $stmt->close();
    }
    else {
        $_SESSION['error'] = "Passwörter stimmen nicht überein.";
    }
}

$conn->close();
header("Location: ./../index.php");
