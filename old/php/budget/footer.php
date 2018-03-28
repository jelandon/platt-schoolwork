</div><!-- close html body div.wrapper -->
<footer>
	&copy; 2018 John Landon
</footer>

<script type="text/javascript">
	var pwBox = document.querySelector('#password');
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
<!-- no close html body -->