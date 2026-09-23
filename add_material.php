<?php

$conn = mysqli_connect("localhost", "root", "", "test");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$message = "";


/* Get Courses */

$course_result = mysqli_query(
    $conn,
    "SELECT id, course_name FROM courses ORDER BY id DESC"
);

if (!$course_result) {
    die("Course query failed: " . mysqli_error($conn));
}


/* Upload Material */

if (isset($_POST['upload_material'])) {

    $course_id = $_POST['course_id'];
    $title = $_POST['title'];

    if (
        isset($_FILES['material_file']) &&
        $_FILES['material_file']['error'] == 0
    ) {

        $file_name = $_FILES['material_file']['name'];
        $tmp_name = $_FILES['material_file']['tmp_name'];

        $extension = strtolower(
            pathinfo($file_name, PATHINFO_EXTENSION)
        );


        /* Automatically Detect File Type */

        if ($extension == "pdf") {

            $type = "PDF";

        } elseif (
            $extension == "mp4" ||
            $extension == "webm" ||
            $extension == "ogg"
        ) {

            $type = "VIDEO";

        } else {

            $message = "Only PDF or Video files are allowed.";

        }


        if (isset($type)) {

            /* Create uploads folder */

            $upload_folder = "../uploads/";

            if (!is_dir($upload_folder)) {
                mkdir($upload_folder, 0777, true);
            }


            /* Create New File Name */

            $new_name = time() . "_" . basename($file_name);

            $file_path = $upload_folder . $new_name;


            /* Move File */

            if (move_uploaded_file($tmp_name, $file_path)) {

                $database_path = "uploads/" . $new_name;


                /* Save in Database */

                $insert = mysqli_query(
                    $conn,
                    "INSERT INTO course_materials
                    (course_id, title, type, file_path)
                    VALUES
                    ('$course_id', '$title', '$type', '$database_path')"
                );


                if ($insert) {

                    $message = "Material uploaded successfully.";

                } else {

                    $message = "Database error: " . mysqli_error($conn);

                }

            } else {

                $message = "File upload failed.";

            }

        }

    } else {

        $message = "Please select a file.";

    }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Course Material</title>


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


/* Sidebar */

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


/* Main */

.main {
    margin-left: 230px;
    padding: 25px;
}


/* Topbar */

.topbar {
    background: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 25px;
}

.topbar h1 {
    margin-bottom: 8px;
}


/* Form */

.form-box {
    background: white;
    padding: 25px;
    border-radius: 8px;
    max-width: 700px;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

input,
select {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 5px;
}


/* Button */

button {
    padding: 12px 22px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 15px;
}

button:hover {
    background: #1d4ed8;
}


/* Message */

.message {
    background: #dcfce7;
    color: #166534;
    padding: 12px;
    margin-bottom: 20px;
    border-radius: 5px;
}

</style>

</head>


<body>


<!-- Sidebar -->

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
    <a href="logout.php">
        Logout
    </a>

</div>


<!-- Main -->

<div class="main">


    <div class="topbar">

        <h1>Add Course Material</h1>

        <p>Upload videos and PDF study materials</p>

    </div>


    <div class="form-box">


        <?php if ($message != "") { ?>

            <div class="message">

                <?php echo htmlspecialchars($message); ?>

            </div>

        <?php } ?>


        <form
            method="POST"
            enctype="multipart/form-data"
        >


            <!-- Select Course -->

            <div class="form-group">

                <label>Select Course</label>

                <select
                    name="course_id"
                    required
                >

                    <option value="">
                        Select Course
                    </option>


                    <?php

                    while (
                        $course =
                        mysqli_fetch_assoc($course_result)
                    ) {

                    ?>

                        <option
                            value="<?php echo $course['id']; ?>"
                        >

                            <?php
                            echo htmlspecialchars(
                                $course['course_name']
                            );
                            ?>

                        </option>

                    <?php

                    }

                    ?>

                </select>

            </div>


            <!-- Material Title -->

            <div class="form-group">

                <label>Material Title</label>

                <input
                    type="text"
                    name="title"
                    placeholder="Example: HTML Introduction"
                    required
                >

            </div>


            <!-- File -->

            <div class="form-group">

                <label>Select PDF or Video</label>

                <input
                    type="file"
                    name="material_file"
                    accept=".pdf,.mp4,.webm,.ogg"
                    required
                >

            </div>


            <!-- Button -->

            <button
                type="submit"
                name="upload_material"
            >
                Upload Material
            </button>


        </form>


    </div>

</div>


</body>

</html>