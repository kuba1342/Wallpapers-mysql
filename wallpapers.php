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
			echo "<input type='submit' name='removeWallpaper' id='".$row['idt']."' value='Delete'>";
			echo "<input type='hidden' name='test' id='".$row['idt']."' value='".$row['idt']."'>";
			echo "</div>";
			echo "</td></tr>";
			
			// Add car details
			echo "<table>";
				echo "<tr>";
					echo "<td> Brand: </td>";
					echo "<td><input type='text' name='brand' class='textInput'></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td> Model: </td>";
					echo "<td><input type='text' name='model' class='textInput'></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td> Year: </td>";
					echo "<td><input type='text' name='year' class='textInput'></td>";
				echo "</tr>";
				echo "<div>";
				echo "<input type='submit' name='upload' value='Upload'>";
				echo "</div>";
			echo "</table>";
			echo "</form>";
		}
		echo "</table>";
		
		if(isset($_POST['removeWallpaper'])) {
			if(!isset($_SESSION)) {
				session_start();
			}
			$WallID = $_POST['test'];
			$sqlDelete = "DELETE from tapety where idt='$WallID'"; 
			mysqli_query($mysqli, $sqlDelete);
			header("location: wallpapers.php");
		}
		
		// Adding car details
		if(isset($_POST['upload'])) {
			if(!isset($_SESSION)) {
				session_start();
			}
			$WallID = $_POST['test'];
		
			// car details
			$brand = $mysqli->real_escape_string($_POST['brand']);
			$model = $mysqli->real_escape_string($_POST['model']);
			$year = $mysqli->real_escape_string($_POST['year']);
		
			// if car doesnt exist add it to table: samochody
			$sqlModel = "SELECT model FROM samochody WHERE model = '".$model."' AND rocznik = '".$year."'";
			$modelResult = mysqli_query($mysqli, $sqlModel);
			$row2 = $modelResult->fetch_row();
			if ($row2[0] == '') {
				echo "<a> Nie ma! </a>";
				$sqlInsertCar = "INSERT INTO samochody (model, marka, rocznik) VALUES ('$model', '$brand', '$year')";
				mysqli_query($mysqli, $sqlInsertCar); // stores submitted car data into table: samochody
			}
			
			// get car's ID
			$sqlCarID = "SELECT ids FROM samochody where model = '".$model."' AND rocznik = '".$year."'";
			$resultCarID = mysqli_query($mysqli, $sqlCarID);
			$rowCarID = $resultCarID->fetch_row();
			
			// put details into table: detal_tapeta
			$sqlDetails = "INSERT INTO detal_tapeta (t_id, s_id) VALUES ('$WallID', '$rowCarID[0]')";
			echo "$sqlDetails";
			mysqli_query($mysqli, $sqlDetails);
			
			header("location: wallpapers.php");
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

<script>
	function high(id) {
		<?php
			$test = id;
			echo $test;
		?>
	}
</script>

</body>
</html>
