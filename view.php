<?php
include("main.php");

// Assuming the student ID is passed via GET or SESSION
$student_id = $_GET['id']; // Replace with session or proper ID mechanism

// Query to fetch student details including class name
$query = "
    SELECT 
        s.name, 
        s.email, 
        s.address, 
        s.created_at, 
        s.image, 
        c.class_name 
    FROM 
        student s 
    LEFT JOIN 
        classes c 
    ON 
        s.class_id = c.class_id 
    WHERE 
        s.id = ?
";

// Prepare and execute the query
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the student exists
if ($result && $row = $result->fetch_assoc()) {
    // Set variables from the query result
    $name = $row['name'];
    $email = $row['email'];
    $address = $row['address'];
    $created_at = $row['created_at'];
    $class_name = $row['class_name'];
    $image = !empty($row['image']) ? "images/{$row['image']}" : "images/default-avatar.png"; // Fallback image
} else {
    // Redirect or show an error if the student is not found
    echo "<p>Student not found!</p>";
    exit;
}
?>

<section class="profile">
    <h1 class="heading">Profile Details</h1>
    <div class="details">
        <div class="user">
            <img src="<?php echo $image; ?>" alt="Profile Picture">
            <h3><?php echo htmlspecialchars($name); ?></h3>
            <p>Student</p>
            <a href="edit.php?id=<?php echo $student_id; ?>" class="inline-btn">Update Profile</a>
        </div>
        <div class="box-container">
            <!-- Full Name -->
            <div class="box">
                <div class="flex">
                    <i class="fa fa-user"></i>
                    <div>
                        <h3><?php echo htmlspecialchars($name); ?></h3>
                        <span>Full Name</span>
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div class="box">
                <div class="flex">
                    <i class="fa fa-envelope"></i>
                    <div>
                        <h3><?php echo htmlspecialchars($email); ?></h3>
                        <span>Email</span>
                    </div>
                </div>
            </div>

            <!-- Address -->
            <div class="box">
                <div class="flex">
                    <i class="fa fa-map-marker"></i>
                    <div>
                        <h3><?php echo htmlspecialchars($address); ?></h3>
                        <span>Address</span>
                    </div>
                </div>
            </div>

            <!-- Class Name -->
            <div class="box">
                <div class="flex">
                    <i class="fa fa-book"></i>
                    <div>
                        <h3><?php echo htmlspecialchars($class_name); ?></h3>
                        <span>Class Name</span>
                    </div>
                </div>
            </div>

            <!-- Creation Date -->
            <div class="box">
                <div class="flex">
                    <i class="fa fa-calendar"></i>
                    <div>
                        <h3><?php echo htmlspecialchars($created_at); ?></h3>
                        <span>Creation Date</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>