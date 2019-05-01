<?php
  session_start();
if(!isset($_SESSION['admin'])){
    header("location:logout.php");
}   
else {
    include("includes/db.inc.php");
    $email = $_SESSION['admin'];
   
}

?>