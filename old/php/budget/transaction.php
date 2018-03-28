<?php 


 /*
Edit any budget as long as ?user_id=X is in the query string
and the logged_in_user is the one who belongs to this profile

otherwise kill the page
*/
require('header.php');
include('transaction-parse.php');


$user_id = $_GET['user_id'];


if($user_id){
	$query="SELECT balance
			from users
			WHERE user_id = $user_id";		  
	$result = $db->query($query);
	$row=$result->fetch_assoc();
	$balance=$row['balance'];
	//echo $balance;

	if($result->num_rows == 0){
		$show_balance=false;
	}

}



if($logged_in_user){
$page_user_id = $logged_in_user['user_id'];
}else{
	die('You need to be <a href="login.php">logged in</a> to view this page.');
}

 ?>
<main class="content">
	<div class="balance">
		<form action="budget.php?user_id=<?php echo $user_id; ?>" method="post">
			<?php show_feedback($feedback, $errors); ?>

			<label for="add_trans">Add a transaction</label>
				<input type="number" name="add_trans" maxlength="13" required id="add_trans" value="">
				<br>

			<label for="the_type">Income or Expense?</label>
				<select id="the_type" name="selectedType">
					<option value="1">Income</option>
					<option value="2">Expense</option>
				</select>
				<br>

			<label for="the_description">Description</label>
				<input type="text" name="description" maxlength="256" id="the_description" value="">
				<br>

			<select id="the_category" name="selectedCategory">
			<!-- TODO: REPLACE WITH DYNAMIC CATEGORIES FROM DB -->
				<option value="1">WAGES</option>
				<option value="2">RENT</option>
			</select>
			<br>

			<input type="submit" value="ADD">
			<input type="hidden" name="did_add_trans" value="1">
			
		</form>
	</div>
</main>