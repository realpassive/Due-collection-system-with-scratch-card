<!DOCTYPE html>
    <html>
    <head>
    <meta charset="UTF-8">
     <script src="ajax.js"></script>
    <title></title>
    <script type="text/javascript">
        
    //id handeler func
function _(x){
   return document.getElementById(x);
     }//end tag handler
        
 //checks fields to filter user inputs
   function restrict(elem){
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "email"){
		rx = /[' "]/gi;
	} else if(elem == "name"){
		rx = /[^a-z]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}
//empty status func
function  emptystatus(x){
    _(x).innerHTML=" ";
    
}
    function checkemail(){
     var e = _("email").value;
        
        	if(e != ""){
		_("emailstatus").innerHTML = "<img src='loading.gif' alt='loading.......'>";
		var ajax = AjaxObject("POST", "admin.php");
        ajax.onreadystatechange = function() {
	       if(ajaxReturn(ajax) == true) {
	           _("emailstatus").innerHTML = ajax.responseText;
	       }
        }
        ajax.send("emailnamecheck="+e);
	}
    
    }

    //data gathering script
    function signup(){
	var e = _("email").value;
	var p1 = _("pass1").value;
	var p2 = _("pass2").value;
	var fn = _("fname").value;
	var ln = _("lname").value;
	var status = _("status");
	if(fn == "" || e == "" || p1 == "" || p2 == "" || ln==""){
		status.innerHTML = "Fill out all of the form data";
	} else if(p1 != p2){
		status.innerHTML = "Your password fields do not match";
	} else {
		_("subtn").style.display = "none";
		status.innerHTML = "<img src='loading.gif' alt='loading.......'>";
		var ajax = AjaxObject("POST", "admin.php");
        ajax.onreadystatechange = function() {
	       if(ajaxReturn(ajax) == true) {
	           if(ajax.responseText != "signup_success"){
			status.innerHTML = ajax.responseText;
			_("subtn").style.display = "block";
                        
			} else {
				window.scrollTo(0,0);

      _("signupform").innerHTML = "OK "+fn+", An email has been sent to  Yakzy 08067411171 please contact him for your passcode <a href='index.php'>Login Here</a> ";
				}
	       }
        }
        ajax.send("fn="+fn+"&e="+e+"&p="+p1+"&ln="+ln);
	}
}
   
        
        </script>
        
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <link rel="stylesheet" type="text/css" href="admin.css"/>
        
    
        
 
    </head>
    <body>
        
        <div id="form">
            <h4 style="text-align: center; background:red">Admin data collection page</h4>
        <form onsubmit="return false;" id="signupform">
    <label for="password"> Email:</label> 
    <input type="text"  id="email" placeholder="email" maxlength="40" onblur="checkemail()"    onkeyup="restrict('email')"  />  <span id="emailstatus" text-align=center></span><br/><br/>
        <label for="firstname">First name:</label> 
        <input type="text" id="fname" placeholder="first name" maxlength="12" onfocus="emptystatus('status')" /><br/><br/>
        <label for="Lastname">Last name:</label> 
        <input type="text" id="lname" placeholder="last name" maxlength="12" onfocus="emptystatus('status')"  /><br/><br/>
        <label for="password">Password:</label> 
        <input type="password" id="pass1" placeholder="password" maxlength="12" onfocus="emptystatus('status')" /><br/><br/>
        <label for="password"> confirm Password:</label> 
        <input type="password" id="pass2" placeholder="confirm password" maxlength="12" onfocus="emptystatus('status')"  /><br/><br/>
        <input type="submit" onclick="signup()" value="Submit" class="btn" id="subtn"/>
              <span id="status"></span>
        </form>
        </div>
    </body>
   </html>