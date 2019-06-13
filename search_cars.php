<!DOCTYPE html>
<html>
<head>
	<title>
		Wyszukiwarka
	</title>
</head>
<body>
	<div id="content">
		<form method="post" action="search_cars.php" enctype="multipart/form-data">
			<input type="hidden" name="size" value="1000000">
			<table>
			<tr>
				<td>Marka: </td>
				<td><input type="text" name="brand" class="textInput"></td>
			</tr>
			<tr>
				<td>Model: </td>
				<td><input type="text" name="model" class="textInput"></td>
			</tr>
			<tr>
				<td>Rocznik: </td>
				<td><input type="text" name="year" class="textInput"></td>
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
	
	if(isset($_POST['search'])) {
		
		// car details
		$brand = $mysqli->real_escape_string($_POST['brand']);
		$model = $mysqli->real_escape_string($_POST['model']);
		$year = $mysqli->real_escape_string($_POST['year']);
		
		// get car's ID
		$sqlCarID = "SELECT ids FROM samochody where model = '".$model."' AND rocznik = '".$year."'";
		$resultCarID = mysqli_query($mysqli, $sqlCarID);
		$rowCarID = $resultCarID->fetch_row();
			
		$sqlSearch = "SELECT * from tapety left join detal_tapeta on idt=t_id where s_id='".$rowCarID[0]."';";
		echo $sqlSearch;
		$res = $mysqli->query($sqlSearch);	
		
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
	}
?>

</body>
</html>