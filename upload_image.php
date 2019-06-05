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
		
		// get submitted data from the form
		list($width, $height, $type, $attr) = getimagesize($_FILES['image']['tmp_name']);
		$display = 0;
		$image = "./grafika/".$_FILES['image']['name'];
		$sql = "INSERT INTO tapety (obraz, wysokosc, szerokosc, wyswietlenia) VALUES ('$image', '$height', '$width', '$display')";
		mysqli_query($mysqli, $sql); // stores submitted data into table: tapety
		
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
			<div>
				<!--<textarea name="text"></textarea>-->
			</div>
			<div>
				<input type="submit" name="upload" value="Upload Image">
			</div>
		</form>
	</div>
</body>
</html>