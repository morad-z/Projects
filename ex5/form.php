
<!DOCTYPE html>
<html>
<head>
  <title>Reservation Details</title>
</head>
<body>
<?php
  $country = $_GET["country"];
  $city = $_GET["city"];
  $streetNumber = $_GET["streetNumber"];
  $size = $_GET["size"];
  $howToGetIn = $_GET["howToGetIn"];
  $date = $_GET["date"];
  $startHour = $_GET["startHour"];
  $endHour = $_GET["endHour"];
?>
  <h1>Reservation Details</h1>
  <p>Country: <?php echo $country; ?></p>
  <p>City: <?php echo $city; ?></p>
  <p>Street Number: <?php echo $streetNumber; ?></p>
  <p>Size: <?php echo $size; ?></p>
  <p>How to Get In: <?php echo $howToGetIn; ?></p>
  <p>Date: <?php echo $date; ?></p>
  <p>Start Hour: <?php echo $startHour; ?></p>
  <p>End Hour: <?php echo $endHour; ?></p>
</body>
</html>
