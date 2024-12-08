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
$queryTransactions = "SELECT t.transaction_id, t.transaction_date, 
                              p.product_name, td.quantity, td.total_price
                       FROM transaction t
                       JOIN transaction_detail td ON t.transaction_id = td.transaction_id
                       JOIN product p ON td.product_id = p.product_id
                       WHERE t.customer_id = '$customer_id'
                       ORDER BY t.transaction_date DESC";
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
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="container my-4">
    <h2 class="text-center mb-4">Transaction History</h2>
    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Transaction Date</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($resultTransactions) > 0): ?>
                <?php while ($transaction = mysqli_fetch_assoc($resultTransactions)): ?>
                    <tr>
                        <td><?php echo $transaction['transaction_id']; ?></td>
                        <td><?php echo $transaction['transaction_date']; ?></td>
                        <td><?php echo $transaction['product_name']; ?></td>
                        <td><?php echo $transaction['quantity']; ?></td>
                        <td>Rp. <?php echo number_format($transaction['total_price'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">You have no transaction history. <a href="index.php">Shop now</a>.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
