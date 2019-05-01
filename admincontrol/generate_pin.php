<?php
require_once('includes/db.inc.php'); 
require_once('includes/function.php'); 
    include 'includes/header.php';
  if(isset($_POST['gen'])){
        $error = "";
       if(empty($_POST['pin_type']) || empty($_POST['amount'])){
          $error = 'please select pin type and amount to generate';
       }
       elseif(!empty($_POST['pin_type']) && !empty($_POST['amount'])){
           $pin_type = database_clean($_POST['pin_type']);
           $amount = database_clean($_POST['amount']);
             pin_Insertion($pin_type, $amount);
       }
      
      
  }

?>
<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
       <link rel="stylesheet" href="css/custom.css"/>
        <meta charset="UTF-8">
        <title></title>
        <style>
            .status{
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
        <form action="" method="post">
            
            <?php if(isset($_POST['gen'])){ echo "<span class='status'>$error </span>" ;} ?>
            
             <div class="form-group">
             <select name="pin_type" class="form-control">
                <option value="">select pin type</option>
                <?php 
                       $result = get_course_details();
                while ($all_data = mysqli_fetch_assoc($result)): ?>
     <option value="<?php echo database_clean($all_data['prefix']); ?>"><?php echo database_clean($all_data['course'])." pin";  ?></option>
                <?php endwhile; ?>
             </select><br/><br/>
            <select name="amount" class="form-control">
                <option value="">Amount to generate</option>
                <?php 
                       $result = get_course_details();
                while ($all_data = mysqli_fetch_assoc($result)): ?>
     <option value="<?php echo database_clean($all_data['old_student']); ?>"><?php echo database_clean($all_data['old_student'])."  naira  ". database_clean($all_data['course'])  ?></option>
                <?php endwhile; ?>
            </select> 
               </div>  
            
            <input type="submit" value="generate pin" name="gen" class="btn btn-primary btn-lg btn-block"/>   
    </form>
            </div>
        </div>
    </body>
</html>
