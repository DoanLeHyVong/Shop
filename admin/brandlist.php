<body>

    <?php 
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/brand.php';

$brand = new Brand(); 

if(isset($_GET['delid'])) {
    $id = $_GET['delid'];
    $delbrand = $brand->del_brand($id);
}

?>
    <link rel="stylesheet" href="../admin/css/style.css">


    <div class="grid_10">
        <div class="box round first grid">
            <h2>Brand List</h2>
            <div class="block">
                <?php
            if(isset($delbrand)){
                echo $delbrand;
            }
            ?>
                <table class="data display datatable" id="example">
                    <button class="add-brand" onclick="window.location.href='brandadd.php'">Add Brand</button>
                    <thead>
                        <tr>
                            <th>Serial No.</th>
                            <th>Brand Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $brands = $brand->getBrands();
                        if ($brands) {
                            $i = 0;
                            while ($result = $brands->fetch_assoc()) {
                                $i++;
                                ?>
                        <tr class="odd gradeX">
                            <td><?php echo $i; ?></td>
                            <td><?php echo $result['brandName']; ?></td>
                            <td class="action-links">
                                <a href="brandedit.php?brandid=<?php echo $result['brandId'] ?>">Edit</a>||
                                <a onclick="return confirm('Are you sure you want to delete?')"
                                    href="?delid=<?php echo $result['brandId'] ?>">Delete</a>
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

    <?php include 'inc/footer.php';?>

</body>

</html>