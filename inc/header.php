`<?php 
    ob_start();
    include_once('lib/session.php');
    Session::init();    
    include_once("lib/database.php");
    include_once("helpers/format.php");
?>

<?php
spl_autoload_register(function($className) {
    include_once "classes/".$className.".php";
});

$db = new Database();
$fm = new Format();
$ct = new Cart();
$cat = new Category();
$product = new Product();
$brand = new Brand();
$user = new User();

if (isset($_GET["action"]) && $_GET['action'] == 'logout') {
    Session::destroy();
    header("Location: index.php");
    exit();
}

?>
<?php
// Set no cache headers
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: " . gmdate("D, d M Y H:i:s", strtotime("5 April 2024")) . " GMT"); // Sử dụng ngày giờ hiện tại
header("Cache-Control: max-age=2592000");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Panda Shop</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
    <script src="assets/js/jquerymain.js"></script>
    <script src="assets/js/script.js" type="text/javascript"></script>
    <script type="text/javascript" src="assets/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="assets/js/nav.js"></script>
    <script type="text/javascript" src="assets/js/move-top.js"></script>
    <script type="text/javascript" src="assets/js/easing.js"></script>
    <script type="text/javascript" src="assets/js/nav-hover.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Link CSS của Font Awesome từ CDN -->



    <script type="text/javascript">
    $(document).ready(function($) {
        $('#dc_mega-menu-orange').dcMegaMenu({
            rowItems: '4',
            speed: 'fast',
            effect: 'fade'
        });
    });
    </script>
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">
                <img style="max-width:50px" src="assets/images/panda.png" alt="PandaShop Logo">
            </a>
            <a class="navbar-brand" href="index.php">Panda Shop</a>

            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li nav-item><a href="index.php" class="button">Home</a></li>

                <li nav-item><a href="products.php" class="button">Products</a></li>
                <li class="dropdown">
                    <a class="dropbtn">Top Brands</a>
                    <div class="dropdown-content">
                        <?php
                        $brands = $brand->getBrands();
                        if ($brands) {
                            while ($brand = $brands->fetch_assoc()) {
                                echo "<a href='productbybrand.php?brandid={$brand['brandId']}'>{$brand['brandName']}</a>";
                            }
                        } else {
                            echo "<span>No brands found</span>";
                        }
                        ?>
                    </div>
                </li>
                <!-- HTML -->
                <li class="dropdown">
                    <a class="dropbtn">Categories</a>
                    <div class="dropdown-content">
                        <?php
                        $categories = $cat->getCategories();
                        if ($categories) {
                            while ($category = $categories->fetch_assoc()) {
                                echo "<a href='productbycat.php?catid={$category['catId']}'>{$category['catName']}</a>";
                            }
                        } else {
                            echo "<p>No categories found</p>";
                        }
                        ?>
                    </div>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <?php 
            $login_check = Session::get('user_login');
            if($login_check == false){
                echo '<a class="nav-link" href="login.php">Login</a>';
            } else {
                echo '<a class="nav-link" href="?action=logout">Logout</a>';
            }
        ?>
                </li>
            </ul>






            <!-- Cart button -->
            <form style="margin-bottom: 0" class="d-flex">
                <?php 
                    $getcart = $ct->getProductCart();
                    if($getcart) {
                        $totalPrice = 0; 
                        while($result = $getcart->fetch_assoc()) {
                            $totalPrice += $result['price'] * $result['quantity'];
                        }
                ?>
                <a href="cart.php" class="btn btn-outline-dark">
                    <i class="bi-cart-fill me-1"></i>
                    Cart
                    <span class="badge bg-dark text-white ms-1 rounded-pill">
                        <?php echo $fm->format_currency($totalPrice)." VNĐ"; ?>
                    </span>
                </a>
                <?php 
                    } else {
                        echo 'Giỏ hàng trống!';
                    }
                ?>
            </form>


        </div>
    </nav>
    <!-- Header-->

</body>
<script>
$(document).ready(function() {
    $('.dropdown-toggle').dropdown();
});
</script>