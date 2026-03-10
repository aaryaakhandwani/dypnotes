<?php
/**
 * fetch-notes.php
 * API Endpoint to retrieve notes from the database along with search/filter params.
 * Returns JSON array.
 */

header('Content-Type: application/json');

$mysqli = require __DIR__ . "/login/database.php";

// Set up base query
$sql = "SELECT id, filename, file_path, subject, semester, branch, uploaded_at FROM notes WHERE 1=1";
$params = [];
$types = "";

// Handle filtering parameters
if (isset($_GET['q']) && !empty($_GET['q'])) {
    $search = "%" . $_GET['q'] . "%";
    $sql .= " AND (subject LIKE ? OR filename LIKE ?)";
    $params[] = $search;
    $params[] = $search;
    $types .= "ss";
}

if (isset($_GET['semester']) && $_GET['semester'] !== 'all' && !empty($_GET['semester'])) {
    $sql .= " AND semester = ?";
    $params[] = $_GET['semester'];
    $types .= "s";
}

if (isset($_GET['branch']) && $_GET['branch'] !== 'all' && !empty($_GET['branch'])) {
    $sql .= " AND branch = ?";
    $params[] = $_GET['branch'];
    $types .= "s";
}

$sql .= " ORDER BY uploaded_at DESC";

$stmt = $mysqli->prepare($sql);

// Bind parameters if we have any
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$notes = [];

if ($stmt->execute()) {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }
}

$stmt->close();
$mysqli->close();

echo json_encode(['success' => true, 'data' => $notes]);
