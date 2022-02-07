<?php
session_start();
require_once 'PDO.php';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // echo "Connected to $dbname at $host successfully.";
} catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" href="img/favicon.png" type="image/png">
	<script language="JavaScript" type="application/javascript" src="jquery.js"></script>
	<script language="JavaScript" type="application/javascript" src="jquery-ui.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
  body{
    background:url('http://1fykyq3mdn5r21tpna3wkdyi-wpengine.netdna-ssl.com/wp-content/uploads/2016/07/one_million_sf_trips_wallpaper.png');
    background-size: 100% auto;
  }
  .outermax {
    width:500px;
    height:300px;
    box-shadow: 2px 2px 15px rgba(0,0,0,0.5);
    background-color:rgba(0,0,0,0.5) ;
    padding:20px;
    border-radius:10px;
    font-size: 18px;
    border:1px solid;
    color:#fff;
    margin:100px auto 0px auto;
  }
   h2{
     left-margin: 20px ;
   }
   .one {
      margin-top :100px;
  }
  p{
    font-size:16px;
    font-family:sans-serif;
    font-weight:600;
    color: #fff;
    margin-left: 30% ;
    margin-top: 10px ;
  }
  #box{
    margin: auto;
  }
  #submit{
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
  #one {
      margin-top :100px;
  }
  li{ color :#fff;
      text-decoration:underline ;
      list-style-type:none;
      margin-left:30% ;
  }
  </style>
	<title>Cabshare details</title>
</head>
<body>
<?php
if(isset($_SESSION['success'])){
	echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
	$stmt = $pdo->prepare("SELECT * FROM users INNER JOIN cabshare ON users.user_id = cabshare.user_id WHERE cabshare.cabshare_id = :id");
	$stmt->execute(array(':id' => $_GET['cabshare_id']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$date = $row['cdate'];
	$time = $row['ctime'];
	$from = htmlentities($row['cabsharefrom']);
	$dest = htmlentities($row['cabshareto']);
	$name = htmlentities($row['name']);
	$phone = htmlentities($row['phone']);


	echo('<p class="one">OriginalPoster Name: '.$name.'</p>');
	echo('<p>OriginalPoster Phone: '.$phone.'</p>');
	echo('<p>Cabshare date: '.$date.'</p>');
	echo('<p>Cabshare time: '.$time.'</p>');
	echo('<p>Cabshare from: '.$from.'</p>');
	echo('<p>Cabshare to: '.$dest.'</p>');
	$stmt = $pdo->prepare("SELECT * FROM users INNER JOIN booker ON users.user_id = booker.user_id WHERE booker.cabshare_id = :id");
	$stmt->execute(array(':id' => $_GET['cabshare_id']));
   

	$bookers = array();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$bookers[] = $row;
}
	echo('<p>Booked by: <ul>');
	foreach ($bookers as $booker) {
		echo('<li>'.$booker['name'].'</li>');
	}
    
?>

</body>
</html>
