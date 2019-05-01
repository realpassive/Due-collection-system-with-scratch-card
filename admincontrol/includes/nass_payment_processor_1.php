<?php
require_once ('db.inc.php');
require_once ('function.php');
require_once ('session.php');
 $page =  $_SERVER['PHP_SELF'];
    $page = detect_nass_nacoss($page);


if(isset($_POST['pin']) || isset($_POST['d'])){
  
    $insert_pin = database_clean($_POST['pin']);
    $insert_depart = database_clean($_POST['d']);
    //clean pin to prevent attack
    $insert_pin_clean = database_clean($insert_pin);
    $pin_beg = preg_match("/^ns/", $insert_pin_clean);
     $check = preg_match("/[0-9]*$/",$insert_pin);
     $id = database_clean($id);
     
     // -------------------------------------------
   $sql = "SELECT pin FROM tblpin WHERE "
           . "pin ='$insert_pin_clean' "
           . "AND status = '0'"
           . " AND used_by = '' "
           . "AND course_id = '$page' LIMIT 1";
    $query = mysqli_query($link, $sql); 
	$pin_check_row = mysqli_num_rows($query);
   //check the the number of hits an ban user after 4 wrong pins 
        
      if($insert_pin == "" || $insert_depart == ""){
          echo "Fill out all of the form data !!!";
          exit();
      }
      elseif(!$pin_beg) {
      echo "not a valid pin";
          exit();
  }
      elseif(!$check) {
      echo "only number are required";
          exit();
  }
     elseif(strlen($insert_pin) < 5) {
     echo "the pin entered is incorrect";
            exit();
}
      elseif(!strlen($insert_pin) > 5) {
            
          //update user hits function
              update_hits($id);
       echo "you entered an incorrect pin !!!";
                exit();
}
   elseif(!$pin_check_row) {
            
          //update user hits function
              update_hits($id);
       echo "you entered an invalid pin !!!";
                exit();
}
           elseif($pin_check_row > 0) {
               
            //update user hits function
              update_hits($id);
              
              
              //pin insertations here
            pin_assign($id,$insert_pin);
            
            //isert user unqiue records
         insert_user_depart_DB($insert_depart, $id);
         
          echo  "Payment was successful";
                      exit();
          }
          
          
   
}
