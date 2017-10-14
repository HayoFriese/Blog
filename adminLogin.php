<?php
	include "server/db.php";
	session_start();

	if(isset($_SESSION['admin_username']) && $_SESSION['admin_username'] == true){
		header('location: admin.php');
	} else {
		if($_SERVER['REQUEST_METHOD'] != 'POST'){
			echo "
				<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" 
				    \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
				<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
					<head>
						<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
						<title>Log In | Hayo Friese</title>
			
						<link href=\"resources/blog.css\" rel=\"stylesheet\" type=\"text/css\">
						<link href=\"resources/font.css\" rel=\"stylesheet\" type=\"text/css\">
					</head>
					<body>
						<div class=\"admin-logon-bg\"></div>
						<div class=\"admin-logon-bg-darken\"></div>
						<div class=\"wrapper\">
							<nav id=\"admin-logon-nav\">
								<p><a href=\"#\" id=\"hafriLogo\">hafri.</a></p>
							</nav>
							<div id=\"admin-logon-cont\">
								<form method=\"post\" action=\"adminLogin.php\">
									<h1>Admin Account</h1>
									<input type=\"text\" name=\"username\" placeholder=\"username\">
									<input type=\"password\" name=\"password\" placeholder=\"password\">
									<div>
										<input type=\"submit\" name=\"logon\" value=\"Sign In\">
									</div>
								</form>
							</div>
						</div>
				
						<footer id=\"admin-footer\">
							<section id=\"blogFooter\">
								<article id=\"blogHyperlinks\">
									<div>
										<ul>
											<li><a class=\"admin-blogHyperlinks\" href=\"#\">Home</a></li>
											<li><a class=\"admin-blogHyperlinks\" href=\"#\">Work</a></li>
											<li><a class=\"admin-blogHyperlinks\" href=\"#\">About</a></li>
											<li><a class=\"admin-blogHyperlinks\" href=\"index.html\">Blog</a></li>
											<li><a class=\"admin-blogHyperlinks\" href=\"#\">Contact</a></li>
										</ul>
									</div>
								</article>
								<article id=\"blogCopyright\">
									<p>&copy; 2016 Hayo Friese - All Rights Reserved.</p>
								</article>
							</section>
						</footer>
					</body>
				</html>
			";
		} else {
			$errors = [];

			if(!isset($_POST['username'])){
				$errors[] = 'The username field must not be empty';
			}
			if(!isset($_POST['password'])){
				$errors[] = 'The password field must not be empty';
			}

			if(!empty($errors)){
				echo '<ul>';
				foreach($errors as $key => $value){
					echo '<li>' . $value . '</li>';
				}
				echo '</ul>';
			} 
			else{
				$uname = mysqli_real_escape_string($conn, $_POST['username']);
				$pass = sha1(mysqli_real_escape_string($conn, $_POST['password']));

				$sql = "SELECT idadmin_user, admin_username FROM portfolio.admin_user
						WHERE admin_username = '$uname'
						AND admin_password = '$pass'";

				$r = mysqli_query($conn, $sql) or die(mysqli_error($conn));

				if(mysqli_num_rows($r) == 0){
					header('location: adminLogin.php');
				} else {
					while($row = mysqli_fetch_assoc($r)){
						$_SESSION['idadmin_user'] = $row['idadmin_user'];
						$_SESSION['admin_username'] = $row['admin_username'];

						header('location: admin.php');
					}
				}
			}


		}

	}
	mysqli_close($conn);
?>