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
	
	if(isset($_POST['upload'])) {
		// path to store uploaded image
		$target = "grafika/".basename($_FILES['image']['name']);
		
		$msg = "";
		
		// car details
		//$brand = $mysqli->real_escape_string($_POST['brand']);
		//$model = $mysqli->real_escape_string($_POST['model']);
		//$year = $mysqli->real_escape_string($_POST['year']);
		
		// get submitted data from the form
		list($width, $height, $type, $attr) = getimagesize($_FILES['image']['tmp_name']);
		$display = 0;
		$image = "./grafika/".$_FILES['image']['name'];
		$sqlUserID = "SELECT idu FROM uzytkownicy where login='" . $_SESSION['username'] . "'";
		$result = mysqli_query($mysqli, $sqlUserID);
		// spr czy wynik jest niepusty
		$row = $result->fetch_row();
		$userID = $row[0]; // to jest nasz int
		$sql = "INSERT INTO tapety (obraz, wysokosc, szerokosc, wyswietlenia, u_id) VALUES ('$image', '$height', '$width', '$display', '$userID')";
		mysqli_query($mysqli, $sql); // stores submitted data into table: tapety
		
		// get wallpaper's ID
		$sqlWallID = "SELECT idt from tapety where obraz = '".$target."'";
		$resultWallID = mysqli_query($mysqli, $sqlWallID);
		$rowWallID = $resultWallID->fetch_row();
		
		// if car doesnt exist add it to table: samochody
		//$sqlModel = "SELECT model FROM samochody WHERE model = '".$model."' AND rocznik = '".$year."'";
		//$modelResult = mysqli_query($mysqli, $sqlModel);
		//$row2 = $modelResult->fetch_row();
		//if ($row2[0] == '') {
			//echo "<a> Nie ma! </a>";
			//$sqlInsertCar = "INSERT INTO samochody (model, marka, rocznik) VALUES ('$model', '$brand', '$year')";
			//mysqli_query($mysqli, $sqlInsertCar); // stores submitted car data into table: samochody
		//}
		
		// get car's ID
		//$sqlCarID = "SELECT ids FROM samochody where model = '".$model."' AND rocznik = '".$year."'";
		//$resultCarID = mysqli_query($mysqli, $sqlCarID);
		//$rowCarID = $resultCarID->fetch_row();
			
		// put details into table: detal_tapeta
		//$sqlDetails = "INSERT INTO detal_tapeta (t_id, s_id) VALUES ('$rowWallID[0]', '$rowCarID[0]')";
		//echo "$sqlDetails";
		//mysqli_query($mysqli, $sqlDetails);
		
		// move uploaded image into folder: grafika
		if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
			$msg = "Image uploaded successfully";
			chmod($target, 0755);
		} else {
			$msg = "There was a problem uploading image";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>
		Image Upload
	</title>
</head>
<body>
	<div id="content">
		<form method="post" action="upload_image.php" enctype="multipart/form-data">
			<input type="hidden" name="size" value="1000000">
			<div>
				<input type="file" name="image">
			</div>
			<!--<table>
			<tr>
				<td>Brand: </td>
				<td><input type="text" name="brand" class="textInput"></td>
			</tr>
			<tr>
				<td>Model: </td>
				<td><input type="text" name="model" class="textInput"></td>
			</tr>
			<tr>
				<td>Production Year: </td>
				<td><input type="text" name="year" class="textInput"></td>
			</tr>
		</table>-->
			<div>
				<input type="submit" name="upload" value="Upload Image">
			</div>
		</form>
	</div>
</body>
</html>
