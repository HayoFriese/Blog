<?php
	include "server/db.php";
	if(isset($_POST['submit'])){
		//Ratings
			$commentError = [];
			//Get Values
				$postid = mysqli_real_escape_string($conn, isset($_POST['postid'])) ? $_POST['postid']: null;
				echo $postid;
				//$rateBy = mysqli_real_escape_string($conn, isset($_POST['ratingBy'])) ? $_POST['ratingBy']: null;
				$comment = mysqli_real_escape_string($conn, isset($_POST['comment'])) ? $_POST['comment']: null;
			
			//Trim  Values
				$postid = trim($postid);
				//$rateBy = trim($rateBy);
				$comment = trim($comment);
			
			//Special Chars for Rating
    	       	$comment = htmlspecialchars($comment);
    		
    		//Numeric
    		    if(!is_numeric($postid)){
    	    		$commentError[] .= 'Post ID Must be numeric.';
    	    	}
    		
    		//Empty comment
    		    elseif(empty($comment)){
    		    	$commentError[] .= 'Aside from file uploads, all fields are required';
    		    }
    		
    		//If there are errors
    		    if(!empty($commentError)){
    		      	echo '<ul>';
    		        foreach ($commentError as $key => $value){
    		        	echo '<li>'.$value.'</li>';
    		        }
    		        echo '</ul>';
    		
    		//Posting Data
    			} else {
    		    	$sqlComment = "INSERT INTO portfolio.blog_comments(comment, commentPost, commentDate) VALUES(?, ?, NOW())";
					
					$stmt = mysqli_prepare($conn, $sqlComment) or die(mysqli_error($conn));
        		    mysqli_stmt_bind_param($stmt, 'sd', $comment, $postid/*, $rateBy*/) or die(mysqli_error($conn));
            		mysqli_stmt_execute($stmt) or die(mysqli_error($conn));
            		mysqli_stmt_close($stmt);
   	    		}
    	echo "<meta http-equiv='refresh' content='0;url=post.php?id=$postid'>";
	} else {
		//$user = $_SESSION['iduser'];
			echo "<form id='blog-comment-form' method='post' action='blogcomment.php' enctype='multipart/form-data'>";
				echo "<input type='hidden' name='postid' value='$id'>";
				//echo "<input type='hidden' name='postedby' value='$user'>";
				echo "<div id='blog-comment-user'>";
					echo "<img>";
				echo "</div>";
				echo "<textarea name='comment' id='blog-comment' placeholder='Leave a Comment...'></textarea>";
				echo "<input type='submit' name='submit' value='Post'>";
			echo "</form>";		
		/*} else {
			echo "<h2 id='reviewSignNo'>You need to be signed in to leave a review.</h2>";
		}*/
		function time_elapsed_string($time_ago){
    		$time_ago = strtotime($time_ago);
    		$cur_time   = time();
    		$time_elapsed   = $cur_time - $time_ago;
    		$seconds    = $time_elapsed ;
    		$minutes    = round($time_elapsed / 60 );
    		$hours      = round($time_elapsed / 3600);
    		$days       = round($time_elapsed / 86400 );
    		$weeks      = round($time_elapsed / 604800);
    		$months     = round($time_elapsed / 2600640 );
    		$years      = round($time_elapsed / 31207680 );

    		// Seconds
    			if($seconds <= 60){
    			    return "just now";
    			}
    		//Minutes
    			else if($minutes <= 60){
    			    if($minutes==1){
    			        return "one minute ago";
    			    }
    			    else{
    			        return "$minutes minutes ago";
    			    }
    			}
    		//Hours
    			else if($hours <=24){
    			    if($hours==1){
    			        return "an hour ago";
    			    }else{
    			        return "$hours hrs ago";
    			    }
    			}
    		//Days
    			else if($days <= 7){
    			    if($days==1){
    			        return "yesterday";
    			    }else{
    			        return "$days days ago";
    			    }
    			}
    		//Weeks
    			else if($weeks <= 4.3){
    			    if($weeks==1){
    			        return "a week ago";
    			    }else{
    			        return "$weeks weeks ago";
    			    }
    			}
    		//Months
    			else if($months <=12){
    			    if($months==1){
    			        return "a month ago";
    			    }else{
    			        return "$months months ago";
    			    }
    			}
    		//Years
    			else{
    			    if($years==1){
    			        return "one year ago";
    			    }else{
    			        return "$years years ago";
    			    }
    			}
		}

		$sqlGetPosts = "SELECT idblog_comments, comment, commentPost, commentDate 
			FROM portfolio.blog_comments WHERE commentPost = $id ORDER BY commentDate DESC";
	
		$rGetPost = mysqli_query($conn, $sqlGetPosts) or die(mysqli_error($conn));

		$rowCnt = mysqli_num_rows($rGetPost);
		echo "<ul id='comment-wrapper'>";
			if($rowCnt == 0){
				echo "<p>0 Comments</p>";
			} else {
				while ($rowPosts = mysqli_fetch_assoc($rGetPost)){
					$commentId = $rowPosts['idblog_comments'];
					$comment = $rowPosts['comment'];
					$commentPost = $rowPosts['commentPost'];
					//$rateBy = $rowPosts['userName'];
					$commentDate = $rowPosts['commentDate'];
					
					echo "<li id='comment-single'>";
						echo "<div id='blog-comment-user'>";
							echo "<img>";
						echo "</div>";
							echo "<p id='comment-username'>Name <span>| ".time_elapsed_string($commentDate)."<span></p>";
						echo "<div id='comment-content'>";
							echo "<p id='comment'>$comment</p>";
							//echo "<p id='rateBy'>Posted by $rateBy</p>";
							echo "<p id='comment-options'>Reply - Share - Reply v <span>3 likes</span></p>";
						echo "</div>";
					echo "</li>";
				}
			}
		echo "</ul>";	
	}
?>