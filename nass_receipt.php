<?php
    
require_once ('includes/function.php');
    $page = '1';
   require_once ('session.php');
  require_once ('includes/defined_price.php');
  include_once('includes/receipt_header.php');
        $id = database_clean($id);
    //detect nass or nacoss 
      
      
        $stud_paid = balance_cal($id,$page);
       $due_amount = sort_old_new_std_NASS($id);
       
     if(!$stud_paid ||  $stud_paid < $due_amount ){    
    ?>
<div style="color:#000;font-size:medium;border:2px solid red;
     width:700px;margin: 0px auto;padding:10px;font-family:sans-serif">
    we detected you are yet to you make full payment 
</div>
<?php
  }
 else {
          //return pool of bio data
     $user_data = user_valid_data($id);
     
     //return depart for right inputation
     $depart = sort_old_new_std_NASS($id);
          $depart = $user_data['detect'];
          
        //return pool of valid payment data eg s/n, refno
         $payment = get_data_by_depart_nass($id,$depart);
         //amount paid
         $amount_paid_by_user = balance_cal($id,$page);
         
         // fetech pins
            $pins =  user_used_pins($id,$page);

                 
         
   ?>
     
     
     <!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
          <link rel="stylesheet" href="css/custom.css"/>

             <script src="js/ajax.js"></script>
             <style>
            table.reference td {
          border: 1px solid #c3c3c3;
          padding: 10px;
          vertical-align: top;
          font-style: oblique;
          font-size: medium;
         
         
}
      
   table.reference {
    border-collapse: collapse;
}
.data{
    text-align: center;
    font-family: sans-serif;
    font-size: xx-large;
    color: red;
    text-transform: capitalize;
    text-transform: uppercase;
}
.message{
    color:#c3c3c3;
    font-size: medium;
}
        </style>   
     
    </head>
    <body>
        <div class="container">
   
           <div style="border: 1px solid #333; margin: 30px auto;width:700px;height:auto">
<div style="padding:10px; background:#333; font-size:24px; color:#CCC;">
<a href="#"><img src="images/nass.png" width="48" height="33" 
style="border:none;
float:left;"></a>NASS MAUTECH, DUES REGISTRATION SPECIMEN </div>
        <span class="data">bio details</span>
 <table class="reference" style="width:60%">
	<tbody>
            <tr>
		<td>MATRIC NUMBER</td>
           <td><?php echo uppercase($user_data['matric']) ?></td>
	</tr>
            <tr>
		<td>FIRST NAME</td>
                <td><?php echo uppercase($user_data['firstname']) ?></td>
	</tr>
	<tr>
		<td>LAST NAME</td>
                <td> <?php echo uppercase($user_data['lastname']) ?></td>
	</tr>
	<tr>
		<td>GENDER</td>
		<td><?php echo uppercase($user_data['gender']) ?></td>
	</tr>
	<tr>
		<td>DEPARTMENT</td>
		<td><?php echo uppercase($user_data['department']) ?></td>
	</tr>
	
        
</tbody>
    

           </table>
    <span class="data">payment details</span>
<table class="reference" style="width:60%">
	<tbody>
            <tr>
		<td>SERIAL NUMBER</td>
		  <td><?php echo uppercase($payment[5]) ?></td>
	</tr>
	<tr>
		<td>REF NUMBER</td>
		<td><?php echo uppercase($payment[1]) ?></td>
	</tr>
	<tr>
		<td>DATE OF PAYMENT</td>
	<td><?php echo uppercase($payment[4]) ?></td>
	</tr>
	<tr>
		<td>AMOUNT PAID</td>
		<td><?php echo uppercase($amount_paid_by_user)." "."naira"; ?></td>
	</tr>
	<tr>
		<td>DUE</td>
		<td><?php echo "NASS"; ?></td>
	</tr>
	<tr>
		<td>USED PINS</td>
		<td><?php //receive an array
                $count = count($pins);
            for($i=0;$i < $count;$i++){
            $pl = split_pin($pins[$i]);
               $splited = implode(" ", $pl).'<br/>';

                echo uppercase($splited);
            }?>
                </td>
	</tr>
	<tr>
		
          <td><input type="button" value="print page" onClick="window.print()" /></td>
	</tr>
        
</tbody>
    
           </table>
    </div>
    </div>
    </body>
</html>
     

 <?php
 }
  
?>
    