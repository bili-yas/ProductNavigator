<?php
include("dbConnection.php");
if(isset($_POST["editProduct"])){
    $id = $_POST['id'];
    $name=$_POST["name"];
    $price=$_POST["price"];
    $cat = $_POST["pCat"];

    $imgName = $_FILES["pImage"]["name"];
    $imgSize = $_FILES["pImage"]["size"];
    $imgType = $_FILES["pImage"]["type"];
    $tmp = $_FILES["pImage"]["tmp_name"];
    $uploadfile = "images/".$imgName;

    if(!empty($imgName)){
        $sql = "UPDATE product SET Name='$name', Price='$price', Category='$cat', Image='$imgName' WHERE ID=$id";

        if(move_uploaded_file($tmp, $uploadfile)){
            echo "Image uploaded.<br>";
        }
        else{
            echo "Error uploading image.<br>";
        }
    }
    else{
        $sql="UPDATE product SET Name='$name', Price='$price', Category='$cat' WHERE ID=$id";
    }

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