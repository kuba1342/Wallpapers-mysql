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
	
	if(isset($_POST['register_btn'])) {
		if(!isset($_SESSION)) {	
			session_start();
		}
		$username = $mysqli->real_escape_string($_POST['username']);
		$password = $mysqli->real_escape_string($_POST['password']);
		$password2 = $mysqli->real_escape_string($_POST['password2']);
		
		if ($password == $password2) {
			// create user
			$password = md5($password); // hash password before storing for security purposes
			$sql = "INSERT INTO uzytkownicy(login, haslo) VALUES('$username', '$password')";
			mysqli_query($mysqli, $sql);
			$_SESSION['message'] = "You are now logged in";
			$_SESSION['username'] = $username;
			header("location: index.php");	// redirect to home page
		} else {
			// failed
			$_SESSION['message'] = "The two passwords do not match";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<body>
	<div class="header">
		<h1>Register</h1>
	</div>
	<?php
		if (isset($_SESSION['message'])) {
			echo "<div id='error_msg'>".$_SESSION['message']."</div>";
			unset($_SESSION['message']);
		}
	?>
	<form method="post" action="register.php">
		<table>
			<tr>
				<td>Username: </td>
				<td><input type="text" name="username" class="textInput"></td>
			</tr>
			<tr>
				<td>Password: </td>
				<td><input type="password" name="password" class="textInput"></td>
			</tr>
			<tr>
				<td>Password again: </td>
				<td><input type="password" name="password2" class="textInput"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="register_btn" value="Register"></td>
			</tr>
		</table>
	</form>
</body>
</html>
