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
		<!--Navigation Menu-->
		<?php
			include 'blognav.php';
		?>
		<div class="wrapper">
		<?php
			$sqlPosts = "SELECT * FROM portfolio.blog_posts WHERE postLive = 1 ORDER BY idblog_posts DESC";
			$rPosts = mysqli_query($conn, $sqlPosts) or die(mysqli_error($conn));
			while($row = mysqli_fetch_assoc($rPosts)){
				$id = $row['idblog_posts'];
				$cover = $row['postCover'];
				$title = $row['postTitle'];
				$desc = $row['postDesc'];
				$postCat = $row['postCategory'];
				$content = $row['post'];
				
				$sqlCats = "SELECT * FROM portfolio.blog_category WHERE idblog_category = $postCat";
				$rCats = mysqli_query($conn, $sqlCats) or die(mysqli_error($conn));
				$rowcat = mysqli_fetch_assoc($rCats);
				$category = $rowcat['blog_category'];

				echo "<section id=\"blogCover\" style=\"background-image: url('$cover')\">
					<article>
						<a href=\"post.php?id=$id\">
							<div>
								<h3>$category</h3>
								<div id=\"blogLine\"></div>
								<h1>$title</h1>
								<h2>$desc</h2>
							</div>
						</a>
					</article>
				</section>
				";
			}

		?>
			<div id="blogMore">
				<div>
					<a href="#">Load More</a>
				</div>
			</div>
		</div>
		<?php
			include 'blogfooter.php';
		?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	</body>
</html>
<!--www.dtelepathy.com/blog/-->