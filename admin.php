<?php
	session_start();

	include("db_connect.php");


	if( !$_SESSION['logged_in'] ){
		header("Location: login.php");
	}

	class Review {

		public $game_name;
		public $game_review;
		public $game_rating;
		public $game_image;

		public function getName(){
			$name = $this->sanitize('game_name');
			return $name;
		}
		public function getReview(){
			$review = $this->sanitize('game_review');
			return $review;
		}
		public function getRating(){
			$rating = $this->sanitize('game_rating');
			return $rating;
		}
		public function getImage(){
			$image = $this->sanitize('game_image');
			return $image;
		}

		public function sanitize($data){
			$this->$data = strip_tags($this->$data);
			$this->$data = htmlentities($this->$data);
			return $this->$data;
		}

		function __construct($name,$review,$rating,$image){
			$this->game_name = $name;
			$this->game_review = $review;
			$this->game_rating = $rating;
			$this->game_image = $image;
		}
	}


	if( isset($_POST['submit_review']) && !empty($_POST['game_name']) && !empty($_POST['game_review']) && !empty($_POST['game_rating']) && !empty($_POST['game_image']) ) {


		/* Sanitize POST Input */

		$form_fields = ["game_name", "game_review", "game_rating", "game_image"];

		foreach ( $form_fields as $field ) {
			$_POST["$field"] = $mysqli->real_escape_string($_POST["$field"]);
		}

		$new_review = new Review($_POST['game_name'],$_POST['game_review'],$_POST['game_rating'],$_POST['game_image']);


		/* Insert Review into Database */

		/*$insert_query = "INSERT INTO a6_reviews (review_id, review_creation_date, game_name, game_review, game_rating, game_image_url, user_id)
		                 VALUES (NULL, CURRENT_TIMESTAMP, '".$_POST['game_name']."', '".$_POST['game_review']."', '".$_POST['game_rating']."', '".$_POST['game_image']."', '".$_SESSION['id']."')";
*/

        $insert_query = "INSERT INTO a6_reviews (review_id, review_creation_date, game_name, game_review, game_rating, game_image_url, user_id)
		                 VALUES (NULL, CURRENT_TIMESTAMP, '".$new_review->getName()."', '".$new_review->getReview()."', '".$new_review->getRating()."', '".$new_review->getImage()."', '".$_SESSION['id']."')";

        $mysqli->query($insert_query);


        /* Add Review to XML */

        $xml = simplexml_load_file("reviews.xml");
        $link_path = "http://sulley.cah.ucf.edu/~ja941580/dig3134/assignment06/review.php?review_id=";

        /*$game_title = $_POST['game_name'];*/
        $game_title = $new_review->getName();
        $game_link = $link_path.$mysqli->insert_id;
        $game_description = $new_review->getReview();
        /*$game_description = $_POST['game_review']; */
            
        $new_xml_review = $xml->channel->addChild("item"); 
        $new_xml_review->addChild("title",$game_title); 
        $new_xml_review->addChild("link",$game_link); 
        $new_xml_review->addChild("description",$game_description); 

        $xml->asXML('reviews.xml');
	}


	function empty_field() {

		$form_fields = ["game_name", "game_review", "game_rating", "game_image"];

		foreach ( $form_fields as $field ) {

			if ( empty($_POST["$field"]) && isset($_POST['submit_review']) ) {

				echo "<p class='error_text'>Please fill out all of the fields below</p>";
				break;
			}
		}
	}

	function review_form() {

?>
	<form action="admin.php" method="post" name="newreview" id="newreview">

		<fieldset>
			<legend>New Review</legend>
			<?php empty_field(); ?>

			<label for="game_name">Game Name</label>
			<input type="text" name="game_name" id="game_name">

			<label for="game_review">Review</label>
			<textarea name="game_review" id="game_review" form="newreview" cols="40" rows="7" maxlength="255"></textarea>

			<label for="game_rating">Rating</label>
			<select name="game_rating" id="game_rating" form="newreview">
				<option value="" selected disabled>&nbsp;</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
			</select>

			<label for="game_image">Game Image URL</label>
			<input type="url" name="game_image" id="game_image">

			<input type="submit" name="submit_review" id="submit_review" value="Submit">

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

				<?php
					if( $_SESSION['access'] == 'administrator' ) { 
						print "<h2>Edit Reviews</h2>";
					}
					else if( $_SESSION['access'] == 'reviewer' ) { 
						print "<h2>Your Reviews</h2>";
					}
				?>

				<table>
					<thead>
						<tr>
							<th>Game Image</th>
							<th>Game Name</th>
							<th>Rating</th>
							<th>Review</th>
							<th>Review Creation Date</th>
							<th>Comments</th>
							<?php
							if( $_SESSION['access'] == 'administrator' ) {
								print "<th>Delete Review</th>";
							} 
							?>
						</tr>
					</thead>
					<tbody>
						<?php

						if( $_SESSION['access'] == 'administrator' ) {

							$query = "SELECT review_id, game_name, game_review, game_rating, game_image_url, user_id,
		 									 DATE_FORMAT(review_creation_date, '%M %e, %Y %l:%i%p') AS review_creation_date
									  FROM a6_reviews";

						}
						else {
							$query = "SELECT review_id, game_name, game_review, game_rating, game_image_url, user_id,
	 									     DATE_FORMAT(review_creation_date, '%M %e, %Y') AS review_creation_date
								      FROM a6_reviews WHERE user_id = ".$_SESSION['id'];
						}

						$result = $mysqli->query($query);

							while( $row = $result->fetch_object() ){

								print "\n\t\t\t\t\t<tr>\n";
								print "\t\t\t\t\t\t<td> <img src='".$row->game_image_url."' alt='Game image for ".$row->game_name."'> </td>\n";
								print "\t\t\t\t\t\t<td class='game_name'>".$row->game_name."</td>\n";
								print "\t\t\t\t\t\t<td class='game_rating'>".$row->game_rating."</td>\n";
								print "\t\t\t\t\t\t<td>".$row->game_review."</td>\n";
								print "\t\t\t\t\t\t<td>".$row->review_creation_date."</td>\n";
								print "\t\t\t\t\t\t<td><a href='review.php?review_id=".$row->review_id."' class='comment_button'>View Comments</a></td>\n";
								if( $_SESSION['access'] == 'administrator' ) {
									print "\t\t\t\t\t\t<td><a href='delete.php?review_id=".$row->review_id."' class='delete_button'>Delete</a></td>\n";
								}
								print "\t\t\t\t\t</tr>\n";
							}
						?>
					</tbody>
				</table>

				<?php
					if( $_SESSION['access'] == 'reviewer' ) {

						review_form();
					}
				?>

			</div>

		</div>

	</body>
	<?php $mysqli->close(); ?>
</html>