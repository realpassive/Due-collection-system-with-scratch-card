<?php
//passkeygenerating function

//Ajax calls this NAME CHECK code to execute

if (isset($_POST["emailnamecheck"])) {
    include_once("includes/db.inc.php");
    $email = mysqli_escape_string($link, trim($_POST['emailnamecheck']));
    $sql = "SELECT id FROM nacoss_login WHERE email ='$email' LIMIT 1";
    $query = mysqli_query($link, $sql);
    $emali_check = mysqli_num_rows($query);
    if (!empty($email) && !preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)) {
        echo '<strong style="color:#F00;"> email is not valid</strong>';
        exit();
    }
    if (is_numeric($email[0])) {
        echo '<strong style="color:#F00;">email must begin with a letter</strong>';
        exit();
    }
    if ($emali_check < 1) {
        echo '<strong style="color:#009900;">' . $email . ' is OK</strong>';
        exit();
    } else {
        echo '<strong style="color:#F00;">' . $email . ' is taken</strong>';
        exit();
    }
}

if(isset($_POST["e"])){
	// CONNECT TO THE DATABASE
	 include_once("includes/db.inc.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$e = mysqli_real_escape_string($link, $_POST['e']);
	$p = $_POST['p'];
	$fn = preg_replace('#[^a-z]#', '', $_POST['fn']);
	$ln = preg_replace('#[^a-z ]#i', '', $_POST['ln']);
	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// DUPLICATE DATA CHECKS FOR  EMAIL
	// -------------------------------------------
	$sql = "SELECT id FROM nacoss_login WHERE email='$e' LIMIT 1";
    $query = mysqli_query($link, $sql); 
	$e_check = mysqli_num_rows($query);
	// FORM DATA ERROR HANDLING
	if($e == "" || $p == "" || $fn == "" || $ln == ""){
		echo "The form submission is missing values.";
                    exit();
	} else if ($e_check > 0){ 
        echo "The email you entered is already taken";
        exit();
	} else if ($e_check > 0){ 
        echo "That email address is already in use in the system";
        exit();
	} else if (strlen($fn) < 3 || strlen($ln) > 16) {
        echo "name must be between 3 and 16 characters";
        exit(); 
    } else if (is_numeric($ln[0] || is_numeric($fn[0]))) {
        echo 'name cannot begin with a number';
        exit();
    }

else {
	// END FORM DATA ERROR HANDLING
	   // Begin Insertion of data into the database
		// Hash the password and apply your own mysterious unique salt
                          include 'passkey.php';
                           $passkey = pass();
                        
                           $p_hash = md5($p);
		// Add user info into the database table for the main site table
$sql = "INSERT INTO nacoss_login (email,password,firstname,lastname,ip,passcode)       
		       VALUES('$e','$p_hash','$fn','$ln','$ip','$passkey')";
		              $query = mysqli_query($link, $sql);
                              
                          $to = $admin_email;
                          $message = "passkey for $e ". " is ".$passkey;
                          $subject = "$e". " admin passkey";
                          //$from = "auto_responder@prymecoders.com";
                                        
                          		$headers = "From: $from\n";
                                    $headers .= "MIME-Version: 1.0\n";
                           $headers .= "Content-type: text/html; charset=iso-8859-1\n";
                          if($query){
                           mail($to, $subject, $message);
		                echo "signup_success";
                                exit();
                          }
                       else {
                           echo "error in registration";
                              exit();
                       }
                       
		          exit();
                                  
                
                
}
}
                
   ?>