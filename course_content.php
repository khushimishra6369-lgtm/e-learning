<?php

$conn = mysqli_connect("localhost", "root", "", "test");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['id'])) {
    die("Course not found.");
}

$course_id = (int) $_GET['id'];

$course_result = mysqli_query(
    $conn,
    "SELECT * FROM courses WHERE id = $course_id"
);

if (!$course_result || mysqli_num_rows($course_result) == 0) {
    die("Course not found.");
}

$course = mysqli_fetch_assoc($course_result);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Course Content - Instructor</title>

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
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .topbar h1 {
            margin-bottom: 8px;
        }

        .topbar p {
            color: #666;
        }

        .content-box {
            background: white;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .content-box h2 {
            margin-bottom: 15px;
        }

        .content-item {
            border: 1px solid #ddd;
            padding: 18px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .content-item h3 {
            margin-bottom: 8px;
        }

        .content-item p {
            color: #666;
            margin-bottom: 12px;
        }

        .btn {
            display: inline-block;
            padding: 9px 15px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 8px;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .back-btn {
            display: inline-block;
            margin-top: 10px;
            color: #2563eb;
            text-decoration: none;
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

        <a href="assignments.php">Assignments</a>

        <a href="quizzes.php">Quizzes</a>

        <a href="students.php">Students</a>

        <a href="profile.php">Profile</a>

        <a href="edit_profile.php">Edit Profile</a>

        <a href="../index.php">Logout</a>

    </div>


    <!-- MAIN -->

    <div class="main">

        <div class="topbar">

            <h1>
                <?php echo htmlspecialchars($course['course_name']); ?>
            </h1>

            <p>
                Manage your course content and learning materials.
            </p>

        </div>


        <!-- COURSE CONTENT -->

        <div class="content-box">

            <h2>Course Content</h2>

            <div class="content-item">

                <h3>📹 Videos</h3>

                <p>
                    Add and manage video lessons for this course.
                </p>

                <a href="add_material.php" class="btn">
                    + Add Video
                </a>

            </div>


            <div class="content-item">

                <h3>📄 PDF / Notes</h3>

                <p>
                    Upload PDF notes and study materials.
                </p>

                <a href="add_material.php" class="btn">
                    + Add PDF
                </a>

            </div>


            <div class="content-item">

                <h3>📝 Quizzes</h3>

                <p>
                    Create quizzes for students.
                </p>

                <a href="quizzes.php" class="btn">
                    + Add Quiz
                </a>

            </div>


            <div class="content-item">

                <h3>📋 Assignments</h3>

                <p>
                    Create assignments for students.
                </p>

                <a href="assignments.php" class="btn">
                    + Add Assignment
                </a>

            </div>

        </div>


        <a href="courses.php" class="back-btn">
            ← Back to My Courses
        </a>

    </div>

</body>

</html>