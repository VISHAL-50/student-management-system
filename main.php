<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bitter&family=Questrial&family=Scope+One&display=swap"
        rel="stylesheet">
</head>

<body>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Add event listener to all delete buttons
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    // Prevent the default action (navigate to delete.php)
                    event.preventDefault();

                    // Get the delete URL from the href attribute
                    const deleteUrl = this.getAttribute('href');

                    // Show a confirmation dialog
                    if (confirm('Are you sure you want to delete this ?')) {
                        // If the user clicks "OK", navigate to the delete.php with the correct id
                        window.location.href = deleteUrl;
                    }
                });
            });
        });
    </script>
    <?php include("config.php") ?>

    <!-- header section start here -->
    <div class="header">
        <section class="flex">
            <a href="index.html" class="logo">Educase India</a>
            <form action="search.php" method="post" class="search-form">
                <input type="text" name="search_box" placeholder="Search students by name..." class="sea" required
                    maxlength="100">
                <button type="submit" class="fa fa-search" name="search"> </button>
            </form>

            <div class="icons">
                <div id="menu-btn" class="fas fa-bars"></div>
                <div id="search-btn" class="fas fa-search"></div>
                <div id="toggle-btn" class="fas fa-sun"></div>


            </div>


        </section>
    </div>




    <!-- header section end here -->

    <!-- sidebar section starts -->

    <div class="side-bar">
        <div class="close-side-bar">
            <i class="fas fa-times"></i>
        </div>
        <div class="profile">
            <!-- <img src="images/pic-1.jpg" alt=""> -->


        </div>
        <nav class="navbar">
            <a href="index.php"><i class="fas fa-home"></i><span>home</span></a>
            <a href="createStudent.php"><i class="fas fa-graduation-cap"></i><span>create students</span></a>
            <a href="classes.php"><i class="fas fa-plus"></i><span>create classes</span></a>


            <!-- <a href="courses.html"><i class="fas fa-graduation-cap"></i><span>courses</span></a>
        <a href="teachers.html"><i class="fas fa-chalkboard-user"></i><span>teachers</span></a>
        <a href="contact.html"><i class="fas fa-headset"></i><span>contact us</span></a> -->

        </nav>
    </div>
    <script src="script.js"></script>