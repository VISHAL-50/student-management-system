<?php
include("main.php");

$student_id = $_GET['id']; // Replace with session or proper ID mechanism

// Initialize variables for the form fields
$name = $email = $address = $class = $image = "";

// Fetch current student details to pre-fill the form
$query = "SELECT * FROM student WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    $name = $row['name'];
    $email = $row['email'];
    $address = $row['address'];
    $class = $row['class_id']; // Assuming class_id contains the class ID
    $image = $row['image'];
} else {
    echo "<p>Student not found!</p>";
    exit;
}

// Fetch classes from the classes table
$classes_query = "SELECT class_id, class_name FROM classes";
$classes_result = $conn->query($classes_query);

// Handle form submission
if (isset($_POST['submit'])) {
    $updated_name = $_POST['name'];
    $updated_email = $_POST['email'];
    $updated_address = $_POST['address'];
    $updated_class = $_POST['class'];
    $updated_image = $_FILES['image'];

    // Validate image file type
    $allowed_types = ['image/jpeg', 'image/png'];
    $max_file_size = 5 * 1024 * 1024; // 5MB max file size

    $error_message = '';

    if (!empty($updated_image['name'])) {
        // Check file type
        if (!in_array($updated_image['type'], $allowed_types)) {
            $error_message = "Only PNG and JPG files are allowed.";
        }

        // Check file size
        if ($updated_image['size'] > $max_file_size) {
            $error_message = "File size must be less than 5MB.";
        }

        // If no errors, proceed with upload
        if (empty($error_message)) {
            $target_directory = "images/";

            // Generate a unique filename to prevent overwriting
            $file_extension = strtolower(pathinfo($updated_image['name'], PATHINFO_EXTENSION));
            $new_filename = uniqid() . '.' . $file_extension;
            $new_image_path = $target_directory . $new_filename;

            // Move new image to the target directory
            if (move_uploaded_file($updated_image['tmp_name'], $new_image_path)) {
                // Delete old image if it exists
                if (!empty($image) && file_exists("images/$image")) {
                    unlink("images/$image");
                }
                $image = $new_filename; // Update image field in the database
            } else {
                $error_message = "Failed to upload the image.";
            }
        }
    }

    // If no image upload errors, proceed with database update
    if (empty($error_message)) {
        // Update the database with new details
        $update_query = "
            UPDATE student 
            SET name = ?, email = ?, address = ?, class_id = ?, image = ?
            WHERE id = ?
        ";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sssssi", $updated_name, $updated_email, $updated_address, $updated_class, $image, $student_id);

        if ($stmt->execute()) {
            echo "<p>Details updated successfully!</p>";
            header("Location: index.php"); // Redirect to profile or another page
            exit;
        } else {
            $error_message = "Failed to update details.";
        }
    }
}
?>

<!-- HTML Form -->
<section class="form-container">
    <form action="" enctype="multipart/form-data" method="post">
        <h3>Edit Student Details</h3>

        <!-- Error Message Display -->
        <?php if (!empty($error_message)): ?>
            <div style="color: red; margin-bottom: 10px;"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <!-- Name -->
        <p>Your Name <span>*</span></p>
        <input type="text" name="name" placeholder="Enter your name" maxlength="100" required class="box"
            value="<?php echo htmlspecialchars($name); ?>">

        <!-- Email -->
        <p>Your Email <span>*</span></p>
        <input type="email" name="email" placeholder="Enter your email" maxlength="100" required class="box"
            value="<?php echo htmlspecialchars($email); ?>">

        <!-- Address -->
        <p>Your Address <span>*</span></p>
        <input type="text" name="address" placeholder="Enter your address" required maxlength="50" class="box"
            value="<?php echo htmlspecialchars($address); ?>">

        <!-- Class -->
        <p>Your Class <span>*</span></p>
        <select name="class" required class="box">
            <option value="" disabled>Select your class</option>
            <?php
            if ($classes_result->num_rows > 0) {
                while ($class_row = $classes_result->fetch_assoc()) {
                    $selected = $class == $class_row['class_id'] ? "selected" : "";
                    echo "<option value='{$class_row['class_id']}' $selected>{$class_row['class_name']}</option>";
                }
            } else {
                echo "<option value='' disabled>No classes available</option>";
            }
            ?>
        </select>

        <!-- Image -->
        <p>Select Pic (PNG or JPG only, max 5MB) <span>*</span></p>
        <input type="file" name="image" accept=".png,.jpg,.jpeg" class="box">
        <?php if (!empty($image)): ?>
            <p>Current Image: <img src="images/<?php echo htmlspecialchars($image); ?>" alt="Current Image" width="50"></p>
        <?php endif; ?>

        <input type="submit" value="Update Now" name="submit" class="btn">
    </form>
</section>