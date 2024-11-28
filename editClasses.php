<?php
include("main.php");

$class_id = $_GET['id'];

// Fetch current class details
$query = "SELECT * FROM classes WHERE class_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $class_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    $class_name = $row['class_name'];
} else {
    echo "<p>Class not found!</p>";
    exit;
}

// Handle form submission
if (isset($_POST['submit'])) {
    $updated_class_name = mysqli_real_escape_string($conn, $_POST['class_name']);

    $update_query = "UPDATE classes SET class_name = ? WHERE class_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $updated_class_name, $class_id);

    if ($stmt->execute()) {
        echo "<p>Class updated successfully!</p>";
        header("Location: classes.php");
        exit;
    } else {
        echo "<p>Failed to update class.</p>";
    }
}
?>

<section class="form-container">
    <form action="" method="post">
        <h3>Edit Class</h3>
        <p>Class Name <span>*</span></p>
        <input type="text" name="class_name" placeholder="Enter class name" maxlength="100" required class="box"
            value="<?php echo htmlspecialchars($class_name); ?>">

        <input type="submit" value="Update Now" name="submit" class="btn">
    </form>
</section>