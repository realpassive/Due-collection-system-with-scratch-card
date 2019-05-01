<?php
require_once './includes/db.inc.php';
require_once './includes/function.php';
include 'includes/header.php';
$sql_blocked = "SELECT firstname,lastname,matric,department FROM tblreg WHERE hits = '4'"; 
$sql_blocked2 = "SELECT firstname,lastname,matric,department,phone FROM tblreg WHERE hits = '4'"; 

           //result of blocked user
           $result_blocked = query($sql_blocked);
           $result_blocked2 = query($sql_blocked2);


$error = "";
 
   if(!empty($_POST['matric']) && isset($_POST['submit'])){
       $matric = database_clean($_POST['matric']);
        $sql_update = "UPDATE tblreg SET hits = '0' WHERE matric = '$matric'";
                   
                $query = query($sql_update);
              if($query){
             echo "<script> alert('$matric has been unlocked')</script>";
             echo "<script>location='block_system.php'</script>";
                  
              }  
           else {
               $error = "unlocking process failed try again";
           }
   }
         

?>
<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <meta charset="UTF-8">
        <title>record</title>
        <style>
            strong{
                margin-left: 300px;
                text-align:center;
                text-transform:uppercase;
            }
            .heading{
                color:red;
                text-align: center;
            }
        </style>
    </head>
    <body>
         <div class="container">
             <form action="<?php $_SERVER['PHP_SELF']; ?>"  method="post">
            <?php if(isset($_POST['submit'])){ echo $error ;} ?>
             <div class="form-group">
             <select name="matric" class="form-control" >
                <option value="">SELECT USER TO UNBLOCK</option>
                <?php 
                       $result = get_course_details();
                while ($all_data = mysqli_fetch_assoc($result_blocked)): ?>
                <option value="<?php echo database_clean($all_data['matric']); ?>"><?php echo display_clean($all_data['firstname'],$all_data['lastname']);  ?></option>
                <?php endwhile; ?>
            </select><br/>
            
            <input type="submit" value="UNLOCK USER" name="submit" class="btn btn-primary btn-lg active"/><br/><br/>   
    </form>
         <table border="2"  width="500" class="table table-bordered">
                    <tr class="heading">
                        
                        <td>MATRIC</td>   
                        <td>FULL NAME</td>   
                        <td>DEPARTMENT</td>
                        <td>PHONE NUMBER</td> 						
                         
                       
                    </tr>
                   
                 <?php
                       
                     while($get_data = mysqli_fetch_assoc($result_blocked2))
                         
                { ?>
                    <tr>
                      
                        <td><?php echo display_clean(($get_data['matric'])); ?></td>
        <td><?php echo $full_name = display_clean(full_name($get_data['firstname'],$get_data['lastname'])); //echo $full_name; ?></td>
                        <td><?php echo display_clean(($get_data['department'])); ?></td>
						<td><?php echo display_clean(($get_data['phone'])); ?></td>
                        

                        
                    </tr> 
                 <?php
             
                 }
             
             
                ?>
                </table>
       
         </div>
         </div>
                 
    </body>
</html>
