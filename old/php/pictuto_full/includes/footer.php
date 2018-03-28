</div><!-- this close div tag should be showing up on the page -->
<footer class="footer">
	&copy; <?php echo date("Y"); ?> Platt College
</footer>
<script type="text/javascript">
//JS for like button which happens on a number of pages:

var likeButtons = document.querySelectorAll('.like-button');
//console.log(likeButtons.length);	
for(var i = 0; i<likeButtons.length; i++){
	var likeButton = likeButtons[i];
	likeButton.onclick = function(){
		var currClass = this.className.split(' ')[1];
		var userId = this.getAttribute('data-userid');
		var postId = this.getAttribute('data-postid');
		confirmAction(currClass, userId, postId);
	};
}	

function confirmAction(currClass, userId=0, postId=0){
//ask which the user wants to do based on currClass

var like = '';
//get values of current elements on this page to change...
var buttonClass = '';
//class of element to change to..

var toAdd = 1;

	if(currClass == 'you-liked'){
		var agree = confirm("You liked this image. Do you want to un-like it?");
		if(agree){
			//yes they want to unlike it
			like = 'unliked';
			buttonClass = 'not-liked';
			toAdd *= -1;

		}else{
			return false; // they oopsed on the button
		}
	}else{
		//we assume they want to like the post
		//temp
		like = 'liked';
		buttonClass = 'you-liked';
	}


var xhttp = new XMLHttpRequest();

xhttp.open("POST", "includes/like-unlike.php", true);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send("like="+like+"&user_id="+userId+"&post_id="+postId);

xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
      //this simulates what would happen if the page is refreshed.
      //the data sent above does the actual db work, but we want the user to know they did something :)
		var currentArticle = document.getElementById('post_id_'+postId);	
		var clickedButton = document.querySelector('#post_id_'+postId+' .like-button');
		 clickedButton.className = clickedButton.className.replace(currClass, buttonClass);
		 var noOfLikes = document.querySelector('#post_id_'+postId+' .likes-number');
		 var theNumber = parseInt(noOfLikes.textContent.split(' ')[1])+toAdd;
		 noOfLikes.textContent = 'Likes: '+theNumber;
	
        }
    };
}




</script>
</body>


</html>