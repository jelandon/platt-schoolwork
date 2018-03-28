<?php 

/**
 * the first step to save a budget. If successful, the transaction is saved and the user is directed to the second step to complete the post title, body, etc.
 */

require_once('header.php');

include('budget-parse.php');

// $user_id = 1;

 ?>
<main class="content">
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<?php 
			show_feedback($feedback, $errors);
		 ?>
		<label for="the_trans">Add a transaction</label>
		<input type="number" name="trans" maxlength="13" required id="the_trans" value="">

		<label for="the_type">Income or Expense?</label>
		<select id="the_type" name="selectedType">
			<option value="1">Income</option>
			<option value="2">Expense</option>
		</select>

		<label for="the_description">Description</label>
		<input type="text" name="description" maxlength="256" id="the_description" value="">

		<select id="the_category" name="selectedCategory">
			<!-- TODO: REPLACE WITH DYNAMIC CATEGORIES FROM DB -->
			<option value="1">WAGES</option>
			<option value="2">RENT</option>
		</select>

		<input type="submit" value="ADD">
		<input type="hidden" name="did_add_trans" value="1">
	</form>
</main>