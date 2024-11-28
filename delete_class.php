<?php
include("main.php");

if (isset($_GET['id'])) {
    $class_id = intval($_GET['id']);

    // Delete the class
    $delete_query = "DELETE FROM classes WHERE class_id = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($stmt, "i", $class_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: classes.php");
        exit;
    } else {
        header("Location: classes.php");
        exit;
    }
} else {
    header("Location: classes.php");
    exit;
}
?>