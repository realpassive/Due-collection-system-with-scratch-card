<?php
require_once './includes/db.inc.php';
require_once './includes/function.php';
include 'includes/header.php';

$result = "";
$count = "";
 //$depart = "";
 
   if(!empty($_POST['depart']) && isset($_POST['submit'])){
       $depart = database_clean($_POST['depart']);
        $sql = "SELECT tblreg.matric,tblreg.firstname,tblreg.lastname,tblreg.phone,$depart.nass_sn,
 $depart.depart_ref,$depart.depart_date,$depart.sn_id FROM tblreg INNER JOIN $depart WHERE
tblreg.id = $depart.user_id AND nass = '1' AND depart_ref !='' ORDER BY $depart.sn_id ASC"; 
           $result = query($sql);
           $count = mysqli_num_rows($result); 
           
   }  
            

?>
<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <meta charset="UTF-8">
        <title>record</title>
        <style>
            strong,h3{
                margin-left: 300px;
                text-align:center;
                text-transform:uppercase;
                color: red;
            }
            
        </style>
    </head>
    <body>
         <div class="container">
             <form action="<?php $_SERVER['PHP_SELF']; ?>"  method="post">
              <select name="depart" class="form-control">
                <option value="">SELECT DEPARTMENT</option>
                <option value="compsci">Computer Science</option>
				
            </select><br/>
            <input type="submit" value="get record by department" name="submit" class="btn btn-primary btn-lg btn-block"/>
             </form>
             
         <table border="2"  width="500" class="table table-bordered">
                    <tr class="">
                        <td>S/N</td>  
                        <td>MATRIC</td>   
                        <td>FULL NAME</td>   
                        <td>REF NUMBER</td> 
                         <td>PHONE</td> 
                         <td>DATE</td> 						 
                        <td>SIGNATURE</td>   
                       
                    </tr>
                   
                 <?php
                        if($count != 0){
                     while($get_data = mysqli_fetch_array($result))
                         
                { ?>
                    <tr>
                        <td><?php echo $sn = display_clean($get_data['sn_id']); ?></td>
                        <td><?php echo display_clean(($get_data['matric'])); ?></td>
                        <td><?php echo $full_name = display_clean(full_name($get_data['firstname'],$get_data['lastname'])); //echo $full_name; ?></td>
                        <td><?php echo display_clean(($get_data['depart_ref'])); ?></td>
						  <td><?php echo display_clean(($get_data['phone'])); ?></td>
						   <td><?php echo display_clean(($get_data['depart_date'])); ?></td>
                        

                        
                    </tr> 
                 <?php
             
                 }
             }
             else {
                 die("<strong>"."no record for selected department"."<strong/>");
          }
                ?>
                </table>
       
         </div>
    </body>
</html>
