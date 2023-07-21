<?php
session_start();
// include('connection.php');

include('config.php');

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
    header("Location: HomePageParking.php"); // Redirect to the dashboard page
    // header('Location:' .URL. 'index.php');

    exit();
}

// Login functionality
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_email']) && isset($_POST['login_password'])) {
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    $sql = "SELECT * FROM tbl_216_users1 WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['email'] = $email;
        header("Location: HomePageParking.php"); // Redirect to the dashboard page
        exit();
    } else {
        $loginErrorMessage = "Incorrect email or password";
    }
}

// Signup functionality
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup_name']) && isset($_POST['signup_email']) && isset($_POST['signup_password'])) {
    $name = $_POST['signup_name'];
    $email = $_POST['signup_email'];
    $password = $_POST['signup_password'];
    

    // Check if the email already exists in the database
    $checkEmailQuery = "SELECT * FROM tbl_216_users1 WHERE email = '$email'";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        $signupErrorMessage = "Email already exists. Please use a different email.";
    } else {
        $role = $email==='morad@gmail.com' ? 'Admin' : 'User';
        $sql = "INSERT INTO tbl_216_users1 (name, email, password,role) VALUES ('$name', '$email', '$password','$role' )";
        if (mysqli_query($conn, $sql)) {
            $signupSuccessMessage = "Signup successful";
        } else {
            $signupErrorMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login and Signup Page</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/all.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
<a id="logo" href="index.php"></a>
<div class="container">
    <div class="card">
        <h2>Login </h2>
        <form action="index.php" method="POST">
            <label for="login_email">Email</label>
            <input type="email" id="login_email" name="login_email" placeholder="morad@gmail.com" required>

            <label for="login_password">Password</label>
            <input type="password" id="login_password" name="login_password" placeholder="morad" required>

            <button type="submit">Login</button>

            <?php if(isset($loginErrorMessage)): ?>
                <div class="error-message"><?php echo $loginErrorMessage; ?></div>
            <?php endif; ?>
        </form>
        <div class="switch">Don't have an account? <a href="#" onclick="switchCard()">Register here</a></div>
    </div>

    <div class="card" style="display: none;">
        <h2>Register Form</h2>
        <form action="index.php" method="POST">
            <label for="signup_name">Full Name</label>
            <input type="text" id="signup_name" name="signup_name" placeholder="Enter your full name" required>

            <label for="signup_email">Email</label>
            <input type="email" id="signup_email" name="signup_email" placeholder="Enter your email" required>

            <label for="signup_password">New Password</label>
            <input type="password" id="signup_password" name="signup_password" placeholder="Enter your new password" required>

            <button type="submit">Register</button>

            <?php if(isset($signupErrorMessage)): ?>
                <div class="error-message"><?php echo $signupErrorMessage; ?></div>
            <?php elseif(isset($signupSuccessMessage)): ?>
                <div class="success-message"><?php echo $signupSuccessMessage; ?></div>
            <?php endif; ?>
        </form>
        <div class="switch">Already have an account? <a href="#" onclick="switchCard()">Login here</a></div>
    </div>
</div>
<script src="js/index.js"></script>
</body>

</html>


