<?php
include("dbConnection.php");
session_start();

if(isset($_POST['login'])){
$username = $_POST['username'];
$password = md5($_POST['password']);

$sql = "SELECT * FROM userdetails WHERE username = '$username' AND password = '$password'";

$result = mysqli_query($connection, $sql) or die(mysqli_error($connection));

$count = mysqli_num_rows($result);
if($count == 1){
    $user = mysqli_fetch_assoc($result);
    if($user['Role'] == 1){
        $_SESSION['adminUsername'] = $username;
        header("Location:adminDashboard.php");
    }
    else{
        $_SESSION['username'] = $username;
        header("Location:userDashboard.php");
    }
}
else{
    echo "Unable to login<br>Invalid credentials.";
}

}
?>
