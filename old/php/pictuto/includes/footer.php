</div>
	<footer>
		&copy; 2018 Platt College
	</footer>

<script type="text/javascript">
	//JS for like button which happens on multiple pages
	var likeButtons = document.querySelectorAll('.like-button');

	for(var i=0; i<likeButtons.length; i++){
		var likeButton = likeButtons[i];
		likeButton.onclick = function(){
			var currClass = this.className.split(' ')[2];
			//like or liked are the expected values. like asks if user wants to like this post, liked states that they did like to like this post
			if(currClass == 'like'){
				currClass = 'unliked';
			}else{
				currClass = 'liked';
			}
			//currClass now matches up with the expected arguments on like_inlike.php
			
			var userId = this.getAttribute('date-userid');
			var postId = this.getAttribute('data-postid');
			console.log(currClass, userId, postId);
			confirmLikeAction(currClass, userId, postId);
		}
	}
/**
 * a function to gather from the button vclicked abd confirm
 *if a picture was linked or not
 *@param: currClass, string = liked or unliked
 *@param {: userId, int, the user liking or unliking
 *@param postId, int, which picture they are liking or unliking
 */

function confirmLikeAction(currClass, userId=0, postId=0){
	//ask the user what he wants to do based on value of currClass
	var like = '';//the text of the button
	var buttonClass = '';//class of the button
	var toAdd = 1; //value difference
	
	if(currClass == 'liked'){
		var agree = confirm("You liked this image. Do you want to un-like it?");
		if(agree){
			//yes, they want to un-like it
			like = 'like';
			buttonClass = like;
			toAdd = -1;
		}else{
			return false; //they oopsed on the button
		}
	}else{
		//we assume the want to like the image
		like='liked';
		buttonClass = like;
	}
	
	var xhttp = new XMLHttpRequest();

	xhttp.open("POST", "includes/like-unlike.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("like="+like+"&user_id"+userId+"&post_id="+postId);

	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			//this simulates what would happen if the page is refreshed
			////the data sent above does the actual db work but we want to give the user feedback w/ a visual response.
			var currentPost = document.getElementById('post_id'+postId);
			var clickedButton = document.querySelector('#post_id_'+postId+' .like-button');

			clickedButton.className = clickedButton.className.replace(currClass, buttonClass);
			var noOfLikes = document.querySelector('#postId'=postId+' .likes-number');
			var theNumber = parseInt(noOfLikes.textContent.split('')[1])+toAdd;
			noOfLikes.textContent = 'Likes: '+theNumber;


		}
	}

}

</script>