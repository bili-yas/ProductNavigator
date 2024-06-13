<?php
session_start();
if(isset($_SESSION["username"]) || $_SESSION["adminUsername"]){
    session_destroy();
    header("location:login.php");
}
else{
    header("location:login.php");
}
?>