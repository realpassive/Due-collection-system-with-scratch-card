<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

     <link rel="stylesheet" href="css/bootstrap.min.css"/>
     <link rel="stylesheet" href="css/custom.css"/>

<script src="js/ajax.js"></script>
 <script type="text/javascript">
     
 function pinfunc(){
	var p = _("pin").value;
        var status =_("status");
	if(p == ""){
		status.innerHTML = "enter pin";
	}else {
		_("subtn").style.display = "none";
		status.innerHTML = "loading.........";
		var ajax = AjaxObject("POST", "includes/process.php");
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
             ajax.send("pin="+p);
	}
}


</script>

﻿</head>
<body>
    <div class="container">
     
        <div class="container">
      <form onsubmit="return false;" id="signupform">
    <label for="PIN">Enter PIn</label> 
        <input type="text" id="pin" placeholder=" enter pin here" maxlength="40" /><br/><br/>  
        <input type="submit" id="subtn" value="pay" onclick=" pinfunc()"/>
            <span id="status" text-align=center></span><br/><br/>
         
 
        </form>
        </div>
</div>
</body>
</html>
