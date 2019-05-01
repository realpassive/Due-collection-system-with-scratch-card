<?php
require_once './includes/db.inc.php';
require_once './includes/function.php';
include 'includes/header.php';
$sql_blocked = "SELECT firstname,lastname,matric,department FROM tblreg"; 
$sql_blocked2 = "SELECT firstname,lastname,matric,department,phone FROM tblreg"; 

           //result of blocked user
           $result_blocked = query($sql_blocked);
           $result_blocked2 = query($sql_blocked2);


$error = "";
 
   if(!empty($_POST['matric']) && isset($_POST['submit'])){
       $matric = database_clean($_POST['matric']);
	   $pass = 'mautech';
	   $password = md5('mautech');
        $sql_update = "UPDATE tblreg SET password = '$password' WHERE matric = '$matric'";
                   
                $query = query($sql_update);
              if($query){
             echo "<script> alert('$matric has been to $pass')</script>";
             echo "<script>location='reset_password.php'</script>";
                  
              }  
           else {
               $error = "password reseting failed. try again";
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
		           <h4>password reset board</h4>
             <form action="<?php $_SERVER['PHP_SELF']; ?>"  method="post">
            <?php if(isset($_POST['submit'])){ echo $error ;} ?>
             <div class="form-group">
             <select name="matric" class="form-control" >
                <option value="">SELECT USER TO RESET PASSWORD</option>
                <?php 
                       $result = get_course_details();
                while ($all_data = mysqli_fetch_assoc($result_blocked)): ?>
                <option value="<?php echo database_clean($all_data['matric']); ?>"><?php echo display_clean($all_data['matric']); ?></option>
                <?php endwhile; ?>
            </select><br/>
            
            <input type="submit" value="RESET PASSWORD" name="submit" class="btn btn-primary btn-lg active"/><br/><br/>   
    </form>
       
         </div>
         </div>
                 
    </body>
</html>
