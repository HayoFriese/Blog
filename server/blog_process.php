<?php
	include 'db.php';

	$cat = $_POST['category'] ? $_POST['category'] : null;
	$title = $_POST['post-title'] ? $_POST['post-title'] : null;
	$summary = $_POST['post-description'] ? $_POST['post-description'] : null;
	$post = $_POST['post'] ? $_POST['post'] : null;
	$author = 1;
	$date = date("Y-m-d");
	$coverHold = $_POST['cover'] ? $_POST['cover'] : null;

	if(isset($_POST['postid'])){
		$postid = $_POST['postid'] ? $_POST['postid'] : null;

		$sqlSave = "SELECT * FROM portfolio.blog_posts WHERE idblog_posts = '$postid'";
		$rSave = mysqli_query($conn, $sqlSave) or die(mysqli_error($conn));
		$rowSave = mysqli_fetch_assoc($rSave);
		$otitle = $rowSave['postTitle'];
		$odesc = $rowSave['postDesc'];
		$ocover = $rowSave['postCover'];
		$ocont = $rowSave['post'];
		$oauthor = $rowSave['postAuthor'];
		$getLive = $rowSave['postLive'];

		if(mysqli_num_rows($rSave)){
			$newCover = cover();
			$sqlOverwrite = "UPDATE portfolio.blog_posts SET postCover = ?, 
			postTitle = ?, postDesc = ?, postCategory = ?, post = ?, postDate = ?, 
			postLive = ?, postAuthor = ? WHERE idblog_posts = ?";

			if($newCover == null || $newCover == "undefined"){
				$saveCover = $ocover;
			} else{
				$saveCover = $newCover;
			}
			if($title || $title != " "){
				$saveTitle = $title;
			} else if(!$title || $title == "" || $title == "undefined" || $title == null){
				$saveTitle = $otitle;
			}
			if($summary || $summary != ""){
				$saveDesc = $summary;
			} elseif(!$summary || $summary == "" || $summary == "undefined" || $summary == null){
				$saveDesc = $odesc;
			}
			if($post  || $title != ""){
				$savePost = $post;
			} elseif(!$post || $post == "" || $post == "undefined" || $post == null){
				$savePost = $ocont;
			}
			if($author || $author != ""){
				$saveAuthor = $author;
			} elseif(!$author || $author == "" || $author == "undefined" || $author == null){
				$saveAuthor = $oauthor;
			}
			if($getLive == 0 && isset($_POST['update'])){
				$live = 0;
			} else {
				$live = 1;
			}

			$stmt = mysqli_prepare($conn, $sqlOverwrite) or die(mysqli_error($conn));
			mysqli_stmt_bind_param($stmt, "sssdssddd", $saveCover, $saveTitle, $saveDesc, $cat, $savePost, $date, $live, $saveAuthor, $postid) or die(mysqli_error($conn));
			mysqli_stmt_execute($stmt) or die(mysqli_error($conn));
		   	mysqli_stmt_close($stmt) or die(mysqli_error($conn));
		   	
		   	echo "Overwrite successful, ";
		}

	}else {
		if(isset($_POST['save-draft'])){
			$live = 0;
			$status = "Saved as Draft.";
		}elseif(isset($_POST['post-live'])){
			$live = 1;
			$status = "File has been sent Live";
		}
		$sqlNewPost = "INSERT INTO portfolio.blog_posts(postCover, postTitle, postDesc, postCategory, post, postDate, postLive, postAuthor) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = mysqli_prepare($conn, $sqlNewPost) or die(mysqli_error($conn));
	    mysqli_stmt_bind_param($stmt, "sssdssdd", $coverHold, $title, $summary, $cat, $post, $date, $live, $author) or die(mysqli_error($conn));
		mysqli_stmt_execute($stmt) or die(mysqli_error($conn));
	    mysqli_stmt_close($stmt) or die(mysqli_error($conn));
	    echo $status;

	    $newID = mysqli_insert_id($conn);

	    if(!empty($_FILES['post-cover'])){
			$movedir = ('../img/blog/'.$newID.'/cover');
			$dir = ('img/blog/'.$newID.'/cover');
			foreach ($_FILES['post-cover'] as $f => $name) {
				$allowedExts = array("gif", "jpeg", "jpg", "png");
				$temp = explode(".", $name);
				$extension = end($temp);
				//Set file type and size
				if ((($_FILES['post-cover']['type'] == "image/gif")
				|| ($_FILES['post-cover']['type'] == "image/jpeg")
				|| ($_FILES['post-cover']['type'] == "image/jpg")
				|| ($_FILES['post-cover']['type'] == "image/png"))
				&& ($_FILES['post-cover']['size'] < 1073741824)
				&& in_array($extension, $allowedExts))
				{
				  	if ($_FILES['post-cover']['error'][$f] > 0){
				  		echo "Return Code: " . $_FILES['post-cover']['error'][$f] . "<br>";
				  	} else {
				    //if the file exists within the directory
				  		if(file_exists($movedir)){
				  			echo "Directory Already Exists ";
				  		} else {
				  			mkdir($movedir, 0777, true);
				  		}
				    	if (file_exists($movedir.$name)){
				    		echo "File Already Exists ";
				    		$pathname = $dir.$name;
						} else {
				    		$names = $_FILES['post-cover']['tmp_name'];
	
			  				if (move_uploaded_file($names, "$movedir/$name")){
			    				$pathname = ($dir."/".$name);

			    				$sqlCover = "UPDATE portfolio.blog_posts SET postCover = ? WHERE idblog_posts = ?";
			    				$stmt = mysqli_prepare($conn, $sqlCover) or die(mysqli_error($conn));
	    						mysqli_stmt_bind_param($stmt, "sd", $pathname, $newID) or die(mysqli_error($conn));
								mysqli_stmt_execute($stmt) or die(mysqli_error($conn));
	    						mysqli_stmt_close($stmt) or die(mysqli_error($conn));
		  					} else {
		  		  				echo "Image File Not Moved, ";

		  		  				$sqlUndo = "DELETE FROM portfolio.blog_posts WHERE idblog_posts = ?";
								$stmt = mysqli_prepare($conn, $sqlUndo) or die(mysqli_error($conn));
								mysqli_stmt_bind_param($stmt, "d", $newID) or die(mysqli_error($conn));
								mysqli_stmt_execute($stmt);
								mysqli_stmt_close($stmt);
					
								echo "Unable to create new Post ";
		  					}
						}
					}
				}
			}
		} else {
			echo "No Photo, ";
			$sqlUndo = "DELETE FROM portfolio.blog_posts WHERE idblog_posts = ?";
			$stmt = mysqli_prepare($conn, $sqlUndo) or die(mysqli_error($conn));
			mysqli_stmt_bind_param($stmt, "d", $newID) or die(mysqli_error($conn));
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);

			echo "Unable to create new Post ";
		}
	}
	echo "Save Completed ";

	function cover(){
		if(!empty($_FILES['post-cover'])){
			$movedir = ('../img/blog/'.$GLOBALS['postid'].'/cover');
			$dir = ('img/blog/'.$GLOBALS['postid'].'/cover');
			foreach ($_FILES['post-cover'] as $f => $name) {
				$allowedExts = array("gif", "jpeg", "jpg", "png");
				$temp = explode(".", $name);
				$extension = end($temp);
				//Set file type and size
				if ((($_FILES['post-cover']['type'] == "image/gif")
				|| ($_FILES['post-cover']['type'] == "image/jpeg")
				|| ($_FILES['post-cover']['type'] == "image/jpg")
				|| ($_FILES['post-cover']['type'] == "image/png"))
				&& ($_FILES['post-cover']['size'] < 1073741824)
				&& in_array($extension, $allowedExts))
				{
				  	if ($_FILES['post-cover']['error'][$f] > 0){
				  		echo "Return Code: " . $_FILES['post-cover']['error'][$f] . "<br>";
				  	} else {
				    //if the file exists within the directory
				  		if(file_exists($movedir)){
				  			echo "Directory Already Exists ";
				  		} else {
				  			mkdir($movedir, 0777, true);
				  		}
				    	if (file_exists($movedir.$name)){
				    		echo "File Already Exists ";
				    		$pathname = $dir.$name;
				    		return $pathname;
						} else {
				    		$names = $_FILES['post-cover']['tmp_name'];
	
			  				if(move_uploaded_file($names, "$movedir/$name")){
			    				$pathname = ($dir."/".$name);
			    				return $pathname;
		  					} else {
		  		  				echo "Not Moved ";
		  		  				return null;
		  					}
						}
					}
				}
			}
		} else {
			return false;
		}
	}
	mysqli_close($conn);
?>