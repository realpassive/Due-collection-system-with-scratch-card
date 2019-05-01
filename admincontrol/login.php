<?php session_start(); ?>
<?php
include_once("includes/db.inc.php");
	
if(isset($_POST['submit'])){
$error= array();
		
//email id		
if(empty($_POST['email'])){
$error[]='please enter a email. ';
}	else if (!empty ($_POST['email'])) {
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
                    
$sql = "SELECT * FROM tbladmin WHERE email='$email' AND password='$password' LIMIT 1";
$result = mysqli_query($link,$sql);
             
if(mysqli_num_rows($result)==1){
$row = mysqli_fetch_array($result);
    $login_email = $row['email'];
    $active = $row['passtest'];
    $admin = $row['status'];
    if(isset($login_email ) AND $active == 0 ){
   $_SESSION['admin'] = $login_email;
   echo "<script>location='key.php'</script>";
      }
      elseif(isset($login_email ) AND $active == 1) {
      $_SESSION['admin'] = $login_email;
   echo "<script>location='index.php'</script>";
  }
   

	                               					
}else{
$error_message ='<span class="error"> email  or password is incorrect</span> <br /> <br />' ;
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
<title>login page</title>
<style type="text/css">
<!--
a:link {
	text-decoration: none;
	color: #FFFFFF;
}
a:visited {
	text-decoration: none;
	color: #FFFFFF;
}
a:hover {
	text-decoration: none;
	color: #FF0000;
}
a:active {
	text-decoration: none;
	color: #FFFFFF;
}
body {
	background-color: #CCCCCC;
	background-image: url(images/kk.jpg);
}
.style8 {
	font-size: 18px;
	color: #FFFFFF;
	font-weight: bold;
}
.style9 {
	font-size: 18px;
	font-weight: bold;
	color: #ADBFCA;
}
body,td,th {
	color: #FFFFFF;
}
.error{
    font-weight:bold;
    color: #FF0000;
}
.style12 {font-size: 20px}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
﻿</head>
<body>
<table width="863" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0">
  <!--DWLayoutTable-->
  <tr>
    <td width="5" height="4"></td>
    <td width="463"></td>
    <td width="510"></td>
    <td width="1"></td>
  </tr>
  <tr>
    <td height="42" colspan="4" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      <tr>
        <td width="975" height="63" align="center" valign="middle" bgcolor="3070B7"><div align="center" class="style9"><a href="index.php"><FONT COLOR="#FFFF00">Click to Go Back to Home</a></div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="19">&nbsp;</td>
    <td rowspan="2" align="center" valign="middle"><img src="images/banner1.jpeg" width="228" height="171" align="middle" longdesc="images/bn.png"></td>
    <td></td>
    <td></td>
  </tr>
  
  <tr>
    <td height="198">&nbsp;</td>
    <td valign="top" bgcolor="#FFFFFF"><form name="form1" method="post" action="">
             <div class="error">
              <?php if(isset($_POST['submit'])){ echo $error_message; }?>
             </div>
        <table width="386" height="180" border="0" align="center" background="images/lock.jpg">
          <!--DWLayoutTable-->
          <tr>
            <td width="17" height="28"></td>
            <td width="37"></td>
            <td width="92" align="right" valign="middle"><span class="style8"><FONT COLOR="#3300FF">Email:</span></td>
            <td width="2"></td>
            <td colspan="3" align="left" valign="middle">
              <div align="left">
                <input type="text" name="email" id="username">
              </div></td>
            <td width="2">&nbsp;</td>
            <td width="185">&nbsp;</td>
          </tr>
          <tr>
            <td height="24"></td>
            <td></td>
            <td align="right" valign="middle"><span class="style12"><FONT COLOR="#3300FF">Password:</span></td>
            <td colspan="4" align="left" valign="middle">
              
              <div align="center">
                <input name="pass" type="password" id="password">
              </div></td>
          </tr>
          <tr>
            <td height="26">&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td width="3">&nbsp;</td>
            <td width="132" align="center" valign="middle">
              
              <div align="center">
                <input type="submit" name="submit" id="Submit" value="Login">
            </div></td>
            <td width="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="79">&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form></td>
  <td></td>
  </tr>
  
  <tr>
    <td height="2"></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td height="37" colspan="4" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      <tr>
        <td width="975" height="37" align="center" valign="middle" bgcolor="#3070B7"><a href="ajax.php"><strong><FONT COLOR="#FFFF00">Create new Account</strong></a></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
