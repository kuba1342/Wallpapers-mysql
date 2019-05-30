<?php
	session_start();
?>

<!DOCTYPE html>

<html>
<head>

</head>
<body>
<div class = "header">
	<div>
		<h4>
			Welcome <?php echo $_SESSION['username']; ?>
		</h4>
	</div>
	<?php
		if (isset($_SESSION['message'])) {
			echo "<div id='error_msg'>".$_SESSION['message']."</div>";
			unset($_SESSION['message']);
		}
		
		if (session_status() === PHP_SESSION_NONE) {
			echo "<div>";
			echo "<a href = 'logout.php'>Logout</a>";
			echo "</div>";
		} 
	?>
	
	<!--<div>
		<a href = "logout.php">Logout</a>
	</div>-->
	
	<ul>
		<li>
			<a href = "index.php">
				Main Page
			</a>
		</li>
		<li>
			<a href = "login.php">
				Login
			</a>
		</li>
		<li>
			<a href = "register.php">
				Registration
			</a>
		</li>
		<li>
			<a href = "wallpapers.php">
				Wallpapers
			</a>
		</li>
	</ul>
</div>
</body>
</html>