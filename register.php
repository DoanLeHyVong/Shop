<?php
include_once('classes/user.php');

$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $insertUser = $user->insertUser($_POST);
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Registration</title>
    <link rel="stylesheet" href="assets/css/login.css" />
</head>

<body>
    <div class="container">
        <?php
        if(!empty($insertUser)){
            echo $insertUser;
        }
        ?>
        <form action="" method="post">
            <h2>Register</h2>
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <button type="submit" name="submit" class="btn">Register</button>
            </div>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</body>

</html>