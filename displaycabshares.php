 <?php
require_once 'PDO.php';
session_start();
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
	<script language="JavaScript" type="application/javascript" src="jquery.js"></script>
<script language="JavaScript" type="application/javascript" src="jquery-ui.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
  margin-right :10px ;
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
  body{
    background:url('http://1fykyq3mdn5r21tpna3wkdyi-wpengine.netdna-ssl.com/wp-content/uploads/2016/07/one_million_sf_trips_wallpaper.png');
    background-size: 100% auto;
  }

</style>
	<title>Display cabshares</title>
</head>
<body>

  <a   href="logout.php" style ="float:right">
  <button type="button" class="btn btn-primary">Logout</button>

  </a>

  <a  href="home.php"  style="float: left">
  <button type="button" class="btn btn-primary">GO Back </button>

  </a>

</div>
<br><br><br><br><br><br>
<?php
if(isset($_SESSION['success'])){
	echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
?>
<div class="text-success">
  <div class="container">
<h1 style="font: 2em Lato;">Cabshare requests currently open: </h1>
<form method ="POST" class="form-inline" id="filterspecs">
<p>select date</p><input type="date" name="cfdate" id="reqdate"><span>  </span>
<input type="button" class ="btn btn-primary" value="search by date" id="editorbut"> <span>  </span>
<input type="button" name="clear" class ="btn btn-primary" value="clear filters" id="clearbut"><p>  <p>
</form>
</div></div>
<?php
$stmt = $pdo->query("SELECT user_id, cabshare_id, cdate, ctime,cabsharefrom, cabshareto, availability FROM cabshare");
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if($row==0){
	echo "No rows found";
	echo "<br><br>";
}
else {
	echo('<table class ="table table-striped table-dark" style="opacity:0.9">');
	echo('<tr><td>Date</td><td>Time</td><td>Cabshare from</td><td>Cabshare to</td><td>Availability</td><td>Action</td></tr>'."\n");
	do{
		if($row['availability']==0) continue;
		echo('<tr class="'.$row['cdate'].' trows"><td>');
		echo(htmlentities($row['cdate']));
		echo "</td><td>";
		echo(htmlentities($row['ctime']));
		echo "</td><td>";
		echo(htmlentities($row['cabsharefrom']));
		echo "</td><td>";
		echo(htmlentities($row['cabshareto']));
		echo "</td><td>";
		echo(htmlentities($row['availability']));
		echo "</td><td>";
		echo('<a href="book.php?cabshare_id='.$row['cabshare_id'].'">Book</a>');
		if($_SESSION['user_id']==$row['user_id'])
		{
			echo('<a href="delete.php?cabshare_id='.$row['cabshare_id'].'">/ Delete</a>');
		}
		echo('</td></tr>'."\n");
	}while($row = $stmt->fetch(PDO::FETCH_ASSOC));
}
?>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		$("#editorbut").click(function(){
		$(".trows").hide();
		var data = $('#filterspecs').serializeArray().reduce(function(obj, item) {
    	obj[item.name] = item.value;
    	return obj;
		}, {});
		cadate = data['cfdate'];
		$("."+cadate).show();
		});
		$("#clearbut").click(function(){
			$(".trows").show();
			$("#reqdate").val(null);
		})
	});
</script>
</body>
</html>
