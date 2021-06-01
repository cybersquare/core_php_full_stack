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
#spliting dob (1-1-200) into seperate
$dob = (explode("-",$prof_data['dob']));

}else{
    ?>
    <script>
        alert("Please Login Your Account..!")
        window.location.href = "index.php";
    </script>
<?php 
}
?>
<?php
#prifile updates ////////////////////////////////////
#collect form datas on button click
$res="";
if(isset($_POST['updbtn'])){
    $firstname = $_POST['firstname'];
    $surname = $_POST['surname'];
    $mobemail = $_POST['mob_email'];
    $dob = $_POST['day'].'-'.$_POST['month'].'-'.$_POST['year'];
    $gender = $_POST['gender'];
    #fileupload 
    $uploadOk = 1;
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    //check file ploaded or not
    if($target_file==$target_dir){
        $target_file=$prof_data['profile'];
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        $res =  "Sorry, file already exists.";
        $uploadOk = 0;
    }
  // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $res =  "Sorry, your file is too large. Upload lesser than 500KB";
        $uploadOk = 0;
    }
    if($uploadOk==1){
     //   move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    }
    #update query PostgreSQL
    #update profile
   $res = pg_query($db,"UPDATE user_register SET firstname='$firstname',surname='$surname',mob_email='$mobemail',dob='$dob',gender='$gender',profile='$target_file' WHERE id = '$user_id' ");
    #update username
   pg_query($db,"UPDATE login SET user_name='$mobemail' WHERE user_id = '$user_id' ");
    #get last insert id
    if ($res) {
        $res =  "Account Account Updated";
    } else {
        $res =  "User must have sent wrong inputs";
    }
}
#end acount registration ///////////////////////
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
    <li class="list-group-item"> <i class="fa fa-user-o" style="font-size:40px">&nbsp;</i><a href="dasboard.php" style="text-decoration: none;color:black"><?php echo $prof_data['firstname'];  ?></a></label></li>
        <li class="list-group-item"><i class="fa fa-pencil-square-o" style="font-size:40px">&nbsp;</i><a href="editprofile.php" style="text-decoration: none;color:black">Edit Profile</a></li>
        <li class="list-group-item"><i class="fa fa-key" style="font-size:40px">&nbsp;</i><a href="changepassword.php" style="text-decoration: none;color:black">Change Password</a></li>
        <li class="list-group-item"><i class="fa fa-sign-out" style="font-size:40px">&nbsp;</i><a href="logout.php" style="text-decoration: none;color:black">Logout</a></li>
    </ul>
    </div>
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 col-xxl-8">
    <div class="row">
    <ul class="list-inline" style="margin-top:4%;font-size:20px">
        <li class="list-inline-item"><i class="bg-badge fa fa-pencil-square-o"></i> Update Status</li>
        <li class="list-inline-item"><i class="bg-badge fa fa-picture-o"></i> Add Photo/Video</i>
        <li class="list-inline-item"><i class="bg-badge fa fa fa-sticky-note-o"></i> Write Note</li>
    </ul>
    </div>
    <div class="row">
        <!--update form -->
        <form class="row g-3" method='post' enctype="multipart/form-data">
                    <div class="col-md-12">
                        <?php 
                        if($prof_data['profile']=="")
                            {
                                ?>
                                <img width="80"  src="images/d_profile.png" id="pic" alt="">
                                <?php
                            }else{
                                ?>
                            <img width="80"  src="<?php echo $prof_data['profile'] ?>" id="pic" alt="">
                                <?php
                            }
                        ?>
                    
                    <label for="upload" class="btn btn-outline-secondary">UPLOAD</label>
                    <input name="fileToUpload" hidden type="file" accept="image/*" id="upload" oninput="pic.src=window.URL.createObjectURL(this.files[0])">
                    </div>
                    <div class="col-md-6">
                            <label for="">Firstname</label>
                        <input type="text" name="firstname" class="form-control input" id="firstname" placeholder="First name" value="<?php echo $prof_data['firstname'] ?>">
                    </div>
                    <div class="col-md-6">
                    <label for="">Surname</label>
                        <input type="text" name="surname" class="form-control input" id="surname" placeholder="Surname" value="<?php echo $prof_data['surname'] ?>">
                    </div>
                    <div class="col-12">
                    <label for="">Email/Contact <span style="color:red">(If you update this the username also will be changed.) <span></label>
                        <input type="text" name="mob_email" class="form-control input" id="mobemail" placeholder="Mobile number or email address" value="<?php echo $prof_data['mob_email'] ?>">
                    </div>
                    <!-- <div class="col-12">
                        <input type="password" name="password" class="form-control input" id="password" placeholder="New password">
                    </div> -->
                    <div class="col-md-6">
                        <label for="inputCity" class="form-label input" style="color: #3f3f3d;">Date of birth</label>
                        <div class="row">
                            <div class="col-lg-12">
                                <select name="day" id="">
                                  <option value="">Day</option>
                                  <option selected value="<?php echo $dob[0] ?>"><?php echo $dob[0] ?></option>
                                  <script> 
                                  for(i=1;i<=31;i++) {
                                    document.write("<option value='"+i+"'>"+i+"</option>")
                                  }
                                  </script>
                                </select>
                                <select name="month" id="">
                                  <option value="">Month</option>
                                  <option value="<?php echo $dob[1] ?>" selected><?php echo $dob[1] ?></option>
                                  <script>
                                     var  months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                                     for(i=0;i<12;i++) {
                                    document.write("<option value='"+months[i]+"'>"+months[i]+"</option>")
                                  }
                                </script>

                                </select>
                                <select name="year" id="">
                                  <option value="">Year</option>
                                  <option selected value="<?php echo $dob[2] ?>"><?php echo $dob[2] ?></option>
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
                            <input <?php if ($prof_data['gender']=='male')  echo "checked"  ?> class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="male">
                            <label class="form-check-label" for="inlineRadio1">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input <?php if ($prof_data['gender']=='female')  echo "checked"  ?> class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="female">
                            <label class="form-check-label" for="inlineRadio2">Female</label>
                        </div>
                    </div>
                    <div class="col-12">
                    <button type="clear"  class="button">Cancel</button> <button type="submit" name='updbtn' class="button">Update</button>
                    <p style="color:red"><?php echo $res ?></p>   
                </div>
                </form>
        <!--//update form-->
    </div>
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