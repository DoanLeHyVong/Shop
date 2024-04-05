<?php
	include 'inc/header.php';
	include 'inc/slider.php';
?>
<div class="main">
    <link rel="stylesheet" href="assets/css/style.css">
    <div class="content">
        <div class="content_top">
            <div class="heading">
                <h3>Feature Products</h3>
            </div>
            <div class="clear"></div>
        </div>
        <div class="section group">
            <?php
                $product_feathered = $product->getproduct_feathered();
                if ($product_feathered) {
                    while ($result = $product_feathered->fetch_assoc()) {
            ?>
            <div class="grid_1_of_4 images_1_of_4">
                <a href="details.php?productid=<?php echo $result['productId']; ?>">
                    <img src="admin/uploads/<?php echo $result['image']; ?>" alt="" width="100" height="100">
                </a>
                <h2><?php echo $result['productName'] ?></h2>
                <p><?php echo $fm->textShorten($result['product_desc'], 30) ?></p>
                <p><span class="price"><?php echo $result['price'] . "VND" ?></span></p>
                <div class="button"><span><a href="details.php?productid=<?php echo $result['productId']; ?>"
                            class="details">Details</a></span></div>
            </div>
            <?php
            }
        }
        ?>
        </div>
        <div class="content_bottom">
            <div class="heading">
                <h3>New Products</h3>
            </div>
            <div class="clear"></div>
        </div>
        <div class="section group">
            <?php
                $product_feathered = $product->getproduct_new();
                if ($product_feathered) {
                    while ($result = $product_feathered->fetch_assoc()) {
            ?>
            <div class="grid_1_of_4 images_1_of_4">
                <a href="details.php?productid=<?php echo $result['productId']; ?>">
                    <img src="admin/uploads/<?php echo $result['image']; ?>" alt="" width="100" height="100">
                </a>
                <h2><?php echo $result['productName'] ?></h2>
                <p><?php echo $fm->textShorten($result['product_desc'], 50) ?></p>
                <p><span class="price"><?php echo $result['price'] . "VND" ?></span></p>
                <div class="button"><span><a href="details.php?productid=<?php echo $result['productId']; ?>"
                            class="details">Details</a></span></div>
            </div>
            <?php
            }
        }
        ?>
        </div>
    </div>
</div>
</div>
<?php
	include 'inc/footer.php';
?>