<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "test");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$message = "";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = mysqli_query(
        $conn,
        "SELECT * FROM instructors
         WHERE email = '$email'
         AND password = '$password'"
    );

    if (mysqli_num_rows($result) == 1) {

        $instructor = mysqli_fetch_assoc($result);

        $_SESSION['instructor_id'] = $instructor['id'];
        $_SESSION['instructor_name'] = $instructor['name'];
        $_SESSION['instructor_email'] = $instructor['email'];

        header("Location: dashboard.php");
        exit();

    } else {

        $message = "Invalid email or password.";

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Login - E-Learning</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-box {
            background: white;
            width: 400px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .login-box h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #1f2937;
        }

        .login-box p {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #1d4ed8;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="login-box">

        <h1>Instructor Login</h1>

        <p>Login to access Instructor Panel</p>

        <?php if ($message != "") { ?>
            <div class="error">
                <?php echo $message; ?>
            </div>
        <?php } ?>

        <form method="POST">

            <div class="form-group">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    placeholder="Enter instructor email"
                    required
                >
            </div>

            <div class="form-group">
                <label>Password</label>
                <input
                    type="password"
                    name="password"
                    placeholder="Enter password"
                    required
                >
            </div>

            <button type="submit" name="login">
                Login
            </button>

        </form>

    </div>

</body>
</html>