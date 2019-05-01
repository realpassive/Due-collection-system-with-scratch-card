<?php
  include 'db.inc.php'; 
function redirect_to($new_location) {
	  header("Location: " . $new_location);
	  exit;
}
function database_clean($var = ""){
    global $link;
    $var = htmlentities(trim(mb_strtolower($var)));
  $var = mysqli_real_escape_string($link,$var);
          return $var;
    
}

//get current session
function get_session(){
    global $link;
    $sql = "SELECT id,session FROM session WHERE curr_session = '1'";
    return  mysqli_query($link, $sql); 
         
}//end of get session
    
function update_hits($id = ""){
    
    global $link;
      $hits = array();
    $sql = "SELECT hits FROM tblreg WHERE id = '$id'";
      if($query = mysqli_query($link, $sql)){
          $hit = mysqli_fetch_array($query);
         $hits[] =  $hit['hits'];   
        
         
       if($hits[0] < 4){
          
       $hits = $hits[0];
       $hit_plus = $hits++;
   $sql = "UPDATE tblreg SET hits = '$hits' WHERE id = '$id'";
           $query = mysqli_query($link, $sql);
             
         }    
        
       else{
      $sql = "UPDATE tblreg SET ban = '1' WHERE id = '$id'";
           $query = mysqli_query($link, $sql);
            echo "you have being ban for inserting multiple pin"; 
                     exit();
      }
     
}   
       
}
//function detail of courses from DB
function get_course_details(){
         global $link;
    $sql = "SELECT distinct(old_student),prefix,course FROM tblcourse 
        UNION SELECT distinct(new_student),prefix,course FROM tblcourse"; 
        return  mysqli_query($link, $sql);

    
    
}


//pin Logic function
function passkey($format = 'u', $utimestamp = null) {
	if (is_null($utimestamp))
	$utimestamp = microtime(true);
			
	$timestamp = floor($utimestamp);
	$milliseconds = round(($utimestamp - $timestamp) * 1000000);
			
return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);
	}//dnd
