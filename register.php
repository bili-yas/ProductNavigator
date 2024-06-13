<?php
include("dbConnection.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Register</legend>
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
            <label>Email</label>
            <input type="text" name="email" value="<?php
                if(isset($_POST['email'])){
                    echo $_POST['email'];
                }
            ?>">
            <br>
            <label>Age</label>
            <select name="age">
                <option value="Select Age">-Select Age-</option>
            <?php

                for($age = 1; $age < 151; $age++){
                    echo "<option value=\"$age\"";
                    if(isset($_POST['age']) && $_POST['age'] == $age){
                        echo "selected";
                    }
                    echo ">$age</option><br>";
                }
            ?>
            </select>
            <br>
            <label>Accept terms and conditions</label>
            <input type="checkbox" value="agreed" name="confirm"<?php echo isset($_POST['confirm']) ? 'checked' : ''; ?>>
            <br>
            <input type="submit" value="Register" name="register">
            <br>
        </fieldset>
    </form>

    <?php
    if(isset($_POST['register'])){
        if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])){
            echo "Please fill in all the fields.<br>";
        }
        else if(strlen($_POST['username']) < 6){
            echo "Username should be atleast of 6 characters.<br>";
        }
        else if(!preg_match("/^[a-zA-Z\s]+$/", $_POST['username'])){
            echo "Username cannot contain number or special characters.<br>";
        }
        else if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $_POST['password'])){
            echo "Password should contain atleast one uppercase, one lowercase and a number.<br>";
        }
        else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            echo "Invalid Email format.<br>";
        }
        else if((int)$_POST['age'] < 1){
            echo "Please select age.<br>";
        }
        else if(empty($_POST['confirm'])){
            echo "Please accept terms and conditions.<br>";
        }
        else{
            $user = trim($_POST['username']);
            $pass = md5($_POST['password']);
            $email = $_POST['email'];
            $age = $_POST['age'];
            $confirm="Agreed<br/>";

            $existingUserQuery = mysqli_query($connection, "SELECT * FROM userdetails WHERE Username = '$user'");
            if (mysqli_num_rows($existingUserQuery) > 0) {
                echo "Username already exists.<br>";
            }
            else{
                $existingEmailQuery = mysqli_query($connection, "SELECT * FROM userdetails WHERE Email = '$email'");
                if (mysqli_num_rows($existingEmailQuery) > 0) {
                    echo "Email already exists.<br>";
                }
                else {
                    // Insert the new user
                    // $pass = md5($_POST['password']);
                    $sql = "INSERT INTO userdetails(Username, Password, Email, Age) VALUES('$user', '$pass', '$email', '$age')";
                    $query = mysqli_query($connection, $sql);
        
                    if ($query) {
                        if (isset($_SESSION['adminUsername'])) {
                            echo "<script>window.location.href = 'adminDashboard.php';</script>";
                        } else {
                            echo "Registration successful.<br>";
                            echo "Go to Login page<br>";
                            echo "<a href='login.php'>Login<br>";
                        }
                    } else {
                        echo "Registration failed.<br>";
                    }
                }
            }
        }
    }
?>
</body>
</html>
