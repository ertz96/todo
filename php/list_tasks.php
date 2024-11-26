<?php
include('./php/database.php');

if (isset($_SESSION["user_id"])) {
    $conn = openDB();

    $userId = $_SESSION["user_id"];

    // Get filter and sort options from request
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

    // Build the SQL query based on the filter and sort options
    $sql = "SELECT * FROM tasks WHERE user_id = ?";
    $conditions = [];

    // Add filter conditions based on task status
    if ($filter === 'completed') {
        $conditions[] = "status = 1"; // Erledigt
    } elseif ($filter === 'open') {
        $conditions[] = "status = 0"; // Offen
    }

    // If there are conditions, append them to the SQL query
    if (!empty($conditions)) {
        $sql .= " AND " . implode(' AND ', $conditions);
    }

    // Add sorting condition
    if ($sort === 'oldest') {
        $sql .= " ORDER BY created_at ASC"; // Assuming you have a created_at column
    } else {
        $sql .= " ORDER BY created_at DESC"; // Newest first
    }

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId); // Bind the userId parameter
    $stmt->execute();
    $result = $stmt->get_result(); // Get the result set from the executed statement
    $stmt->close();
    $conn->close();
    return $result;
}
