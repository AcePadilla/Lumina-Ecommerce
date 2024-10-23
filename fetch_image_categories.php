<?php
if (isset($_GET['category'])) {
    $category = htmlspecialchars($_GET['category']);
    $directoryPath = 'images/' . $category;

    if (is_dir($directoryPath)) {
        $files = array_slice(scandir($directoryPath), 2);
        $imagePaths = array_map(function($file) use ($category) {
            return "images/$category/" . $file;
        }, $files);

        echo json_encode($imagePaths);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode(['error' => 'No category specified']);
}
?>
