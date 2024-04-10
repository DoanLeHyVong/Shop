<?php
include 'inc/header.php';
include 'inc/slider.php';

$pd = new Product();



?>

<section class="py-5">
    <h2 style="font-size: 30px">Products</h2>


    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php
                $getProducts = $product->getProducts();
                if ($getProducts) {
                    while ($result = $getProducts->fetch_assoc()) {
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
                echo "<div class='main'><p>No products </p></div>";
            }
            ?>

        </div>
    </div>
</section>

<?php
include 'inc/footer.php';
?>