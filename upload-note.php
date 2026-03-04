<?php
header('Content-Type: application/json');

// Simulate a brief delay to mimic network/upload time
sleep(1);

// Basic response structure
$response = [
    'status' => 'error',
    'message' => 'An unknown error occurred.'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if file was uploaded
    if (isset($_FILES['note_file'])) {
        $fileError = $_FILES['note_file']['error'];
        
        switch ($fileError) {
            case UPLOAD_ERR_OK:
                // File uploaded successfully (in a real app, you would move_uploaded_file here)
                $fileName = htmlspecialchars(basename($_FILES['note_file']['name']));
                $response['status'] = 'success';
                $response['message'] = "File '{$fileName}' uploaded successfully!";
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $response['message'] = 'File is too large.';
                break;
            case UPLOAD_ERR_PARTIAL:
                $response['message'] = 'File was only partially uploaded.';
                break;
            case UPLOAD_ERR_NO_FILE:
                $response['message'] = 'No file was uploaded. Please select a file.';
                break;
            default:
                $response['message'] = 'Failed to upload due to a server error.';
                break;
        }
    } else {
         $response['message'] = 'No file data received.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
exit;
