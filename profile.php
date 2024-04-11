<?php
include 'inc/header.php';
?>
<?php
 $login_check= Session::get('user_login');
if($login_check==false){
    header('location: login.php');
}?>

<?php

?>
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                    <h1 class="page-name">Thông tin tài khoản</h1>
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

            <table class="table table-bordered table-dark">
                <?php
                $id=Session::get('user_id');
                $getUser = $user->getAllUser($id);
                if($getUser){
                    while($result=$getUser->fetch_assoc()){
                ?>
                <thead>
                    <th>Tên</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                </thead>
                <tbody>
                    <td><?php echo $result['username'];?></td>
                    <td><?php echo $result['address'];?></td>
                    <td><?php echo $result['phone'];?></td>
                    <td><?php echo $result['email'];?></td>

                </tbody>
                <td colspan="4"><a href="editProfile.php" class="btn btn-submit btn-solid-border pull-right">Cập nhật
                        thông tin</a></td>
                <?php     }
                }
                ?>
            </table>
        </div>

    </div>
    </div>

    <?php
include 'inc/footer.php';
?>