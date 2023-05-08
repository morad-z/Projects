<!DOCTYPE html>
<html>
<head>
    <title>Processing Result</title>
</head>
<body>

<?php $color = $_GET['color'];?>
<?php $size = $_GET['size']; ?>
<?php $quantity = $_GET['quantity']; ?>
<?php $availableColors = array('red' => 10,'blue' => 20,'green' => 15); ?>
<?php if (!array_key_exists($color, $availableColors)) {
    echo "<h2>Processing Result</h2>";
    echo "<p>Selected color is not available.</p>";
    exit;
}?>
<?php $availableQuantity = $availableColors[$color];?>
<?php if ($quantity > $availableQuantity) {
    echo "<h2>Processing Result</h2>";
    echo "<p>Requested quantity not available for the selected color.</p>";
    exit;
} ?>
<?php $result = "Available Color: $color, Size: $size, Requested Quantity: $quantity";?>

    <h2>Processing Result</h2>
    <p><?php echo $result; ?></p>
</body>
</html>
