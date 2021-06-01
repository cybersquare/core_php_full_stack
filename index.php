<?php

#include db connection
require_once('db_connect.php');

#account registration ////////////////////////////////////
#collect form datas on button click
$res = "";
$log_err ="";
if(isset($_POST['signbtn'])){
    $firstname = $_POST['firstname'];
    $surname = $_POST['surname'];
    $mobemail = $_POST['mob_email'];
    $password = $_POST['password'];
    $dob = $_POST['day'].'-'.$_POST['month'].'-'.$_POST['year'];
    $gender = $_POST['gender'];
    #insert query PostgreSQL.................
    $res = pg_query($db,"INSERT INTO  user_register(firstname,surname,mob_email,dob,gender) VALUES('$firstname','$surname','$mobemail','$dob','$gender')");
    #get last insert id...................
    $last_id = pg_query($db,"SELECT max(id ) FROM user_register");
    $data =  pg_fetch_array($last_id);
    $lastid = $data[0];
    #insert username and pass with foreign key
    pg_query($db,"INSERT INTO  login(user_id,username,password) VALUES('$lastid',' $mobemail','$password')");
    if ($res) {
        $res =  "Account registerd successfully";
    } else {
        $res =  "User must have sent wrong inputs";
    }
}
#end acount registration ///////////////////////

