<?php
include("main.php");

// Check if the search form was submitted and sanitize the input
$search_query = "";
if (isset($_POST['search_box'])) {
    $search_query = mysqli_real_escape_string($conn, $_POST['search_box']);
}

// Build the query for searching students
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

// Append a WHERE clause if a search query is provided
if (!empty($search_query)) {
    $query .= " WHERE s.name LIKE '%$search_query%'";
}

$result = mysqli_query($conn, $query);
?>

<section class="student-table">

    <div class="table-container">
        <h1>search student list</h1>
        <table>
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
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $imagePath = !empty($row['image']) ? "images/{$row['image']}" : "https://via.placeholder.com/50";
                        echo "<tr>
                            <td><img src='{$imagePath}' alt='Student Thumbnail' width='50'></td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['created_at']}</td>
                            <td>{$row['class_name']}</td>
                            <td style='flex-direction: column;'>
                                <a href='view.php?id={$row['id']}' class='btn table-btn'>View</a>
                                <a href='edit.php?id={$row['id']}' class='option-btn table-btn'>Update</a>
                                <a href='delete.php?id={$row['id']}' class='delete-btn table-btn'>Delete</a>
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