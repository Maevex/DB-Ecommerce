<?php
session_start();
include 'config.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['customer_id'])) {
    header("Location: loginform.php");
    exit;
}

$customer_id = $_SESSION['customer_id'];

// Ambil semua transaksi pelanggan
$queryTransactions = "SELECT * FROM transaction WHERE customer_id = '$customer_id' ORDER BY transaction_date DESC";
$resultTransactions = mysqli_query($conn, $queryTransactions);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History | MikroTik E-Commerce</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

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
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="products.php">Products</a>
                        </li>
                        <?php if(isset($_SESSION['username'])): ?>

                            <li class="nav-item">
                                <a class="nav-link" href="cart.php">Cart</a>
                            </li>
                            <!-- Jika user sudah login, tampilkan logout -->

                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>
                        <?php else: ?>
                            <!-- Jika user belum login, tampilkan login dan register -->
                            <li class="nav-item">
                                <a class="nav-link" href="loginform.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="registerform.php">Register</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    
    <div class="container">
        <h2 class="my-4">Transaction History</h2>

        <?php
        // Menampilkan alert jika ada
        if (isset($_SESSION['alert'])) {
            echo '<div class="alert alert-info text-center" role="alert">' . $_SESSION['alert'] . '</div>';
            unset($_SESSION['alert']);
        }
        ?>

        <?php if (mysqli_num_rows($resultTransactions) > 0): ?>
            <?php while ($transaction = mysqli_fetch_assoc($resultTransactions)): ?>
                <div class="card my-3">
                    <div class="card-header">
                        <strong>Transaction ID:</strong> <?php echo $transaction['transaction_id']; ?> <br>
                        <strong>Date:</strong> <?php echo $transaction['transaction_date']; ?>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php
                            // Ambil detail transaksi
                            $transaction_id = $transaction['transaction_id'];
                            $queryDetails = "SELECT td.*, p.product_name 
                                             FROM transaction_detail td 
                                             JOIN product p ON td.product_id = p.product_id 
                                             WHERE td.transaction_id = '$transaction_id'";
                            $resultDetails = mysqli_query($conn, $queryDetails);

                            while ($detail = mysqli_fetch_assoc($resultDetails)): ?>
                                <li class="list-group-item">
                                    <?php echo $detail['product_name']; ?> - 
                                    Quantity: <?php echo $detail['quantity']; ?> - 
                                    Total: Rp. <?php echo number_format($detail['total_price'], 2); ?>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>You have no transaction history. <a href="index.php">Shop now</a>.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
