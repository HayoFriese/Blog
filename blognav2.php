		<nav class="blogNav">
			<div class="navInner">
				<div class="navBlog2">
					<ul>
						<li class="categories dropdown">
							<a href="#">Category <span>&#x33;</span></a>
							<ul class="dropdownMenu">
							<?php
								$sqlNav = "SELECT * FROM portfolio.blog_category";
								$rNav = mysqli_query($conn, $sqlNav) or die(mysqli_error($conn));
								while($row = mysqli_fetch_assoc($rNav)){
									$navid = $row['idblog_category'];
									$navcat = $row['blog_category'];
									echo "<li><a href=\"search_category.php?id=$navid\">$navcat</a></li>";
								}
							?>
							</ul>	
						</li>
						<li class="connect dropdown">
							<a href="#">More Info <span>&#x33;</span></a>
							<ul class="dropdownMenu">
								<li><a href="#">About The Blog</a></li>
								<li><a href="#">Facebook</a></li>
								<li><a href="#">LinkedIn</a></li>
							</ul>
						</li>
						<li><a href="#">Subscribe</a></li>
					</ul>
				</div>
			</div>
		</nav>