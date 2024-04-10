<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php $filepath = realpath(dirname(__FILE__));
    include_once ( $filepath.'/../classes/cart.php');?>
<?php
    if(isset($_GET['shiftId'])){
      $ct=new Cart();
      $shiftId = $_GET['shiftId'];
      $time = $_GET['time'];
      $price = $_GET['price'];
      $shift=$ct->shilfted($shiftId,$time,$price);
  
  }

  if(isset($_GET['delId'])){
    $ct=new Cart();
    $shiftId = $_GET['delId'];
    $time = $_GET['time'];
    $price = $_GET['price'];
    $delShift=$ct->delShift($shiftId,$time,$price);

}

?>

<link rel="stylesheet" href="../admin/css/style.css">
<div class="grid_10">
    <div class="box round first grid">
        <h2>List Order</h2>
        <div class="block">
            <?php
        if(isset($shift)){
          echo  $shift;
        }
        ?>
            <table class="data display datatable" id="example">
                <?php
        if(isset($shift)){
          echo  $shift;
        }
        ?>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Thời gian đặt hàng</th>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Id người dùng</th>
                        <th>Địa chỉ</th>
                        <th>Chức năng</th>
                    </tr>

                </thead>
                <tbody>
                    <?php
        $ct = new Cart();
        $get_inbox_cart = $ct->getInboxCart();
        if($get_inbox_cart){
          $i=0;
          while($result=$get_inbox_cart->fetch_assoc()){
            $i++;
          ?>

                    <tr class="odd gradeX">
                        <td><?php echo $i;?></td>
                        <td><?php echo date('H:i d/m/Y',strtotime($result['dateOrder']));?></td>
                        <!-- <td><img src="uploads/brand/" width="80px" alt="ImageBrand"></td> -->
                        <td><?php echo $result['productName'];?></td>
                        <td><?php echo $result['quantity'];?></td>
                        <td><?php echo $result['price'];?></td>
                        <td><?php echo $result['userId'];?></td>
                        <td><a href="user.php?id=<?php echo $result['userId']?>">Xem thông tin</a>
                        </td>
                        <td>
                            <?php if($result['status'] == 0): ?>
                            <a
                                href="?shiftId=<?php echo $result['id']?>&price=<?php echo $result['price'] ?>&time=<?php echo $result['dateOrder'] ?>">
                                <span class="label label-warning">Đang xử lý</span>
                            </a>
                            <?php elseif($result['status'] == 1): ?>
                            <a href="#">
                                <span class="label label-primary">Đã xử lý</span>
                            </a>
                            <?php else: ?>
                            <a
                                href="?delId=<?php echo $result['id']?>&price=<?php echo $result['price'] ?>&time=<?php echo $result['dateOrder'] ?>">
                                <span class="label label-danger">Xóa</span>
                            </a>
                            <?php endif; ?>
                        </td>


                    </tr>

                    <?php
                            }
                        }
                        ?>

                </tbody>

            </table>

        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    setupLeftMenu();
    $('.datatable').dataTable();
    setSidebarHeight();
});
</script>
<?php include 'inc/footer.php';?>