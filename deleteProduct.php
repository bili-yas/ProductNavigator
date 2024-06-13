<?php
include("dbConnection.php");
if(isset($_GET['id'])& isset($_GET['action'])){
    $id=$_GET['id'];
    $action=$_GET['action'];
    switch($action){
        case 'delete':{
            // echo "You are going to delete the record";
            if($id == 7){
                header("Location:adminDashboard.php?message=AdminCannotBeDeleted");
            }
            else{
                $sql="DELETE from product WHERE ID=$id";
            //executing the query
                $qry=mysqli_query($connection, $sql)or die(mysqli_error($connection));
                if($qry){
                    header("Location:adminDashboard.php?message=Item deleted");
                }
                break;
            }  
        }
        default:{
            echo "Unauthorized operations";
            break;
        }
    }
}
else{
    header("Location:adminDashboard.php");
}

?>