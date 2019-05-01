<?php session_start(); ?>

<?php
include_once("includes/db.inc.php");
	
if(isset($_POST['submit'])){
$error= array();
		
//email id		
if(empty($_POST['email'])){
$error[]='please enter an ID. ';
}else if (!empty ($_POST['email'])) {
$email = mysqli_real_escape_string($link, strip_tags($_POST['email']));
} 		
//password
if(empty($_POST['pass'])){
$error[]='please enter a password.';
}else {
$upassword = md5($_POST['pass']);
$password = mysqli_real_escape_string($link, $upassword);
}	
		
if (empty ($error)){
                    
$sql = "SELECT id,ban,hits FROM tblreg WHERE email = '$email' OR matric = '$email' AND password = '$password' LIMIT 1";
$result = mysqli_query($link,$sql);
             
if(mysqli_num_rows($result)==1){
$row = mysqli_fetch_array($result);
    $id = $row['id'];
    $ban = $row['ban'];
    $hits = $row['hits'];
    if(isset($id ) AND $hits < 4 ){
       $_SESSION['id'] = $id;
   echo "<script>location='nass_payment.php'</script>";
      }
      elseif(isset($id ) AND  $hits >= 4 ) {
    $error_message ='<span class="error"> contact admin to unlock you</span> <br />';
  }
	                               					
}else{
$error_message ='<span class="error"> email ID or password is incorrect</span> <br /> <br />' ;
}
}else{
$error_message ='<span class="error">' ;
foreach($error as $key => $values) {
$error_message.= "$values";
}
$error_message.="</span> <br/><br/>";
}

}

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
     <link rel="stylesheet" href="css/custom.css"/>
<title>login page</title>
<style type="text/css">

.error{
    font-weight:bold;
    color: #FF0000;
}

</style>

﻿</head>
<body style="background:#fff;">
  <div class="jumbotronRE">
   <div class="container">
  <div class="row">
  <div class="col-lg-4 col-md-4 col-sm-4"></div>
  <div class="col-lg-6 col-md-6 col-sm-6" 
  style="box-shadow: -0.2px -0.2px 4px 4px #ccc;background:lightcyan; position: relative; border-radius: 4px;">
  <div class="logins" style=" padding:30px 10px;">
  <div class="login" style="font-size:18px; font-style:normal; margin-bottom:20px;">Login to your account</div>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <span id="error"><?php if(isset($_POST['submit'])){ echo $error_message; }?></span>
  <div class="form-group">
    <label for="exampleInputEmail1">Matric/Email</label>
    <input type="text" class="form-control" name="email" placeholder="Email or matric">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" name="pass" placeholder="Password">
  </div>
        <button type="submit" class="btn btn-default" name="submit">Login</button>
        <a href="signup.php" class="btn btn-lg btn-md btn-sm btn-primary">Register</a>
    </form>
    </div>
    </div>
    </div>
    </div>
    </div>
    
</body><br/><br/><br/><br/><br/><br/>
<?php include 'includes/footer.php'; ?>
</html>
