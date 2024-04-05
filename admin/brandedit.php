<?php 
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/brand.php';

$brand = new Brand(); 

if(isset($_GET['brandid']) && $_GET['brandid'] != NULL) {
    $id = $_GET['brandid'];
} else {
    echo "<script>window.location = 'brandlist.php';</script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $brandName = $_POST['brandName'];
    $updateBrand = $brand->update_brand($brandName, $id);
}

?>
<link rel="stylesheet" href="../admin/css/style.css">
<div class="grid_10">
    <div class="box round first grid">
        <h2>Sửa thương hiệu</h2>
        <div class="block copyblock">
            <?php
            if(isset($updateBrand)){
                echo $updateBrand;
            }
            ?>
            <?php
            $get_brand_name = $brand->getBrandById($id);
            if($get_brand_name) {
                while ($result = $get_brand_name->fetch_assoc()) {
            ?>
            <form action="" method="post">
                <table class="form">
                    <tr>
                        <td>
                            <input type="text" value="<?php echo $result['brandName'] ?>" name="brandName"
                                placeholder="Sửa tên thương hiệu..." class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" name="submit" Value="Save" />
                        </td>
                    </tr>
                </table>
            </form>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>

<?php include 'inc/footer.php';?>