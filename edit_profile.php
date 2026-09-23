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

$instructor_id = $_SESSION['instructor_id'];

$message = "";

$result = mysqli_query(
    $conn,
    "SELECT name, email, phone, qualification, specialization, experience, bio
     FROM instructors
     WHERE id = $instructor_id"
);

$instructor = mysqli_fetch_assoc($result);


if (isset($_POST['update_profile'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $qualification = $_POST['qualification'];
    $specialization = $_POST['specialization'];
    $experience = $_POST['experience'];
    $bio = $_POST['bio'];

    $insert = mysqli_query(
        $conn,
        "INSERT INTO instructor_profile_requests
        (instructor_id, name, email, phone, qualification,
         specialization, experience, bio, status)
        VALUES
        (
            $instructor_id,
            '$name',
            '$email',
            '$phone',
            '$qualification',
            '$specialization',
            '$experience',
            '$bio',
            'Pending'
        )"
    );

    if ($insert) {
        $message = "Profile changes submitted successfully. Waiting for Admin approval.";
    } else {
        $message = "Something went wrong: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Profile - Instructor</title>

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
    padding: 30px;
}

.form-box {
    background: white;
    padding: 30px;
    border-radius: 8px;
    max-width: 800px;
}

.form-box h1 {
    margin-bottom: 10px;
}

.form-box p {
    color: #666;
    margin-bottom: 25px;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    margin-bottom: 7px;
    font-weight: bold;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 11px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.form-group textarea {
    height: 100px;
    resize: vertical;
}

.update-btn {
    background: #2563eb;
    color: white;
    border: none;
    padding: 11px 20px;
    border-radius: 6px;
    cursor: pointer;
}

.update-btn:hover {
    background: #1d4ed8;
}

.message {
    background: #dcfce7;
    color: #166534;
    padding: 12px;
    border-radius: 5px;
    margin-bottom: 20px;
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

    <a href="logout.php">Logout</a>

</div>


<!-- MAIN -->

<div class="main">

    <div class="form-box">

        <h1>Edit Profile</h1>

        <p>
            Update your profile information. Changes require Admin approval.
        </p>


        <?php if ($message != "") { ?>

            <div class="message">
                <?php echo htmlspecialchars($message); ?>
            </div>

        <?php } ?>


        <form method="POST">

            <div class="form-group">

                <label>Name</label>

                <input
                    type="text"
                    name="name"
                    value="<?php echo htmlspecialchars($instructor['name']); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    value="<?php echo htmlspecialchars($instructor['email']); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>Phone</label>

                <input
                    type="text"
                    name="phone"
                    value="<?php echo htmlspecialchars($instructor['phone']); ?>"
                >

            </div>


            <div class="form-group">

                <label>Qualification</label>

                <input
                    type="text"
                    name="qualification"
                    value="<?php echo htmlspecialchars($instructor['qualification']); ?>"
                >

            </div>


            <div class="form-group">

                <label>Specialization</label>

                <input
                    type="text"
                    name="specialization"
                    value="<?php echo htmlspecialchars($instructor['specialization']); ?>"
                >

            </div>


            <div class="form-group">

                <label>Experience</label>

                <input
                    type="text"
                    name="experience"
                    value="<?php echo htmlspecialchars($instructor['experience']); ?>"
                >

            </div>


            <div class="form-group">

                <label>Bio</label>

                <textarea name="bio"><?php echo htmlspecialchars($instructor['bio']); ?></textarea>

            </div>


            <button type="submit" name="update_profile" class="update-btn">
                Submit for Approval
            </button>

        </form>

    </div>

</div>

</body>

</html>