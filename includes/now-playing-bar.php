<?php
	$songQuery = mysqli_query($con, "SELECT * FROM songs ORDER BY RAND() LIMIT 10");
	
	$resultArray = array();
	while ($row = mysqli_fetch_array($songQuery)) {
		array_push($resultArray, $row['id']);
	}

	$jsonArray = json_encode($resultArray);
?>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		currentPlaylist = <?php echo $jsonArray; ?>;
		audioElement = new Audio();
		setTrack(currentPlaylist[0], currentPlaylist, false);
	});

	function setTrack(trackId, newPlaylist, play) {
		const trackURL = "includes/handlers/ajax/get-song-json.php";
		const trackData = new FormData();
		trackData.append('songId', trackId);

		fetch(trackURL, { method: 'POST', body: trackData })
		.then(function (response) {
		  return response.text();
		})
		.then(function (body) {
		  const track = JSON.parse(body);

		  const trackName = document.querySelector(".track-name span"); 
		  trackName.innerHTML = track.title;

		// Nested ajax call to get artist info once track has been returned 
		const artistURL = "includes/handlers/ajax/get-artist-json.php";
		const artistData = new FormData();
		artistData.append('artistId', track.artist);

		fetch(artistURL, {method: 'POST', body: artistData})
		.then(function (response) {
		  return response.text();
		})
		.then(function (body) {
		  const artist = JSON.parse(body);

		  const artistName = document.querySelector(".artist-name span"); 
		  artistName.innerHTML = artist.name;
		});

		// Nested ajax call to get album artwork once track has been returned 
		const albumURL = "includes/handlers/ajax/get-album-json.php";
		const albumData = new FormData();
		albumData.append('albumId', track.album);
		fetch(albumURL, {method: 'POST', body: albumData})
		.then(function (response) {
		  return response.text();
		})
		.then(function (body) {
		  const album = JSON.parse(body);
		  const albumName = document.querySelector(".album-link img"); 
		  albumName.src = album.artworkPath;

		  // Play track
		  audioElement.setTrack(track.path);
		  audioElement.play();
		});

		if (play == true) {
			audioElement.play();
		}
		});
	}

	function playSong() {
		var playing = document.querySelector(".play-button");
		var paused = document.querySelector(".pause-button");
		playing.classList.add("hidden");
		paused.classList.remove("hidden");
		audioElement.play();
	}

	function pauseSong() {
		var playing = document.querySelector(".play-button");
		var paused = document.querySelector(".pause-button");
		paused.classList.add("hidden");
		playing.classList.remove("hidden");
		audioElement.pause();
	}
</script>
	
<div id="now-playing-bar-container">
	<div id="now-playing-bar">
		<div id="now-playing-left">
			<div class="content">
				<span class="album-link">
					<img class="album-artwork" src="" alt="" />
				</span>
				<div class="track-info">
					<span class="track-name"><span></span></span>
					<span class="artist-name"><span></span></span>
				</div>
			</div>	
		</div>
		<div id="now-playing-center">
			<div class="content player-controls">
				<div class="buttons">
					<button class="control-button shuffle-button" title="Shuffle Button">
						<img src="./assets/images/icons/shuffle-button.png" alt="Shuffle" />
					</button>
					<button class="control-button previous-button" title="Previous Button">
						<img src="./assets/images/icons/previous-button.png" alt="Previous" />
					</button>
					<button class="control-button play-button" title="Play Button" onclick="playSong()">
						<img src="./assets/images/icons/play-button.png" alt="Play" />
					</button>
					<button class="control-button pause-button hidden" title="Pause Button" onclick="pauseSong()">
						<img src="./assets/images/icons/pause-button.png" alt="Pause" />
					</button>
					<button class="control-button next-button" title="Next Button">
						<img src="./assets/images/icons/next-button.png" alt="Next" />
					</button>
					<button class="control-button repeat-button" title="Repeat Button">
						<img src="./assets/images/icons/repeat-button.png" alt="Repeat" />
					</button>
				</div>

				<div class="playback-bar">
					<span class="progress-time current">0.00</span>
					<div class="progress-bar">
						<div class="progress-bar-bg">
							<div class="progress"></div>
						</div>
					</div>
					<span class="progress-time remaining">0.00</span>
				</div>
			</div>
		</div>
		<div id="now-playing-right">
			<div class="volume-bar">
				<button class="control-button" title="Volume Button">
					<img src="./assets/images/icons/volume-button.png" alt="Volume" />
				</button>
				<div class="progress-bar">
					<div class="progress-bar-bg">
						<div class="progress"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>