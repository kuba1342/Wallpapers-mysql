<?php
	session_start();
	
	//connect to database
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$mysqli = new mysqli('localhost', 'kuba1342', 'rog6Eizae6aa', 'kuba1342_model');

	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	} else {
		echo "Connected" . "\n";
	}
	
	if(isset($_POST['passwordChanged'])) {
		if(!isset($_SESSION)) {	
			session_start();
		}
		$newPassword = $mysqli->real_escape_string($_POST['changePassword']);
		
		$newPassword = md5($newPassword); // hash
		
		$sqlUpdate = "UPDATE uzytkownicy SET haslo='$newPassword' where login='".$_SESSION['username']."'";
		mysqli_query($mysqli, $sqlUpdate);
	}
	
	if(isset($_POST['removeUser'])) {
		if(!isset($_SESSION)) {
			session_start();
		}
		$sqlDelete = "DELETE from uzytkownicy where login='".$_SESSION['username']."'"; 
		mysqli_query($mysqli, $sqlDelete);
		session_start();
		session_destroy();
		unset($_SESSION['username']);
		$_SESSION['message'] = "You are now logged out";
		header("location: login.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>
		User details
	</title>
</head>
<body>
	<div id="content">
		<form method="post" action="user_details.php" enctype="multipart/form-data">
			<input type="hidden" name="size" value="1000000">
			<table>
			<tr>
				<td>Change password</td>
				<td><input type="text" name="changePassword" class="textInput"></td>
			</tr>
			</table>
			<div>
				<input type="submit" name="passwordChanged" value="Zmien haslo">
			</div>
			<div>
				<input type="submit" name="removeUser" value="Usun konto">
			</div>
		</form>
	</div>
</body>
</html>
