<?php 


 /*
Edit any budget as long as ?user_id=X is in the query string
and the logged_in_user is the one who belongs to this profile

otherwise kill the page
*/
require('header.php');
include('budget-parse.php');
//include('transaction-parse.php');


// $query=	"SELECT balance
// 		FROM users
// 		WHERE user_id = $user_id
// 		LIMIT 1";
// $result = $db->($query) or die(mysql_error()); 

// $balance=$_GET['balance'];
// $show_balance=true;

//check for invalid balance in Query string
// if(! $balance){
// 	die('invalid budget');
// 	$show_balance=false;
// }






$user_id = $_GET['user_id'];


if($user_id){
	$query="SELECT balance
			from users
			WHERE user_id = $user_id";		  
	$result = $db->query($query);
	$row=$result->fetch_assoc();
	$balance=$row['balance'];

	if($result->num_rows == 0){
		$show_balance=false;
	}

}



if($logged_in_user){
$page_user_id = $logged_in_user['user_id'];
}else{
	die('You need to be <a href="login.php">logged in</a> to view this page.');
}


// echo $logged_in_user;

 ?>

<main class="content budget">

	<?php if($balance == '0.00'){ ?>
		<div class="balance">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>?user_id=<?php echo $user_id; ?>" method="post">
				<?php show_feedback($feedback, $errors); ?>
			 	<h2>Beginning Balance: $<?php echo $balance ?></h2>
			 	<p class="add">Add
			 		<div class="styled-input">
						<input type="number" name="add_balance" id="add_balance">
						<!-- <label for="add_balance">$</label> -->
					</div>
					to Beginning Balance
					<input type="submit" value="ADD">
					<input type="hidden" name="did_add_balance" value="1">
				</p>
			</form>
		</div>
	<?php }else{ ?>
		<div class="balance">
			<h2>Balance: $<?php echo $balance ?></h2>
			 <a href="transaction.php?user_id=<?php echo $user_id ?>">Add a Transaction</a>
			 	
			</form>
		</div>
	<?php } ?>
</main>