<?php
	session_start();

	include("db_connect.php");
	
	if( isset($_POST['submit']) && !isset($_SESSION['logged_in']) ) {

		$query = "SELECT * FROM a5_users";

		$result = $mysqli->query($query);
		
		while( $row = $result->fetch_object() ) {

			if ( ( ($_POST['username']) == ($row->username) ) && ( md5(($_POST['password'])) == ($row->password) ) ) {

				$_SESSION['logged_in'] = true;
				$_SESSION['user'] = $row->first_name." ".$row->last_name;
				$_SESSION['id'] = $row->user_id;
				$_SESSION['access'] = $row->access_level;
			}
		}
	}
	
	if ( isset($_SESSION['logged_in']) ) {
		header("Location: admin.php");
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

		<!--<header>
			<h1>Classic Game Review</h1>
		</header>-->

		<?php require('header.php'); ?>

		<div class="container">

			<div class="content">
				<form action="login.php" method="post" name="myForm" id="myForm">
					<fieldset>
						<legend>Login</legend>

						<label for="username">Username</label>
						<input type="text" name="username" id="username" />

						<label for="password">Password</label>
						<input type="password" name="password" id="password" />

						<input type="submit" id="submit" name="submit" value="Login">
					</fieldset>
				</form>
			</div>

		</div>

	</body>
	<?php $mysqli->close(); ?>
</html>