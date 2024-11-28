<?php
include("main.php");
?>

<section class="student-table">
    <div class="table-container">
        <h1>Student List</h1>
        <table id="studentTable">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Creation Date</th>
                    <th>Class Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Your existing query code remains the same
                $query = "
                    SELECT 
                        s.id, 
                        s.name, 
                        s.email, 
                        s.created_at, 
                        c.class_name, 
                        s.image 
                    FROM 
                        student s 
                    LEFT JOIN 
                        classes c 
                    ON 
                        s.class_id = c.class_id
                ";

                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $imagePath = !empty($row['image']) ? "images/{$row['image']}" : "https://via.placeholder.com/50";
                        echo "<tr>
                            <td><img src='{$imagePath}' alt='Student Thumbnail' width='50'></td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['created_at']}</td>
                            <td>{$row['class_name']}</td>
                            <td>
                                <a href='view.php?id={$row['id']}' class='btn table-btn'>View</a>
                                <a href='edit.php?id={$row['id']}' class='option-btn table-btn'>Update</a>
                                <a href='delete.php?id={$row['id']}' class='delete-btn table-btn' data-id='{$row['id']}'>Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr>
                        <td colspan='6'>No students found</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</section>