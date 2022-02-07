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
  .loginbtn{
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
  .loginbtn:hover {
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
	$email=$_POST['email'];
	$password = $_POST['psw'];
	$email_search="select * from users where email='$email'";
	$query=mysqli_query($con,$email_search);
	$email_count=mysqli_num_rows($query);

	if($email_count)
	{
		$email_pass = mysqli_fetch_assoc($query);
		$db_pass=$email_pass['password'];

    $_SESSION['name'] = $email_pass['name'];
    $_SESSION['user_id'] = $email_pass['user_id'];
    $_SESSION['phone'] = $email_pass['phone'];
		$pass_decode = password_verify($password,$db_pass);
		if($pass_decode)
		{
			echo "Login Successful";
      ?>
      <script>
        location.replace("home.php");
      </script>
      <?php
		}
		else echo "Password Incorrect";
	}
	else echo "Invalid Email";
}
  ?>
  <div class="container">
    <h2>Login Form</h2>
  <form name="form1" method="POST">
  <label for="email">Email : </label>
  <input type="text" placeholder="Enter Email" name="email" required><br><br>

    <label for="psw">Password : </label><br>
    <input type="password" placeholder="Enter Password" name="psw" required><br><br>
    <button type="submit" name="submit" class="loginbtn">Login Now</button><br><br>
    <div class="cen">

     Don't have an account? <a href="regist.php"> Register here </a><span>
     </div>
     </form>
     </div>
</body>
</html>
