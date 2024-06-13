<?php
include("dbConnection.php");
if(isset($_POST["editUser"])){
    $id=$_POST["id"];
    $name=$_POST["name"];
    $email = $_POST["email"];
    $age = $_POST['age'];

    $sql="UPDATE userdetails SET Username='$name', Age='$age', Email='$email' WHERE Id=$id";
    
    $qry=mysqli_query($connection, $sql)or die(mysqli_error($connection));
    if($qry)
    {
        header("Location:adminDashboard.php?message=Data Updated Successfully");
    }
}
else{
    header("Location:adminDashboard.php");
}
?>