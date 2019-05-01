<?php //include 'session_control.php';  ?>
<?php
//ini_set('error_reporting', 'E_NONE'); 
@ob_start();
include 'includes/db.inc.php';
if(isset($_POST['submit']) && trim($_POST['submit']) != ""){
    $count_users = count($_POST['userId']);
    echo $count_users;
    
    for($i = 0; $i < $count_users; $i++){
   $userId = mysqli_real_escape_string($link,trim(strip_tags($_POST['userId'][$i])));
   $course = mysqli_real_escape_string($link,trim(strip_tags($_POST['course'][$i])));
   $course_amount =  mysqli_real_escape_string($link,trim(strip_tags($_POST['course_amount'][$i])));
   
   $sql_update = "UPDATE tblcourse SET course = ' $course',course_amount = '$course_amount'
           WHERE id = '$userId'";
           mysqli_query($link,$sql_update);
      
    }
    
   header('location:index.php');
   //echo  $userId = mysqli_real_escape_string(trim(strip_tags($_POST['userId'][$i])));
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
   <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
<div style="width:500px; margin:0px auto; align="center";">
        <?php
       $selected_users_id = count($_POST['user']);
       if($selected_users_id == 0){
         ?>
   <div style="margin:0 auto; padding:10px; background:#FFFFEA;line-height:20px; border:1px solid #F1F1F1; text-align:center;box-shadow:rgba(0,0,0,0.7) 0px 0px 8px;">
        please click on an item to update
    </div>
   </div><br/><br/>
    <div align="center" style="margin:0px 500px;" class="btn" onClick="window.location.replace('index.php');">back</div>
<?php
       }
    else{
       ?>
<form action="<?php echo isset($_SERVER['PHP_SELF']) ? trim($_SERVER['PHP_SELF']): ""; ?>" method="post">
  <table border="0" cellpadding="10" width="500" class="py_table_wrapper">
                    <tr class="py_table_header">
                        <td>Update user Informantion</td>  
                         
                    </tr>
                  <?php
 
                 for($i=0; $i < $selected_users_id ; $i++){
                   $user =  mysqli_real_escape_string($link, strip_tags($_POST['user'][$i]));
                             $user =  trim($user);
                          // echo ($user);
          $select_user = "SELECT * FROM tblcourse WHERE id = '$user'";
          $select_user = mysqli_query($link, $select_user);
              $grab_user_detail[$i] = mysqli_fetch_array($select_user);
                 ?>
      <tr class="py_outer_table" >
      <td>
        <table border="0" cellpadding="10" cellspacing="0" width="500" align ="center" class="py_inner_table">
    <tr>
       <td><label>Category</label></td>
      <td><input type="text" name="course[]" class="field" value="<?php echo $grab_user_detail[$i]['course'] ?>"/></td>
            
    </tr>
    <tr>
       <td><label>Category Amount</label></td>
   
      <td>
          <input type="hidden" name="userId[]" class="field" value="<?php echo $grab_user_detail[$i]['id'] ?>"/>
<input type="text" name="course_amount[]" class="field" value="<?php echo $grab_user_detail[$i]['course_amount'] ?>"/>
    </td>
            
    </tr>
       
        
        
     </table> 
    </td>
      
      </tr>
<?php 
      
    }
  ?>
      <tr class="py_outer_table" >
 
          <td colspan="2" align="center"><input type="submit" name="submit" value="Save changes" class="btn"/></td>
      </tr>       
                 
</form>
    <?php
    }
        
    ?>   
    </body>
</html>
