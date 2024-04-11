<?php
include_once 'inc/header.php';

  $login_check= Session::exists('user_login');
   if($login_check==false){
	header('location: login.php');}
    ?>
<?php
if(isset($_GET['cartId'])){
    $delId = $_GET['cartId'];
    $delCart = $ct->deleteProCart($delId);
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
    $cartId = $_POST['cartId'];
    $quantity = $_POST['quantity'];
    $updatequantityCart = $ct->updatequantityCart($quantity, $cartId);
}
?>

<section class="h-100 gradient-custom">
    <div class="container py-5">
        <div class="row d-flex justify-content-end my-4">
            <?php if(isset($updatequantityCart)){
                echo $updatequantityCart;
            }?>
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0">Shopping Cart</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php
                            $totalCart = 0;
                            $getcart = $ct->getProductCart();
                            if($getcart){
                                while ($result = $getcart->fetch_assoc()){
                                    $total = $result['price'] * $result['quantity'];
                            ?>
                            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                                <div class="bg-image hover-overlay hover-zoom ripple rounded"
                                    data-mdb-ripple-color="light">
                                    <img src="admin/uploads/<?php echo $result['image'] ?>" class="w-100" />
                                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                                <strong>Tên sản phẩm: <?php echo $result['productName'] ?></strong>
                                <form method="GET" action="">
                                    <button type="submit" name="cartId" value="<?php echo $result['cartId'] ?>"
                                        onclick="return confirm('Bạn chắc chắn muốn xóa?')"
                                        class="btn btn-primary btn-sm me-1 mb-2" data-mdb-tooltip="tooltip"
                                        title="Remove item">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                                <div class="d-flex mb-4" style="max-width: 300px">
                                    <div data-mdb-input-init class="form-outline">
                                        <form method="POST" action="">
                                            <label class="form-label" for="form1">Quantity :</label>
                                            <input id="form1" min="1" name="quantity"
                                                value="<?php echo $result['quantity'] ?>" type="number"
                                                style="width:50%;text-align:center;" class="form-control" />
                                            <input type="hidden" name="cartId" value="<?php echo $result['cartId'] ?>">
                                            <button type="submit" name="submit" class="btn btn-primary">Cập
                                                nhật</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                                <p class="text-start text-md-center"><strong>Price:
                                        <?php echo $fm->format_currency($result['price']) . " VNĐ" ?></strong>
                                </p>
                            </div>
                            <?php
                                    $totalCart += $total;
                                }
                            } else {
                                echo '<p>Giỏ hàng đang trống!</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <?php if($getcart){ ?>
                    <div class="card-header py-3">
                        <h5 class="mb-0">Summary</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                Total
                                <span><?php echo $fm->format_currency($totalCart) . ' VNĐ'; Session::set("total", $totalCart); ?></span>
                            </li>
                        </ul>
                        </br>
                        <a href="checkout.php" class="btn btn-primary btn-lg btn-block">Go to checkout</a>
                        <a href="index.php" class="btn btn-primary btn-lg btn-block">Continue shopping</a>

                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once 'inc/footer.php'; ?>