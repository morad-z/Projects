<?php
include 'config.php';
$query = "SELECT * FROM tbl_30_books";
$result = mysqli_query($conn, $query);
$categoryList = file_get_contents('categories.json');
$categories = json_decode($categoryList, true);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bookstore</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1 class="text-center mt-4">Bookstore</h1>
    <ul id="categoryList" class="text-center">
        <li onclick="filterBooks('All')">All</li>
        <?php foreach ($categories['categories'] as $category): ?>
            <li onclick="filterBooks('<?php echo $category; ?>')"><?php echo $category; ?></li>
        <?php endforeach; ?>
    </ul>
    <div class="container">
        <div class="row book-list">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4 book-item" data-category="<?php echo $row['category']; ?>">
                    <a href="book.php?id=<?php echo $row['id']; ?>">
                        <img src="<?php echo $row['image_path']; ?>" alt="Book Cover">
                        <h3><?php echo $row['book_name']; ?></h3>
                        <p><?php echo $row['description']; ?></p>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
