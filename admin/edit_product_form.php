<?php
include 'config.php'; // Menyertakan file koneksi
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Product</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php
        // Ambil data produk berdasarkan ID
        if (isset($_GET['id'])) {
            $productId = $_GET['id'];
            $query = "SELECT * FROM product WHERE product_id = $productId";
            $result = mysqli_query($conn, $query);
            $product = mysqli_fetch_assoc($result);

            if (!$product) {
                die("Product not found!");
            }
        } else {
            die("Product ID not provided!");
        }
        ?>

        <form action="update_product.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product['product_name']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value="">Select a category</option>
                    <?php
                    // Ambil daftar kategori dari database
                    $categoryQuery = "SELECT * FROM category";
                    $categoryResult = mysqli_query($conn, $categoryQuery);
                    while ($row = mysqli_fetch_assoc($categoryResult)) {
                        $selected = $product['category_id'] == $row['category_id'] ? 'selected' : '';
                        echo '<option value="' . $row['category_id'] . '" ' . $selected . '>' . $row['category_name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="product_image" class="form-label">Product Image</label>
                <input type="file" class="form-control" id="product_image" name="product_image" accept="image/*">
                <small>Leave empty to keep the current image.</small>
                <br>
                <img src="<?php echo $product['product_image']; ?>" width="100" alt="Current Image">
            </div>

            <div class="mb-3">
                <label for="product_description" class="form-label">Description</label>
                <textarea class="form-control" id="product_description" name="product_description" rows="4" required><?php echo $product['product_description']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="product_stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="product_stock" name="product_stock" value="<?php echo $product['product_stock']; ?>" min="0" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="products.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
