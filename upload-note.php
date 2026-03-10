<?php
/**
 * upload-note.php
 * Handle note file uploads from the frontend and save to the DB.
 */

header('Content-Type: application/json');
$mysqli = require __DIR__ . "/login/database.php";

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
    exit;
}

// Check required fields
if (!isset($_FILES['note_file']) || !isset($_POST['subject']) || !isset($_POST['semester']) || !isset($_POST['branch'])) {
    $response['message'] = 'Missing required fields.';
    echo json_encode($response);
    exit;
}

$file = $_FILES['note_file'];
$subject = trim($_POST['subject']);
$semester = trim($_POST['semester']);
$branch = trim($_POST['branch']);

if ($file['error'] !== UPLOAD_ERR_OK) {
    $response['message'] = 'File upload failed with error code: ' . $file['error'];
    echo json_encode($response);
    exit;
}

$allowedMimeTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain'];
$maxSize = 25 * 1024 * 1024; // 25 MB

if (!in_array($file['type'], $allowedMimeTypes)) {
    $response['message'] = 'Invalid file type. Only PDF, DOC, DOCX, and TXT are allowed.';
    echo json_encode($response);
    exit;
}

if ($file['size'] > $maxSize) {
    $response['message'] = 'File size exceeds limit of 25MB.';
    echo json_encode($response);
    exit;
}

// Generate unique filename and path
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = uniqid('note_') . '.' . $ext;
$uploadDir = __DIR__ . '/uploads/notes/';
$targetPath = $uploadDir . $filename;

// Ensure upload directory exists
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0777, true)) {
         $response['message'] = 'Failed to create upload directory.';
         echo json_encode($response);
         exit;
    }
}

if (move_uploaded_file($file['tmp_name'], $targetPath)) {
    // Relative path for downloading
    $dbPath = 'uploads/notes/' . $filename;
    
    // Insert into DB
    $sql = "INSERT INTO notes (filename, file_path, subject, semester, branch) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    
    $originalName = basename($file['name']);
    $stmt->bind_param("sssss", $originalName, $dbPath, $subject, $semester, $branch);
    
    if ($stmt->execute()) {
        $response['success'] = true;
        // Optionally pass the new note back to append to UI instantly
        $response['note'] = [
            'subject' => htmlspecialchars($subject),
            'branch' => htmlspecialchars($branch),
            'semester' => htmlspecialchars($semester),
            'file_path' => $dbPath
        ];
    } else {
        $response['message'] = 'Database insertion failed: ' . $stmt->error;
        unlink($targetPath); // Cleanup
    }
    $stmt->close();
} else {
    $response['message'] = 'Failed to move uploaded file.';
}

$mysqli->close();
echo json_encode($response);
