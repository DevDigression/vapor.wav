<?php 
include("includes/config.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");

// code to manually log out - uncomment below to log out
// session_destroy();

if (isset($_SESSION['userLoggedIn'])) {
	$userLoggedIn = $_SESSION['userLoggedIn'];
	echo "<script>userLoggedIn = '$userLoggedIn';</script>";
} else {
	header("Location: register.php");
}

?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>V A P O R . w a v</title>
	<link rel="stylesheet" href="./assets/css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="assets/js/script.js"></script>
</head>
<body>
	<div id="dashboard-container">
		<div id="top-section-container">
			<?php include("./includes/navbar-container.php"); ?>

			<div id="main-view-container">
				<div id="main-content">