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
				include 'blognav2.php';
			?>
		<div class="blog-about-wrapper">
			<div class="blog-about-title">
				<h1>About The Blog</h1>
			</div>
			<div class="blog-about-content">
				<p>Since the entire purpose of my portfolio is to show you who I am, there is no better option for you to get complete insight into who I am than a blog I keep consistently up to date, with content that aims to inspire you with my thoughts about the design world. My goal with every post is to ensure you get an insight into the way I think, the way I work, and the way I live, while also being a great place for me to practice discussing my opinions, thoughts, and theories about the world of design, all the while developing my view on the industry.</p>

				<h2>Content</h2>
				<p>The content I post will be relevant in all aspects of design that I am involved with. Currently I am building my skillset within digital advertising, so I will share my general experience on the process without discussing my work or job directly. The blog will also share general tips and tricks I have picked up on over the years, as well as insights into innovations, best practices, and of course, case studies of past work that I have been able to do.</p>

				<h2>Share Your Thoughts</h2>
				<p>I am in this industry to learn and develop new skills every step of the way. I post based on my thoughts and experience, but I cannot experience everything in this world. I would love nothing more than hearing about your thoughts. If you, the reader, has a different experience with regards to what I discuss, do not hesitate to share your opinions on a matter in the comments, or get in touch directly in the Contact section.</p>
			</div>
		</div>
		<?php
			include 'blogfooter.php';
		?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	</body>
</html>