<?php 
$server = "localhost";
$user="root";
$password="";
$db="cabify";
$con=new mysqli($server,$user,$password,$db);

if($con)
{
		echo '<p style="color: green; text-align: center"> Connection Successful </p>';
}
else
{
	?>
	<script>
		alert("No Connection");
	</script>
	<?php
}
 ?>