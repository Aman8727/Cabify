<?php
session_start();
require_once 'PDO.php';
//if(!isset($_SESSION['user_id'])){
	//die("Please Log in");
	//return;
//}
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    //echo "Connected to $dbname at $host successfully.";
} catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}
if(isset($_POST['addseats'])){
$newseats = $_POST['availability']-$_POST['addseats'];
if($newseats>=0 && $_POST['addseats']>0){
$stmt = $pdo->prepare("UPDATE cabshare SET availability = :newseats WHERE cabshare_id= :cid");
$stmt->execute(array(
	':newseats'=>$newseats,
	'cid'=>$_GET['cabshare_id']
));
$stmt = $pdo->prepare("INSERT INTO booker (cabshare_id, user_id, seatbooked) VALUES (:cid, :uid, :sbkd)");
$stmt->execute(array(
	':cid'=>$_GET['cabshare_id'],
	':uid'=>$_SESSION['user_id'],
	':sbkd'=>$_POST['addseats']
));
$_SESSION['success'] = 'Cab booked';
header('Location: cabsharedetails.php?cabshare_id='.$_GET['cabshare_id']);
}
else {
	$_SESSION['failure'] = "enter a valid number";
	header("Location: book.php?cabshare_id=".$_GET['cabshare_id']);
    return;
	}
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
    height:500px;
    box-shadow: 2px 2px 15px rgba(0,0,0,0.5);
    background-color:rgba(0,0,0,0.5) ;
    padding:20px;
    border-radius:10px;
    font-size: 18px;
    border:1px solid;
    color:#fff;
    margin:100px auto 0px auto;
  }
  .con{
      margin-left:10% ;
  }
  #pr{
     left-margin: 50px ;
   }
   h2{
       margin-left:40px ;
   }
  p{
    font-size:16px;
    font-family:sans-serif;
    font-weight:600;
    color: #fff;
  }
  #addseats{
    margin-left :70px;
    width:250px;
     border-radius:3px;
    background-color:rgba(0,0,0,0.5) ;
    color: #fff;
  }
  #box{
       color: #fff;
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
   #mybutton{
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
  </style>
	<title>Book</title>
</head>
<body>
<div class="outermax">


<div class ="con" >
<h2 class="font-weight-bold">Confirm booking </h2>
  
	<?php
	if(isset($_SESSION['failure'])) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['failure'])."</p>\n");
    unset($_SESSION['failure']);
}
	$stmt = $pdo->prepare("SELECT * FROM cabshare WHERE cabshare_id = :id");
	$stmt->execute(array(':id' => $_GET['cabshare_id']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
  echo ('<br> ') ;
	echo('<p>You have selected to book for: '.$row['cdate'].'</p>');
  echo ('<br> ') ;
echo('<p>Cabshare to  '.$row['cabshareto'].' with '.$row['availability'].' available seats </p>');
echo ('<br> ') ;
echo('<p>Enter the number of seats you want to book:</p>');
?>
</div>
<div class="container">

<form method="post">
	<input type="number" id="addseats" name="addseats" value="0">
	<input type="hidden"id="box" name="availability" value=<?= $row['availability']; ?>>
  <br><br>
	<input type="submit" id ="submit" value="book" id="book">
</form>

<div>
<br>
<button onclick="location.href = 'displaycabshares.php';" id="myButton" >Cancel</button>
</div>
<script type="text/javascript">
	avl = <?= $row['availability']; ?>;
	$(document).ready(function(){
		$("#book").click(function(){
			var num = $("#addseats").val();
		if(num<=0){
			alert("enter a valid number");
			return;
		}
		if(num>avl){
			alert("not enough seats available!");
			return;
		}
		});
	});
</script>
</body>
</html>
