<?php include 'includes/header.php'; ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
     <link rel="stylesheet" href="css/custom.css"/>
        <script src="js/ajax.js"></script>
        <script>
        function check(){
     var m = _("matric").value;
        
        	if(m != ""){
		_("matric_status").innerHTML = 'checking ...';
		var ajax = AjaxObject("POST", "includes/process2.php");
        ajax.onreadystatechange = function() {
	       if(ajaxReturn(ajax) == true) {
	           _("matric_status").innerHTML = ajax.responseText;
	       }
        }
            ajax.send("matriccheck="+m);
	}
        } 
        
         function signup(){
	var d = _("depart").value;
	var m = _("matric").value;
	var p1 = _("pass").value;
	var p2 = _("Vpass").value;
	var fn = _("fname").value;
	var ln = _("lname").value;
	var e = _("email").value;
	var g = _("gender").value;
	var ph = _("phone_no").value;
	var lv = _("level").value;
	var status = _("status");
	if(fn == "" || e == "" || p1 == "" || p2 == "" || ln=="" || d == "" || m =="" || g == "" || ph == ""|| lv ==""){
		status.innerHTML = "Fill out all of the form data";
	} else if(p1 != p2){
		status.innerHTML = "Your password fields do not match";
	} else {
		_("subtn").style.display = "none";
		status.innerHTML = 'please wait ...';
		var ajax = AjaxObject("POST", "includes/process2.php");
        ajax.onreadystatechange = function() {
	       if(ajaxReturn(ajax) == true) {
	           if(ajax.responseText != "signup_success"){
			status.innerHTML = ajax.responseText;
			_("subtn").style.display = "block";
                        
			} else {
				window.scrollTo(0,0);

      _("signupform").innerHTML = "OK "+fn+", your password was sent to your email,check inbox or spam folder <a href='index.php'>Login Here</a> ";
				}
	       }
        }
        ajax.send("fn="+fn+"&p="+p1+"&ln="+ln+"&e="+e+"&g="+g+"&ph="+ph+"&m="+m+"&d="+d+"&lv="+lv);
	}
}
       
        </script>
        <style>
            #status{
    color: red;
    font-size:  medium;
    text-align: center;
}
        </style>
    </head>
    <body>
       
            <div class="jumbotron">
    <div class="container">
<div  class="row">
<div class="col-lg-3 col-md-3 col-sm-3"></div>
<div class="col-lg-6 col-md-6 col-sm-6" 
  style="box-shadow: -0.2px -0.2px 4px 4px #ccc;background:lightcyan; position: relative; border-radius: 4px;"> 
<div class="login" style="font-size:18px;
     font-size: medium;
     font-family:fantasy;
     margin-bottom:20px;
     background:green;
     box-shadow: -0.2px -0.2px 4px 4px #ccc;
     border-radius: 4px;text-align:center;">NASS/NACOSS DUE SIGN UP PAGE</div>
<p>
        <form action="" onsubmit="return false;" id="signupform">
                   
                 
                    <select id="depart" class="form-control" >
                <option value="">SELECT DEPARTMENT</option>
                <option value="Computer Science">Computer Science</option>
				<option value="Micro Biology">Micro Biology</option>
				<option value="Physics">Physics</option>
				<option value="mathematics">mathematics</option>
				<option value="statistics/ORr">statistics/ OR</option>
				<option value="Operations reserach">Operations Reserach</option>
				<option value="Science Lab. Tech">Science Lab. Tech</option>
				<option value="Biochemistry">Biochemistry</option>
				<option value="chemistry">Chemistry</option>
				<option value="biotechnology">biotechnology</option>
				<option value="biological science">biological science</option>
				<option value="geology">Geology</option>
				<option value="mathematics Economics">mathematics/ Economics</option>
                                <option value="Plant Science">Plant Science</option>
				<option value="Zoology">Zoology</option>
            </select><br/><span id="matric_status"></span> 
      
        <div class="form-group">
        
       <label for="inputEmail3" class="col-sm-2 control-label">Matric:</label>
       <div class="col-sm-10">
           
           <input type="Matric" class="form-control" placeholder="Matric" id="matric" onblur="check()" onfocus="emptystatus('status')">  
    </div><br/>
        </div><br/>
        <div class="form-group">
       <label for="inputEmail3" class="col-sm-2 control-label">Firstname:</label>
       <div class="col-sm-10">
           <input type="Firstname" class="form-control"  placeholder="Firstname" id="fname" onfocus="emptystatus('status')">
    </div><br/>
        </div><br/>
        <div class="form-group">
            <label for="inputEma>
              il3" class="col-sm-2 control-label">Lastname:</label>
       <div class="col-sm-10">
           <input type="Lastname" class="form-control"  placeholder="Lastname" id="lname"onfocus="emptystatus('status')">
    </div><br/>
        </div><br/>
           
            <select id="level" class="form-control">
                                <option value="">SELECT LEVEL</option>
                                 <option value="100">100 LEVEL</option>
                                <option value="200">200 LEVEL</option>
				<option value="200DE">200DE LEVEL</option>
				<option value="300">300 LEVEL</option>
				<option value="400">400 LEVEL</option>
				<option value="500">500 LEVEL</option>
				
            </select><br/>
        <div class="form-group">
       <label for="inputEmail3" class="col-sm-2 control-label">email:</label>
       <div class="col-sm-10">
           <input type="email" class="form-control"  placeholder="email" id="email" onfocus="emptystatus('status')">
    </div><br/>
        </div><br/>
        <div class="form-group">
       <label for="inputEmail3" class="col-sm-2 control-label">password:</label>
       <div class="col-sm-10">
           <input type="password" class="form-control"  placeholder="password" id="pass" onfocus="emptystatus('status')">
    </div><br/>
        </div><br/>
        <div class="form-group">
       <label for="inputEmail3" class="col-sm-2 control-label">V.password:</label>
       <div class="col-sm-10">
           <input type="password" class="form-control" placeholder="password" id="Vpass" onfocus="emptystatus('status')">
    </div><br/>
        </div><br/>
                    <select id="gender" class="form-control">
                                        <option value="">Select Gender</option>
                                         <option value="M">Male</option>
                                        <option value="F">Female</option>

                    </select><br/>
             <div class="form-group">
       <label for="inputEmail3" class="col-sm-2 control-label">Phone No:</label>
       <div class="col-sm-10">
           <input type="tel" class="form-control"  placeholder="phone number" id="phone_no" onfocus="emptystatus('status')">
    </div><br/>
        </div><br/>
       
        <input type="submit" class="btn btn-default" id="subtn" onclick="signup()" value="Create an account" />
        <a href="index.php" class="btn btn-lg btn-md btn-sm btn-primary">I have an account</a>
        
                  <div id="status"></div>
        </form>
</p>
        </div>
        </div>
        </div>
        </div>
      
   
  <?php include 'includes/footer.php'; ?>
    </body>
</html>
