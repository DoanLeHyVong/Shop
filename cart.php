<?php
	include 'inc/header.php';
?>
<style>
.tblone {
    width: 100%;
    border-collapse: collapse;
}

.tblone th,
.tblone td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.tblone th {
    background-color: #f2f2f2;
}

.tblone tr:nth-child(even) {
    background-color: #f2f2f2;
}

.tblone tr:hover {
    background-color: #ddd;
}
</style>
<?php
if(isset($_POST['update_quantity'])) {
    $productId = $_POST['product_id'];
    $new_quantity = $_POST['quantity'];
    $ct->update_quantity($productId, $new_quantity);
}

// Xử lý xóa sản phẩm
if(isset($_GET['delete_product'])) {
    $productId = $_GET['delete_product'];
    $ct->delete_product($productId);
}
?>
<div class="main">
    <div class="content">
        <div class="cartoption">
            <div class="cartpage">
                <h2>Your Cart</h2>
                <table class="tblone">
                    <tr>
                        <th width="20%">Product Name</th>
                        <th width="10%">Image</th>
                        <th width="15%">Price</th>
                        <th width="25%">Quantity</th>
                        <th width="20%">Total Price</th>
                        <th width="10%">Action</th>
                    </tr>
                    <?php
                        $get_product_cart = $ct->get_product_cart();
                        $has_products = false;
                        $subtotal = 0;
                        if ($get_product_cart) {
                            while ($result = $get_product_cart->fetch_assoc()) {
                                $has_products = true; 
                                $total = $result['price'] * $result['quantity'];
                                $subtotal += $total;
                    ?>
                    <tr>
                        <td><?php echo $result['productName'] ?></td>
                        <td><img src="admin/uploads/<?php echo $result['image'] ?>" alt="" /></td>
                        <td><?php echo $result['price'] ?></td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $result['productId']; ?>">
                                <input type="number" name="quantity" min="0"
                                    value="<?php echo $result['quantity'] ?>" />
                                <input type="submit" name="update_quantity" value="Update" />
                            </form>
                        </td>
                        <td><?php echo $total; ?></td>
                        <td><a href="?delete_product=<?php echo $result['productId']; ?>">X</a></td>
                    </tr>
                    <?php
                        }
                    }

                    if (!$has_products) {
                    ?>
                    <tr>
                        <td style="text-align: center; color:red" ; colspan="6">No products in the cart</td>
                    </tr>
                    <?php
                    }

                    // Tính toán VAT và grand total
                    $vat = $subtotal * 0.1;
                    $gtotal = $subtotal + $vat;
                    ?>
                </table>

                <table style="float:right; text-align:left;" width="40%">
                    <tr>
                        <th>Sub Total:</th>
                        <td><?php echo $subtotal; ?></td>
                    </tr>
                    <tr>
                        <th>VAT:</th>
                        <td>10%</td>
                    </tr>
                    <tr>
                        <th>Grand Total:</th>
                        <td><?php echo $gtotal; ?></td>
                    </tr>
                </table>
            </div>

            <div class="shopping">
                <div class="shopleft">
                    <a href="index.php"> <img src="assets/images/shop.png" alt="" /></a>
                </div>
                <div class="shopright">
                    <a href="login.php"> <img src="assets/images/check.png" alt="" /></a>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php
	include 'inc/footer.php';
?>