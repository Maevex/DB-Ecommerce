<?php
// Memulai session
if(session_id() == '' || !isset($_SESSION)){session_start();}

// Mengambil ID produk dari URL
$productID = isset($_GET['id']) ? $_GET['id'] : null;

if ($productID) {
    // Mengambil koneksi database
    include 'config.php';

    // Query untuk mengambil data produk berdasarkan ID
    $query = "SELECT product_name, product_price, product_image, product_description, category_name
              FROM product
              JOIN category ON product.category_id = category.category_id
              WHERE product.product_id = $productID";
    $result = mysqli_query($conn, $query);

    // Jika produk ditemukan
    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        $productName = $product['product_name'];
        $productPrice = $product['product_price'];
        $productImage = $product['product_image'];
        $productDescription = $product['product_description'];
        $categoryName = $product['category_name'];
    } else {
        // Jika produk tidak ditemukan
        echo '<p class="text-center">Product not found.</p>';
        exit;
    }
} else {
    // Jika ID produk tidak ada
    echo '<p class="text-center">Invalid product.</p>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $productName; ?> - Product Details</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="images/logo.jpg" alt="Logo"> Lintas Buana
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="products.php">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Register</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Product Detail Section -->
    <section class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo $productImage; ?>" alt="<?php echo $productName; ?>" class="img-fluid">
            </div>
            <div class="col-md-6">
                <h2><?php echo $productName; ?></h2>
                <p><strong>Category:</strong> <?php echo $categoryName; ?></p>
                <p><strong>Price:</strong> $<?php echo number_format($productPrice, 2); ?></p>
                <p><strong>Description:</strong></p>
                <p><?php echo nl2br($productDescription); ?></p>
                <a href="products.php" class="btn btn-secondary">Back to Products</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 MikroTik E-Commerce | All Rights Reserved</p>
    </footer>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
