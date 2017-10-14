<?php
	include 'server/db.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Blog | Hayo Friese</title>

		<link href="resources/blog.css" rel="stylesheet" type="text/css">
		<link href="resources/font.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php
			include 'blognav.php';
		?>
		<div class="wrapper">
<?php
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$sql = "SELECT idblog_posts, postCover, postTitle, postDesc, blog_category, post, postDate, admin_name FROM portfolio.blog_posts 
		INNER JOIN portfolio.blog_category ON portfolio.blog_category.idblog_category = portfolio.blog_posts.postCategory 
		INNER JOIN portfolio.admin_user ON portfolio.admin_user.idadmin_user = portfolio.blog_posts.postAuthor 
		WHERE idblog_posts = '$id'";
		$rPost = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		$rNum = mysqli_num_rows($rPost);
		if($rNum == 0){
			echo "Post Does Not Exist";
		} else {
			$row = mysqli_fetch_assoc($rPost) or die(mysqli_error($conn));
			$postid = $row['idblog_posts'];
			$cover = $row['postCover'];
			$title = $row['postTitle'];
			$desc = $row['postDesc'];
			$cat = $row['blog_category'];
			$content = $row['post'];
			$date = $row['postDate'];
			$author = $row['admin_name'];
		
			echo "
			<section class=\"blog-post-cover\" id=\"blogCover\" style=\"background-image:url('$cover');\">
				<article>
						<a>
							<div>
								<h3>$cat</h3>
								<div id=\"blogLine\"></div>
								<h1>$title</h1>
							</div>
						</a>
				</article>
			</section>
			<section id=\"blog-content\">
				<article>
					<div id=\"post-author\">
						<img src=\"img/birthday.jpg\">
						<p>by <span>$author</span></p>
					</div>
					<div class=\"post-content\">
						$content
					</div>
				</article>
			</section>";
		}

	} else {
		echo "No Post Selected";
	}
?>
		</div>
		<?php
			include 'blogfooter.php';
		?>
		<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>-->
	</body>
</html>		