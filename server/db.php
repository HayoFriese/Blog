<?php
	$conn = mysqli_connect('localhost', 'root', '', '');

	if (mysqli_connect_errno()){
		echo "<p>Connection Failed:".mysqli_connect_error()."</p>\n";
	}
	//set UTF8 for php material
	mysqli_set_charset($conn, "utf8");
	//Date Time Zone Set
	//date_default_timezone_set('Europe/London');
?>
