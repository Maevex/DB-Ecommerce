<?php
session_start();
include 'config.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['customer_id'])) {
    header("Location: loginform.php");
    exit;
}

$customer_id = $_SESSION['customer_id'];

// Jika form checkout dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan ada item yang dipilih
    if (isset($_POST['selected_items']) && is_array($_POST['selected_items'])) {
        $selected_items = $_POST['selected_items'];

        // Mulai transaksi database
        mysqli_begin_transaction($conn);

        try {
            // Insert ke tabel transaction
            $transaction_date = date("Y-m-d H:i:s");
            $queryTransaction = "INSERT INTO transaction (transaction_date, customer_id) VALUES ('$transaction_date', '$customer_id')";
            mysqli_query($conn, $queryTransaction);

            // Ambil ID transaksi terakhir
            $transaction_id = mysqli_insert_id($conn);

            // Proses setiap item yang dipilih
            foreach ($selected_items as $cart_item_id) {
                // Ambil detail item dari cart_items
                $queryItem = "SELECT ci.*, p.product_stock 
                              FROM cart_items ci 
                              JOIN product p ON ci.product_id = p.product_id 
                              WHERE ci.cart_item_id = '$cart_item_id'";
                $resultItem = mysqli_query($conn, $queryItem);
                $item = mysqli_fetch_assoc($resultItem);

                if ($item) {
                    $product_id = $item['product_id'];
                    $quantity = $item['quantity'];
                    $total_price = $item['total_price'];
                    $product_stock = $item['product_stock'];

                    // Periksa stok produk
                    if ($quantity > $product_stock) {
                        throw new Exception("Stok tidak mencukupi untuk produk ID $product_id.");
                    }

                    // Insert ke tabel transaction_detail
                    $queryTransactionDetail = "INSERT INTO transaction_detail (transaction_id, product_id, quantity, total_price) 
                                               VALUES ('$transaction_id', '$product_id', '$quantity', '$total_price')";
                    mysqli_query($conn, $queryTransactionDetail);

                    // Update stok produk
                    $new_stock = $product_stock - $quantity;
                    $queryUpdateStock = "UPDATE product SET product_stock = '$new_stock' WHERE product_id = '$product_id'";
                    mysqli_query($conn, $queryUpdateStock);

                    // Hapus item dari cart_items
                    $queryDeleteCartItem = "DELETE FROM cart_items WHERE cart_item_id = '$cart_item_id'";
                    mysqli_query($conn, $queryDeleteCartItem);
                } else {
                    throw new Exception("Item dengan ID $cart_item_id tidak ditemukan.");
                }
            }

            // Commit transaksi
            mysqli_commit($conn);
            $_SESSION['alert'] = "Checkout berhasil!";
            header("Location: transaction_detail.php");
            exit;
        } catch (Exception $e) {
            // Rollback jika ada error
            mysqli_rollback($conn);
            $_SESSION['alert'] = "Checkout gagal: " . $e->getMessage();
            header("Location: cart.php");
            exit;
        }
    } else {
        $_SESSION['alert'] = "Tidak ada item yang dipilih untuk checkout.";
        header("Location: cart.php");
        exit;
    }
}
?>
