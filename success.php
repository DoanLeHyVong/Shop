<?php
include 'inc/header.php';
?>
<?php

if ($_GET['resultCode'] == 0) {
    $partnerCode = $_GET['partnerCode'];
    $orderId = $_GET['orderId'];
    $requestId = $_GET['requestId'];
    $amount = $_GET['amount'];
    $orderInfo = $_GET['orderInfo'];
    $orderType = $_GET['orderType'];
    $transId = $_GET['transId'];
    $resultCode = $_GET['resultCode'];
    $message = $_GET['message'];
    $payType = $_GET['payType'];
    $responseTime = $_GET['responseTime'];
    $paymentOption = $_GET['paymentOption'];

    $data = [
        'orderId' => $orderId,
        'requestId' => $requestId,
        'amount' => $amount,
        'orderInfo' => $orderInfo,
        'orderType' => $orderType,
        'transId' => $transId,
        'resultCode' => $resultCode,
        'message' => $message,
        'payType' => $payType,
        'responseTime' => $responseTime,
        'paymentOption' => $paymentOption
    ];

    $handleMomo = $ct->handleMomo($data);
}

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