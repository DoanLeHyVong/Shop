<?php
include 'inc/header.php';
include 'inc/slider.php';

$brand = new Brand();

if (isset($_GET['brandid']) && $_GET['brandid'] != NULL) {
    $id = $_GET['brandid'];
} else {
    echo "<script>window.location = '404.php';</script>";
}
?>

<section class="py-5">
    <?php
            // Kiểm tra và hiển thị tên brand
                $brand_name = $brand->get_brand_name($id);
                if ($brand_name) {
                    $result_name = $brand_name->fetch_assoc();
                    ?>
    <h2 style="font-size: 30px;">Brand: <?php echo $result_name['brandName']; ?></h1>
        <?php } ?>

        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
            // Hiển thị sản phẩm của brand
            $brand_products = $brand->get_product_by_brand($id);
            if ($brand_products) {
                while ($result = $brand_products->fetch_assoc()) {
            ?>
                <div class="col-3 mb-5">
                    <div class="card h-100">
                        <!-- Product image -->
                        <a href="details.php?productid=<?php echo $result['productId']; ?>"><img
                                style="height: 150px; width:150px " src="admin/uploads/<?php echo $result['image']; ?>"
                                alt="" />
                        </a>
                        <!-- Product details -->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name -->
                                <h5 class="fw-bolder"><?php echo $result['productName']; ?></h5>
                                <p><?php echo $fm->textShorten($result['product_desc'], 300) ?></p>

                                <!-- Product price -->
                                <p><span class="price">$<?php echo $result['price']; ?></span></p>
                            </div>
                        </div>
                        <!-- Product actions -->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <a class="btn btn-outline-dark mt-auto"
                                    href="details.php?productid=<?php echo $result['productId']; ?>">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
            } else {
                echo "<div class='main'><p>No products found in this category.</p></div>";
            }
            ?>
            </div>
        </div>
</section>

<?php
include 'inc/footer.php';
?>