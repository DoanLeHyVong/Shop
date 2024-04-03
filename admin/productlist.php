<?php 
include_once 'inc/header.php';
include_once 'inc/sidebar.php';
include_once '../classes/category.php';
include_once '../classes/brand.php';
include_once '../classes/product.php';
include_once '../helpers/format.php';

$product = new Product();
$fm = new Format();

if(isset($_GET['delid'])) {
    $id = $_GET['delid'];
    $delProduct = $product->del_product($id);
}

?>
<link rel="stylesheet" href="../admin/css/style.css">
<div class="grid_10">
    <div class="box round first grid">
        <h2>Post List</h2>
        <div class="block">
            <?php
            if(isset($delProduct)){
                echo $delProduct;
            }
            ?>
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $products = $product->getProducts();
                        if ($products) {
                            $i = 0;
                            while ($result = $products->fetch_assoc()) {

                                $i++;
                        ?>
                    <tr class="odd gradeX">
                        <td><?php echo $i ?></td>
                        <td><?php echo $result['productName']; ?></td>
                        <td><?php echo $result['catName']; ?></td>
                        <td><?php echo $result['brandName']; ?></td>
                        <td><?php echo $fm->textShorten($result['product_desc'], 50); ?></td>
                        <td><?php echo ($result['type'] == 0) ? 'Feathered' : 'Non-Feathered'; ?></td>
                        <td><?php echo $result['price']; ?></td>
                        <td class="image-cell"><img src="uploads/<?php echo $result['image'] ?>" width="200"
                                height="200"></td>
                        <td class="action-links">
                            <a href="productedit.php?productid=<?php echo $result['productId']; ?>">Edit</a> ||
                            <a onclick="return confirm('Are you sure you want to delete?')"
                                href="?delid=<?php echo $result['productId']; ?>">Delete</a>
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

</body>

</html>