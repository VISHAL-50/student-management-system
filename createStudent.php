<?php
include("main.php"); // Include your database connection file

// Handle form submission
if (isset($_POST['submit'])) {
    // Image validation
    $allowed_types = ['image/jpeg', 'image/png'];
    $max_file_size = 5 * 1024 * 1024; // 5MB max file size
    $error_message = '';

    // Validate image file
    if (!empty($_FILES['image']['name'])) {
        $image_type = $_FILES['image']['type'];
        $image_size = $_FILES['image']['size'];

        // Check file type
        if (!in_array($image_type, $allowed_types)) {
            $error_message = "Only PNG and JPG files are allowed.";
        }

        // Check file size
        if ($image_size > $max_file_size) {
            $error_message = "File size must be less than 5MB.";
        }
    }

    // If no image errors, proceed with registration
    if (empty($error_message)) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $class_id = mysqli_real_escape_string($conn, $_POST['class']);

        // Generate unique filename
        $image_name = $_FILES['image']['name'];
        $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $unique_filename = uniqid() . '.' . $file_extension;
        $image_folder = 'images/' . $unique_filename;

        // Move uploaded image to the images folder
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_folder)) {
            // Insert data into the database
            $query = "INSERT INTO student (name, email, address, class_id, image) VALUES ('$name', '$email', '$address', '$class_id', '$unique_filename')";

            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Student registered successfully!');</script>";
                header("Location:index.php");
                exit;
            } else {
                // If database insertion fails, remove the uploaded image
                if (file_exists($image_folder)) {
                    unlink($image_folder);
                }
                $error_message = "Failed to register student.";
            }
        } else {
            $error_message = "Failed to upload image.";
        }
    }
}

// Fetch classes from the database for the dropdown
$class_query = "SELECT class_id, class_name FROM classes";
$class_result = mysqli_query($conn, $class_query);
?>

<!-- HTML Form -->
<section class="form-container">
    <form action="" enctype="multipart/form-data" method="post">
        <h3>register student</h3>

        <!-- Error Message Display -->
        <?php if (!empty($error_message)): ?>
            <div style="color: red; margin-bottom: 10px;"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <p>your name <span>*</span></p>
        <input type="text" name="name" placeholder="enter your name" maxlength="100" required class="box">

        <p>your email <span>*</span></p>
        <input type="email" name="email" placeholder="enter your email" required class="box">

        <p>your address <span>*</span></p>
        <input type="text" name="address" placeholder="enter your address" required maxlength="255" class="box">

        <p>your class <span>*</span></p>
        <select name="class" required class="box">
            <option value="" disabled selected>Select your class</option>
            <?php
            if (mysqli_num_rows($class_result) > 0) {
                while ($row = mysqli_fetch_assoc($class_result)) {
                    echo "<option value='" . $row['class_id'] . "'>" . $row['class_name'] . "</option>";
                }
            } else {
                echo "<option value='' disabled>No classes available</option>";
            }
            ?>
        </select>

        <p>select pic (PNG or JPG only, max 5MB) <span>*</span></p>
        <input type="file" name="image" accept=".png,.jpg,.jpeg" required class="box">

        <input type="submit" value="register now" name="submit" class="btn">
    </form>
</section>