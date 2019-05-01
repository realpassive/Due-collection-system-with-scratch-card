<?php
include './session_control.php';
 include_once("includes/db.inc.php");

 if(isset($_POST['submit'])){
     $DB_pass = "";
     $error= array();
if(empty($_POST['passkey'])){
    
 echo "<script> alert('please enter a passkey')</script>";
       exit();
}
else if (!empty ($_POST['passkey'])) {
$passkey = mysqli_real_escape_string($link,trim($_POST['passkey']));
 
$sql = "SELECT passcode FROM nacoss_login WHERE passcode = '$passkey' AND email = '$email' LIMIT 1";
     $result = mysqli_query($link, $sql);
	$passkey_check = mysqli_num_rows($result);
        
          if($passkey_check != 1) {
              
echo "<script> alert('wrong passkey entered')</script>";
   
  //exit();
}
   elseif($passkey_check == 1) {
  
   $sql = "UPDATE nacoss_login SET passtest = '1' WHERE email='$email' LIMIT 1";
         $query = mysqli_query($link, $sql);
 echo "<script> alert('Congratulation your passkey has been activated')</script>";
           echo "<script>location='nacoss_report.php'</script>";
}
}

     
 }
 
?>
<html>
<head>
    <title>
    yakzy
    </title>
 <link rel="stylesheet" href="edit.css" type="text/css">
 <style>
       
    #go{
text-align: center;
margin-top: 300px;
box-shadow: 5px 2px 12px 4px red;    
width: 350px;
    margin-left: 500px
}
        </style>
    </head>
    <body>
   <div id="go"> 
       <div style="color:red; font-family:sans-serif; font-size:18px;"><?php if(isset($_POST['submit'])){  $error;} ?></div>
       <form action="key.php" method="post">
       <div id="wrap">
          <h1>Yakzy Pass key activator</h1>
          
Passkey:    <input type="password" name="passkey" class="go">
<input type="submit" value="submit" name="submit">
        
        </div>

        </form>
</div>
       </body>
        


</html>
