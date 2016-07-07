<?php
	session_start();

	include("db_connect.php");
	
	if( !isset($_SESSION['logged_in']) ){
		$_SESSION['logged_in'] = false;
	}

	if( isset($_POST['submit_comment']) && !empty($_POST['comment']) && isset($_GET['review_id']) && $_SESSION['logged_in'] && isset($_SESSION['id']) ) {

		$_POST['comment'] = $mysqli->real_escape_string($_POST['comment']);

		$new_comment_query = "INSERT INTO a6_comments(comment_id, comment_creation_date, comment, review_id, user_id)
						  VALUES (NULL, CURRENT_TIMESTAMP, '".$_POST['comment']."', '".$_GET['review_id']."', '".$_SESSION['id']."')";

		$mysqli->query($new_comment_query);

		header('Location: reviews.php');
	}


function empty_comment() {

		if ( empty($_POST["comment"]) && isset($_POST['submit_comment']) ) {

			echo "<p class='error_text'>Please enter a comment</p>";
		}
	}


function comment_form() {

?>
	<form action="review.php?review_id=<?php print $_GET['review_id']; ?>" method="post" name="newcomment" id="newcomment">

		<fieldset>
			<legend>New Comment</legend>
			<?php empty_comment(); ?>

			<textarea name="comment" id="comment" form="newcomment" cols="40" rows="7" maxlength="255"></textarea>

			<input type="submit" name="submit_comment" id="submit_comment" value="Submit">

		</fieldset>
	</form>
<?php
	} // END of review_form

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

				<h3><a href="reviews.php">&#9664; All Reviews</a></h3>

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
							if( isset($_SESSION['access']) ) {

								if( $_SESSION['access'] == 'administrator' ) {
									$reviews_query = "SELECT review_id, game_name, game_review, game_rating, game_image_url, user_id,
				 									  DATE_FORMAT(review_creation_date, '%M %e, %Y %l:%i%p') AS review_creation_date
											          FROM a6_reviews WHERE review_id = ".$_GET['review_id'];
								}
								else if( $_SESSION['access'] == 'reviewer' ) {
									$reviews_query = "SELECT review_id, game_name, game_review, game_rating, game_image_url, user_id,
				 									  DATE_FORMAT(review_creation_date, '%M %e, %Y') AS review_creation_date
											          FROM a6_reviews WHERE review_id = ".$_GET['review_id'];
								}
							}
							else{
								$reviews_query = "SELECT review_id, game_name, game_review, game_rating, game_image_url, user_id,
			 									  DATE_FORMAT(review_creation_date, '%M %e, %Y') AS review_creation_date
										          FROM a6_reviews WHERE review_id = ".$_GET['review_id'];
								}

							$reviews_result = $mysqli->query($reviews_query);

							while( $row = $reviews_result->fetch_object() ){

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

				<h2>Comments</h2>

				<table class="left_table">
					<thead>
						<tr>
							<th>Posted By</th>
							<!--<th>Date</th>-->
							<th>Comment</th>
						</tr>
					</thead>
					<tbody>
						<?php

							$comments_query = "SELECT c.review_id, c.user_id, c.comment, u.last_name, u.first_name,
		 									 DATE_FORMAT(c.comment_creation_date, '%M %e, %Y %l:%i%p') AS new_comment_creation_date
									  FROM a6_comments c, a6_users u WHERE u.user_id = c.user_id AND c.review_id = ".$_GET['review_id']." ORDER BY c.comment_creation_date";


							$comments_result = $mysqli->query($comments_query);

							while( $row = $comments_result->fetch_object() ){

								print "\n\t\t\t\t\t<tr>\n";
								print "\t\t\t\t\t\t<td><p class='commenter_name'>".$row->first_name." ".$row->last_name."</p> <br> <span>".$row->new_comment_creation_date."</span> </td>\n";
								print "\t\t\t\t\t\t<td>".$row->comment."</td>\n";
								print "\t\t\t\t\t</tr>\n";
							}


							/*$comments_query = "SELECT review_id, user_id, comment,
		 									 DATE_FORMAT(comment_creation_date, '%M %e, %Y %l:%i%p') AS new_comment_creation_date
									  FROM a6_comments WHERE review_id = ".$_GET['review_id']." ORDER BY comment_creation_date";

							$comments_result = $mysqli->query($comments_query);

							while( $row = $comments_result->fetch_object() ){

								print "\n\t\t\t\t\t<tr>\n";
								print "\t\t\t\t\t\t<td>".$row->new_comment_creation_date."</td>\n";
								print "\t\t\t\t\t\t<td>".$row->comment."</td>\n";
								print "\t\t\t\t\t</tr>\n";
							}*/

						?>
					</tbody>
				</table>

				<?php
					if( $_SESSION['logged_in'] ) {

						comment_form();
					}
				?>

			</div>

		</div>

	</body>
	<?php $mysqli->close(); ?>
</html>