<?php
include("main.php");

if (isset($_GET['id'])) {
    $studentId = intval($_GET['id']);

    // First, retrieve the image filename associated with the student
    $imageQuery = "SELECT image FROM student WHERE id = ?";
    $stmt = mysqli_prepare($conn, $imageQuery);
    mysqli_stmt_bind_param($stmt, "i", $studentId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $imageToDelete = null;
    if ($row = mysqli_fetch_assoc($result)) {
        $imageToDelete = $row['image'];
    }

    // Prepare and execute the delete query
    $deleteQuery = "DELETE FROM student WHERE id = ?";
    $stmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "i", $studentId);

    if (mysqli_stmt_execute($stmt)) {
        // If student was successfully deleted and there's an image
        if (!empty($imageToDelete)) {
            $imagePath = "images/" . $imageToDelete;

            // Check if file exists before trying to delete
            if (file_exists($imagePath)) {
                // Attempt to delete the image file
                if (unlink($imagePath)) {
                    // Image successfully deleted
                    header("Location: index.php");
                } else {
                    // Failed to delete image file
                    header("Location: index.php");

                }
            } else {
                // Image file doesn't exist
                header("Location: index.php");

            }
        } else {
            // No image to delete
            header("Location: index.php");

        }

        exit;
    } else {
        // Database deletion failed
        header("Location: index.php");

        exit;
    }
} else {
    // No ID provided
    header("Location: index.php");

    exit;
}
?>