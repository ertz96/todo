<?php
session_start();
if (isset($_SESSION['message'])) {
    echo "<div class='success'>" . $_SESSION['message'] . "</div>";
    unset($_SESSION['message']);
}

if (isset($_SESSION['error'])) {
    echo "<div class='error'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}
if (isset($_SESSION['username']))
    $username = $_SESSION['username'];
else
    $username = "Gast";

$result = include("./php/list_tasks.php");
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo-List</title>
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/app.js" defer></script>
</head>

<body>

    <header>
        <nav>
            <a href="#home" id="home_link">Home</a>
            <a href="#login" id="login_link">Login</a>
            <a href="#registration" id="registrierung_link">Registrierung</a>
            <a href="#logout" id="logout_link">Logout (<?= $username ?>)</a>
        </nav>
    </header>

    <div class="container">
        <form action="./php/login.php" method="post" id="login" class="login" style="display: none;">
            <label for="username">Benutzername:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Passwort:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>

        <form action="./php/register.php" method="post" id="registration" class="registration" style="display: none;">
            <label for="username">Benutzername:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Passwort:</label>
            <input type="password" id="password" name="password" required><br>
            <label for="confirmPassword">Passwort bestätigen:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
            <button type="submit">Registrieren</button>
        </form>
        <form action="./php/save_task.php" method="post" id="addTask" class="addTask" style="display: none;">
            <?php if ($username != "Gast") { ?>
                <label for="task_name">Aufgabenname:</label>
                <input type="text" id="task_name" name="task_name" required>
                <button type="submit">Aufgabe hinzufügen</button>
            <?php } else { ?>
                <p style="font-weight: bold;">Bitte zuerst einloggen!</p>
            <?php } ?>
        </form>
    </div>
    <?php if ($username != 'Gast') { ?>
        <div class="filter-container">
            <label for="filter">Filter:</label>
            <select id="filter" onchange="applyFilter()">
                <option value="none">...</option>
                <option value="all">Alle</option>
                <option value="completed">Erledigt</option>
                <option value="open">Offen</option>
            </select>

            <label for="sort">Sortieren nach:</label>
            <select id="sort" onchange="applyFilter()">
                <option value="none">...</option>
                <option value="newest">Neueste zuerst</option>
                <option value="oldest">Älteste zuerst</option>
            </select>
        </div>

        <div class="content">
            <ul id='task-list'>
                <?php
                if ($result->num_rows == 0) echo '<li>Keine Aufgaben vorhanden.</li>';
                else {
                    while ($row = $result->fetch_assoc()) {
                        if ($result->num_rows >= 0) {
                            $status = $row['status'] ? 'Erledigt' : 'Offen';
                            $statusTurned = !$row['status'] ? 'Erledigt' : 'Offen'; ?>
                            <li name="<?= "task_" . $row['id'] ?>" data-task-id='<?= $row['id'] ?>' class='<?= ($row['status'] ? 'done' : 'pending') ?>'>
                                <form action="./php/update_task.php" method="post" style="display:inline;">
                                    <input type="hidden" name="task_id" value="<?= $row['id'] ?>"> <!-- Hidden input for task ID -->
                                    <button class='mark-done' type="submit"><?= $statusTurned ?></button>
                                </form>
                                <?= htmlspecialchars($row['task_name']) ?> (Status: <?= $status ?>)
                                <form action="./php/delete_task.php" method="post" style="display:inline;">
                                    <input type="hidden" name="task_id" value="<?= $row['id'] ?>"> <!-- Hidden input for task ID -->
                                    <button class='delete-task' type="submit" onclick="return confirm('Möchten Sie diese Aufgabe wirklich löschen?');">Löschen</button>
                                </form>
                            </li>
                        <?php } ?>
                <?php }
                } ?>
            </ul>
        </div>

    <?php } ?>
</body>

</html>