<?php

	// If url received as ajax request (user clicked logo to change page)
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
		include("includes/config.php");
		include("includes/classes/Artist.php");
		include("includes/classes/Album.php");
		include("includes/classes/Song.php");
	} 
	// url in typed manually
	else {
		include("includes/header.php");
		include("includes/footer.php");

		$url = $_SERVER['REQUEST_URI'];
		echo "<script>renderPage('$url')</script>";
		exit();
	}

?>