<?php
	session_start();

	include("db_connect.php");
	
	if( !$_SESSION['logged_in'] ){
		header("Location: login.php");
	}

	if( isset($_POST['delete']) && isset($_GET['review_id']) && ($_SESSION['access'] == 'administrator') ) {

		$delete_query = "DELETE FROM a6_reviews WHERE review_id = '".$_GET['review_id']."'";

		$mysqli->query($delete_query);

		header('Location: admin.php');
	}
	else if ( isset($_POST['go_back']) ) {

		header('Location: admin.php');
	}

?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Basic CMS &ndash; Jacob Vogelbacher</title>
		<style> 
			@import url("css/reset.css");
			@import url("css/styles.css");
		</style>
	</head>
	<body>

		<?php require('header.php'); ?>

		<div class="container">

			<div class="content">

				<h2>Delete Review</h2>

				<table>
					<thead>
						<tr>
							<th>Game Image</th>
							<th>Game Name</th>
							<th>Rating</th>
							<th>Review</th>
							<th>Review Creation Date</th>
						</tr>
					</thead>
					<tbody>
						<?php

							$query = "SELECT review_id, game_name, game_review, game_rating, game_image_url, user_id,
		 									 DATE_FORMAT(review_creation_date, '%M %e, %Y %l:%i%p') AS review_creation_date
									  FROM a6_reviews WHERE review_id = ".$_GET['review_id'];

							$result = $mysqli->query($query);

							while( $row = $result->fetch_object() ){

								print "\n\t\t\t\t\t<tr>\n";
								print "\t\t\t\t\t\t<td> <img src='".$row->game_image_url."' alt='Game image for ".$row->game_name."'> </td>\n";
								print "\t\t\t\t\t\t<td class='game_name'>".$row->game_name."</td>\n";
								print "\t\t\t\t\t\t<td class='game_rating'>".$row->game_rating."</td>\n";
								print "\t\t\t\t\t\t<td>".$row->game_review."</td>\n";
								print "\t\t\t\t\t\t<td>".$row->review_creation_date."</td>\n";
								print "\t\t\t\t\t</tr>\n";
							}
						?>
					</tbody>
				</table>

				<form method="post" action="delete.php?review_id=<?php print $_GET['review_id']; ?>">
					<fieldset>
						<legend>Delete</legend>

						<p>Are you sure you want to delete this review?</p>

						<div class="delete_box">
							<input type="submit" name="delete" id="delete" value="Yes">
							<input type="submit" name="go_back" id="go_back" value="No">
						</div>

					</fieldset>
				</form>

			</div>

		</div>

	</body>
	<?php $mysqli->close(); ?>
</html>