<?php include './session_control.php'; 
require_once './includes/db.inc.php';
require_once './includes/function.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="header.css" type="text/css" rel="stylesheet"/>
<style>
    .nav{
padding:0px 50px;
margin:0px;
height:32px;
border-bottom:1px solid #000;
}
.nav ul{ list-style:none;

}
.nav li{
float:left;
line-height:32px;
}
.nav li a{
display:block;
color:#6600CC;
font-size:1.5em;
//float:left;
text-decoration:none;
padding:0px 15px;
margin-right:5px;
text-decoration:none;
background: background-color: rgb(40, 96, 144);
border:1px solid #000000;
border-bottom:0;}

.nav li a:hover{ 
background:#CCCCCC;
color:#666666;
text-decoration:none;
margin-top:-1px;
}


    
</style>
<title>NASS</title>
</head>

<body>
<div class="nav">
<ul>
  <li><a href="index.php">HOME</a></li>
  <li><a href="reset_password.php">RESET STD PASSWORD</a></li>
  <li><a href="veiw_pins.php">PRINT PIN</a></li>
  <li><a href="nass_report.php">NASS</a></li>
 
</ul>
</div>
</body><br/><br/>
</html>
