<?php
require_once ('db.inc.php');
require_once ('function.php');
if (isset($_POST["matriccheck"])) {
     $matric = $_POST['matriccheck'];
    $filter = preg_match("/^[A-za-z0-9\/]*$/", $matric);
     $matric = database_clean($matric);
   
    $sql = "SELECT id FROM tblreg WHERE matric ='$matric' LIMIT 1";
    $query = mysqli_query($link, $sql);
    $matric_check = mysqli_num_rows($query);
    if (!empty($matric) && !$filter) {
        echo '<strong style="color:#F00;"> matric is not valid</strong>';
        exit();
    }
    if (strlen($matric) < 5) {
        echo '<strong style="color:#F00;"> matric is not valid</strong>';
        exit();
    }
    if ($matric_check < 1) {
        echo '<strong style="color:#009900;">' .$matric . ' is OK</strong>';
        exit();
    } else {
        echo '<strong style="color:#F00;">' . $matric . ' is taken</strong>';
        exit();
    }
}



if (isset($_POST['m'])) {
    //matric number
        $m = database_clean($_POST['m']);
        $m_filter = preg_match("/^[A-za-z0-9\/]*$/", $m);
        //password
	$p = database_clean($_POST['p']);
        //firstname
	$fn = preg_replace('#[^a-z]#i', '', $_POST['fn']);
        $fn = database_clean($fn);
        //lastname
	$ln = preg_replace('#[^a-z ]#i', '', $_POST['ln']);
        $ln = database_clean($ln);
      //emaill
        $e = database_clean($_POST['e']);
        //email validation
        $e_check = preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $e);
        //gender
        $g = database_clean($_POST['g']);
      //phone number
        $ph = ($_POST['ph']);
      //department
        $d = database_clean($_POST['d']);
        //validate a phone number
        $check_ph = preg_match("/^[0-9]*$/", $ph);
        
        //level
        $lv = $_POST['lv'];
        $lv = database_clean($lv);
        
        //database check for a match for email
        // -------------------------------------------
	$sql = "SELECT id FROM tblreg WHERE email='$e' LIMIT 1";
               $query = mysqli_query($link, $sql); 
	$e_db_check = mysqli_num_rows($query);
          // -------------------------------------------
        //database check for a match of matric number
	$sql2 = "SELECT id FROM tblreg WHERE matric ='$m' LIMIT 1";
               $query = mysqli_query($link, $sql2); 
	$m_db_check = mysqli_num_rows($query);
        
 if($fn == "" || $e == "" || $p == "" || $ln=="" || $d == "" || $m == "" || $g == "" || $ph == "" ||$lv == ""){
           
            echo "The form submission is missing values.";
            exit();
        }
       else if ($m_db_check > 0){ 
        echo "The matric no you entered is already taken";
        exit();
	} else if ($e_db_check > 0){ 
        echo "That email address is already in use in the system";
        exit();
	} else if (strlen($fn) < 3 || strlen($ln) > 16) {
        echo "name must be between 3 and 16 characters";
        exit(); 
    } else if (is_numeric($ln[0] || is_numeric($fn[0]))) {
        echo 'name cannot begin with a number';
        exit();
    }
     else if(empty($g)) {
        echo 'select a gender';
        exit();
    }
     else if(empty($p)) {
        echo 'entered your password';
          exit();
    }
     else if(strlen($p) < 6) {
        echo 'password must be at least six characters ';
          exit();
    }
    elseif (empty ($ph)) {
       echo 'entered your password';
          exit();
}
 else if (!$e_check){ 
        echo "email is not valid";
        exit();
}
 else if (!$m_filter){ 
        echo "matric is not valid";
        exit();
}
    elseif (empty($ph)) {
       echo 'entered your password';
          exit();
}
    elseif (!$check_ph) {
       echo 'phone number is not valid';
          exit();
}

    elseif(empty($d)) {
     echo ' select your department';
          exit();
}
 else {
                $p_hash = md5($p);
		// Add user info into the database table for the main site table
$sql = "INSERT INTO tblreg (email,password,firstname,lastname,phone,matric,gender,level,department)
                          VALUES('$e','$p_hash','$fn','$ln','$ph','$m','$g','$lv','$d')";
                        //set  headers
           $headers  = 'MIME-Version: 1.0' . "\r\n";
         $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
         $to = $e;
         $message = "matric:" .$m."<br/>"."password:".$p;
         $subject = $_SERVER['SERVER_NAME'];
         
 
         if(mysqli_query($link,$sql)){
        mail($to, $subject, $message, $headers);
                     echo "signup_success";
                                exit();
             
         }
       else {
           echo "error in registration";
                              exit();
       }
         
         
       
                          
                     
}      
}
