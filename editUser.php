<?php
include("dbConnection.php");

if(isset($_GET['id'])& isset($_GET['action'])){
    $id=$_GET['id'];
    $action = $_GET['action'];
    
    switch($action){
        case 'edit':{
            $sql="SELECT * from userdetails WHERE Id=$id";
            $qry=mysqli_query($connection, $sql)or die(mysqli_error($connection));
            while($row=mysqli_fetch_array($qry)){
                $id=$row['Id'];
                $name=$row['Username'];
                $email = $row['Email'];
                $age = $row['Age'];
                echo "<form method='post' name=edituser action='editUserProcess.php'>";
                echo "<fieldset>";
                echo "<legend>Edit $name Record</legend>";
                echo "<label>ID</label><br>";
                echo "<input type='text' name='id' value='$id' readonly><br>";
        
                echo "<label>Name</label><br>";
                echo "<input type='text' name='name' value='$name'><br>";
        
                echo "<label>Email</label><br>";
                echo "<input type='text' name='email' value='$email'><br>";
        
                echo "<label>Age</label><br>";
                echo "<input type='text' name='age' value='$age'><br>";
        
                echo "<br><input type='submit' name='editUser' value='Edit'>";
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


