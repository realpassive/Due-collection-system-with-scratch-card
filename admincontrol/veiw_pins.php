<?php
include 'includes/db.inc.php'; 
include 'includes/function.php'; 
include 'includes/header.php';
   $count = "";
  
        $error = "";
        
      
       if(!empty($_POST['course']) && !empty($_POST['amount']) && isset($_POST['veiw_pin'])){
           $pin_type = database_clean($_POST['course']);
           $amount = database_clean($_POST['amount']);
           
     $sql = "SELECT pin, amount FROM tblpin WHERE course_id = '$pin_type' AND  status = '0' AND used_by = '' AND amount = '$amount'";
               $pin_result = query($sql);
              $count = mysqli_num_rows($pin_result);
           
       }
      
      
  

?>
<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
       <link rel="stylesheet" href="css/custom.css"/>
        <meta charset="UTF-8">
        <title></title>
        <style>
            strong{
                margin-left: 300px;
                text-align:center;
                text-transform:uppercase;
                color: red;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div id="inner">
            <?php echo "<h4>". "admin header dashboard goes here" ."</h4>" ?>
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
            <?php if(isset($_POST['veiw pin'])){ echo $error ;} ?>
             <div class="form-group">
             <select name="course" class="form-control">
                <option value="">SELECT PIN TO VIEW</option>
				<option value="1">NASS</option>
				<option value="2">NACOSS</option>
            </select><br/>
            <select name="amount" class="form-control">
                <option value="">Amount to generate</option>
                <?php 
                       $result = get_course_details();
                while ($all_data = mysqli_fetch_assoc($result)){ ?>
     <option value="<?php echo database_clean($all_data['old_student']); ?>"><?php echo database_clean($all_data['old_student'])."  naira  ". database_clean($all_data['course'])  ?></option>
                <?php } ?>
            </select> 
               </div>  
            
            <input type="submit" value="veiw pin" name="veiw_pin" class="btn btn-primary btn-lg btn-block"/>   
    </form>
            </div>
               <table border="2"  width="500" class="table table-bordered">
                    <tr class="">
                       
   
                        <td>S/N</td>   
                        <td>PIN</td>   
                        <td>AMOUNT</td>   
                         
                       
                    </tr>
                   
                 <?php
                         $sn = 1;
                        if($count != 0){
                     while($get_data = mysqli_fetch_array($pin_result))
                            
                            
                             
                { ?>
                    <tr>
<td><?php echo $sn++ ; ?></td>
<td><?php echo  $get_data['pin']; ?></td>
<td><?php echo display_clean(($get_data['amount'])); ?></td>

                        

                        
                    </tr> 
                 <?php
             
                 }
             }
             else {
                 die("<strong>"."no record for selected details"."<strong/>");
          }
                ?>
                </table>
        </div>
    </body>
</html>
