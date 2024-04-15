<?php
include 'inc/header.php';
?>
<?php
//  if(isset($_GET['cartId']) ){
//   $delId=$_GET['cartId'];
//   $delCart= $cart->deleteProCO($delId);
//   }
//   ?>
<?php
   $login_check= Session::exists('user_login');
   if($login_check==false){
	header('location: login.php');
 }
 
  ?>
<?php
  
  if(isset($_GET['confirmId'])){
    $ct=new Cart();
    $id = $_GET['confirmId'];
    $time = $_GET['time'];
    $price = $_GET['price'];
    $shiftConfirm=$ct->shiftConfirm($id,$time,$price);
  }
  ?>

<div class="page-wrapper">
    <div class="cart shopping">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="block">
                        <div class="product-list">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="">Sản phẩm</th>
                                        <th class="">Giá</th>
                                        <th class="">Số lượng</th>
                                        <th class="">Thành tiền</th>
                                        <th class="">Trạng thái</th>
                                        <th class="">Ngày đặt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                    $id=Session::get('user_id');
                    $getcart = $ct->getcartOdered($id);
                    if($getcart){
                        $totalCart=0;
                       
                        while ($result=$getcart->fetch_assoc()){
                    ?>
                                    <tr class="">
                                        <td class="">
                                            <div class="product-info">
                                                <a
                                                    href="details.php?proId=<?php echo $result['productId']?>"><?php echo $result['productName']?></a>
                                            </div>
                                        </td>
                                        <td class=""><?php echo $fm->format_currency($result['price'])." "."VNĐ"?></td>
                                        <td name="quantity"> <?php echo $result['quantity']?></td>
                                        <td class="">
                                            <?php $total= $result['price'] * $result['quantity']; echo $fm->format_currency($total)." "."VNĐ"?>
                                        </td>
                                        <td class="" name="status"><?php
                                            if($result['status']==0){
                                                echo '<span class="label label-warning">Đang xử lý</span>';
                                            }elseif($result['status']=='1'){?>
                                            <span class="label label-primary">Đang vận chuyển</span>
                                            <?php }else{
                                                echo '<span class="label label-success">Hoàn thành</span>';
                                            }
                                            ?>
                                        </td>
                                        <td class="">
                                            <?php 
                                            echo date('H:i d/m/Y',strtotime($result['dateOrder']));
                                            ?>
                                        </td>
                                        <?php
                                            if($result['status'] == 0) {
                                                // Trạng thái hiện tại là 0
                                            } elseif($result['status'] == '1') {
                                                // Trạng thái hiện tại là 1
                                                // Hiển thị liên kết "Đã nhận hàng"
                                                echo '<td><a href="?confirmId='.$id.'&price='.$result['price'].'&time='.$result['dateOrder'].'"><span class="label label-info">Đã nhận hàng</span></a></td>';
                                            } else {
                                                // Trạng thái hiện tại là gì đó khác
                                                echo '<td><span class="label label-info">OK</span></td>';
                                            }
                                            ?>

                                    </tr>

                                    <?php
                       $totalCart += $total;
                            }
                          }?>

                                </tbody>
                            </table>
                            <hr style="border:.2px solid #ccc">
                            <?php if($getcart){?>
                            <tr>
                                <th> <b>Tổng tiền:</b> </th>
                                <td><?php echo  $fm->format_currency($totalCart).' '.'VNĐ';  Session::set("total",$totalCart);?>
                                </td>
                            </tr>
                            <?php 
                    }else{
                  // echo '<p>Giỏ hàng đang trống!</p>';
                }?>
                            <!--                 
                <a href="checkout.php" class="btn btn-submit btn-solid-border pull-right"><b>Thanh toán</b></a>
                <a href="shop.php" class="btn btn-submit btn-solid-border pull-right"><b>Tiếp tục mua sắm</b></a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// include 'inc/footer.php';
?>