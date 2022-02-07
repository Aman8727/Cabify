<?php
session_start();
?>

 
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>New Request</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="shortcut icon" href="img/favicon.png" type="image/png">
    <style >
    body{
      background:url(http://1fykyq3mdn5r21tpna3wkdyi-wpengine.netdna-ssl.com/wp-content/uploads/2016/07/one_million_sf_trips_wallpaper.png);
      background-size: 100% auto;
      background-color:cyan;
    }
    .navigation {
  width: 100%;
  background-color: black;
}
.logout {
  font-family: sans-serif ;
  font-size: 1.1em;
  position: relative;
  padding :5px;
  letter-spacing: 1px;
  display :inline-block;
}

.button {
  text-decoration: none;
  float: right;
  padding: 12px;
  margin-top: 1px;
  margin-right: 2px;
  color: black;
  width: 100px;
  background-color: cyan;

}
    </style>
    
  </head>
  <body>
    <?php
  include 'dbcon.php';
if(isset($_POST['submit']))
{
  $cabsharefrom=mysqli_real_escape_string($con, $_POST['FromLocation']);
  $cabshareto=mysqli_real_escape_string($con, $_POST['Location']);
  $cdate=mysqli_real_escape_string($con, $_POST['Date']);
  $ctime=mysqli_real_escape_string($con, $_POST['Time']);
  $availability=mysqli_real_escape_string($con, $_POST['Passno']);
  $tot_seats=mysqli_real_escape_string($con, $_POST['Seat']);
  $id=$_SESSION['user_id'];
  if($tot_seats<=$availability)
  {
     echo '<p style="color: red; text-align: center"> Available seats should be less than the total seats </p>';
  }
  else{
    $insertquery ="insert into cabshare(user_id, cdate, ctime,cabsharefrom, cabshareto, availability, tot_seats) values('$id', '$cdate', '$ctime', '$cabsharefrom', '$cabshareto', '$availability', '$tot_seats')";
$iquery=mysqli_query($con,$insertquery);
if($iquery)
{
  ?>
  <script>
    alert("Request Registered Successfully");
  </script>
  <?php
}
else{
?>
  <script>
    alert("Request Not Registered");
  </script>
  <?php
}
}
}
?>

<div class="navigation">
  
  <a class="button"  href="logout.php">
  <div class="logout" ><b>LOGOUT</b></div>

  </a>

  <a class="button" href="home.php"  style="float: left">
  <div class="logout"><b>GO BACK</b></div>

  </a>
  
</div>
<br><br><br>

    <div class="main">
    
    <div class="box">
     <h2>Post Request</h2>
    <form class="newrequest" method="POST">

      <label>Location:</label><br>
      <input type="text" name="FromLocation" required placeholder="From"><br><br>
      <label>Location:</label><br>
      <input type="text" name="Location" required placeholder="To"><br><br>
      <label>Date:</label>
      <br>
      <input type="date" name="Date" value=""required> <br><br>
      <label for="Time">Time:</label>
      <br>
      <input type="time" name="Time" value="" required><br><br>
      <label for="">Enter Seat Availablity:</label><br>
      <select name="Passno" class="pass">
         <option value="1">1</option>
         <option value="2">2</option>
         <option value="3">3</option>
         <option value="4">4</option>
         <option value="5">5</option>

      </select>
      <br><br>
      <label for="">Total seats in Taxi</label><br>
      &nbsp;&nbsp;
        <span id="rd1">4</span>
      <input type="radio" id="rd" name="Seat" value="4">
      <span id="rd1">6</span>

      <input type="radio" id="rd" name="Seat" value="6">

      <br><br>
      <input type="submit" id="submit" name="submit" value="Submit">

    </form>
    </div>
  </div>
  </body>
</html>
