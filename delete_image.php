

<?php
require_once 'db_connection.php'; // Adjust the path as necessary

// Expected POST data: itemId, imageIndex (or another identifier for the image)
$data = json_decode(file_get_contents('uploads/'), true);

if (isset($data['ItemID'], $data['ImageID'])) {
    $itemId = mysqli_real_escape_string($conn, $data['ItemID']);
    $imageId = mysqli_real_escape_string($conn, $data['ImageID']); // Corrected to use 'ImageID'
    
    // Fetch the image file path before deletion if needed for file system cleanup
    $sqlFetchImagePath = "SELECT ImageURL FROM productimages WHERE ItemID = ? AND ImageID = ?";
    $stmt = mysqli_prepare($conn, $sqlFetchImagePath);
    mysqli_stmt_bind_param($stmt, 'ii', $itemId, $imageId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $image = mysqli_fetch_assoc($result);

    if ($image) {
        // Optional: Delete the file from the file system
        if (file_exists($image['ImageURL'])) {
            unlink($image['ImageURL']);
        }

        // Delete the image record from the database
        $sqlDeleteImage = "DELETE FROM productimages WHERE ItemID = ? AND ImageID = ?";
        $stmt = mysqli_prepare($conn, $sqlDeleteImage);
        mysqli_stmt_bind_param($stmt, 'ii', $itemId, $imageId);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Image deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete image.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Image not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No ItemID or ImageID provided.']);
}

mysqli_close($conn);
?>

