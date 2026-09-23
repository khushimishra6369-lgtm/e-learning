<?php

$conn = mysqli_connect("localhost", "root", "", "test");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


/* Get Students and Course Details */

$result = mysqli_query(
    $conn,
    "SELECT
        students.name,
students.email,
students.mobile,
students.address,
courses.course_name
     FROM enrollments
     INNER JOIN students
        ON enrollments.student_id = students.id
     INNER JOIN courses
        ON enrollments.course_id = courses.id
     ORDER BY enrollments.id DESC"
);

if (!$result) {
    die("Student query failed: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Students - Instructor Panel</title>

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

        .students-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #f3f4f6;
        }

        .progress {
            font-weight: bold;
        }

        .no-student {
            padding: 20px;
            text-align: center;
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

    <a href="../index.php">
        Logout
    </a>

</div>


<!-- MAIN -->

<div class="main">


    <div class="topbar">

        <h1>
            Students
        </h1>

        <p>
            Students enrolled in courses
        </p>

    </div>


    <div class="students-box">

        <?php

        if (mysqli_num_rows($result) > 0) {

        ?>

            <table>

                <thead>

                    <tr>

                        <th>Student Name</th>
<th>Email</th>

<th>mobile</th>
<th>Address</th>
<th>Course</th>
<th>Progress</th>

                    </tr>

                </thead>


                <tbody>

                <?php

                while ($student = mysqli_fetch_assoc($result)) {

                ?>

                    <tr>

                        <td>
                            <?php
                            echo htmlspecialchars($student['name']);
                            ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars($student['email']);
                            ?>
                        </td>
                        <td>
    <?php echo htmlspecialchars($student['mobile']); ?>
</td>

<td>
    <?php echo htmlspecialchars($student['address']); ?>
</td>

                        <td>
                            <?php
                            echo htmlspecialchars($student['course_name']);
                            ?>
                        </td>

                        <td>

                            <span class="progress">
                                0%
                            </span>


                        </td>

                    </tr>

                <?php

                }

                ?>

                </tbody>

            </table>

        <?php

        } else {

        ?>

            <div class="no-student">

                <h2>
                    No Students Found
                </h2>

                <p>
                    No students are enrolled in any course yet.
                </p>

            </div>

        <?php

        }

        ?>

    </div>


</div>


</body>

</html>