<?php
	session_start();

	include("db_connect.php");
	
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

				<h2>Reviews</h2>

				<table class="left_table">
					<thead>
						<tr>
							<th>Game Image</th>
							<th>Game Name</th>
							<!--<th>Game Rating</th>
							<th>Game Review</th>
							<th>Review Creation Date</th>-->
						</tr>
					</thead>
					<tbody>
						<?php

							$query = "SELECT review_id, game_name, game_review, game_rating, game_image_url, user_id,
		 									 DATE_FORMAT(review_creation_date, '%M %e, %Y') AS review_creation_date
									  FROM a6_reviews ORDER BY game_name";

							$result = $mysqli->query($query);

							while( $row = $result->fetch_object() ){

								print "\n\t\t\t\t\t<tr>\n";
								print "\t\t\t\t\t\t<td> <a href='review.php?review_id=".$row->review_id."'> <img src='".$row->game_image_url."' alt='Game image for ".$row->game_name."'> </a> </td>\n";
								/*print "\t\t\t\t\t\t<td class='game_name'>".$row->game_name."</td>\n";*/
								print "\t\t\t\t\t\t<td><a href='review.php?review_id=".$row->review_id."' class='game_name'>".$row->game_name."</a></td>\n";
								/*print "\t\t\t\t\t\t<td class='game_rating'>".$row->game_rating."</td>\n";
								print "\t\t\t\t\t\t<td>".$row->game_review."</td>\n";
								print "\t\t\t\t\t\t<td>".$row->review_creation_date."</td>\n";
								print "\t\t\t\t\t</tr>\n";*/
							}
						?>
					</tbody>
				</table>

			</div>

		</div>

	</body>
	<?php $mysqli->close(); ?>
</html>