<?php
// ratings.php

include('config.php');

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php"); // Redirect to the sign-in page
    exit();
}

// Sign out functionality
if (isset($_POST['signout'])) {
    // Clear session data
    session_unset();
    session_destroy();

    header("Location: index.php"); // Redirect to the sign-in page after signing out
    exit();
}

$email = $_SESSION['email'];

// Retrieve the user's name from tbl_216_users1
$query = "SELECT name, role FROM tbl_216_users1 WHERE email = '$email'";
$result = mysqli_query($conn, $query);

// Check if the query was successful and a row was returned
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $userName = $row['name'];
    $userRole = $row['role'];
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the data from tbl_216_aps for the specific ID
    $query = "SELECT * FROM tbl_216_aps WHERE id = $id";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful and a row was returned
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $country = $row['country'];
        $city = $row['city'];
        $streetNumber = $row['streetNumber'];
        $size = $row['size'];
        $howToGetIn = $row['howToGetIn'];
        $reservationDate = $row['reservationDate'];
        $startHour = $row['startHour'];
        $endHour = $row['endHour'];
    }
}

// Retrieve all ratings for the object
$query = "SELECT user_email, rating FROM tbl_216_rating1 WHERE object_id = $id";
$result = mysqli_query($conn, $query);

$ratings = array(); // Array to store ratings

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $userEmail = $row['user_email'];
        $rating = $row['rating'];

        $ratings[] = array(
            'userEmail' => $userEmail,
            'rating' => $rating
        );
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>Ratings</title>
</head>
<body>
    
    <div class="container">
        <h1 class="mt-4">Ratings</h1>

        <?php if (count($ratings) > 0) : ?>
            <h2 class="mt-4">Object Ratings</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>User Email</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ratings as $rating) : ?>
                        <tr>
                            <td><?php echo $rating['userEmail']; ?></td>
                            <td><?php echo $rating['rating']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No ratings available for this object.</p>
        <?php endif; ?>
        <a href="index.php"> back to main page</a>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
