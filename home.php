<?php

session_start();
if(!isset($_SESSION['name']))
{
	echo "You are logged out";
	header('location:login.php');
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <title>Cabify</title>
    <link rel="stylesheet" href="css/sytlemain.css">
    <style>
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
  margin: 15px;
  color: black;
  width: 100px;
  background-color: cyan;
}


    </style>
</head>
<body>
  <h1 style="color: cyan; font-family: sans-serif;" >
Hello 
<?php echo $_SESSION['name'];
?>
!
</h1>
<br>
<div class="navigation">
  
  <a class="button" href="logout.php">
  <div class="logout"><b>LOGOUT</b></div>

  </a>
  
</div>

    <div class="maint">
       <div class="b1">
      <a href="newrequest.php" class="BUTTON_FEF">Create New Request</a>
        </div>
       <div class="b2">
          <a href="displaycabshares.php" class="BUTTON_FEF">Search from Existing Request</a>
       </div>
    </div>
    <br>
</body>
</html>