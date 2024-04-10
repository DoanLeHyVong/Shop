<?php 
    include_once 'inc/header.php';
    include_once 'inc/sidebar.php';
    include_once '../classes/user.php';

    $user = new User();

    if(!isset($_GET['id']) || $_GET['id'] == null){
        echo "<script>window.location = 'inbox.php'</script>";
    } else {
        $userId = $_GET['id'];
    }
?>

<link rel="stylesheet" href="../admin/css/style.css">
<div class="grid_10">
    <div class="box round first grid">
        <h2>Khách hàng</h2>
        <table class="data display datatable" id="example">
            <thead>
                <tr>
                    <th>Tên đăng nhập</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Gọi hàm getAllUser để lấy thông tin của người dùng với id tương ứng
                    $getUser = $user->getAllUser($userId);
                    
                    // Kiểm tra xem có dữ liệu trả về hay không
                    if($getUser){
                        while ($result = $getUser->fetch_assoc()){
                ?>
                <tr class="odd gradeX">
                    <td><?php echo $result['username'];?></td>
                    <td><?php echo $result['address'];?></td>
                    <td><?php echo $result['phone'];?></td>
                    <td><?php echo $result['email'];?></td>
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

<?php include 'inc/footer.php';?>