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
		audioElement.setTrack("assets/music/Sad Summer - 07 Caribbean Queen.mp3");
		if (play == true) {
			audioElement.play();
		}
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
					<img class="album-artwork" src="https://f4.bcbits.com/img/a1915979467_10.jpg" alt="" />
				</span>
				<div class="track-info">
					<span class="track-name"><span>Track</span></span>
					<span class="artist-name"><span>Artist</span></span>
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