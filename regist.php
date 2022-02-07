<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<style>
  body{

    background:url(http://1fykyq3mdn5r21tpna3wkdyi-wpengine.netdna-ssl.com/wp-content/uploads/2016/07/one_million_sf_trips_wallpaper.png);
    background-size: 100% auto;
}
.container {
width:400px;
box-shadow: 2px 2px 15px rgba(0,0,0,0.5);
background-color:rgba(0,0,0,0.5) ;
padding:20px;
border-radius:10px;
font-size: 18px;
border:1px solid;
color:#fff;
margin:100px auto 0px auto;
}

input[type=text], input[type=password], textarea {
width:360px;
border:1px solid #ddd;
border-radius: 3px;
outline:0px;
padding: 7px;
background-color:#fff;
box-shadow:inset 1px 1px 5px rgba(0,0,0,0.3;)
}
label{
font-family:sans-serif;
font-size:18px;
font-style:italic;
}
h2{
text-align: center;
padding:20px;
font-family: sans-serif;
}
.registerbtn{
width:250px;
padding:7px;
font-size:16px;
font-family:sans-serif;
font-weight:600;
margin-left:70px;
border-radius:3px;
background-color:rgba(0,0,0,0.5) ;
color: #fff;
cursor:pointer;
border:1px solid rgba(255,255,255,0.3);
box-shadow: 1px 1px 5px rgba(0,0,0,0.3);
}
.registerbtn:hover {
opacity: 1;
border: solid #00CCCC 1px;

}
.cen{
text-align :center;


}
a{
text-decoration:none;
color:white;
}
a:hover{
color:#00CCCC;
}
  </style>
</head>
<body>
  <?php
  include 'dbcon.php';
if(isset($_POST['submit']))
{
  $Name=mysqli_real_escape_string($con, $_POST['fullname']);
  $Phone=mysqli_real_escape_string($con, $_POST['phone']);
  $Email=mysqli_real_escape_string($con, $_POST['email']);
  $Password=mysqli_real_escape_string($con, $_POST['psw']);
  $ConfPassword=mysqli_real_escape_string($con, $_POST['psw-repeat']);


  $pass =password_hash($Password, PASSWORD_BCRYPT);
  $cpass =password_hash($ConfPassword, PASSWORD_BCRYPT);

  $emailquery = " select * from users where email='$Email'";
  $query = mysqli_query($con,$emailquery);
  $emailcount =mysqli_num_rows($query);
  if($emailcount>0)
  {
    echo '<p style="color: red; text-align: center"> Email already exists </p>';
  }
  else if(strlen($Phone)!=10)
  {
    echo '<p style="color: red; text-align: center"> Phone number should be of 10 digits only </p>';
  }
  else if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $Email)) 
  {
    echo '<p style="color: red; text-align: center"> Enter a valid email id </p>';
  }
  else{
  if($Password===$ConfPassword)
  {
    $insertquery ="insert into users(name, phone, email, password) values('$Name', '$Phone', '$Email', '$pass')";

    $iquery=mysqli_query($con,$insertquery);

if($iquery)
{
  ?>
  <script>
    alert("Registered Successfully");
  </script>
  <?php
}
else{
?>
  <script>
    alert("Not Registered");
  </script>
  <?php
}

  }
  else {echo "password is not matching";}
}
}

  ?>
  <div class="container">
        <h2> Registration Form</h2>
          <form name="form1"  method="POST" >
      <label><b> Full Name :</b></label>
      <br>
    <input type="text" name="fullname" placeholder= "Full name" size="15" required /><br><br>
    <label for="phone"><b> Phone : </b></label><br>
    <input type="text" name="phone" placeholder="phone no." size="10"/ required><br><br>
     <label for="email"><b>Email : </b></label>
     <input type="text" placeholder="Enter Email" name="email" required><br><br>

        <label for="psw"><b>Password : </b></label><br>
        <input type="password" placeholder="Create Password" name="psw"; required>
        <br><br>
        <label for="psw-repeat"><b>Repeat Password : </b></label><br>

        <input type="password" placeholder="Repeat Password" name="psw-repeat" required>
        <br><br>
         <button type="submit" name="submit" class="registerbtn">Create Account</button><br><br>

        <div class="cen">
         Already have an account? <a href="login.php"> Login here </a></div>
     </form>
     </div>
</body>
</html>
