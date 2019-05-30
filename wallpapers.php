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
?>

<div class = "header">
	<div>
		<h4>
			Welcome <?php echo $_SESSION['username']; ?>
		</h4>
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
			<a href = "wallpapers.php">
				Wallpapers
			</a>
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
			echo "</td></tr>";
		}
		echo "</table>";
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