#acount login 
if(isset($_POST['login'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];
    #select query for get login credentials
    $log_qry = pg_query($db,"SELECT * FROM login WHERE password = '$pass'");
    
    if(pg_num_rows($log_qry)>0){
        $logary = pg_fetch_assoc($log_qry);
        $duser=$logary['username'];
        $dpass=$logary['password'];
        if(($user==$user)and($pass==$pass)){
            #set userid in SESSION
            session_start();
            $_SESSION['user_id']=$logary['user_id'];
            #redict to dashboard
            header("location:dashboard.php");
        }else{
            $log_err =  "Incorrect username or password";
        }
    }else{
        $log_err =  "Incorrect username or password";
    }
}
#end acount login /////////////////
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <title>Welcome Facebook | CyberSquare</title>
    <link rel="stylesheet" href="css/style.css">


</head>

<body>


    <!--navbar-->
    <div class="row bg-nav">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
            <img class="img img-fluid" src="images/fb-logo.png" width="230" alt="">
        </div>
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-6 d-none d-sm-block d-sm-none d-md-block">
            <!--login form-->
            <form class="row" method='post'>
                <div class="col">
                    <label class="txt-color" for="username">Username</label>
                    <input type="text" name="username" required class="form-control" aria-label="username" id="username">
                    <div class="form-text" style="color:red"> <?php echo $log_err ?> </div>
                </div>
                <div class="col">
                    <label class="txt-color" for="password">Password</label>
                    <input type="text" name="password" required class="form-control" aria-label="password" id="password1">
                    <div class="form-text"> <a href="forgotpassword.php" style="text-decoration: none;color: white;">Forgotten account?</a> </div>
                </div>
                <div class="col">
                    <div class="mt-4">
                        <button class="btn txt-color" name="login" style="background-color: #4267b2;border-color: #29487d;">Login</button>
                    </div>
                </div>
            </form>
            <!--//login form-->
        </div>

    </div>
    <!--close navbar-->

    <!--section body-->
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-6 d-none d-sm-block d-sm-none d-md-block">
                <h2 class="mt-3 mb-3" style="color: #3e385f; font-size: 20px;">Facebook helps you connect and share with the people in your life.</h2>
                <img src="images/connect.png" alt="" class="img img-fluid">
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-6 d-none d-sm-block d-sm-none d-md-block">

                <h1 class="head"><b>Create a new account</b></h1>
                <h5 class="mt-3 mb-3" style="color: #292e2e;">It's quick and easy.</h5>
                <!--register form -->
                <form class="row g-3" method='post' onsubmit="return validateForm()">
                    <div class="col-md-6">

                        <input type="text" name="firstname" class="form-control input" id="firstname" placeholder="First name">
                    </div>
                    <div class="col-md-6">

                        <input type="text" name="surname" class="form-control input" id="surname" placeholder="Surname">
                    </div>
                    <div class="col-12">

                        <input type="text" name="mob_email" class="form-control input" id="mobemail" placeholder="Mobile number or email address">
                    </div>
                    <div class="col-12">

                        <input type="password" name="password" class="form-control input" id="password" placeholder="New password">
                    </div>
                    <div class="col-md-6">
                        <label for="inputCity" class="form-label input" style="color: #3f3f3d;">Date of birth</label>
                        <div class="row">
                            <div class="col-lg-12">
                                <select name="day" id="day">
                                  <option value="">Day</option>
                                  <script> 
                                  for(i=1;i<=31;i++) {
                                    document.write("<option value='"+i+"'>"+i+"</option>")
                                  }
                                  </script>
                                </select>
                                <select name="month" id="month">
                                  <option value="">Month</option>
                                  <script>
                                     var  months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                                     for(i=0;i<12;i++) {
                                    document.write("<option value='"+months[i]+"'>"+months[i]+"</option>")
                                  }
                                </script>
                                </select>
                                <select name="year" id="year">
                                  <option value="">Year</option>
                                  <script> 
                                  for(i=1993;i<= (new Date().getFullYear());i++) {
                                    document.write("<option value='"+i+"'>"+i+"</option>")
                                  }
                                  </script> 
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">

                        <label for="gender" class="form-label input" style="color: #3f3f3d;">Gender</label> <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                            <label class="form-check-label" for="inlineRadio1">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                            <label class="form-check-label" for="inlineRadio2">Female</label>
                        </div>
                    </div>
                    <div class="form-text">By clicking Sign Up, you agree to our Terms, Data Policy and Cookie Policy . You may receive SMS notifications from us and can opt out at any time.</div>
                    <div class="col-12">
                        <button type="submit" name='signbtn' class="button">Sign Up</button>
                        <p style="color:red"><?php echo $res ?></p>
                    </div>
                </form>
                <!--//register form-->
            </div>
        </div>
    </div>
    <!--//section body-->

    <!--login responsive-->
    <div class="container">
        <div class="row">
            <div class="d-md-none d-lg-block d-lg-none d-xl-block d-xl-none d-xxl-block d-xxl-none">
                <form method='post'>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" name="password"  class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <button type="submit" name="login" style="width: 100%;" class="btn btn-primary">Submit</button>
                    <div class="form-text"> <a href="forgot_password.php" style="text-decoration: none;color: #000000;">Forgotten account?</a> </div>
                    <div class="form-text" style="color:red"> <?php echo $log_err ?> </div>
                </form>
            </div>
        </div>
    </div>
    <!--//login responsive-->

    <!--validatin-->
    <script>
function validateForm()
{
    if(document.getElementById("firstname").value=="")
	{
		alert("Please enter the first name");
		document.getElementById("firstname").focus();
		return false;
	}
    if(/[^a-z]/gi.test(document.getElementById("firstname").value)){
		alert("Enter alphabets only");
		document.getElementById("firstname").focus();
		return false;
	}
    if(document.getElementById("surname").value=="")
	{
		alert("Please enter the last name");
		document.getElementById("surname").focus();
		return false;
	}
    if(document.getElementById("mobemail").value=="")
	{
		alert("Please enter the email or contact");
		document.getElementById("mobemail").focus();
		return false;
	}
    if(/[^a-z]/gi.test(document.getElementById("surname").value)){
		alert("Enter alphabets only");
		document.getElementById("surname").focus();
		return false;
	}
    var emailPat =/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;

     var emailid=document.getElementById("mobemail").value;

     var matchArray = emailid.match(emailPat);

     if ((matchArray == null) && (isNaN(document.getElementById("mobemail").value)))

    {

               alert("Enter Email id or contact number incorect format");
               document.getElementById("mobemail").focus();
               return false;

    }
    if(document.getElementById("password").value=="")
	{
		alert("Please enter the password");
		document.getElementById("password").focus();
		return false;
	}
    if(document.getElementById("day").value=="")
	{
		alert("Please select day");
		document.getElementById("day").focus();
		return false;
	}
    if(document.getElementById("month").value=="")
	{
		alert("Please select month");
		document.getElementById("month").focus();
		return false;
	}
    if(document.getElementById("year").value=="")
	{
		alert("Please select year");
		document.getElementById("year").focus();
		return false;
	}
    if(document.getElementById("male").checked=="" && document.getElementById("female").checked=="" )
	{
		alert("Please select gender");
		document.getElementById("male").focus();
		document.getElementById("female").focus();
		return false;
	} 
    //return false;
}	
</script>

    <!---//validation ------->


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
</body>

</html>