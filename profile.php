<?php

$conn = mysqli_connect("localhost", "root", "", "test");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$instructor_id = 1;

$result = mysqli_query(
    $conn,
    "SELECT name, email, qualification, specialization, experience, phone, bio
     FROM instructors
     WHERE id = $instructor_id"
);

if (!$result) {
    die("Profile query failed: " . mysqli_error($conn));
}

$instructor = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Instructor Profile</title>

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

        .profile-box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            max-width: 700px;
        }

        .profile-row {
            padding: 18px 0;
            border-bottom: 1px solid #ddd;
        }

        .profile-row:last-child {
            border-bottom: none;
        }

        .profile-row strong {
            display: inline-block;
            width: 120px;
        }

        .edit-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 11px 20px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .edit-btn:hover {
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

        <h1>My Profile</h1>

        <p>View your instructor information</p>

    </div>


    <div class="profile-box">

        <div class="profile-row">

            <strong>Name:</strong>

            <?php
            echo htmlspecialchars($instructor['name']);
            ?>

        </div>


        <div class="profile-row">

            <strong>Email:</strong>

            <?php
            echo htmlspecialchars($instructor['email']);
            ?>

        </div>
       <div class="profile-row">

    <strong>Qualification:</strong>

    <?php
    echo htmlspecialchars($instructor['qualification']);
    ?>

</div>


<div class="profile-row">

    <strong>Specialization:</strong>

    <?php
    echo htmlspecialchars($instructor['specialization']);
    ?>

</div>


<div class="profile-row">

    <strong>Experience:</strong>

    <?php
    echo htmlspecialchars($instructor['experience']);
    ?>

</div>


<div class="profile-row">

    <strong>Phone:</strong>

    <?php
    echo htmlspecialchars($instructor['phone']);
    ?>

</div>


<div class="profile-row">

    <strong>Bio:</strong>

    <?php
    echo htmlspecialchars($instructor['bio']);
    ?>

</div>


        <div class="profile-row">

            <strong>Role:</strong>

            Instructor

        </div>


        <a href="edit_profile.php" class="edit-btn">
            Edit Profile
        </a>

    </div>

</div>


</body>

</html>