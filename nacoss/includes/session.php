<?php
 session_start();
 if(isset($_SESSION['id'])){
     require_once ('function.php');
     $id = database_clean($_SESSION['id']);
     
 }
 else {
    
     redirect_to('login.php');     
}
