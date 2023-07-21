<?php
include('config.php');
// include('connection.php');
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php"); // Redirect to the sign-in page
    // header('Location:' .URL. 'index.php');
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

// Load cities from city.json
$cityData = file_get_contents('city.json');
$cities = json_decode($cityData, true);

// Function to get options for the city select element
function getCityOptions($country) {
    global $cities;
    $options = '';
    foreach ($cities[$country] as $city) {
        $options .= '<option value="' . $city . '">' . $city . '</option>';
    }
    return $options;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" >
  <meta http-equiv="X-UA-Compatible" content="IE=edge" >
  <meta name="viewport" content="width=device-width, initial-scale=1.0" >
  <link rel="stylesheet" href="css/all.css" >
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384- 9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5JvoRxTsoB1TGf 0 bubble 1QofQ" crossorigin="anonymous" >
  <!-- //link to javascript file by cdn   -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
  <!-- import bree serif font from google fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" >
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin >
  <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&display=swap" rel="stylesheet" >
  
  <title>upload available parkink spot</title>
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
      <svg id="notificationIcon" xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
      </svg>
      <img class="profileImage" src="images/profile_mobile.jpg" alt="">
    </section>
  </header>
  <nav class="mainNav_index">
      <!--  make item selected in deffrent color -->
      <ul class="MainNavUl_index">
        <li>
          <a href="index.php" onclick="color=blue">Home</a>
        </li>
        <li>
          <a href="upload_aps.php">Add park</a>
        </li>
        <li>
          <a href="#">Analysis</a>
        </li>
        <li>
          <a href="#">Services</a>
        </li>
        <li>
          <a href="#">join us</a>
        </li>
        <li>
          <a href="#">History</a>
        </li>
      </ul>
    </nav>
  <h1 class="upload_spot">Upload parking spot</h1>
  <h2 class="details">Enter your parking spot details :</h2>

<section class="form">
    <form name="reservationForm" class="m-4" onsubmit="return validateForm()" action="php/form.php" method="POST">
        <div class="mb-3">
            <label for="country" class="form-label">Country:</label>
            <input type="text" id="country" name="country" class="form-control1" required>
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">City:</label>
            <select id="city" name="city" class="form-control1" required>
                <option value="" selected disabled>Select a city</option>
                <?php echo getCityOptions("Israel"); ?>
            </select>
        </div>


      <div class="mb-3">
        <label for="streetNumber" class="form-label">Street Number:</label>
        <input type="text" id="streetNumber" name="streetNumber" class="form-control1" required>
      </div>

      <div class="mb-3">
        <label for="size" class="form-label">Size:</label>
        <input type="text" id="size" name="size" class="form-control1" required>
      </div>

      <div class="mb-3">
        <label for="howToGetIn" class="form-label">How to Get In:</label>
        <textarea id="howToGetIn" name="howToGetIn" class="form-control1" required></textarea>
      </div>

      <div class="mb-3">
        <label for="reservationDate" class="form-label">reservationDate:</label>
        <input type="date" id="reservationDate" name="reservationDate" class="form-control1" required>
      </div>

      <div class="mb-3">
        <label for="startHour" class="form-label">Start Hour:</label>
        <input type="time" id="startHour" name="startHour" class="form-control1" required>
      </div>

      <div class="mb-3">
        <label for="endHour" class="form-label">End Hour:</label>
        <input type="time" id="endHour" name="endHour" class="form-control1" required>
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </section>
  <nav class="sticky-navbar">
    <ul class="nav justify-content-center">
      <li class="nav-item">
        <a class="nav-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
        </svg></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
          <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z"/>
        </svg></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chat-dots-fill" viewBox="0 0 16 16">
          <path d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
        </svg></a>
      </li>
    </ul>
  </nav>
  <footer id="footer_upload">
    <a href="index.php" id="signout-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-box-arrow-left"
          viewBox="0 0 16 16">
          <path
            d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z" />
          <path
            d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
        </svg>
      </a>
      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-gear-fill"
        viewBox="0 0 16 16">
        <path
          d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
      </svg>
    </footer>

    <!-- Sign out form -->
    <form id="signout-form" action="HomePageParking.php" method="POST" style="display: none;">
        <input type="hidden" name="signout" value="1">
    </form>
<script src="js/index.js"></script>
</body>
</html>
