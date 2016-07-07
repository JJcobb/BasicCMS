<?php
	session_start();

	if(isset($_SESSION['logged_in'])) {
		unset($_SESSION['logged_in']);
	}
	
	if(isset($_SESSION['user'])) {
		unset($_SESSION['user']);
	}

	if(isset($_SESSION['id'])) {
		unset($_SESSION['id']);
	}

	if(isset($_SESSION['access'])) {
		unset($_SESSION['access']);
	}
	
	header("Location: login.php");
?>