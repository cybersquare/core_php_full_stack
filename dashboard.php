<?php

#include db connection
require_once('db_connect.php');
session_start();
#check session exist or no
if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
#getting profile details
$prof_qry = pg_query($db,"SELECT * FROM user_register  WHERE id = '$user_id'");
$prof_data = pg_fetch_array($prof_qry);

}else{
    ?>
    <script>
        alert("Please Login Your Account..!")
        window.location.href = "index.php";
    </script>
<?php 
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Welcome Facebook | CyberSquare</title>
  </head>
  <body>
   
    <div class="container-fluid">
    <div class="row bg-nav">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
        <div class="input-group">
    <input type="text" class="form-control" placeholder="Search this blog">
    <div class="input-group-append">
      <button class="btn btn-secondary" type="button">
        <i class="fa fa-search"></i>
      </button>
    </div>
  </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
        <?php if($prof_data['profile']=="") {?>
        <img width="40" src="images/d_profile.png" alt=""> <label style="color:white"><?php echo $prof_data['firstname'];  ?></label>
        <?php } else {
            ?>
            <img width="40" src="<?php echo $prof_data['profile'] ?>" alt=""> <label style="color:white"><?php echo $prof_data['firstname'];  ?></label>
            <?php
        } ?>
        </div>
    </div>
    </div>
    <div class="container-fluid">
    <div class="row">
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
    <ul class="list-group">
        <li class="list-group-item"> <i class="fa fa-user-o" style="font-size:40px">&nbsp;</i><a href="dashboard.php" style="text-decoration: none;color:black"><?php echo $prof_data['firstname'];  ?></a></label></li>
        <li class="list-group-item"><i class="fa fa-pencil-square-o" style="font-size:40px">&nbsp;</i><a href="editprofile.php" style="text-decoration: none;color:black">Edit Profile</a></li>
        <li class="list-group-item"><i class="fa fa-key" style="font-size:40px">&nbsp;</i><a href="changepassword.php" style="text-decoration: none;color:black">Change Password</a></li>
        <li class="list-group-item"><i class="fa fa-sign-out" style="font-size:40px">&nbsp;</i><a href="logout.php" style="text-decoration: none;color:black">Logout</a></li>
    </ul>
    </div>
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 col-xxl-8">
    <ul class="list-inline" style="margin-top:4%;font-size:20px">
        <li class="list-inline-item"><i class="bg-badge fa fa-pencil-square-o"></i> Update Status</li>
        <li class="list-inline-item"><i class="bg-badge fa fa-picture-o"></i> Add Photo/Video</i>
        <li class="list-inline-item"><i class="bg-badge fa fa fa-sticky-note-o"></i> Write Note</li>
    </ul>
    </div>
    </div>
    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
    -->
  </body>
</html>