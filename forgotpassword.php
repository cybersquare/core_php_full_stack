<?php
#include db connection
require_once('db_connect.php');
$log_err="";
#acount login /////////////////
if(isset($_POST['login'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];
    #select query for get login credentials
    $log_qry = pg_query($db,"SELECT * FROM login WHERE password = '$pass'");
    
    if(pg_num_rows($log_qry)>0){
        $logary = pg_fetch_assoc($log_qry);
        $duser=$logary['user_name'];
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
//forgot password 
if(isset($_POST['btnssearch'])){
    $serch_data=$_POST['serchtxt'];
    $log_user = pg_query($db,"SELECT * FROM login WHERE username = ' $serch_data'");
    if(pg_num_rows($log_user)>0){
        echo "exist";
    }else{
       
        echo "not exist";
    }
}
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
    <style>
        .form-m {
            margin: 12%;
        }
    </style>


</head>

<body>


    <!--navbar-->
    <div class="row bg-nav">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
            <img class="img img-fluid" src="images/fb-logo.png" width="230" alt="">
        </div>
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-6 d-none d-sm-block d-sm-none d-md-block">
            <!--login form-->
            <form method = 'post'>
            <div class="row">
                <div class="col">
                    <label class="txt-color" for="username">Username</label>
                    <input type="text" name="username" required class="form-control" aria-label="username" id="username">
                    <div class="form-text" style="color:red"> <?php echo $log_err ?> </div>
                </div>
                <div class="col">
                    <label class="txt-color" for="password">Password</label>
                    <input type="text" name="password" class="form-control" required aria-label="password" id="password">
                    <div class="form-text"> <a href="forgot_password.php" style="text-decoration: none;color: white;">Forgotten account?</a> </div>
                </div>
                <div class="col">
                    <div class="mt-4">
                        <button class="btn txt-color" name="login" style="background-color: #4267b2;border-color: #29487d;">Login</button>
                    </div>

                </div>
            </div>
            </form>
            <!--//login form-->
        </div>

    </div>
    <!--close navbar-->


    <!--forgot pass form-->
    <div class="container" style="margin-top: 8%;">
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 col-xxl-3"></div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">

                <div class="card">
                    <div class="card-header" style="background-color: white;">
                        <h4><b>Find Your Account</b></h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <form method="post">
                            <b><label for="formGroupExampleInput" class="form-label">Please enter your email address or mobile number to search for your account.</label></b>
                            <input type="text" required name="serchtxt" class="form-control" id="formGroupExampleInput" placeholder="Mobile number or Email">
                        </div>

                    </div>
                    <div class="card-footer" style="background-color: white;">
                        <div class="mb-3" style="text-align: right;">
                            <button type="clear" class="btn btn-dark">Clear</button>
                            <button name="btnssearch" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 col-xxl-3"></div>
        </div>
    </div>


    <!--//forgot pass form-->

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