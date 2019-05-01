<?php
require_once ('includes/function.php');
  require_once ('session.php');

   ?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

     <link rel="stylesheet" href="css/bootstrap.min.css"/>
     <link rel="stylesheet" href="css/custom.css"/>

<script src="js/ajax.js"></script>
 <script type="text/javascript">
 function pinfunc(){
	var d = _("depart").value;
	var p = _("pin").value;
        var status =_("status");
	if(p == "" || d == ""){
      status.innerHTML = "Fill out all of the form data";
	}else {
		_("subtn").style.display = "none";
		status.innerHTML = "loading.........";
		var ajax = AjaxObject("POST", "includes/nacoss_payment_processor.php");
                  ajax.onreadystatechange = function() {
	       if(ajaxReturn(ajax) == true) {
	           if(ajax.responseText != "payment_success"){
			status.innerHTML = ajax.responseText;
			_("subtn").style.display = "block";
                        
			} else {
				window.scrollTo(0,0);

      _("signupform").innerHTML = "OK "+ p +"payment was successful";
				}
	       }
        }
             ajax.send("pin="+p+"&d="+d);
             
             
	}
}


</script>
<style>
    #status,h3,#sta{
    font-weight:bold;
    color: #FF0000;
    text-align:center;
    
}
</style>
﻿</head>
<body>
    <div class="container">
    <ul class="nav nav-tabs">
       <li role="presentation" ><a href="nass_payment.php">NASS</a></li>
       <li role="presentation" class="active"><a href="nacoss_payment.php">NACOSS</a></li>
       <li role="presentation"><a href="receipt.php">RECEIPT</a></li>
         <li role="presentation"><a href="logout.php">LOGOUT</a></li>
       </ul>
        <div class="container">
              <div id="voguepay" class=".col-md-4">
                <h3>Payment Instructions</h3>
                <strong><span id="sta">1.</span>All NACOSS pin start with  the prefix csc e.g csc2356789543
                so ensure you pay the correct pin</strong>
                  <strong><span id="sta">2.</span>Enter pin</strong>
         <strong><span id="sta">3.</span>Select your department correctly</strong>
          <strong><span id="sta">4.</span>Hit the Pay button</strong>
                
            </div>
            <div id="pinform" class="col-md-6">
       <form onsubmit="return false;" id="signupform">
    <label for="PIN">Enter PIn</label> 
    <input type="text" id="pin" class="form-control" placeholder=" enter pin here" maxlength="40" autocomplete="off" onfocus="emptystatus('status')"/><br/>
    <select id="depart" class="form-control">
                <option value="">SELECT DEPARTMENT</option>
                             <option value="compsci">Computer Science</option>
				
            </select><br/><br/>
    <input type="submit" id="subtn" value="make payment" onclick=" pinfunc()" class="btn btn-success"/><br/><br/>
            <span id="status"></span><br/><br/>
         
 
        </form>  
                
            </div>
          
        </div>
    </div>
</body>
</html>
