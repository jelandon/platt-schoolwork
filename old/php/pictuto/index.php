<?php 
	include_once('includes/header.php');
 ?>
		<main class="content grid">
			<?php //get the most recxent posts for the main feed page

			// $query = "SELECT *
			// 		FROM posts
			// 		WHERE is_published = 1";
			
			//super simple query
			$query = "SELECT posts.*, users.username, users.email, users.user_id
						FROM posts, users
						WHERE posts.is_published = 1
						AND users.user_id = posts.user_id
						ORDER BY posts.date DESC
						LIMIT 10";

			$result = $db->query($query);

			if(! $result){
				echo $db->error;
			}

			if($result->num_rows>=1){
				//loop through all the rows
				while($row=$result->fetch_assoc()){
//					var_dump($row);
//					echo '<br>';
				

			 ?>

			<article>
				<h2 class="user-card">
					<a href="author.php?user_id=<?php echo $row['user_id'] ?>">
						AVATAR
						<span class="username">
							<?php echo $row['username']; ?>
						</span>
					</a>
				</h2>
				<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
					<img src="<?php echo image_url($row['post_id'], 'large'); ?>">
				</a>
				<h3><?php echo $row['title']; ?></h3>
				<p><?php echo $row['body']; ?></p>
				<div class="post-info">
					<span class="datetime"><?php echo convert_date($row['date']); ?></span>
					<span class="username"><?php echo $row['username']; ?></span>
					<div class="tags">TAGS</div>
					<div class="likes-number">#ofLIKES</div>
					<div class="comments-number">#ofCOMMENTS</div>
				</div>
			</article>

			<?php 
				}
			}
			 ?>

		</main>
		<?php 
			include_once('includes/sidebar.php');
		 ?>
		<?php 
			include_once('includes/footer.php');
		 ?>

 </body>
 	<script type="text/javascript">
		var pwBox = document.querySelector('#the_password');
		var showBtn = document.querySelector('#show-hide');

		showBtn.onclick = function(e){
			e.preventDefault();
			var theType = pwBox.getAttribute('type');
			console.log(theType);
			if(theType == 'password'){
				theNewType = 'text';
				theText = 'Hide';
			}else{
				theNewType = 'password';
				theText = 'Show';
			}
			pwBox.setAttribute('type', theNewType);
			this.textContent=theText;
		}

	</script>
 </html>