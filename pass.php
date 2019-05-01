<?php
if(isset($_POST['sub'])){
        $d = "gooooo";
        $m = $_POST['pass'];
    switch ($m){
        case $d:
            echo "password match";
            break;
        
        default:
       echo "enter pass";
    }
}


?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action=""method="post">
            <input type="text" name="paas"/>
            <input type="submit" name="sub" value="check pass"/>
            
        </form>
    </body>
</html>
