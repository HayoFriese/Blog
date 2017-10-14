<?php
	//On-click on the save function
		//connect to database
			include 'server/db.php';
		//store stuff in database
			//Get Variables
				$postid = $_POST['id'] ? $_POST['id'] : null;
				$cover = $_POST['cover'] ? $_POST['cover'] : null;
				$title = $_POST['title'] ? $_POST['title'] : null;
				$summary = $_POST['desc'] ? $_POST['desc'] : null;
				$cat = $_POST['cat'] ? $_POST['cat'] : null;
				$post = $_POST['post'] ? $_POST['post'] : null;
				$date = date('Y-m-d');
				$live = 0;
				
				if(!empty($_FILES['cover'])){
						$dir = ('img/blog/'.$postid.'/cover/');
						foreach ($_FILES['cover'] as $f => $name) {
							$allowedExts = array("gif", "jpeg", "jpg", "png");
    						$temp = explode(".", $name);
    						$extension = end($temp);
    						//Set file type and size
    						if ((($_FILES['cover']['type'][$f] == "image/gif")
    						|| ($_FILES['cover']['type'][$f] == "image/jpeg")
    						|| ($_FILES['cover']['type'][$f] == "image/jpg")
    						|| ($_FILES['cover']['type'][$f] == "image/png"))
    						&& ($_FILES['cover']['size'][$f] < 1073741824)
    						&& in_array($extension, $allowedExts))
    						{
    						  	if ($_FILES['cover']['error'][$f] > 0){
    						  		echo "Return Code: " . $_FILES['cover']['error'][$f] . "<br>";
    						  	} else {
    						    //if the file exists within the directory
    						    	if (file_exists($dir . $name)){
    						    		echo "<p>File Already Exists</p>";
    								} else {
    						    		$names = $_FILES['cover']['tmp_name'][$f];
										
        				  				if (move_uploaded_file($names, "$dir/$name")){
        				    				$pathname = ($dir."/".$name);

        			    				} else {
        			  		  				echo "<p>not moved</p>";
        			  					}
        							}
      							}
    						}
  						}
  					}
		//if exists, overwrite

				if($postid != null || $postid != ""){
					$sqlSave = "SELECT * FROM portfolio.blog_posts WHERE idblog_posts = '$postid'";
					$rSave = mysqli_query($conn, $sqlSave) or die(mysqli_error($conn));
					if(mysqli_num_rows($rSave)){
						$sqlOverwrite = "UPDATE portfolio.blog_posts SET postCover = ?, postTitle = ?, postDesc = ?, postCategory = ?, post = ?, postDate = ?, postLive = ? WHERE idblog_posts = ?";
						$stmt = mysqli_prepare($conn, $sqlOverwrite) or die(mysqli_error($conn));
						mysqli_stmt_bind_param($stmt, "sssdssdd", $pathname, $title, $summary, $cat, $post, $date, $live, $postid) or die(mysqli_error($conn));
						mysqli_stmt_execute($stmt);
                		mysqli_stmt_close($stmt);
                		echo "overwrite successful";
					} else {
						newSave();
					}
					echo "save completed";
				}

				function newSave(){
					$sqlNewSave = "INSERT INTO portfolio.blog_posts(postCover, postTitle, postDesc, postCategory, post, postDate, postLive) VALUES(?, ?, ?, ?, ?, ?, ?)";
					$stmt = mysqli_prepare($GLOBALS['conn'], $sqlNewSave) or die(mysqli_error($GLOBALS['conn']));
                	mysqli_stmt_bind_param($stmt, "sssdssd", $GLOBALS['pathname'], $GLOBALS['title'], 
                		$GLOBALS['summary'], $GLOBALS['cat'], $GLOBALS['post'], $GLOBALS['date'], $GLOBALS['live']) 
                		or die(mysqli_error($GLOBALS['conn']));
					mysqli_stmt_execute($stmt);
                	mysqli_stmt_close($stmt);
                	echo "file has been saved";
				}

				mysqli_close($conn);
		//reload the form page with the content on it

?>