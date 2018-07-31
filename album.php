<?php include("./includes/header.php"); 

	if (isset($_GET['id'])) {
		$albumId = $_GET['id'];
	} else {
		header("Location: index.php");
	}

	$album = new Album($con, $albumId);
	$artist = $album->getArtist();
?>	

<div class="entity-info">
	<div class="left-section">
		<img src="<?php echo $album->getArtworkPath(); ?>" alt="Album Artwork" />
	</div>
	<div class="right-section">
		<h2><?php echo $album->getTitle(); ?></h2>
		<p>By <?php echo $artist->getName(); ?></p>
		<p><?php echo $album->getNumberOfSongs(); ?> songs</p>
	</div>
</div>
<div class="track-list-container">
	<ul class="track-list">
		<?php 
			$songIdArray = $album->getSongIds();

			$i = 1;
			foreach($songIdArray as $songId) {
				$albumSong = new Song($con, $songId);
				$albumArtist = $albumSong->getArtist();
				echo "<li class='track-list-row'>
					<div class='track-count'>
						<img class='song-play' src='assets/images/icons/play-button.png' />
						<span class='track-number'>$i</span>
					</div>
					<div class='track-info'>
						<span class='track-name'>" . $albumSong->getTitle() . "</span>
						<span class='artist-name'>" . $albumArtist->getName() . "</span>
					</div>
					<div class='track-options'>
						<img class='options-button' src='assets/images/icons/more-button.png' />
					</div>
					<div class='track-duration'>
						<span class='duration'>" . $albumSong->getDuration() . "</span>
					</div>
				</li>";

			$i++;
			} 
		?>
	</ul>
</div>

<?php include("./includes/footer.php"); ?>