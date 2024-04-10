<?php
include 'inc/header.php';
?>
<?php
$login_check= Session::get('user_login');
if ($login_check == false) {
  header('location: 404.php');
} ?>
<section class="page-wrapper success-msg">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-3">
                <div class="block text-center">
                    <i class="fa-solid fa-circle-check fa-bounce"></i>
                    <h2 style="margin-right: 100px" class="text-center">Cảm ơn bạn đã thanh toán!</h2>
                    <p style="text-align: center;">Đơn hàng sẽ được giao với thời gian sớm nhất có thể</p>
                    <a href="orderdetail.php" class="btn btn-main mt-20">Xem chi tiết đơn hàng</a>
                    <a href="index.php" class="btn btn-main mt-20">Tiếp tục mua sắm</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include 'inc/footer.php';
?>