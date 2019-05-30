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
	
	if(isset($_POST['login_btn'])) {
		if(!isset($_SESSION)) {	
			session_start();
		}
		$username = $mysqli->real_escape_string($_POST['username']);
		$password = $mysqli->real_escape_string($_POST['password']);
		
		$password = md5($password); // hash
		$sql = "SELECT * FROM uzytkownicy where login='$username' and haslo='$password'";
		$result = mysqli_query($mysqli, $sql);
		
		if (mysqli_num_rows($result) == 1) {
			$_SESSION['message'] = "You are now logged in";
			$_SESSION['username'] = $username;
			header("location: index.php"); // redirect to home page
		} else {
			$_SESSION['message'] = "Username/password combination incorrect";
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
		<h1>Login</h1>
	</div>
	<?php
		if (isset($_SESSION['message'])) {
			echo "<div id='error_msg'>".$_SESSION['message']."</div>";
			unset($_SESSION['message']);
		}
	?>
	<form method="post" action="login.php">
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
				<td></td>
				<td><input type="submit" name="login_btn" value="Login"></td>
			</tr>
		</table>
	</form>
</body>
</html>
