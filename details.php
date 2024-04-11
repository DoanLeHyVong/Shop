<?php
include_once 'inc/header.php';

  $login_check= Session::exists('user_login');
   if($login_check==false){
	header('location: login.php');}?>
<?php

if(!isset($_GET['productid']) || $_GET['productid'] == null){
    echo "<script>window.location = '404.php'</script>";
} else {
    $productId = $_GET['productid'];
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
    $quantity = $_POST['quantity'];
    $Addtocart = $ct->addtocart($productId, $quantity);
}
?>

<section class="py-5">
    <div class="container">
        <div class="row gx-5">
            <?php
            $getproductDetail = $product->get_details($productId);
            if($getproductDetail){
                while($result = $getproductDetail->fetch_assoc()){
            ?>
            <aside class="col-lg-6">
                <div class="border rounded-4 mb-3 d-flex justify-content-center">
                    <a data-fslightbox="mygalley" class="rounded-4" target="_blank" data-type="image"
                        href="admin/uploads/<?php echo $result['image'] ?>">
                        <img src="admin/uploads/<?php echo $result['image'] ?>">
                    </a>
                </div>
            </aside>
            <main class="col-lg-6">
                <div class="ps-lg-3">
                    <h4 class="title text-dark">
                        <?php echo $result['productName']?>
                    </h4>

                    <div class="mb-3">
                        <span class="h5"><?php echo $fm->format_currency($result['price'])." ".'VNĐ'?></span>
                    </div>

                    <p>
                        <?php echo $fm->textShorten($result['product_desc'], 200)?>
                    </p>

                    <div class="row">
                        <dt class="col-3">Category</dt>
                        <dd class="col-9"><?php echo $result['catName']?></dd>

                        <dt class="col-3">Brand</dt>
                        <dd class="col-9"><?php echo $result['brandName']?></dd>
                    </div>

                    <hr />

                    <form method="POST" action="">
                        <div class="row mb-4">
                            <div class="col-md-4 col-6 mb-3">
                                <label class="mb-2 d-block">Quantity</label>
                                <div class="input-group mb-3" style="width: 170px;">
                                    <div class="product-quantity-slider">
                                        <input type="number" name="quantity" min="1" value="1"
                                            style="width:50%;text-align:center;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="submit" value="" class="btn btn-primary shadow-0"> <i
                                class="me-1 fa fa-shopping-basket"></i> Add to cart
                        </button>
                    </form>
                    <?php
                    if(isset($Addtocart)){
                        echo $Addtocart;
                    }
                    ?>
                </div>
            </main>
            <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<?php
include_once 'inc/footer.php';
?>