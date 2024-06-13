<?php
include("dbConnection.php");

if(isset($_GET['id'])& isset($_GET['action'])){
    $id=$_GET['id'];
    $action = $_GET['action'];
    
    switch($action){
        case 'edit':{
            $sql="SELECT * from product WHERE ID=$id";
            $qry=mysqli_query($connection, $sql)or die(mysqli_error($connection));
            while($row=mysqli_fetch_array($qry)){
                $id=$row['ID'];
                $name=$row['Name'];
                $price = $row['Price'];
                $image = $row['Image'];
                $category = $row['Category'];
                // $imgName = $_FILES["pImage"]["name"];
                echo "<form method='post' name=editproduct action='editProductProcess.php' enctype='multipart/form-data'>";
                echo "<fieldset>";
                echo "<legend>Edit $name Details</legend>";
                echo "<label>ID</label><br>";
                echo "<input type='text' name='id' value='$id' readonly><br>";
        
                echo "<label>Name</label><br>";
                echo "<input type='text' name='name' value='$name'><br>";
        
                echo "<label>Price</label><br>";
                echo "<input type='text' name='price' value='$price'><br>";
                
                echo "<label>Category</label><br>";
                echo "<select name='pCat'>";
                echo "<option>Select category</option>";

                // List of categories
                $categories = array('Musical_Instrument', 'Books', 'Dress');

                // Loop through categories and generate options
                foreach ($categories as $categoryOption) {
                    $selected = ($categoryOption == $category) ? "selected" : "";
                    echo "<option value='$categoryOption' $selected>$categoryOption</option>";
                }
                echo "</select><br>";

                echo "<label>Image:</label><br>";
                echo "<img src='images/$image' height='100px' width='100px'><br>";
                echo "<input type='file' name ='pImage'>";

                echo "<br><input type='submit' name='editProduct' value='Edit'>";
                echo "</fieldset>";
                echo "</form>";
            }
            break;

        }
        default:{
            echo "Unauthorized Operations.<br>";
        }

    } 
}
?>