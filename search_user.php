<!DOCTYPE html>
<html>
<head>
	<title>
		Wyszukiwarka
	</title>
</head>
<body>
	<div id="content">
		<form method="post" action="search_user.php" enctype="multipart/form-data">
			<input type="hidden" name="size" value="1000000">
			<table>
			<tr>
				<td>Nick: </td>
				<td><input type="text" name="nick" class="textInput"></td>
			</tr>
			</table>
			<div>
				<input type="submit" name="search" value="Szukaj">
			</div>
		</form>
	</div>	
	
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
	
	$_SESSION["test"] = "";
	
	if(isset($_POST['search'])) {
		
		// car details
		$nick = $mysqli->real_escape_string($_POST['nick']);
			
		$sqlSearch = "SELECT * FROM uzytkownicy where login='".$nick."'";
		echo $sqlSearch;
		$res = $mysqli->query($sqlSearch);	
		
		echo "<table>";
		while ($row = $res->fetch_array()) {
			echo "<tr><td>";
			echo $row["login"];
			echo "</td></tr>";
			echo "<form method='post' action='search_user.php' enctype='multipart/form-data'>";
			echo "<tr><td>";
			//echo "<input type='submit' name='subscribe' id='".$row['idu']."' value='Subskrybuj'>";
			echo "<input type='hidden' name='test' id='".$row['idu']."' value='".$row['idu']."'>";
			echo "</td></tr>";
			echo "</form>";
		}
		echo "</table>";
		
		$sqlLoggedID = "SELECT idu FROM uzytkownicy where login = '".$_SESSION['username']."'";
		$resultLoggedID = mysqli_query($mysqli, $sqlLoggedID);
		$rowLoggedID = $resultLoggedID->fetch_row();
		$sqlSubID = "SELECT idu FROM uzytkownicy where login = '".$nick."'";
		$resultSubID = mysqli_query($mysqli, $sqlSubID);
		$rowSubID = $resultSubID->fetch_row();
		
		//$userID = $_POST['test'];
		
		$sqlSubscribe = "INSERT INTO subskrybenci (u_id, subskrybent_id) VALUES ('$rowLoggedID[0]', '$rowSubID[0]')"; 
		mysqli_query($mysqli, $sqlSubscribe);
		
		
		if(isset($_POST['subscribe'])) {
			if(!isset($_SESSION)) {
				session_start();
			}
			$sqlLoggedID = "SELECT idu FROM uzytkownicy where login = '".$_SESSION['username']."'";
			$resultLoggedID = mysqli_query($mysqli, $sqlLoggedID);
			$rowLoggedID = $resultLoggedID->fetch_row();
			echo $rowLoggedID[0];
			$sqlSubID = "SELECT idu FROM uzytkownicy where login = '".$nick."'";
			$resultSubID = mysqli_query($mysqli, $sqlSubID);
			$rowSubID = $resultSubID->fetch_row();
			echo $rowSubID[0];
			$sqlSubscribe = "INSERT INTO subskrybenci (u_id, subskrybent_id) VALUES ('$rowLoggedID[0]', '$rowSubID[0]')"; 
			mysqli_query($mysqli, $sqlSubscribe);
			header("location: search_user.php");
		}
	}
?>

</body>
</html>