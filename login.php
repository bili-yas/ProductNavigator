<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
</head>
<body>
    <form action="validateLogin.php" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Login</legend>
            <label>Username</label>
            <input type="text" name="username" value="<?php
                if(isset($_POST['username'])){
                    echo $_POST['username'];
                }
            ?>">
            <br>
            <label>Password</label>
            <input type="password" name="password" value="<?php
                if(isset($_POST['password'])){
                    echo $_POST['password'];
                }
            ?>">
            <br>
            <!-- <label for="">Email</label>
            <input type="text" name="email">
            <br> -->
            <label>Remember me</label>
            <input type="checkbox" value="1">
            <br>
            <input type="submit" value="Login" name="login">
            <br>
            <a href="sendEmail.php">Forgot password?  </a>
            <a href="register.php">| Register </a>
            <a href="../../index.php">| watIndex</a>
        </fieldset>
    </form>
</body>
</html>