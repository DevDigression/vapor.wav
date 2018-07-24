<?php include("./includes/header.php"); 

	if (isset($_GET['id'])) {
		$albumId = $_GET['id'];
	} else {
		header("Location: index.php");
	}

	$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE id='$albumId'");
	$album = mysqli_fetch_array($albumQuery);

	$artist = new Artist($con, $album['artist']);
	echo $album['title'] . "<br>";
	echo $artist->getName();

	// $artistId = $album['artist'];
	// $artistQuery = mysqli_query($con, "SELECT * FROM artists WHERE id='$artistId'");
	// $artist = mysqli_fetch_array($artistQuery);
?>	



<?php include("./includes/footer.php"); ?>