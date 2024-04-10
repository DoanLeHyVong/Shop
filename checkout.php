<?php
include 'inc/header.php';

?>
<?php
//   $login_check= Session::exists('user_login');
//    if($login_check==false){
// 	header('location: login.php');}?>
<?php
 if(isset($_GET['orderid']) &&$_GET['orderid']=='order'  ){
    $customerId = Session::get('customer_id');
    $insertOrder = $ct->insertOder( $customerId);
    //neu da thanh toan thi xoa gio hang
    $delCart=$ct->delAllCart();
    header('location: success.php');
  }
  ?>
<?php
  if($_SERVER['REQUEST_METHOD']==='POST'&& isset($_POST['submit'])){
   $checkmethodpayment = $_POST['payment'];
	if( $checkmethodpayment == 'cash'){
      header('location: ?orderid=order');
   }else{
      header('location: congthanhtoan.php');
   }
   }
  ?>

<div class="page-wrapper">
    <div class="checkout shopping">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="block billing-details">
                        <h4 class="widget-title">Thông tin nhận hàng</h4>
                        <?php
                $id=Session::get('user_id');
                $getuser = $user->getAllUser($id);
                if($getuser){
                    while($result=$getuser->fetch_assoc()){
                ?>
                        <form class="checkout-form">
                            <div class="form-group">
                                <label for="full_name">Tên:</label>
                                <input type="text" class="form-control" id="name"
                                    value="<?php echo $result['username'];?>">
                            </div>
                            <div class="form-group">
                                <label for="user_address">Địa chỉ:</label>
                                <input type="text" class="form-control" id="address"
                                    value="<?php echo $result['address'];?>">
                            </div>

                            <div class="form-group">
                                <label for="user_post_code">Số điện thoại:</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="<?php echo $result['phone'];?>">
                            </div>
                            <div class="form-group">
                                <label for="user_city">Email:</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    value="<?php echo $result['email'];?>">
                            </div>

                        </form>
                        <?php }}?>
                    </div>
                    <div class="block">
                        <h4 style="font-size: 30px; color:red" class="widget-title">Phương thức thanh toán</h4>
                        <!-- <p>Credit Cart Details (Secure payment)</p> -->
                        <div class="checkout-product-details">
                            <div class="payment">
                                <div class="card-details">
                                    <div class="form-group">
                                        <form action="" method="post">
                                            <label for="delivery">Thanh toán khi nhận
                                                hàng</label>
                                            <input type="radio" id="delivery" name="payment" value="cash" checked>
                                            <br>
                                            <label style="margin-top: 30px;" for="delivery">Thanh toán QR momo</label>
                                            <input style="margin-left: 27px" type="radio" id="momo" name="payment"
                                                value="momo">
                                            <button type="submit" name="submit"
                                                class="btn btn-submit btn-solid-border pull-right">Thanh toán</button>
                                        </form>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-checkout-details">
                        <div class="block">
                            <h4 class="widget-title">Đơn hàng</h4>
                            <?php
                    $getcart = $ct->getProductCart();
                    if($getcart){
                        $totalCart=0;
                       
                        while ($result=$getcart->fetch_assoc()){
                    ?>
                            <div class="media product-card">
                                <a class="pull-left" href="details.php?proId=<?php echo $result['productId']?>">
                                    <img class="media-object" src="admin/uploads/<?php echo $result['image']?>"
                                        alt="image">
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading"><a
                                            href="details.php?proId=<?php echo $result['productId']?>"><?php echo $result['productName']?></a>
                                    </h4>
                                    <p>Số lượng sản phẩm: <?php echo $result['quantity']?> </p>
                                    <p> Giá tiền: <?php echo $fm->format_currency($result['price'])." "."VNĐ"?></p>
                                    <?php $total= $result['price'] * $result['quantity'];?>
                                    <span class="remove"><a href="?cartId=<?php echo $result['cartId']?>"><i
                                                class="fas fa-trash"></i></a></span>
                                </div>
                            </div>
                            <?php
                     $totalCart += $total; }}?>
                            <ul class="summary-prices">
                                <?php if($getcart){?>
                                <li>
                                    <span>Thành tiền:</span>
                                    <span class="price"><?php echo $fm->format_currency($totalCart)." "."VNĐ"?></span>
                                </li>
                                </br>
                                <li>
                                    <span>Shipping:</span>
                                    <span>Free</span>
                                </li>
                            </ul>
                            </br>
                            <div class="summary-total">
                                <span>Tổng cộng</span>
                                <span><?php echo $fm->format_currency($totalCart)." "."VNĐ"?></span>
                            </div>
                            <?php }else{
                        // header('location: cart.php');
                     }?>
                            <div class="verified-icon">

                                <!-- <input name="submit" type="submit" class="btn btn-submit btn-solid-border pull-right" value="Thanh toán"></input> -->
                                <a href="cart.php" class="btn btn-submit btn-solid-border">Quay về giỏ hàng</a>
                                <!-- <a href="?orderid=order" class="btn btn-submit btn-solid-border pull-right" >Thanh toán </a> -->


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'inc/footer.php';
?>