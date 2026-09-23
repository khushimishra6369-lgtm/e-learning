<?php

$conn = mysqli_connect("localhost", "root", "", "test");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$instructor_id = 1;

$course_result = mysqli_query(
    $conn,
    "SELECT id, course_name, instructor, status
     FROM courses
     ORDER BY id DESC"
);

if (!$course_result) {
    die("Course query failed: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Courses - Instructor</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6f9;
        }

        .sidebar {
            width: 230px;
            height: 100vh;
            background: #1f2937;
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            padding: 25px 15px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 13px 15px;
            margin-bottom: 8px;
            border-radius: 6px;
        }

        .sidebar a:hover {
            background: #374151;
        }

        .main {
            margin-left: 230px;
            padding: 25px;
        }

        .topbar {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .course-box {
            background: white;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .course-box h2 {
            margin-bottom: 12px;
        }

        .course-box p {
            color: #555;
            margin-bottom: 8px;
        }

        .status {
            font-weight: bold;
        }

        .add-btn {
            display: inline-block;
            padding: 11px 20px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .add-btn:hover {
            background: #1d4ed8;
        }
        .manage-btn {
    display: inline-block;
    padding: 10px 18px;
    background: #2563eb;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    margin-top: 10px;
}

.manage-btn:hover {
    background: #1d4ed8;
}

    </style>

</head>

<body>

    <!-- SIDEBAR -->

     <div class="sidebar">

    <h2>Instructor Panel</h2>

    <a href="dashboard.php">Dashboard</a>

    <a href="courses.php">My Courses</a>

    <a href="add_material.php">Add Material</a>
    <a href="assignments.php">
    Assignments
</a>
<a href="Quizzes.php">
    Quizzes
</a>
    <a href="students.php">Students</a>

    <a href="profile.php">Profile</a>

    <a href="edit_profile.php">Edit Profile</a>

    <a href="../index.php">Logout</a>

</div>


    <!-- MAIN -->

    <div class="main">

        <div class="topbar">

            <h1>My Courses</h1>

            <p>Manage your courses</p>

</div>


        <?php

        if (mysqli_num_rows($course_result) > 0) {

            while ($course = mysqli_fetch_assoc($course_result)) {

        ?>

                <div class="course-box">

                    <h2>
                        <?php
                        echo htmlspecialchars($course['course_name']);
                        ?>
                    </h2>

                    <p>
                        <strong>Instructor:</strong>
                        <?php
                        echo htmlspecialchars($course['instructor']);
                        ?>
                    </p>

                    <p class="status">
                        <strong>Status:</strong>
                        <?php
                        echo htmlspecialchars($course['status']);
                        ?>
                    </p>
                    <a href="course_content.php?id=<?php echo $course['id']; ?>" class="manage-btn">
    Manage Course
</a>

                </div>

        <?php

            }

        } else {

        ?>

            <div class="course-box">

                <h2>No Courses Available</h2>

                <p>
                    Your courses will appear here after you add them.
                </p>

            </div>

        <?php

        }

        ?>

    </div>

</body>

</html>