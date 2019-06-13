<!DOCTYPE html>
<html>
<head>
	<title>
		Subskrybenci
	</title>
</head>
<body>
<?php
	session_start();
	
	// connect to database
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$mysqli = new mysqli('localhost', 'kuba1342', 'rog6Eizae6aa', 'kuba1342_model');

	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	} else {
		echo "Connected" . "\n";
	}
		
	$sqlLoggedID = "SELECT idu FROM uzytkownicy where login = '".$_SESSION['username']."'";
	$resultLoggedID = mysqli_query($mysqli, $sqlLoggedID);
	$rowLoggedID = $resultLoggedID->fetch_row();

	echo $rowLoggedID[0];
	
	$res = $mysqli->query("SELECT * from uzytkownicy left join subskrybenci on idu=subskrybent_id where u_id='".$rowLoggedID[0]."'");
	echo "<table>";
	while ($row = $res->fetch_array()) {
		echo "<tr><td>";
		echo $row["login"];
		echo "<form method='post' action='subskrybenci.php' enctype='multipart/form-data'>";
		echo "<input type='hidden' name='size' value='1000000'>";
		echo "<div>";
		echo "<input type='submit' name='removeSub' id='".$row['ids']."' value='Delete'>";
		echo "<input type='hidden' name='test' id='".$row['ids']."' value='".$row['ids']."'>";
		echo "</div>";
		echo "</form>";
		echo "</td><tr>";
	}
	echo "</table>";
	
	if(isset($_POST['removeSub'])) {
		if(!isset($_SESSION)) {
			session_start();
		}
		$SubID = $_POST['test'];
		$sqlDelete = "DELETE from subskrybenci where ids='$SubID'"; 
		mysqli_query($mysqli, $sqlDelete);
		header("location: subskrybenci.php");
	}
	
?>

</body>
</html>