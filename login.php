<?php
include_once('classes/user.php');

$user = new User();
$login = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $login = $user->loginUser($_POST);
}
?>
<?php
$login_check= Session::get('user_login');
if($login_check){
	header('location: index.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/login.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>

<body>
    <div class="container">
        <form action="" method="post">
            <h2>Login</h2>
            <?php
            if(!empty($login)){
                echo $login;
            }
            ?>
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <button type="submit" name="login" class="btn">Login</button>
            </div>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>
    </div>
</body>

</html>