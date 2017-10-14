<?php
	include "server/db.php";

	if($_SERVER['REQUEST_METHOD'] != 'POST'){
		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" 
				    \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
				<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
					<head>
						<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
						<title>New Admin Account | Hayo Friese</title>
			
						<link href=\"resources/blog.css\" rel=\"stylesheet\" type=\"text/css\">
						<link href=\"resources/font.css\" rel=\"stylesheet\" type=\"text/css\">
					</head>
					<body>
						<form action=\"newAdmin.php\" method=\"post\">
							<h1>New Admin</h1>
							<input type=\"text\" name=\"username\" placeholder=\"Username\">
							<input type=\"password\" name=\"password\" placeholder=\"New Password\">
							<input type=\"password\" name=\"conpassword\" placeholder=\"Confirm Password\">
							<div>
								<input type=\"submit\" name=\"logon\" value=\"Sign In\">
							</div>
						</form>
					</body>
				</html>";
	} else {
        $username = mysqli_real_escape_string($conn, isset($_POST['username'])) ? $_POST['username']: null;
        $password = mysqli_real_escape_string($conn, isset($_POST['password'])) ? $_POST['password']: null;
        $conpass = mysqli_real_escape_string($conn, isset($_POST['conpassword'])) ? $_POST['conpassword']: null;

        $username = trim($username);
        $password = trim($password);
        $conpass = trim($conpass);

        $username = filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $password = filter_var($password, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $conpass = filter_var($conpass, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

        if($password != $conpass){
            echo 'Your Passwords did not match. Please try again. ';
            echo '<a href="newAdmin.php">Back...</a>';
        } else {
            $hashpassword = sha1($password);

            $sql = "INSERT INTO portfolio.admin_user(admin_username, admin_password) VALUES(?, ?)";
    
            $stmt = mysqli_prepare($conn, $sql);
    
            mysqli_stmt_bind_param($stmt, "ss", $username, $hashpassword);
		  	mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
    
            mysqli_close($conn);

            echo "Registration successful. <a href=\"adminLogin.php\">Log In...</a>";
        }
	}
?>