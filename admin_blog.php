<?php
	include "server/db.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Blog Admin | Hayo Friese</title>
			
		<link href="resources/blog.css" rel="stylesheet" type="text/css">
		<link href="resources/font.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="admin-bg"></div>
		<section class="admin-left">
			<nav class="admin-nav-left">
				<div class="admin-logo-cont">
					<div>
						<a href="#" id="hafriLogo">hafri.</a>
					</div>
				</div>
				<ul class="admin-nav-ul">
					<li class="admin-nav-block">
						<div>
							<img src="img/icon/admin/ic_av_timer_black_36px.svg">
							<p><a href="admin.php">Dashboard</a><p>
						</div>
					</li>
					<li class="admin-nav-block">
						<div>
							<img src="img/icon/admin/ic_person_black_36px.svg">
							<p><a href="#">About Me</a><p>
						</div>
					</li>
					<li class="admin-nav-block">
						<div>
							<img src="img/icon/admin/ic_work_black_36px.svg">
							<p><a href="#">Work</a><p>
						</div>
					</li>
					<li class="admin-nav-block">
						<div>
							<img src="img/icon/admin/ic_people_black_36px.svg">
							<p><a href="#">Clients</a><p>
						</div>
					</li>
					<li class="admin-nav-block" id="admin-selected">
						<div>
							<img src="img/icon/admin/ic_insert_comment_black_36px.svg">
							<p><a href="#">Blog</a><p>
						</div>
					</li>
					<li class="admin-nav-block">
						<div>
							<img src="img/icon/admin/ic_mail_black_36px.svg">
							<p><a href="#">Contact</a><p>
						</div>
					</li>
					<li class="admin-nav-block">
						<div>
							<img src="img/icon/admin/ic_settings_black_36px.svg">
							<p><a href="#">Settings</a><p>
						</div>
					</li>
				</ul>
				<p class="admin-nav-copyright">&copy; Hayo Friese 2016</p>
			</nav>
		</section>
			
		<section class="admin-right">
			<nav class="admin-nav-top">
				<div class="admin-nav-top-cont">
					<div class="admin-nav-top-left">
						<div class="admin-nav-page-name">
							<h1>Blog</h1>
						</div>
					</div>
					<div class="admin-nav-top-right">
						<div class="admin-nav-images">
							<img src="img/icon/admin/ic_perm_media_black_36px.svg">
						</div>
						<div class="admin-nav-datetime">
							<h2>5:30pm, 20 August 1994</h2>
						</div>
						<div class="admin-nav-search">
							<p><input type="text" name="admin-search" placeholder="Search..."></p>
						</div>
						<div class="admin-nav-logout">
							<p><a href="admin_logout.php">Log Out</a></p>
						</div>
					</div>
				</div>
			</nav>
			<article class="admin-cont">
				<div class="admin-blog-wrapper">
					<div class="admin-blog-data-cont" id="admin-blog-box-one">
						<div class="admin-blog-heading">
							<h3>All Blog Posts</h3>
							<a href="admin_newBlog.php" data-alt="Post">New</a>
						</div>
						<div class="admin-blog-table-heading">
							<table>
								<thead>
									<tr>
										<th>Edit</th>
										<th>Post Title</th>
										<th>Post Date</th>
										<th>Likes</th>
										<th>Shares</th>
										<th>Comments</th>
										<th>Live</th>
										<th>Delete</th>
									</tr>
								</thead>
							</table>
						</div>
						<div class="admin-blog-table-body">
							<table class="admin-blog-post-table">
								<tbody>
									<?php
										$sqlPosts = "SELECT * FROM portfolio.blog_posts ORDER BY idblog_posts DESC";
										$rPosts = mysqli_query($conn, $sqlPosts) or die(mysqli_error($conn));
										while($Posts = mysqli_fetch_assoc($rPosts)){
											$postid = $Posts['idblog_posts'];
											$cover = $Posts['postCover'];
											$title = $Posts['postTitle'];
											$summary = $Posts['postDesc'];
											$cat = $Posts['postCategory'];
											$post = $Posts['post'];
											$date = $Posts['postDate'];
											$live = $Posts['postLive'];

											echo "<tr>
												<td><a href=\"admin_newBlog.php?id=$postid\">Edit</a></td>
												<td class=\"admin-blog-data-title\">$title</td>
												<td>$date</td>
												<td>Likes</td>
												<td>Shares</td>
												<td>Comments</td>
												<td>";
												if($live == 1){
													echo "Yes";
												} else {
													echo "No";
												}
												echo "</td>
												<td><a href=\"#\">Delete</a></td>
											</tr>";
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="admin-blog-data-cont">
						<div class="admin-blog-heading">
							<h3>Subscribers</h3>
						</div>
						<div class="admin-blog-table-heading">
							<table>
								<thead>
									<tr>
										<th>Username</th>
										<th>Email</th>
										<th>Subbed Since</th>
										<th>Occupation</th>
										<th>Company</th>
									</tr>
								</thead>
							</table>
						</div>
						<div class="admin-blog-table-body">
							<table class="admin-blog-post-table">
								<tbody>
									<tr>
										<td>Username</td>
										<td>Post TitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitle</td>
										<td>Subbed Since</td>
										<td>Occupation</td>
										<td>Company</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</article>
		</section>
	</body>
</html>
