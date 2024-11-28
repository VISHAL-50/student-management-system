<?php
include("main.php");

// Handle form submission to add a new class
if (isset($_POST['create_class'])) {
    $class_name = mysqli_real_escape_string($conn, $_POST['class_name']);

    if (!empty($class_name)) {
        // Insert the new class into the database
        $query = "INSERT INTO classes (class_name, created_at) VALUES ('$class_name', NOW())";

        if (mysqli_query($conn, $query)) {
            header("Location:classes.php");

        } else {
            echo "<script>alert('Failed to create class.');</script>";
        }
    } else {
        echo "<script>alert('Please enter a class name.');</script>";
    }
}
?>

<section class="create-class">
    <!-- New Class Form -->
    <div class="create-class-form">
        <form action="" method="post" class="create-form">
            <div class="form-row" style="
    display: flex;
    justify-content: center;
    align-items: baseline;
    gap: 1rem;
">
                <input type="text" name="class_name" placeholder="Enter class name" required="" class="box">
                <input type="submit" value="Create" name="create_class" class="btn create-btn">
            </div>
        </form>
    </div>
</section>

<section class="class-table">
    <div class="table-container">
        <h1>Class List</h1>


        <!-- Class Table -->
        <table id="classTable">
            <thead>
                <tr>
                    <th>Class ID</th>
                    <th>Class Name</th>
                    <th>Creation Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query to fetch class details
                $query = "SELECT class_id, class_name, created_at FROM classes";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$row['class_id']}</td>
                            <td>{$row['class_name']}</td>
                            <td>{$row['created_at']}</td>
                            <td>
                                <a href='editClasses.php?id={$row['class_id']}' class='option-btn table-btn'>Update</a>
                                <a href='delete_class.php?id={$row['class_id']}' class='delete-btn table-btn' data-id='{$row['class_id']}'>Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No classes found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</section>