//pin logic and combination logic
  function pinLogic(){
      $rand1 = mt_rand(1000000, 9999999); 
     $rand2 = mt_rand(1000000, 9999999);
     return $rand2.passkey().$rand1;
     
  }//end
  
  //pin generation  logic
     function pin_Insertion($prefix = "", $amount=""){
                                  //databae connection variable
                                       global $link;
                               //fetching course prefix from database
                             $sql = "SELECT id FROM tblcourse WHERE prefix = '$prefix'";
                                    $query = mysqli_query($link, $sql); 
                               $course_id = mysqli_fetch_array ($query);
                               $course_id = $course_id['id'];//end and assign fetch data to $course_id
                                    
                                //get current session for the pin 
                                $curr_session_id = get_session();
                                 $curr_session_id = mysqli_fetch_array($curr_session_id);
                                  $curr_session_id = $curr_session_id['id'];
                                
                            for ($index = 0; $index < 20; $index++) {
                                           $pin = pinLogic();
                         
                                  $query = "SELECT * FROM tblpin WHERE pin='$pin'";
                            $check = mysqli_query($link,$query);
                                 if(mysqli_num_rows($check)> 0){
                            $index-=1;
                            }elseif (mysqli_num_rows($check)== 0) {
                                     //append prefix with pin
                                     $pin = $prefix.$pin;
                 $sql = "INSERT INTO tblpin (pin,amount,course_id,date_created,curr_session_id) VALUES"
                                     . "('$pin','$amount','$course_id',now(),'$curr_session_id')";
                                        $query = mysqli_query($link,$sql);
                                       
                                 
                            }
                                 

                            
                            }
                            if($query){
                     echo '<strong style="color:#F00;margin-left:500px;"> pins were generated successfully </strong>';
                    
                         
                   }
                           
     }//end
     
     function query($sql){
         global $link;
      return mysqli_query($link, $sql);
     }
     
     
   function user_valid_data($id=""){
        $result =  array();
    $sql = "SELECT firstname,lastname,department,level,matric,gender,detect FROM tblreg WHERE id = '$id'";
            $details = query($sql); 
          $result = mysqli_fetch_array($details);
             $result[] = $result['firstname'];
             $result[] = $result['lastname'];
             $result[] = $result['level'];
             $result[] = $result['department'];
             $result[] = $result['gender'];
             $result[] = $result['matric'];
             $result[] = $result['detect'];
             
             //returns an array
              return $result;
   }
    

         function detect_nass_nacoss($st=""){
                     $exp = explode("/", $st);
                      if($exp[3] == "nass_payment_processor.php"){
                          
                          return "1";   
                    }
                    elseif($exp[3] == "nacoss_payment_processor.php") {
                          return "2";
                    }
       
}
 function insert_user_depart_DB($depart="",$id = ""){
              $ref_no = passkey();
              $nass = 1;
             $nass_sn = SN_max_nass();
           //clean variable against SQL INJECTION
            $depart = database_clean($depart);  
            $id = database_clean($id); 
            
            $sql_sn = "SELECT sn_id FROM $depart WHERE user_id = '$id'";
                      $result = query($sql_sn);
                     $count = mysqli_num_rows($result);
                    $sn_result = mysqli_fetch_array($result);
                     $sn_result = $sn_result[0];
                    if($count == 0){
       $insert_sql = "INSERT INTO $depart (user_id,ref_no,date,nass,nass_sn) VALUES"
                       . "('$id','$ref_no',now(),'1','$nass_sn')";
       
                    $query = query($insert_sql);
                    }
             else {
                 
                 $insert_sql = "UPDATE $depart
                   SET nass_sn ='$nass_sn', ref_no = '$ref_no',
                   date = now(),departmental = '1'
                    WHERE user_id = $id";
                 $query = query($insert_sql);
             }
        $detect_sql = "UPDATE tblreg SET detect = '$depart' WHERE id = '$id'"; 
           
           
           $query2 = query($detect_sql);
           if(!$query || !$query2){
               echo "payment not sucessful";
                    exit();
           }
         
         
  }
  
       function SN_max(){
       $sql = "SELECT MAX(depart_sn) FROM compsci";
       $result = query($sql);
       $max_depart_id = mysqli_fetch_array($result);
           $max_id = $max_depart_id[0];
            return $max_id = $max_id + 1;
   }
   
    function SN_max_nass(){
       $sql = "SELECT MAX(nass_sn) FROM compsci";
       $result = query($sql);
       $max_depart_id = mysqli_fetch_array($result);
           $max_id = $max_depart_id[0];
            return $max_id = $max_id + 1;
   }
   
   
   
 function insert_user_depart_DB_nacoss($depart="",$id = ""){
                      $max = SN_max();
              $ref_no = passkey();
              $nacoss = 2;
           //clean variable against SQL INJECTION
            $depart = database_clean($depart);  
                $id = database_clean($id);  
                
            $sql_sn = "SELECT sn_id FROM $depart WHERE user_id = '$id'";
                      $result =  query($sql_sn);
                     $count = mysqli_num_rows($result);
                    $sn_result = mysqli_fetch_array($result);
                     $sn_result = $sn_result[0];
                     
                     if($count == 0){
 $insert_sql = "INSERT INTO $depart (depart_sn,depart_ref,depart_date,departmental,user_id) "
         . "VALUES('$max','$ref_no',now(),'1','$id')";   
               $query = query($insert_sql);
                     }
                     
             else {
       $insert_sql = "UPDATE $depart
                   SET depart_sn='$max', depart_ref = '$ref_no',
                   depart_date = now(),departmental = '1'
                    WHERE user_id = $id";
                  $query = query($insert_sql);
        
                    
             }
          $detect_sql = "UPDATE tblreg SET detect = '$depart' WHERE id = '$id'";
              $query2 = query($detect_sql);
              
           if(!$query || !$query2){
               echo "payment not sucessful";
                    exit();
           }
         
         
  }
 function pin_assign($id = "",$user_pin){
         //update pin table to identify used pins
       $insert_sql = "UPDATE tblpin SET status = '1',"
               . "date_used = now(),"
               . "used_by = '$id' WHERE pin = '$user_pin'";      
         $query = query($insert_sql);
              if(!$query){
               echo "payment was unsuccesstul";
                     exit();
              }
         
  }
  
  // sort out new and old student using matric number  and session
  function sort_old_new_std_NASS($id=""){
       
       $session = get_session();
       $curr_sess = mysqli_fetch_array($session);
       $curr_sess = $curr_sess['session'];
         $curr_sess = explode("/", $curr_sess);
         
            $curr_sess = $curr_sess[0];
         
       $user_details = user_valid_data($id);
       $matric = $user_details['matric'];
       $depart = $user_details['detect'];
       
        $matric = explode("/", $matric);
                $matric  = $matric[1];
       
           if($curr_sess > $matric){
            //return he is an new student
            return  $due_price = OLD_NASS;
       }
         elseif($curr_sess <= $matric ){
             //return he is an old student
             return $due_price = NEW_NASS;
             
         }
       else {
             return "";
       }
            
   }
   
   function get_data_by_depart_nass($id =" ",$depart=" "){
       //require detect variable to get user database for depaertment
               $depart_data = array();
       $sql = "SELECT nass_sn,ref_no,user_id,nass,date FROM $depart WHERE user_id = '$id'";
         $query = query($sql);
        $result = mysqli_fetch_array($query);
         $depart_data[] = $result['nass_sn'];
          $depart_data[] = $result['ref_no'];
          $depart_data[] = $result['user_id'];
          $depart_data[] = $result['nass'];
         $depart_data[] = $result['date'];
        
          //array of users data
          return $depart_data;
   }
   function get_data_by_depart($id =" ",$depart=" "){
       //require detect variable to get user database for depaertment
               $depart_data = array();
       $sql = "SELECT nass_sn,ref_no,user_id,nass,date,departmental,depart_sn,depart_ref,depart_date FROM $depart WHERE user_id = '$id'";
         $query = query($sql);
        $result = mysqli_fetch_array($query);
         $depart_data[] = $result['nass_sn'];
          $depart_data[] = $result['ref_no'];
          $depart_data[] = $result['user_id'];
          $depart_data[] = $result['nass'];
         $depart_data[] = $result['date'];
          $depart_data[] = $result['departmental'];
          $depart_data[] = $result['depart_sn'];
          $depart_data[] = $result['depart_ref'];
          $depart_data[] = $result['depart_date'];
          //array of users data
          return $depart_data;
   }
   
          //amount balance calculation
    function balance_cal($id = "",$page = ''){
       $sql_amount = "SELECT SUM(amount) FROM tblpin WHERE used_by = '$id' "
               . "AND status = '1' AND"
               . " date_used != '000-00-00' AND course_id = '$page'";
         
         $amount_query = query($sql_amount);
         $amount_result = mysqli_fetch_array($amount_query);
            $total_amount = $amount_result[0];
         
            return $total_amount;
            
                 
            
   }
   
   function user_used_pins($id = "",$due =""){
       $pin = array();
       $sql_pin = "SELECT pin FROM tblpin WHERE used_by = '$id'"
               . " AND status = '1' "
               . "AND date_used != '000-00-00' "
               . "AND course_id = '$due'";
        $pin_query = query($sql_pin);
          $count = mysqli_num_rows($pin_query);
          for($i=0;$i<$count;$i++){
          $pin_result = mysqli_fetch_array($pin_query);
          
              $pin[] = $pin_result[0];
       }
        return $pin;
   }
   
   function uppercase($var){
       return strtoupper($var);
   }
   
   function split_pin($str = ""){
     $str = str_split($str, 5);

         return $str;

       
   }
   
   
   
