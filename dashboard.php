<?php
session_start();

if (!isset($_SESSION['instructor_id'])) {
    header("Location: login.php");
    exit();
}
$conn = mysqli_connect("localhost", "root", "", "test");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$instructor_id = 1;


/* Instructor Information */

$instructor_result = mysqli_query(
    $conn,
    "SELECT name, email
     FROM instructors
     WHERE id = $instructor_id"
);

if (!$instructor_result) {
    die("Instructor query failed: " . mysqli_error($conn));
}

$instructor = mysqli_fetch_assoc($instructor_result);


/* Total Courses */

$course_result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM courses"
);

if (!$course_result) {
    die("Course query failed: " . mysqli_error($conn));
}

$course_data = mysqli_fetch_assoc($course_result);

$total_courses = $course_data['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Instructor Dashboard - E-Learning</title>

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

        /* SIDEBAR */

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

        /* MAIN */

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

        .topbar h1 {
            margin-bottom: 5px;
        }

        /* CARDS */

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .card h3 {
            color: #555;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 28px;
            font-weight: bold;
        }

        /* QUICK ACTIONS */

        .quick-actions {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 25px;
        }

        .quick-actions h2 {
            margin-bottom: 15px;
        }

        .quick-actions a {
            display: inline-block;
            padding: 12px 22px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-right: 15px;
            margin-bottom: 12px;
        }

        .quick-actions a:hover {
            background: #1d4ed8;
        }

    </style>

</head>

<body>


<!-- SIDEBAR -->

<div class="sidebar">

    <h2>Instructor Panel</h2>

    <a href="dashboard.php">
        Dashboard
    </a>

    <a href="courses.php">
        My Courses
    </a>

    <a href="add_material.php">
        Add Material
    </a>
    <a href="assignments.php">
    Assignments
</a>
<a href="Quizzes.php">
    Quizzes
</a>

    <a href="students.php">
        Students
    </a>

    <a href="profile.php">
        Profile
    </a>

    <a href="edit_profile.php">
        Edit Profile
    </a>

    <a href="http://localhost/e_learning/instructor/logout.php">Logout</a>
</div>


<!-- MAIN -->

<div class="main">


    <!-- TOP BAR -->

    <div class="topbar">

        <h1>
            Instructor Dashboard
        </h1>

        <p>
            Welcome,
            <?php echo htmlspecialchars($instructor['name']); ?>
        </p>

    </div>


    <!-- CARDS -->

    <div class="cards">


        <div class="card">

            <h3>
                My Courses
            </h3>

            <p>
                <?php echo $total_courses; ?>
            </p>

        </div>


        <div class="card">

            <h3>
                Total Students
            </h3>

            <p>
                0
            </p>

        </div>


        <div class="card">

            <h3>
                Total Quizzes
            </h3>

            <p>
                0
            </p>

        </div>


    </div>


    <!-- QUICK ACTIONS -->

    <div class="quick-actions">

        <h2>
            Quick Actions
        </h2>

        <a href="courses.php">
            My Courses
        </a>

        <a href="add_material.php">
            Add Material
        </a>

        <a href="students.php">
            Students
        </a>

    </div>


</div>


</body>

</html>