<?php
	session_start();
	
	if(isset($_SESSION['admin_username']) && $_SESSION['admin_username'] == true){
		//unset session values 
		$_SESSION = [];
		session_destroy();
		echo "You have successfully signed out.";
		header("location: adminLogin.php");
	}
?>