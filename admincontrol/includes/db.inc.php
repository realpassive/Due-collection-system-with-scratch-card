<?php
$link = mysqli_connect('localhost', 'root', '');
if (!$link)
{
  echo 'Unable to connect to the database server.';
  exit();
}

if (!mysqli_set_charset($link, 'UTF8'))
{
  echo 'Unable to set database connection encoding.';
  exit();
}

if(!mysqli_select_db($link, 'nassmaut_cs'))
{
  echo 'Unable to locate database.';
  exit();  
}
ini_set('error_reporting', 'E_NONE'); 
$admin = "j.babique@gmail.com";

$admin_email = 'yakubudaiman@gmail.com';
$from = "NASSMAUTECH";
?>