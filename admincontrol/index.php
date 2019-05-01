<?php 
 //include 'session_control.php'; 
include 'includes/db.inc.php';
include 'includes/header.php';
include 'includes/function.php';
$select_user = "SELECT * FROM tblcourse ORDER by 'id' asc";
$select_user = mysqli_query($link, $select_user);
 nass_pinRecord();
 nacoss_pinRecord();
       
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            #add{
                display: none;
                background: #F1F1F1;
                width: 560px;
                height: 560px;
            }   
            
        </style>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Programme</title>
        <script language="javascript" type="text/javascript">
// Redirect user to update details page
function update_data_redirection() 
{
	document.form_name.action = "update.php";
	document.form_name.submit();
}


// Redirect to delete detail page and perform user detail deletion
function delete_data_redirection() 
{
	if(confirm("Do you really mean to delete the details?")) 
	{
		document.form_name.action = "delete.php";
		document.form_name.submit();
	}
}
</script>
<link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        
        <div style="width:500px;margin: 0 auto;">
            
            <form  name="form_name" method="post" action="">
                <table border="0" cellpadding="10" width="500" class="py_table_wrapper">
                    <tr class="py_table_header">
                        <td>COURSE</td>  
                        <td>old student Amount</td>   
                        <td>new student Amount</td>   
                         <td style="text-align:center;">ACTION</td>  
                    </tr>
                   
                 <?php
                 $tbl_class = "py_tbl_dark";
                 while($get_data = mysqli_fetch_array($select_user))
                { ?>
                    <tr class="<?php echo isset($tbl_class) ? $tbl_class : ''; ?>">
                        <td><?php echo trim(strip_tags($get_data['course'])); ?></td>
                        <td><?php echo trim(strip_tags($get_data['old_student'])); ?></td>
                        <td><?php echo trim(strip_tags($get_data['new_student'])); ?></td>
  <td style="text-align:center;"><input type="checkbox" name="user[]" class="users" id="user"
                                          value="<?php echo trim(strip_tags($get_data['id']));?>"</td>
                        
                   </tr> 
                 <?php
              $tbl_class = $tbl_class == "py_tbl_dark" ? "py_light" : "py_dark";
                 }
                ?>
                   
                    <tr class="py_table_header">
                        <td colspan="5" align="center">
     <input type="button" value="Update" name="update" class="btn" onclick="update_data_redirection();"/>
      <input type="button" value="Delete" name="Delete" class="btn" onclick="delete_data_redirection();"/>
 <input name="updateRecord" type="submit" value="Create Group" 
   onClick="return GB_show('Google', this.href)"class="btn btn-lg btn-md btn-sm btn-primary"
     style="width:100%;"  /><br/>
                        
                    </tr>
                    
                </table>
                 <p> number of student registered: <strong><?php echo num_reg_std();  ?></strong></p>
     <p>number of pins sold <strong><?php echo tracking_profit();  ?></strong></p> 
     <p><?php echo tracking_profit() ." x 50" ?> = <strong><?php echo tracking_profit() * 50;  ?></strong></p> 
            </form>
            
        </div>
      
    </body>
    <script type="text/javascript">
var GB_ROOT_DIR = "key.php";
</script>
<link href="greyBox/gb_styles.css" rel="stylesheet" type="text/css">
<link href="greyBox/help.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="greyBox/AJS.js"></script>
<script type="text/javascript" src="greyBox/AJS_fx.js"></script>
<script type="text/javascript" src="greyBox/gb_scripts.js"></script>
<script type="text/javascript" src="greyBox/js.js"></script>
</html>
