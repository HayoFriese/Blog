<?php
	include 'server/db.php';
	$catid = $_GET['id'];

	$sqlCats = "SELECT * FROM portfolio.blog_category WHERE idblog_category = $catid";
	$rCats = mysqli_query($conn, $sqlCats) or die(mysqli_error($conn));
	$rowcat = mysqli_fetch_assoc($rCats);
	$catCover = $rowcat['cat_background'];
	$category = $rowcat['blog_category'];
	$catDesc = $rowcat['cat_desc'];

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
			echo "<div class=\"search-wrapper\" style=\"background-image:url('$catCover');\">
				<div class=\"shade\">";
					include 'blognav.php';

					echo "<section class=\"cat-description\">
						<article>
							<h1>$category</h1>
							<div class=\"cat-line\"></div>
							<h3>$catDesc</h3>
						</article>
					</section>
	
					<section class=\"cat-posts\">";
						$sqlPosts = "SELECT * FROM portfolio.blog_posts WHERE postLive = 1 AND postCategory = $catid ORDER BY idblog_posts DESC";
						$rPosts = mysqli_query($conn, $sqlPosts) or die(mysqli_error($conn));
						while($row = mysqli_fetch_assoc($rPosts)){
							$id = $row['idblog_posts'];
							$cover = $row['postCover'];
							$title = $row['postTitle'];
							$desc = $row['postDesc'];
							$postCat = $row['postCategory'];
							$content = $row['post'];
	
							$sqlCat = "SELECT * FROM portfolio.blog_category WHERE idblog_category = $postCat";
							$rCat = mysqli_query($conn, $sqlCat) or die(mysqli_error($conn));
							$rowcat = mysqli_fetch_assoc($rCat);
							$catPost = $rowcat['blog_category'];
	
							echo "<article style=\"background-image:url('$cover')\">
								<div>
									<a href=\"post.php?id=$id\">
										<div>
											<h3>$catPost</h3>
											<div id=\"blogLine\"></div>
											<h1>$title</h1>
											<h2>$desc</h2>
										</div>
									</a>
								</div>
							</article>";						
						}
					echo "</section>
				</div>
			</div>";
		?>
	</body>
</html>