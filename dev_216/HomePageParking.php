<?php
include('config.php');

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['email'])) {
  header("Location: index.php"); // Redirect to the sign-in page
  // header('Location:' .URL. 'index.php');
  exit();
}

// Fetch all available parking spots for Section A
$querySectionA = "SELECT * FROM tbl_216_aps";
$resultSectionA = mysqli_query($conn, $querySectionA);

$city = ""; // Initialize the city variable for Section B

// Check if the search form is submitted for Section B
if (isset($_POST['search'])) {
  $city = $_POST['city']; // Get the searched city from the form
  if (!empty($city)) {
    // Modify the query to filter based on the city
    $querySectionB = "SELECT * FROM tbl_216_aps WHERE city = '$city'";
  } else {
    // If the search field is empty, show all parking spots for Section B
    $querySectionB = "SELECT * FROM tbl_216_aps";
  }
} else {
  // If the search form is not submitted, show all parking spots for Section B
  $querySectionB = "SELECT * FROM tbl_216_aps";
}

$resultSectionB = mysqli_query($conn, $querySectionB);
// Sign out functionality
if (isset($_POST['signout'])) {
    // Clear session data
    session_unset();
    session_destroy();

    header("Location: index.php"); // Redirect to the sign-in page after signing out
    exit();
}
if (isset($_POST['update'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Update the user details in the database
  $queryUpdateUser = "UPDATE tbl_216_users1 SET name = '$name', email = '$email', password = '$password' WHERE email = '$email'";
  $resultUpdateUser = mysqli_query($conn, $queryUpdateUser);

  if ($resultUpdateUser) {
      // If the update is successful, refresh the page to show the updated details
      header("Location: index.php");
      exit();
  } else {
      // Handle error if the update fails
      echo "Error updating user details: " . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" >
  <meta http-equiv="X-UA-Compatible" content="IE=edge" >
  <meta name="viewport" content="width=device-width, initial-scale=1.0" >
  <link rel="stylesheet" href="css/all.css" >
  <!-- //link to javascript file by cdn   -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
  <!-- import bree serif font from google fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" >
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin >
  <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&display=swap" rel="stylesheet" >
  <title>Home Page</title>
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
  
  <main class="main100">
    <section class="menuIconSection_index">
      <svg id="menuIconMobile_index" xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
      </svg>
      <button class="btn btn-primary" id="listBtn">List</button>
      <button class="btn btn-secondary">Map</button>
      <form class="d-none d-md-flex input-group w-auto my-auto">
        <input autocomplete="off" type="search" class="form-control rounded" placeholder='Search (ctrl + "/" to focus)' style="min-width: 225px" >
        <span class="input-group-text border-0">
          <i class="fas fa-search"></i>
        </span>
      </form>
    </section>

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
  </main>
  <h1 class="h1_mobile_list">all available parkings</h1>

  <div id="mobileWrapper">

  <div class="list-group" id="list-tab2" role="tablist">
        <?php
        while ($row = mysqli_fetch_assoc($resultSectionA)) {
          $id = $row['id'];

          echo '<a class="list-group-item list-group-item-action" id="sectionC-list-park2-list" data-toggle="list" href="parking.php?id=' . $id . '" role="tab">';
          echo  $row['city'] . ' ' .  $row['streetNumber']  . ' ' . $row['startHour'] . ' ' . $row['endHour'];
          echo '</a>';
        }
        ?>
      </div>
  </div>
  <div id="wrapper_index">
  <section class="user-details" style="display: none;">
      <?php
      // Fetch user details from the database and display them
      $email = $_SESSION['email'];
      $queryUserDetails = "SELECT * FROM tbl_216_users1 WHERE email = '$email'";
      $resultUserDetails = mysqli_query($conn, $queryUserDetails);
      if (mysqli_num_rows($resultUserDetails) > 0) {
        $userDetails = mysqli_fetch_assoc($resultUserDetails);
        echo '<h2>User Details</h2>';
        echo '<form method="post">';
        echo '<p><strong>Name:</strong> <input type="text" name="name" value="' . $userDetails['name'] . '"></p>';
        echo '<p><strong>Email:</strong> <input type="email" name="email" value="' . $userDetails['email'] . '"></p>';
        echo '<p><strong>Password:</strong> <input type="password" name="password" value="' . $userDetails['password'] . '"></p>';
        echo '<input type="submit" name="update" value="Update">';
        echo '</form>';
      }
      ?>
    </section>
    <section id="parkingSection">
      <span class="SectionName">All Parkings</span>
      <div class="list-group" id="list-tab3" role="tablist">
        <?php
        // Display the parking spots based on the search result in Section B
        while ($row = mysqli_fetch_assoc($resultSectionB)) {
          $id = $row['id'];
          echo '<a class="list-group-item list-group-item-action" id="sectionC-list-park2-list" data-toggle="list" href="parking.php?id=' . $id . '" role="tab">';
          echo $row['city'] . ' ' . $row['streetNumber'] . ' ' . $row['startHour'] . ' ' . $row['endHour'];
          echo '</a>';
        }
        ?>
      </div>
      <div class="search">
      <form method="post">
        <input placeholder="Search city..." type="text" name="city">
        <button type="submit" name="search">Go</button>
        </form>
      </div>
  </div>
  <footer id="footer_index">
    <a href="index.php" id="signout-link">
      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
        <path d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z" />
        <path d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
      </svg>
    </a>
    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
      <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
    </svg>
  </footer>

  <!-- Sign out form -->
  <form id="signout-form" action="HomePageParking.php" method="POST" style="display: none;">
    <input type="hidden" name="signout" value="1">
  </form>
  <script src="js/index.js"></script>
</body>

</html>
