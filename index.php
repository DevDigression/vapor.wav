<?php 
include("includes/config.php");

// code to manually log out - uncomment below to log out
// session_destroy()

if (isset($_SESSION['userLoggedIn'])) {
	$userLoggedIn = $_SESSION['userLoggedIn'];
} else {
	header("Location: register.php");
}

?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>V A P O R . w a v</title>
</head>
<body>
	<h1>A E S T H E T I C</h1>
</body>
</html>