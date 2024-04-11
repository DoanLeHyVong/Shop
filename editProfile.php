<?php
include 'inc/header.php';
?>
<?php
 $login_check= Session::get('user_login');
if($login_check==false){
    header('location: login.php');
}?>

<?php

  $id=Session::get('user_id');
if($_SERVER['REQUEST_METHOD']==='POST'&& isset($_POST['submit'])){
	
	$updateUser = $user->updateUser($id,$_POST);
}
?>
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                    <h1 class="page-name">Cập nhật thông tin tài khoản</h1>
                    <ol class="breadcrumb">
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="single-product">
    <div class="container">
        <div class="row">
            <form action="" method="post">
                <table class="table table-bordered table-dark">
                    <?php if(isset($updateUser)) {
                 echo'<thead colspan="4">'.$updateUser.'</thead>';
               }?>
                    <?php
                $id=Session::get('user_id');
                $getuser = $user->getAllUser($id);
                if($getuser){
                    while($result=$getuser->fetch_assoc()){
                ?>
                    <thead>
                        <th>Tên</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                    </thead>
                    <tbody>
                        <td><input type="text" name="username" value="  <?php echo $result['username'];?>">
                        <td><input type="text" name="address" value="  <?php echo $result['address'];?>">
                        <td><input type="text" name="phone" value="  <?php echo $result['phone'];?>">
                        <td><input type="text" name="email" value="  <?php echo $result['email'];?>">

                    </tbody>
                    <td colspan="4"><input type="submit" name="submit" value="Cập nhật"
                            class="btn btn-submit btn-solid-border pull-right"></input></td>
                    <?php     }
                }
                ?>
                </table>
            </form>
        </div>

    </div>
    </div>

    <?php
include 'inc/footer.php';
?>