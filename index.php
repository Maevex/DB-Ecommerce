<?php
//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
if(session_id() == '' || !isset($_SESSION)){session_start();}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MikroTik E-Commerce</title>
    <!-- Favicon -->
    <link rel="icon" href="favicon.ico" type="images/logo.jpg">
    <!-- Link ke file CSS eksternal -->
    <link href="style.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="">
                    <img src="images/logo.jpg" alt="Logo"> Lintas Buana
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
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

    <!-- Hero Section -->
    <section class="hero">
        <h2>Welcome to Lintas Buana</h2>
        <p>Shop the best MikroTik routers and accessories!</p>
        <a href="#products" class="btn btn-primary btn-lg">Browse Products</a>
    </section>

    <!-- Products Section -->
    <section id="products" class="container my-5">
        <h2 class="text-center mb-4">Our Products</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php
            // Mengambil koneksi database dari file eksternal
            include 'config.php'; // Pastikan file config.php sudah ada dan terhubung ke database

            // Query untuk mengambil data produk
            $query = "SELECT product_name, product_price, product_image FROM product LIMIT 4";
            $result = mysqli_query($conn, $query);

            // Mengecek apakah ada data produk
            if (mysqli_num_rows($result) > 0) {
                // Loop melalui setiap produk
                while ($row = mysqli_fetch_assoc($result)) {
                    $productName = $row['product_name'];
                    $productPrice = $row['product_price'];
                    $productImage = $row['product_image'];
                    // Menampilkan setiap produk dalam format card
                    echo '
                    <div class="col">
                        <div class="card h-100">
                            <img src="' . $productImage . '" class="card-img-top" alt="' . $productName . '" style="height: 200px; object-fit: fill;">
                            <div class="card-body">
                                <h5 class="card-title">' . $productName . '</h5>
                                <p class="card-text">Price: $' . number_format($productPrice, 2) . '</p>
                                <a href="#" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                // Jika tidak ada data produk
                echo '<p class="text-center">No products available.</p>';
            }
            ?>
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
