<?php

$conn = mysqli_connect("localhost", "root", "", "test");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$message = "";


/* CREATE QUIZ */

if (isset($_POST['create_quiz'])) {

    $title = $_POST['title'];
    $course_id = $_POST['course_id'];
    $description = $_POST['description'];

    $insert = mysqli_query(
        $conn,
        "INSERT INTO quizzes (title, course_id, description)
         VALUES ('$title', '$course_id', '$description')"
    );

    if ($insert) {
        $message = "Quiz created successfully.";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}


/* GET COURSES */

$course_result = mysqli_query(
    $conn,
    "SELECT id, course_name
     FROM courses
     ORDER BY id DESC"
);


/* GET QUIZZES */

$quiz_result = mysqli_query(
    $conn,
    "SELECT
        quizzes.id,
        quizzes.title,
        quizzes.description,
        quizzes.course_id,
        courses.course_name
     FROM quizzes
     INNER JOIN courses
        ON quizzes.course_id = courses.id
     ORDER BY quizzes.id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Instructor Quizzes</title>

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

        .form-box {
            background: white;
            padding: 25px;
            border-radius: 8px;
            max-width: 700px;
            margin-bottom: 25px;
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
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        button {
            padding: 12px 22px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .message {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .quiz-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .quiz-box h2 {
            margin-bottom: 10px;
        }

        .quiz-box p {
            margin-bottom: 8px;
            color: #555;
        }

        .add-question {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 18px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .add-question:hover {
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
   <a href="quizzes.php">
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
            Quiz Management
        </h1>

        <p>
            Create and manage quizzes for your courses
        </p>

    </div>


    <?php if ($message != "") { ?>

        <div class="message">

            <?php
            echo htmlspecialchars($message);
            ?>

        </div>

    <?php } ?>


    <!-- CREATE QUIZ -->

    <div class="form-box">

        <h2>
            Create New Quiz
        </h2>

        <br>


        <form method="POST">


            <div class="form-group">

                <label>
                    Quiz Title
                </label>

                <input
                    type="text"
                    name="title"
                    placeholder="Example: HTML Basic Quiz"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Select Course
                </label>

                <select name="course_id" required>

                    <option value="">
                        Select Course
                    </option>

                    <?php

                    while ($course = mysqli_fetch_assoc($course_result)) {

                    ?>

                        <option value="<?php echo $course['id']; ?>">

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


            <div class="form-group">

                <label>
                    Description
                </label>

                <textarea
                    name="description"
                    placeholder="Enter quiz description"
                    required
                ></textarea>

            </div>


            <button
                type="submit"
                name="create_quiz"
            >
                Create Quiz
            </button>


        </form>

    </div>


    <!-- EXISTING QUIZZES -->

    <div>

        <h2 style="margin-bottom: 15px;">
            My Quizzes
        </h2>


        <?php

        if (mysqli_num_rows($quiz_result) > 0) {

            while ($quiz = mysqli_fetch_assoc($quiz_result)) {

        ?>

                <div class="quiz-box">

                    <h2>
                        <?php
                        echo htmlspecialchars($quiz['title']);
                        ?>
                    </h2>

                    <p>

                        <strong>
                            Course:
                        </strong>

                        <?php
                        echo htmlspecialchars(
                            $quiz['course_name']
                        );
                        ?>

                    </p>

                    <p>

                        <strong>
                            Description:
                        </strong>

                        <?php
                        echo htmlspecialchars(
                            $quiz['description']
                        );
                        ?>

                    </p>


                    <a
                        href="add_question.php?quiz_id=<?php echo $quiz['id']; ?>"
                        class="add-question"
                    >
                        Add Questions
                    </a>

                </div>

        <?php

            }

        } else {

        ?>

            <div class="quiz-box">

                <h2>
                    No Quizzes Found
                </h2>

                <p>
                    Create your first quiz above.
                </p>

            </div>

        <?php

        }

        ?>

    </div>


</div>

</body>

</html>