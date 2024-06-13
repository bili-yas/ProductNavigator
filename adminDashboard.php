<?php
session_start();
if(!isset($_SESSION['adminUsername'])){
    header("Location: login.php");
    exit();
}


?>
<?php
include("dbConnection.php");

echo "Welcome ".$_SESSION['adminUsername']." ". "| <a href = logout.php>Logout</a>";
echo "<hr>";

echo "<h2>Users Details</h2>";
echo "<a href=register.php>Add Users</a>";
echo "<br>";
echo "<br>";

echo "<table border=1>";
echo "<tr>";
echo "<th>ID</th>";
echo "<th>Username</th>";
echo "<th>Password</th>";
echo "<th>Email</th>";
echo "<th>Age</th>";
echo "<th>Action</th>";
echo "</tr>";

$sql = "SELECT * FROM userdetails";
$result = mysqli_query($connection, $sql);
while($row = mysqli_fetch_array($result)){
    $id = $row['Id'];
    echo "<tr>";
    echo "<td>";
    echo $row['Id'];
    echo "</td>";
    echo "<td>";
    echo $row['Username'];
    echo "</td>";
    echo "<td>";
    echo $row['Password'];
    echo "</td>";
    echo "<td>";
    echo $row['Email'];
    echo "</td>";
    echo "<td>";
    echo $row['Age'];
    echo "</td>";
    echo "<td>";
    echo "<a href=editUser.php?id=$id&action=edit>Edit | </a>";
    echo "<a href=deleteUser.php?id=$id&action=delete>Delete</a>";
    echo "</td>";
    echo "</tr>";
}
echo "</table>";
echo "<br>";

?>

<hr>

<?php
echo "<h2>Product Details:</h2>";

echo "<table border=1>";
echo "<tr>";
echo "<th>ID</th>";
echo "<th>Name</th>";
echo "<th>Price</th>";
echo "<th>Category</th>";
echo "<th>Image</th>";
echo "<th>Action</th>";
echo "</tr>";

$sql = "SELECT * FROM product";
$result = mysqli_query($connection, $sql);
while($row = mysqli_fetch_array($result)){
    $pId = $row['ID'];
    echo "<tr>";
    echo "<td>";
    echo $row['ID'];
    echo "</td>";
    echo "<td>";
    echo $row['Name'];
    echo "</td>";
    echo "<td>";
    echo $row['Price'];
    echo "</td>";
    echo "<td>";
    echo $row['Category'];
    echo "</td>";
    echo "<td>";
    $image = $row['Image'];
    echo "<img src = images/$image widht = 100 height = 100>";
    echo "</td>";
    echo "<td>";
    echo "<a href=editProduct.php?id=$pId&action=edit>Edit | </a>";
    echo "<a href=deleteProduct.php?id=$pId&action=delete>Delete</a>";
    echo "</td>";
    echo "</tr>";
}

echo "</table>";
?>
<h3>Add Product</h3>
<form method="POST" enctype="multipart/form-data" name="productForm">
    <fieldset>
        <legend>Add Product</legend>
        <label>Product Name:</label>
        <input type="text" name ="pName">
        <br>
        <label>Price:</label>
        <input type="text" name="pPrice">
        <br>
        <label>Category:</label>
        <select name="pCategory">
            <option>Select category</option>
            <option value="Musical_Instrument">Musical Instrument</option>
            <option value="Books">Books</option>
            <option value="Dress">Clothing</option>
        </select>
        <br>
        <label>Image file:</label>
        <input type="file" name ="pImage">
        <br>
        <input type="submit" value="Add" name="submitProduct">
    </fieldset>
</form>

<?php
    if(isset($_POST['submitProduct'])){
        $pName = $_POST['pName'];
        $pPrice = $_POST['pPrice'];
        $pCat = $_POST['pCategory'];

        //capturing the file information
        $imgName = $_FILES["pImage"]["name"];
        $imgSize = $_FILES["pImage"]["size"];
        $imgType = $_FILES["pImage"]["type"];
        $tmp = $_FILES["pImage"]["tmp_name"];
        $uploadfile = "images/".$imgName;


        if(empty($pName) || empty($pPrice) || empty($pCat)){
            echo "Please fill all the fields.<br>";
        }
        else if(empty($imgName)){
            echo "Please upload item image<br>";
        }

        else if($imgType=="pImage/jpeg" || $imgType=="pImage/jpg" || $imgType=="pImage/gif" ||$imgType=="pImage/png"){
            echo "Unsupported file format";
        }

        else{
            $sql = "INSERT INTO product(Name, Price, Category, Image) Values ('$pName', '$pPrice', '$pCat', '$imgName')";
            $query = mysqli_query($connection, $sql);
            
            if(move_uploaded_file($tmp,$uploadfile)){
                echo "Image Uploaded<br>";
                echo "<img src=images/$imgName width=200px height=200px>";
            }
        }
    }
    ?>