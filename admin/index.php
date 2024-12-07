<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['admin'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: admin/login_form.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MikroTik E-Commerce</title>
    <link rel="icon" href="favicon.ico" type="images/logo.jpg">
    <link href="style.css" rel="stylesheet">
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
                        
                        <?php if(isset($_SESSION['admin'])): ?>

                            <li class="nav-item">
                            <a class="nav-link" href="products.php">Products</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="transactions.php">Transactions</a>
                            </li>
                            <!-- Jika user sudah login, tampilkan logout -->

                            <li class="nav-item">
                                <a class="nav-link" href="admin/logout.php">Logout</a>
                            </li>

                            

                        <?php else: ?>
                            <!-- Jika user belum login, tampilkan login dan register -->
                            <li class="nav-item">
                                <a class="nav-link" href="admin/login_form.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="admin/register_form.php">Register</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <h2>Welcome Admin</h2>
        
    </section>

    
    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 MikroTik E-Commerce | All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
