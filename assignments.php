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

$message = "";

/* ADD ASSIGNMENT */

if (isset($_POST['add_assignment'])) {

    $title = $_POST['title'];
    $course_id = $_POST['course_id'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $marks = $_POST['marks'];
    $status = $_POST['status'];

    $query = "INSERT INTO assignments
              (title, course_id, description, due_date, marks, status)
              VALUES
              ('$title', '$course_id', '$description', '$due_date', '$marks', '$status')";

    if (mysqli_query($conn, $query)) {
        $message = "Assignment added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}


/* DELETE ASSIGNMENT */

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    mysqli_query(
        $conn,
        "DELETE FROM assignments WHERE id = $id"
    );

    header("Location: assignments.php");
    exit();
}


/* GET COURSES */

$courses = mysqli_query(
    $conn,
    "SELECT id, course_name
     FROM courses
     ORDER BY course_name ASC"
);


/* GET ASSIGNMENTS */

$assignments = mysqli_query(
    $conn,
    "SELECT assignments.*, courses.course_name
     FROM assignments
     LEFT JOIN courses
     ON assignments.course_id = courses.id
     ORDER BY assignments.id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Instructor Assignments</title>

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
            position: fixed;
            left: 0;
            top: 0;
            background: #1f2937;
            padding: 25px 15px;
        }

        .sidebar h2 {
            color: white;
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

        .sidebar .active {
            background: #2563eb;
        }

        /* MAIN */

        .main {
            margin-left: 230px;
            padding: 30px;
        }

        .topbar {
            background: white;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .topbar h1 {
            color: #1f2937;
            margin-bottom: 8px;
        }

        .topbar p {
            color: #666;
        }

        /* FORM */

        .form-box {
            background: white;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 25px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }

        .form-box h2 {
            margin-bottom: 20px;
            color: #1f2937;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            color: #444;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group textarea {
            height: 100px;
            resize: vertical;
        }

        .add-btn {
            background: #2563eb;
            color: white;
            border: none;
            padding: 11px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
        }

        .add-btn:hover {
            background: #1d4ed8;
        }

        .message {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        /* TABLE */

        .table-box {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }

        .table-box h2 {
            margin-bottom: 20px;
            color: #1f2937;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f3f4f6;
            padding: 13px;
            text-align: left;
            border-bottom: 2px solid #ddd;
        }

        td {
            padding: 13px;
            border-bottom: 1px solid #ddd;
            color: #555;
        }

        .status {
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: bold;
        }

        .active {
            background: #dcfce7;
            color: #166534;
        }

        .closed {
            background: #fee2e2;
            color: #991b1b;
        }

        .delete-btn {
            background: #dc2626;
            color: white;
            text-decoration: none;
            padding: 7px 12px;
            border-radius: 5px;
        }

        .delete-btn:hover {
            background: #b91c1c;
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

    <a href="logout.php">
        Logout
    </a>

</div>


<!-- MAIN -->

<div class="main">


    <!-- TOP -->

    <div class="topbar">

        <h1>Assignments</h1>

        <p>
            Create and manage course assignments
        </p>

    </div>


    <!-- MESSAGE -->

    <?php if ($message != "") { ?>

        <div class="message">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php } ?>


    <!-- ADD ASSIGNMENT -->

    <div class="form-box">

        <h2>Add New Assignment</h2>

        <form method="POST">


            <div class="form-group">

                <label>Assignment Title</label>

                <input
                    type="text"
                    name="title"
                    placeholder="Enter assignment title"
                    required
                >

            </div>


            <div class="form-group">

                <label>Course</label>

                <select name="course_id" required>

                    <option value="">
                        Select Course
                    </option>

                    <?php

                    while ($course = mysqli_fetch_assoc($courses)) {

                    ?>

                        <option value="<?php echo $course['id']; ?>">

                            <?php
                            echo htmlspecialchars(
                                $course['course_name']
                            );
                            ?>

                        </option>

                    <?php } ?>

                </select>

            </div>


            <div class="form-group">

                <label>Description</label>

                <textarea
                    name="description"
                    placeholder="Enter assignment instructions"
                    required
                ></textarea>

            </div>


            <div class="form-group">

                <label>Due Date</label>

                <input
                    type="date"
                    name="due_date"
                    required
                >

            </div>


            <div class="form-group">

                <label>Total Marks</label>

                <input
                    type="number"
                    name="marks"
                    placeholder="Enter total marks"
                    min="1"
                    required
                >

            </div>


            <div class="form-group">

                <label>Status</label>

                <select name="status">

                    <option value="Active">
                        Active
                    </option>

                    <option value="Closed">
                        Closed
                    </option>

                </select>

            </div>


            <button
                type="submit"
                name="add_assignment"
                class="add-btn"
            >
                Add Assignment
            </button>


        </form>

    </div>


    <!-- ASSIGNMENT LIST -->

    <div class="table-box">

        <h2>All Assignments</h2>


        <table>

            <thead>

                <tr>

                    <th>Assignment</th>
                    <th>Course</th>
                    <th>Due Date</th>
                    <th>Marks</th>
                    <th>Status</th>
                    <th>Action</th>

                </tr>

            </thead>


            <tbody>

            <?php

            if (mysqli_num_rows($assignments) > 0) {

                while ($row = mysqli_fetch_assoc($assignments)) {

            ?>

                <tr>

                    <td>
                        <?php
                        echo htmlspecialchars($row['title']);
                        ?>
                    </td>

                    <td>
                        <?php
                        echo htmlspecialchars(
                            $row['course_name']
                        );
                        ?>
                    </td>

                    <td>
                        <?php
                        echo htmlspecialchars(
                            $row['due_date']
                        );
                        ?>
                    </td>

                    <td>
                        <?php
                        echo htmlspecialchars(
                            $row['marks']
                        );
                        ?>
                    </td>

                    <td>

                        <?php if ($row['status'] == 'Active') { ?>

                            <span class="status active">
                                Active
                            </span>

                        <?php } else { ?>

                            <span class="status closed">
                                Closed
                            </span>

                        <?php } ?>

                    </td>

                    <td>

                        <a
                            href="assignments.php?delete=<?php echo $row['id']; ?>"
                            class="delete-btn"
                            onclick="return confirm('Are you sure you want to delete this assignment?');"
                        >
                            Delete
                        </a>

                    </td>

                </tr>

            <?php

                }

            } else {

            ?>

                <tr>

                    <td colspan="6" style="text-align:center;">
                        No assignments available.
                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>


</div>


</body>

</html>