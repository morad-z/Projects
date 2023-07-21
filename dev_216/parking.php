<?php
// mainObject.php

include('config.php');
// include('connection.php');

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['email'])) {
  header("Location: index.php"); // Redirect to the sign-in page
  // header('Location:' . URL . 'index.php');
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
$query = "SELECT name,role FROM tbl_216_users1 WHERE email = '$email'";
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
    $ownerId = $row['user_id'];
    $ownerId = $row['user_id'];

    // Retrieve the owner's name from tbl_216_users1
    $query = "SELECT name FROM tbl_216_users1 WHERE id = $ownerId";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      $ownerRow = mysqli_fetch_assoc($result);
      $ownerName = $ownerRow['name'];
    } else {
      $ownerName = "Unknown";
    }
  }
}

// Delete functionality
if (isset($_POST['delete'])) {
  // Retrieve the user's ID from tbl_216_users1
  $query = "SELECT id FROM tbl_216_users1 WHERE email = '$email'";
  $result = mysqli_query($conn, $query);

  // Check if the query was successful and a row was returned
  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $userId = $row['id'];

    // Retrieve the item from tbl_216_aps based on the ID
    $query = "SELECT * FROM tbl_216_aps WHERE id = $id";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful and a row was returned
    if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $ownerId = $row['user_id'];

      // Check if the current user is the owner of the item
      if ($userId == $ownerId || $userRole == 'Admin') {
        // Delete the item from tbl_216_aps based on the ID
        $query = "DELETE FROM tbl_216_aps WHERE id = $id";
        $result = mysqli_query($conn, $query);

        if ($result) {
          // Redirect to index1.php after successful deletion
          header("Location: HomePageParking.php");
          exit();
        } else {
          echo "Error deleting item: " . mysqli_error($conn);
        }
      } else {
        echo "You are not authorized to delete this item.";
      }
    }
  }
}

// Handle the rating submission
if (isset($_POST['rate'])) {
  $rating = $_POST['rate'];

  // Check if the user has already rated the object
  $query = "SELECT rating FROM tbl_216_rating1 WHERE object_id = $id AND user_email = '$email'";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    // Update the existing rating for the object by the user
    $query = "UPDATE tbl_216_rating1 SET rating = $rating WHERE object_id = $id AND user_email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result) {
      // Rating updated successfully
      echo "Rating updated successfully";
    } else {
      echo "Error updating rating: " . mysqli_error($conn);
    }
  } else {
    // Insert a new rating for the object by the user
    $query = "INSERT INTO tbl_216_rating1 (object_id, rating, user_email) VALUES ($id, $rating, '$email')";
    $result = mysqli_query($conn, $query);

    if ($result) {
      // Rating inserted successfully
      echo "Rating saved successfully";
    } else {
      echo "Error inserting rating: " . mysqli_error($conn);
    }
  }
}

// Retrieve the user's rating for the object, if available
$query = "SELECT rating FROM tbl_216_rating1 WHERE object_id = $id AND user_email = '$email'";
$result = mysqli_query($conn, $query);

$userRating = 0; // Default user rating

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $userRating = $row['rating'];
}

// Retrieve the average rating for the object
$query = "SELECT AVG(rating) AS averageRating FROM tbl_216_rating1 WHERE object_id = $id";
$result = mysqli_query($conn, $query);

$averageRating = 0; // Default average rating

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $averageRating = round($row['averageRating'], 2);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link id="style" rel="stylesheet" href="css/all.css" />


  <!-- link to boostrap -->
  <!-- CSS only -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <!-- JS, Popper.js, and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>parking</title>
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
    <section class="textt">Uploaded parking spot</section>

    <h1 class="main100">floor 1 / Section A / Park 1</h1>
    <div id="wrapper_text_image">

      <section id="imageSection">

      </section>
      <section id="textSection">
        <span>Owner :</span> <small><?php echo $ownerName; ?> &nbsp;</small>
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-dots-fill" viewBox="0 0 16 16">
          <path d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
        </svg>
        <br>
        <span>available date : </span><small><?php echo $reservationDate ?></small>
        <br>
        <span>Availbel hours :</span> <small><?php echo $startHour ?> to <?php echo $endHour ?></small>
        <br>
        <span>Size : </span><small> <?php echo $size ?></small>
        <br>
        <span>city : </span><small> <?php echo $city ?></small>
        <br>
        <span>How to enter : </span><small> <?php echo $howToGetIn ?></small>
        <br>
      </section>
    </div>


      <section id="ratingSection">
        <div class="rating">
          <input type="radio" id="star5" name="rate" value="5" <?php if ($userRating == 5) echo 'checked'; ?> onclick="submitRating(this)">
          <label for="star5" title="text"></label>
          <input type="radio" id="star4" name="rate" value="4" <?php if ($userRating == 4) echo 'checked'; ?> onclick="submitRating(this)">
          <label for="star4" title="text"></label>
          <input type="radio" id="star3" name="rate" value="3" <?php if ($userRating == 3) echo 'checked'; ?> onclick="submitRating(this)">
          <label for="star3" title="text"></label>
          <input type="radio" id="star2" name="rate" value="2" <?php if ($userRating == 2) echo 'checked'; ?> onclick="submitRating(this)">
          <label for="star2" title="text"></label>
          <input type="radio" id="star1" name="rate" value="1" <?php if ($userRating == 1) echo 'checked'; ?> onclick="submitRating(this)">
          <label for="star1" title="text"></label>
        </div>
        <p>Average Rating: <?php echo $averageRating; ?> <a href="ratings.php?id=<?php echo $id; ?>">View All Ratings</a></p>
      </section>
  <section id="lowwerSection">
    <?php
    // Retrieve the user's ID from tbl_216_users1
    $query = "SELECT id,role FROM tbl_216_users1 WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful and a row was returned
    if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $userId = $row['id'];
      $userRole = $row['role'];


      // Retrieve the item from tbl_216_aps based on the ID
      $query = "SELECT * FROM tbl_216_aps WHERE id = $id";
      $result = mysqli_query($conn, $query);

      // Check if the query was successful and a row was returned
      if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $ownerId = $row['user_id'];


        // Check if the current user is the owner of the item
        if ($userId == $ownerId || $userRole == 'Admin') {
          echo '<a href="updateParkDetails.php?id=' . $id . '"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi-bi-pencil-fill" viewBox="0 0 16 16">
          <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
        </svg></a>';
        }
      }
    }

    //  echo '<a href="updateParkDetails.php?id='.$id.'"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi-bi-pencil-fill" viewBox="0 0 16 16">
    //     <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
    //   </svg></a>';
    ?>
   
    
  </section>
  
  
  
  
  
  
  

  
  
  
  <script src="js/index.js"></script>
  
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
    <div class="form-wrapper">
    <form id="trashform" action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?')" >
      <button class="btn btn-delete" name="delete" >
        <span class="mdi mdi-delete mdi-24px"></span>
        <span class="mdi mdi-delete-empty mdi-24px"></span>
        <span>Delete</span>
      </button>
    </form>
  </div>
  <!-- Sign out form -->
  <form id="signout-form" action="parking.php" method="POST" style="display: none;">
    <input type="hidden" name="signout" value="1">
  </form>
  </footer>
</body>

</html>
