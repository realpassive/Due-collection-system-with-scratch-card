<?php 
   require_once ('includes/db.inc.php');
   require_once ('includes/function.php');
   require_once ('includes/defined_price.php');
   
    $result = render_by_department("phy");
      
    if(mysqli_num_rows($result) != 0){
        
    while($result = mysqli_fetch_array($result)){
           echo $result['nass_sn'];
                $result['matric'];
                $result['firstname'];
                $result['lastname'];
                $result['ref_no'];
                $ $result['date'];
       }
    }
     else {
             die("no record found for this department");
     }
                    
     
?>