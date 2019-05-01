<?php
require_once './includes/db.inc.php';
require_once './includes/function.php';
include 'includes/finan_header.php';
$sql = "SELECT t_pin_gen,amount_pin_gen,t_pin_sold,amount_pin_sold,t_pin_left,date FROM nacoss_record";
    $result = query($sql);

?>
<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <meta charset="UTF-8">
        <title>record</title>
        <style>
            strong,h3{
                margin-left: 30px;
                text-align:center;
                text-transform:uppercase;
                color: red;
            }
            .title{
               color: #23527c; 
               text-align:center;
               font-size:17px;
            }
            .data{
                text-align:center;
                color: #000000;
               
            }
            
        </style>
    </head>
    <body>
         <div class="container">  
             <h3>NACOSS FINANCIAL RECORD </h3>
         <table border="2"  width="500" class="table table-bordered">
                    <tr class="title">
                         <td>DATE</td>  
                         <td>TOTAL PIN GENERATED</td>   
                         <td>AMOUNT OF PIN GENERATED &#8358</td>   
                         <td>TOTAL NUMBER OF PIN SOLD</td>
                         <td>AMOUNT OF PIN SOLD &#8358</td> 
                         <td>NUMBER OF PIN LEFT</td> 						
                          
                       
                    </tr>
                   
                 <?php
                      
                     while($get_data = mysqli_fetch_array($result))
                         
                { ?>
                    <tr class="data">
<td><?php echo $sn = display_clean($get_data['date']); ?></td>
<td><?php echo display_clean(($get_data['t_pin_gen'])); ?></td>
<td><?php echo '&#8358'." ". display_clean($get_data['amount_pin_gen']); //echo $full_name; ?></td>
<td><?php echo display_clean(($get_data['t_pin_sold'])); ?></td>
<td><?php echo '&#8358'." ". display_clean(($get_data['amount_pin_sold'])); ?></td>
<td><?php echo display_clean(($get_data['t_pin_left'])); ?></td>
                        

                        
                    </tr> 
                 <?php
             
                 }
             
            
                ?>
                </table>
       
         </div>
    </body>
</html>
