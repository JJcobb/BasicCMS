<header>
	<div class="site_title">
		<h1>Classic Game Review</h1>
	</div>

	<div class="user_header">

		<nav>
			<a href="reviews.php">All Reviews</a>

			<a href="admin.php"><?php
									if( isset($_SESSION['access']) ) {
										if( $_SESSION['access'] == 'administrator' ) { 
											print "Edit Reviews";
										}
										else if( $_SESSION['access'] == 'reviewer' ) { 
											print "My Reviews";
										}
									}
								?>
			</a>
		</nav>

		<p>Welcome, <?php
						if( isset($_SESSION['user']) ) {
							echo $_SESSION['user'];
						}
						else {
							echo "Guest";
						}
					?>
		</p>

		<a href="logout.php" class="logout"><?php 
												if( isset($_SESSION['logged_in']) ) {
													if( $_SESSION['logged_in'] ) { 
														print "Logout";
													}
													else if( !$_SESSION['logged_in'] ) { 
														print "Login";
													}
												}
												else {
													print "Login";
												}
											?>
		</a>
	</div>
</header>