//   function render_by_department($depart = ""){
//                 $result = array();
//        $sql = "SELECT tblreg.matric,tblreg.firstname,tblreg.lastname,$depart.nass_sn,
// $depart.ref_no,$depart.date FROM tblreg INNER JOIN $depart WHERE
//tblreg.id = $depart.user_id AND nass = '1' ORDER BY $depart.nass_sn DESC"; 
//           $result = query($sql);
//           if(mysqli_num_rows($result) != 0){
//        
//         $result = mysqli_fetch_row($result);
//               $result[] = $result['nass_sn'];
//                $result[] =   $result['matric'];
//                 $result[] = $result['firstname'];
//                 $result[] =  $result['lastname'];
//                 $result[] = $result['ref_no'];
//                  $result[] = $result['date'];
//                   
//                   
//                   return $result;
//    }
//     else {
//             die("no record found for this department");
//     }
//         
//        
//                
//       }
       
 
     function full_name($var,$var2){
         return $full = $var.", ". $var2;
     }
     
     function display_clean($var = ""){
    global $link;
    $var = htmlentities(strtoupper((trim(($var)))));
  $var = mysqli_real_escape_string($link,$var);
          return $var;
    
}
function nass_pinRecord(){
    //amount of total pin
     $sql_total_pin_amount = "SELECT SUM(amount) FROM tblpin WHERE course_id = '1'";
                 $query = query($sql_total_pin_amount);
             $amount_total_pin = mysqli_fetch_array($query);
                     //amount of total pin
              $amount_total_pin = $amount_total_pin[0];
     
     //count the total pin produce
     $sql_total_pin = "SELECT COUNT(pin) FROM tblpin WHERE course_id = '1'";
                $query = query($sql_total_pin);
           $total_pin = mysqli_fetch_array($query);
                  //total amount of pin
              $total_pin =  $total_pin[0];
     
     //====================================================================
    //amount pin unsold
    $sql_gen_pin = "SELECT SUM(amount) FROM tblpin WHERE status = '0' AND course_id = '1' AND used_by = ''";
                               $query = query($sql_gen_pin);
                           $amount_unsold = mysqli_fetch_array($query);
                                 //total amount of pin
                               $amount_unsold =  $amount_unsold[0];
    
    //count pin unsold
    $sql_count_pin_unsold = "SELECT COUNT(pin) FROM tblpin WHERE status = '0' AND course_id = '1' AND used_by = ''";
                                $query = query($sql_count_pin_unsold);
                           $count_unsold_pin = mysqli_fetch_array($query);
                                 //total amount of pin
                               $count_unsold_pin =  $count_unsold_pin[0];
    
    //====================================================================================================
     //count pin sold
    $sql_count_sold_pin = "SELECT COUNT(pin) FROM tblpin WHERE status = '1' AND course_id = '1' AND used_by != ''";
                              $query = query($sql_count_sold_pin);
                           $count_sold_pin = mysqli_fetch_array($query);
                                 //count sold pin
                               $count_sold_pin =  $count_sold_pin[0];
    
    //amount of pin sold
    $sql_pin_amount_sold = "SELECT SUM(amount) FROM tblpin WHERE status = '1' AND course_id = '1' AND used_by != ''";
                                $query = query($sql_pin_amount_sold);
                           $amount_sold_pin = mysqli_fetch_array($query);
                                 //amount of sold pin
                               $amount_sold_pin =  $amount_sold_pin[0];
    
    
    
    //grab the date
     $rid = date("D");
     //make a timestamp from the date
    $rid = strtotime($rid);
    //clean data for sql injection
    $rid = database_clean($rid);
    $sql = "SELECT mr_id FROM nass_record WHERE mr_id = '$rid' LIMIT 1";
    $query = query($sql);
    $count = mysqli_num_rows($query);
    
        if($count == 1){
 $sql = "UPDATE nass_record SET t_pin_gen = '$total_pin',amount_pin_gen = '$amount_total_pin', 
                 t_pin_sold = '$count_sold_pin',amount_pin_sold = '$amount_sold_pin', t_pin_left = '$count_unsold_pin',
                 date = now() WHERE mr_id = '$rid'"; 
                  query($sql);
                  return TRUE;
        }
        else{
    $sql = "INSERT INTO nass_record (mr_id,t_pin_gen,amount_pin_gen,t_pin_sold,amount_pin_sold,t_pin_left,date)
           VALUES('$rid','$total_pin','$amount_total_pin','$count_sold_pin','$amount_sold_pin','$count_unsold_pin',now())";
                        query($sql);
                         return TRUE;
        }
    
    
}
//==============================end of nass pin tracker function===============================
function nacoss_pinRecord(){
    //amount of total pin
     $sql_total_pin_amount = "SELECT SUM(amount) FROM tblpin WHERE course_id = '2'";
                 $query = query($sql_total_pin_amount);
             $amount_total_pin = mysqli_fetch_array($query);
                     //amount of total pin
              $amount_total_pin = $amount_total_pin[0];
     
     //count the total pin produce
     $sql_total_pin = "SELECT COUNT(pin) FROM tblpin WHERE course_id = '2'";
                $query = query($sql_total_pin);
           $total_pin = mysqli_fetch_array($query);
                  //total amount of pin
              $total_pin =  $total_pin[0];
     
     //====================================================================
    //amount pin unsold
    $sql_gen_pin = "SELECT SUM(amount) FROM tblpin WHERE status = '0' AND course_id = '2' AND used_by = ''";
                               $query = query($sql_gen_pin);
                           $amount_unsold = mysqli_fetch_array($query);
                                 //total amount of pin
                               $amount_unsold =  $amount_unsold[0];
    
    //count pin unsold
    $sql_count_pin_unsold = "SELECT COUNT(pin) FROM tblpin WHERE status = '0' AND course_id = '2' AND used_by = ''";
                                $query = query($sql_count_pin_unsold);
                           $count_unsold_pin = mysqli_fetch_array($query);
                                 //total amount of pin
                               $count_unsold_pin =  $count_unsold_pin[0];
    
    //====================================================================================================
     //count pin sold
    $sql_count_sold_pin = "SELECT COUNT(pin) FROM tblpin WHERE status = '1' AND course_id = '2' AND used_by != ''";
                              $query = query($sql_count_sold_pin);
                           $count_sold_pin = mysqli_fetch_array($query);
                                 //count sold pin
                               $count_sold_pin =  $count_sold_pin[0];
    
    //amount of pin sold
    $sql_pin_amount_sold = "SELECT SUM(amount) FROM tblpin WHERE status = '1' AND course_id = '2' AND used_by != ''";
                                $query = query($sql_pin_amount_sold);
                           $amount_sold_pin = mysqli_fetch_array($query);
                                 //amount of sold pin
                               $amount_sold_pin =  $amount_sold_pin[0];
    
    
    
    //grab the date
     $rid = date("D");
     //make a timestamp from the date
    $rid = strtotime($rid);
    //clean data for sql injection
    $rid = database_clean($rid);
    $sql = "SELECT mr_id FROM nacoss_record WHERE mr_id = '$rid' LIMIT 1";
    $query = query($sql);
    $count = mysqli_num_rows($query);
    
        if($count == 1){
 $sql = "UPDATE nacoss_record SET t_pin_gen = '$total_pin',amount_pin_gen = '$amount_total_pin', 
                 t_pin_sold = '$count_sold_pin',amount_pin_sold = '$amount_sold_pin', t_pin_left = '$count_unsold_pin',
                 date = now() WHERE mr_id = '$rid'"; 
                  query($sql);
                  return TRUE;
        }
        else{
    $sql = "INSERT INTO nacoss_record (mr_id,t_pin_gen,amount_pin_gen,t_pin_sold,amount_pin_sold,t_pin_left,date)
           VALUES('$rid','$total_pin','$amount_total_pin','$count_sold_pin','$amount_sold_pin','$count_unsold_pin',now())";
                        query($sql);
                         return TRUE;
        }
    
    
}
//==============end nacoss pin record track====================================

function tracking_profit(){
      $sql =  "SELECT COUNT(*) FROM tblpin WHERE status = '1' AND used_by != ' '";
        $result = query($sql);
        $result = mysqli_fetch_array($result);
        return $result[0];
   }

 function num_reg_std(){
     $sql = "SELECT COUNT(*) FROM tblreg";
     $result = query($sql);
     $result = mysqli_fetch_array($result);
         echo $result[0];
     
 }