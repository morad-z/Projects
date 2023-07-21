
<!DOCTYPE html>
<html> <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/all.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384- 9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5JvoRxTsoB1TGf 0 bubble 1QofQ" crossorigin="anonymous" />
    <!-- //link to javascript file by cdn   -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
    <!-- import bree serif font from google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&display=swap" rel="stylesheet" />
    <title>Form</title>
  </head>
  <body>
    <header class="header_index">
      <a id="logo" href="index.php"></a>
    <div class="form-check form-switch">
      <input class="form-check-input" type="checkbox" role="switch" id="darkModeSwitch">
      <label class="form-check-label" for="darkModeSwitch">Dark Mode</label>
    </div>
    <section class="user">
      <section class="elipse"></section>
      <svg id="notificationIcon" xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
        class="bi bi-bell" viewBox="0 0 16 16">
        <path
          d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
      </svg>
      <img class="profileImage" src="../images/profile_mobile.jpg" alt="">
    </section>
    </header>
    
    <?php
    include('../config.php');

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
$query = "SELECT name FROM tbl_216_users1 WHERE email = '$email'";
$result = mysqli_query($conn, $query);

// Check if the query was successful and a row was returned
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $userName = $row['name'];
}

// Retrieve form data
$country = mysqli_real_escape_string($conn, $_POST['country']);
$city = mysqli_real_escape_string($conn, $_POST['city']);
$streetNumber = mysqli_real_escape_string($conn, $_POST['streetNumber']);
$size = mysqli_real_escape_string($conn, $_POST['size']);
$howToGetIn = mysqli_real_escape_string($conn, $_POST['howToGetIn']);
$reservationDate = mysqli_real_escape_string($conn, $_POST['reservationDate']);
$startHour = mysqli_real_escape_string($conn, $_POST['startHour']);
$endHour = mysqli_real_escape_string($conn, $_POST['endHour']);

// Get the user's ID based on the email
$email = $_SESSION['email'];
$query = "SELECT id FROM tbl_216_users1 WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $userId = $row['id'];

    // Insert form data into the database with the user's ID
    $sql = "INSERT INTO tbl_216_aps (country, city, streetNumber, size, howToGetIn, reservationDate, startHour, endHour, user_id)
            VALUES ('$country', '$city', '$streetNumber', '$size', '$howToGetIn', '$reservationDate', '$startHour', '$endHour', '$userId')";

    if (mysqli_query($conn, $sql)) {
        echo "Data inserted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Error: User not found.";
}

// Close the database connection
mysqli_close($conn);
?>
  <h1>Reservation Details</h1>
  <p>Country: <?php echo $country; ?></p>
  <p>City: <?php echo $city; ?></p>
  <p>Street Number: <?php echo $streetNumber; ?></p>
  <p>Size: <?php echo $size; ?></p>
  <p>How to Get In: <?php echo $howToGetIn; ?></p>
  <p>Date: <?php echo $reservationDate; ?></p>
  <p>Start Hour: <?php echo $startHour; ?></p>
  <p>End Hour: <?php echo $endHour; ?></p>
  <a href="../index.php"> back to main page</a>
  <script src="../javaScript/index.js"></script>
</body>
</html>

