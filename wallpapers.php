<!DOCTYPE html>

<html>
<head>

</head>
<body>
	
<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysqli = new mysqli('localhost', 'kuba1342', 'rog6Eizae6aa', 'kuba1342_model');

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else {
    echo "Connected" . "\n";
}

if(isset($_POST['removeWallpaper'])) {
	if(!isset($_SESSION)) {
		session_start();
	}
}

?>

<div class = "header">
	<div>
		<h4>
			Welcome <?php 
						if (!(isset($_SESSION['username']) && $_SESSION['username'] != '')) {
			
						} else {
							echo $_SESSION['username'];;
						}
					?>
		</h4>
			<?php
				if (!(isset($_SESSION['username']) && $_SESSION['username'] != '')) {
			
				} else {
					echo "<div>";
					echo "<a href = 'logout.php'>Logout</a>";
					echo "</div>";
				}
			?>
	</div>
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
		<li>
			<?php
				if (!(isset($_SESSION['username']) && $_SESSION['username'] != '')) {
					echo "Please log in to upload files";
				} else {
					echo "<a href = 'upload_image.php'>";
					echo "Upload";
					echo "</a>";	
				}
			?>
		</li>
	</ul>
</div>
<div class = "wall">
	
	<?php
		$res = $mysqli->query("select * from tapety;");
		echo "<table>";
		while ($row = $res->fetch_array()) {
			echo "<tr><td><img src = \"";
			echo $row["obraz"];
			echo "\" height=\"600\" width=\"1024\">\n</td><td>";
			echo $row["szerokosc"];
			echo "x";
			echo $row["wysokosc"];
			echo "<form method='post' action='wallpapers.php' enctype='multipart/form-data'>";
			echo "<input type='hidden' name='size' value='1000000'>";
			echo "<div>";
			echo "<input type='submit' name='removeWallpaper' value='".$row['idt']."'>";
			echo "</div>";
			echo "</form>";
			echo "</td></tr>";
		}
		echo "</table>";
		
		if(isset($_POST['removeWallpaper'])) {
			if(!isset($_SESSION)) {
				session_start();
			}
			$WallID = $_POST['removeWallpaper'];
			$sqlDelete = "DELETE from tapety where idt='$WallID'"; 
			mysqli_query($mysqli, $sqlDelete);
		}
		
	?>
	<table>
		<tr>
			<td>
				<!--- <img src = "./grafika/test.jpg"> -->
			</td>
		</tr>
	</table>
</div>

</body>
</html>
