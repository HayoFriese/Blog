<?php
	include 'server/db.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Blog Admin | Hayo Friese</title>
			
		<link href="resources/blog.css" rel="stylesheet" type="text/css">
		<link href="resources/font.css" rel="stylesheet" type="text/css">
		<link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="resources/fonts/font-awesome-4.6.3/css/font-awesome.min.css">
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
				<div class="admin-newb-progress-cont">
					<div class="admin-newb-progress-status">
						<button>&#9776;</button>
						<h1 id="admin-blog-step"></h1>
						<a id="admin-newb-next" href="#" onclick="blog_nextStep();">Next &raquo;</a>
					</div>
					<div class="admin-newb-progress-bar" id="blog-progress"></div>
				</div>
				<div class="admin-newb-step-cont">
					<form action="blog_process.php" method="post" id="new-blog-post" enctype="multipart/form-data">
					<?php
						$sqlCats = "SELECT * FROM portfolio.blog_category";
						$rCats = mysqli_query($conn, $sqlCats) or die(mysqli_error($conn));
						$catnum = mysqli_num_rows($rCats);

						// SELECT SESSION ID AKA ADMIN ID.

						if(isset($_GET['id'])){
							$getid = $_GET['id'];

							$sqlPosts = "SELECT * FROM portfolio.blog_posts WHERE idblog_posts = $getid";
							$rPosts = mysqli_query($conn, $sqlPosts) or die(mysqli_error($conn));
							$rowPost = mysqli_fetch_assoc($rPosts);

							$id = $rowPost['idblog_posts'];
							$cover = $rowPost['postCover'];
							$title = $rowPost['postTitle'];
							$desc = $rowPost['postDesc'];
							$postCat = $rowPost['postCategory'];
							$content = $rowPost['post'];
							$live = $rowPost['postLive'];
							if($live != 0){
								$date = $rowPost['postDate'];
							}

							//postauthor hidden input NEEDS TO BE = SESSION ID FROM LOGGED IN ADMIN USER

							echo "<input type=\"hidden\" name=\"postid\" id=\"postid\" value=\"$id\">
								<input type=\"hidden\" name=\"postauthor\" id=\"postauthor\" value=\"1\">
								<div class=\"admin-newb-step-one\" id=\"blog-step-one\">
								<div class=\"admin-newb-cover\" style=\"background: #FFFFFF url('$cover') no-repeat; background-size: cover; background-position:center center\">
									<article>
										<div>
											<div>";
												if($catnum == 0){
													echo "<select id=\"blog-post-cat\">
														<option>-- No Categories Available</option>
													</select>";
												} else {
													/*eDIT THIS*/
													echo "<select id=\"blog-post-cat\" name=\"category\">";
														while($rowCats = mysqli_fetch_assoc($rCats)){
															$idcat=$rowCats['idblog_category'];
															$category = $rowCats['blog_category'];
															
															if($idcat == $postCat){
																echo "<option value=\"$idcat\" selected>$category</option>\n";
															} else{
																echo "<option value=\"$idcat\">$category</option>\n";
															}
														}
													echo "</select>";
												}
											echo "
												<input type=\"text\" id=\"blog-post-title\" placeholder=\"Title\" name=\"post-title\" value=\"$title\">
												<textarea id=\"blog-post-desc\" placeholder=\"Post Summary\" name=\"post-description\">$desc</textarea>
											</div>
										</div>
									</article>
									<input type=\"file\" id=\"blog-post-cover\" name=\"post-cover\">
								</div>
							</div>
							<div class=\"admin-newb-step-two\" id=\"blog-step-two\">
							<div class=\"blog-editor-bar\">
								<a href=\"#\" data-command='save' id='save'><i class='fa fa-save'></i></a>
								<a href=\"#\" data-command=\"undo\"><i class=\"fa fa-undo\"></i></a>
								<a href=\"#\" data-command=\"redo\"><i class=\"fa fa-repeat\"></i></a>
				
								<div class=\"fore-wrapper\"><i class='fa fa-font'></i>
							    	<div class=\"fore-palette\">
							   		</div>
							  	</div>
							  	<div class=\"font-wrapper\"><i class='fa fa-text-height'></i>
							  		<ul>
							  			<li><a href=\"#\" data-command=\"fontSize\" data-value=\"1\"><font size=\"1\">X-Small</font></a></li>
							  			<li><a href=\"#\" data-command=\"fontSize\" data-value=\"2\"><font size=\"1\">Small</font></a></li>
							  			<li><a href=\"#\" data-command=\"fontSize\" data-value=\"3\"><font size=\"3\">Normal</font></a></li>
							  			<li><a href=\"#\" data-command=\"fontSize\" data-value=\"4\"><font size=\"4\">Large</font></a></li>
							  			<li><a href=\"#\" data-command=\"fontSize\" data-value=\"5\"><font size=\"5\">X-Large</font></a></li>
							  			<li><a href=\"#\" data-command=\"fontSize\" data-value=\"6\"><font size=\"6\">XX-Large</font></a></li>
							  			<li><a href=\"#\" data-command=\"fontSize\" data-value=\"7\"><font size=\"7\">Largest</font></a></li>
							  		</ul>
							  	</div>
							  	<a href=\"#\" data-command=\"bold\"><i class=\"fa fa-bold\"></i></a>
							  	<a href=\"#\" data-command=\"italic\"><i class=\"fa fa-italic\"></i></a>
							  	<a href=\"#\" data-command=\"underline\"><i class=\"fa fa-underline\"></i></a>
							  	<a href=\"#\" data-command=\"strikeThrough\"><i class=\"fa fa-strikethrough\"></i></a>
				
							  	<a href=\"#\" data-command=\"justifyLeft\"><i class=\"fa fa-align-left\"></i></a>
							  	<a href=\"#\" data-command=\"justifyCenter\"><i class=\"fa fa-align-center\"></i></a>
							  	<a href=\"#\" data-command=\"justifyRight\"><i class=\"fa fa-align-right\"></i></a>
							  	<a href=\"#\" data-command=\"justifyFull\"><i class=\"fa fa-align-justify\"></i></a>
				
							  	<a href=\"#\" data-command=\"indent\"><i class=\"fa fa-indent\"></i></a>
							  	<a href=\"#\" data-command=\"outdent\"><i class=\"fa fa-outdent\"></i></a>
							  	<a href=\"#\" data-command=\"insertUnorderedList\"><i class=\"fa fa-list-ul\"></i></a>
							  	<a href=\"#\" data-command=\"insertOrderedList\"><i class=\"fa fa-list-ol\"></i></a>
				
							  	<a href=\"#\" data-command=\"h1\">H1</a>
							  	<a href=\"#\" data-command=\"h2\">H2</a>
							  	<a href=\"#\" data-command=\"h3\">H3</a>
							  	<a href=\"#\" data-command=\"h4\">H4</a>
							  	<a href=\"#\" data-command=\"blockquote\"><i class=\"fa fa-quote-right\"></i></a>
							  	<a href=\"#\" data-command=\"p\">P</a>
				
							  	<a href=\"#\" data-command=\"createlink\"><i class=\"fa fa-link\"></i></a>
							  	<a href=\"#\" data-command=\"unlink\"><i class=\"fa fa-unlink\"></i></a>
							  	<a href=\"#\" data-command=\"insertHorizontalRule\"><i class=\"fa fa-minus\"></i></a>
							  	<a href=\"#\" data-command=\"insertimage\"><i class=\"fa fa-image\"></i></a>
				
							  	<a href=\"#\" data-command=\"subscript\"><i class=\"fa fa-subscript\"></i></a>
							  	<a href=\"#\" data-command=\"superscript\"><i class=\"fa fa-superscript\"></i></a>
							</div>
							<div id=\"blog-post-content\" contenteditable>
								$content
							</div>
							</div>
							<div class=\"admin-newb-step-three\" id=\"blog-step-three\">";
							if($live == 1){
								echo "<h2 id=\"admin-newb-confirm\">Update Post</h2>
								<div class=\"admin-newb-demo-query\">
									<a href=\"#\"><p>View Demo</p><p class=\"ion-ios-paper-outline\"></p></a>
								</div>
								<div class=\"admin-newb-buttons\">
									<input type=\"submit\" id=\"blog-post-update\" value=\"Update\" name=\"update\">
								</div>
							</div>";
							} else{
								echo "
								<h2 id=\"admin-newb-confirm\">Would you like to Save as Draft or Post Live?</h2>
								<div class=\"admin-newb-demo-query\">
									<a href=\"#\"><p>View Demo</p><p class=\"ion-ios-paper-outline\"></p></a>
								</div>
								<div class=\"admin-newb-buttons\">
									<input type=\"submit\" id=\"blog-post-draft\" value=\"Save\" name=\"save-draft\">
									<input type=\"submit\" id=\"blog-post-live\" value=\"Post Live\" name=\"post-live\">
								</div>
							</div>";
							}
						} else {
							echo "
								<div class=\"admin-newb-step-one\" id=\"blog-step-one\">
								<div class=\"admin-newb-cover\">
									<article>
										<div>
											<div>";
												if($catnum == 0){
													echo "<select id=\"blog-post-cat\">
														<option>-- No Categories Available</option>
													</select>";
												} else {
													echo "<select id=\"blog-post-cat\" name=\"category\">";
														while($rowCats = mysqli_fetch_assoc($rCats)){
															$idcat=$rowCats['idblog_category'];
															$category = $rowCats['blog_category'];
											
															echo "<option value=\"$idcat\">$category</option>";
														}
													echo "</select>";
												}
											echo "
												<input type=\"text\" id=\"blog-post-title\" placeholder=\"Title\" name=\"post-title\" >
												<textarea id=\"blog-post-desc\" placeholder=\"Post Summary\" name=\"post-description\"></textarea>
											</div>
										</div>
									</article>
									<input type=\"file\" id=\"blog-post-cover\" name=\"post-cover\">
								</div>
							</div>
							<div class=\"admin-newb-step-two\" id=\"blog-step-two\">
								<div class=\"blog-editor-bar\">
									<a href=\"#\" data-command='save' id='save'><i class='fa fa-save'></i></a>
									<a href=\"#\" data-command=\"undo\"><i class=\"fa fa-undo\"></i></a>
									<a href=\"#\" data-command=\"redo\"><i class=\"fa fa-repeat\"></i></a>
					
									<div class=\"fore-wrapper\"><i class='fa fa-font'></i>
								    	<div class=\"fore-palette\">
								   		</div>
								  	</div>
								  	<div class=\"font-wrapper\"><i class='fa fa-text-height'></i>
								  		<ul>
								  			<li><a href=\"#\" data-command=\"fontSize\" data-value=\"1\"><font size=\"1\">X-Small</font></a></li>
								  			<li><a href=\"#\" data-command=\"fontSize\" data-value=\"2\"><font size=\"1\">Small</font></a></li>
								  			<li><a href=\"#\" data-command=\"fontSize\" data-value=\"3\"><font size=\"3\">Normal</font></a></li>
								  			<li><a href=\"#\" data-command=\"fontSize\" data-value=\"4\"><font size=\"4\">Large</font></a></li>
								  			<li><a href=\"#\" data-command=\"fontSize\" data-value=\"5\"><font size=\"5\">X-Large</font></a></li>
								  			<li><a href=\"#\" data-command=\"fontSize\" data-value=\"6\"><font size=\"6\">XX-Large</font></a></li>
								  			<li><a href=\"#\" data-command=\"fontSize\" data-value=\"7\"><font size=\"7\">Largest</font></a></li>
								  		</ul>
								  	</div>
								  	<a href=\"#\" data-command=\"bold\"><i class=\"fa fa-bold\"></i></a>
								  	<a href=\"#\" data-command=\"italic\"><i class=\"fa fa-italic\"></i></a>
								  	<a href=\"#\" data-command=\"underline\"><i class=\"fa fa-underline\"></i></a>
								  	<a href=\"#\" data-command=\"strikeThrough\"><i class=\"fa fa-strikethrough\"></i></a>
					
								  	<a href=\"#\" data-command=\"justifyLeft\"><i class=\"fa fa-align-left\"></i></a>
								  	<a href=\"#\" data-command=\"justifyCenter\"><i class=\"fa fa-align-center\"></i></a>
								  	<a href=\"#\" data-command=\"justifyRight\"><i class=\"fa fa-align-right\"></i></a>
								  	<a href=\"#\" data-command=\"justifyFull\"><i class=\"fa fa-align-justify\"></i></a>
					
								  	<a href=\"#\" data-command=\"indent\"><i class=\"fa fa-indent\"></i></a>
								  	<a href=\"#\" data-command=\"outdent\"><i class=\"fa fa-outdent\"></i></a>
								  	<a href=\"#\" data-command=\"insertUnorderedList\"><i class=\"fa fa-list-ul\"></i></a>
								  	<a href=\"#\" data-command=\"insertOrderedList\"><i class=\"fa fa-list-ol\"></i></a>
					
								  	<a href=\"#\" data-command=\"h1\">H1</a>
								  	<a href=\"#\" data-command=\"h2\">H2</a>
								  	<a href=\"#\" data-command=\"h3\">H3</a>
								  	<a href=\"#\" data-command=\"h4\">H4</a>
								  	<a href=\"#\" data-command=\"blockquote\"><i class=\"fa fa-quote-right\"></i></a>
								  	<a href=\"#\" data-command=\"p\">P</a>
					
								  	<a href=\"#\" data-command=\"createlink\"><i class=\"fa fa-link\"></i></a>
								  	<a href=\"#\" data-command=\"unlink\"><i class=\"fa fa-unlink\"></i></a>
								  	<a href=\"#\" data-command=\"insertHorizontalRule\"><i class=\"fa fa-minus\"></i></a>
								  	<a href=\"#\" data-command=\"insertimage\"><i class=\"fa fa-image\"></i></a>
					
								  	<a href=\"#\" data-command=\"subscript\"><i class=\"fa fa-subscript\"></i></a>
								  	<a href=\"#\" data-command=\"superscript\"><i class=\"fa fa-superscript\"></i></a>
								</div>
								<div id=\"blog-post-content\" class=\"post-content\"contenteditable>
								</div>
							</div>
							<div class=\"admin-newb-step-three\" id=\"blog-step-three\">
								<h2 id=\"admin-newb-confirm\">Select Choice</h2>
								<div class=\"admin-newb-demo-query\">
									<a href=\"#\"><p>View Demo</p><p class=\"ion-ios-paper-outline\"></p></a>
								</div>
								<div class=\"admin-newb-buttons\">
									<input type=\"submit\" id=\"blog-post-draft\" value=\"Save as Draft\" name=\"save-draft\">
									<input type=\"submit\" id=\"blog-post-live\" value=\"Post Live\" name=\"post-live\">
								</div>
							</div>";
						}
?>
					</form>
				</div>
			</article>
		</section>
		<script src="js/jquery-2.2.1.js"></script>
		<script src="js/blog.js"></script>
	</body>
</html>