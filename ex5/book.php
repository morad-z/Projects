<?php
include 'config.php';
if (isset($_GET['id'])) {
    $bookId = $_GET['id'];
    $query = "SELECT * FROM tbl_30_books WHERE id = $bookId";
    $result = mysqli_query($conn, $query);
    $book = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Details</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <div class="book-item1">
            <h1><?php echo $book['book_name']; ?></h1>
            <div class = "image-container">
            <img src="<?php echo $book['image_path']; ?>" alt="Book Cover">
            <img src="<?php echo $book['image_path2']; ?>" alt="Book Cover">
            </div>
            <br>
            <p>Category: <?php echo $book['category']; ?></p>
            <p><?php echo $book['description']; ?></p>
            <p>Price: <?php echo $book['price']; ?>$</p>
            <p>Rating: <?php echo $book['rating']; ?></p>
            <p>Author: <?php echo $book['author_name']; ?></p>
        </div>
    </div>
</body>
</html>