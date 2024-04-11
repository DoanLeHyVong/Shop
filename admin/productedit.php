<?php 
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/product.php';
include '../classes/category.php';
include '../classes/brand.php';


$product = new Product(); 

// Kiểm tra xem có thông tin sản phẩm cần chỉnh sửa không
if(isset($_GET['productid']) && $_GET['productid'] != NULL) {
    $id = $_GET['productid'];
} else {
    echo "<script>window.location = 'productlist.php';</script>";
}

// Kiểm tra xem có dữ liệu được gửi từ form không
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy thông tin sản phẩm từ form
    $productName = $_POST['productName'];
    $categoryId = $_POST['categoryId'];
    $brandId = $_POST['brandId'];
    $productDesc = $_POST['productDesc'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $updateProduct = $product->update_product($productName, $categoryId, $brandId, $productDesc, $type, $price, $id, $quantity);
}


?>
<link rel="stylesheet" href="../admin/css/style.css">
<div class="grid_10">
    <div class="box round first grid">
        <h2>Chỉnh sửa sản phẩm</h2>
        <div class="block copyblock">
            <?php
            if(isset($updateProduct)){
                echo $updateProduct;
            }
            ?>
            <?php
            // Lấy thông tin sản phẩm từ cơ sở dữ liệu
            $getProductInfo = $product->getProductById($id);
            if($getProductInfo) {
                while ($result = $getProductInfo->fetch_assoc()) {
            ?>
            <form action="" method="post">
                <table class="form">
                    <tr>
                        <td>
                            <label>Tên sản phẩm:</label>
                        </td>
                        <td>
                            <input type="text" value="<?php echo $result['productName'] ?>" name="productName"
                                placeholder="Nhập tên sản phẩm..." class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Danh mục:</label>
                        </td>
                        <td>
                            <!-- Hiển thị danh sách danh mục hiện có -->
                            <?php
                            $category = new Category();
                            $categories = $category->getCategories();
                            if($categories) {
                                echo "<select name='categoryId'>";
                                while ($catResult = $categories->fetch_assoc()) {
                                    if($catResult['catId'] == $result['categoryId']) {
                                        echo "<option value='{$catResult['catId']}' selected>{$catResult['catName']}</option>";
                                    } else {
                                        echo "<option value='{$catResult['catId']}'>{$catResult['catName']}</option>";
                                    }
                                }
                                echo "</select>";
                            } else {
                                echo "No category found";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Thương hiệu:</label>
                        </td>
                        <td>
                            <!-- Hiển thị danh sách thương hiệu hiện có -->
                            <?php
                            $brand = new Brand();
                            $brands = $brand->getBrands();
                            if($brands) {
                                echo "<select name='brandId'>";
                                while ($brandResult = $brands->fetch_assoc()) {
                                    if($brandResult['brandId'] == $result['brandId']) {
                                        echo "<option value='{$brandResult['brandId']}' selected>{$brandResult['brandName']}</option>";
                                    } else {
                                        echo "<option value='{$brandResult['brandId']}'>{$brandResult['brandName']}</option>";
                                    }
                                }
                                echo "</select>";
                            } else {
                                echo "No brand found";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Mô tả:</label>
                        </td>
                        <td>
                            <textarea name="productDesc"
                                class="tinymce"><?php echo $result['product_desc'] ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Loại:</label>
                        </td>
                        <td>
                            <input type="radio" name="type" value="0"
                                <?php if($result['type'] == 0) echo "checked"; ?>>Feathered
                            <input type="radio" name="type" value="1"
                                <?php if($result['type'] == 1) echo "checked"; ?>>Non-Feathered
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Giá:</label>
                        </td>
                        <td>
                            <input type="text" value="<?php echo $result['price'] ?>" name="price"
                                placeholder="Nhập giá sản phẩm..." class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Số Lượng:</label>
                        </td>
                        <td>
                            <input type="text" value="<?php echo $result['quantity'] ?>" name="quantity"
                                placeholder="Nhập số lượng sản phẩm..." class="medium" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="submit" name="submit" Value="Cập nhật" />
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