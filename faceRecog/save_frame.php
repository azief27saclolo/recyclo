<?php
session_start();
require '../Php/connector.php';

// Create a new database connection
$db = new DBConnection();
$conn = $db->connect();

if (isset($_POST['image']) && isset($_SESSION['user_id'])) {
    $data = $_POST['image'];
    $data = str_replace('data:image/png;base64,', '', $data);
    $data = str_replace(' ', '+', $data);
    $data = base64_decode($data);
    $user_id = $_SESSION['user_id'];

    // Check if an entry already exists for the given user_id
    $stmt = $conn->prepare("SELECT id FROM face_verification WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Update the existing record
        $stmt->close();
        $stmt = $conn->prepare("UPDATE face_verification SET verified_image = ? WHERE user_id = ?");
        $stmt->bind_param("bi", $data, $user_id);
        $stmt->send_long_data(0, $data);
    } else {
        // Insert a new record
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO face_verification (user_id, verified_image) VALUES (?, ?)");
        $stmt->bind_param("ib", $user_id, $data);
        $stmt->send_long_data(1, $data);
    }

    if ($stmt->execute()) {
        echo 'Image saved successfully.';
        header("Location: ../USER/index.php");
    } else {
        echo 'Failed to save image.';
    }

    $stmt->close();
} else {
    echo 'No image data or user not logged in.';
}

$conn->close();
?>