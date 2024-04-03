<body>
    <?php 
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/category.php';

$cat = new Category(); 

if(isset($_GET['delid'])) {
    $id = $_GET['delid'];
    $delcat = $cat->del_category($id);
}

?>
    <link rel="stylesheet" href="../admin/css/style.css">

    <div class="grid_10">
        <div class="box round first grid">
            <h2>Category List</h2>

            <div class="block">
                <?php
            if(isset($delcat)){
                echo $delcat;
            }
            ?>
                <table class="data display datatable" id="example">
                    <button class="add-category" onclick="window.location.href='catadd.php'">Add Category</button>
                    <thead>
                        <tr>
                            <th>Serial No.</th>
                            <th>Category Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $categories = $cat->getCategories();
                        if ($categories) {
                            $i = 0;
                            while ($result = $categories->fetch_assoc()) {
                                $i++;
                                ?>
                        <tr class="odd gradeX">
                            <td><?php echo $i; ?></td>
                            <td><?php echo $result['catName']; ?></td>
                            <td class="action-links">
                                <a href="catedit.php?catid=<?php echo $result['catId'] ?>">Edit</a> ||
                                <a onclick="return confirm('Are you sure you want to delete?')"
                                    href="?delid=<?php echo $result['catId'] ?>">Delete</a>
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