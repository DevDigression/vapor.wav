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
		var newPlaylist = <?php echo $jsonArray; ?>;
		audioElement = new Audio();
		setTrack(newPlaylist[0], newPlaylist, false);
		updateVolumeProgressBar(audioElement.audio);

// Prevent highlighting controls on mouse drag  
		var nowPlayingBarContainer = document.getElementById("now-playing-bar-container");
		['mousemove', 'touchmove', 'mousedown', 'touchstart'].forEach(function(event) {
  			nowPlayingBarContainer.addEventListener(event, function(e) {
  				e.preventDefault();
  			});
		});

// Playback bar functionality for dragging to certain time(s)
		var playbackbarClickStatus = document.querySelector(".playback-bar .progress-bar");
		playbackbarClickStatus.addEventListener("mousedown", function() {
			mouseDown = true;
		});

		var playbackbarDrag = document.querySelector(".playback-bar .progress-bar");
		playbackbarDrag.addEventListener("mousemove", function(event) {
			if (mouseDown == true) {
				//Set time of song depending on position of mouse
				timeFromOffset(event, this);
			}
		});

		var playbackbarDragComplete = document.querySelector(".playback-bar .progress-bar");
		playbackbarDragComplete.addEventListener("mouseup", function(event) {
			timeFromOffset(event, this);
		});

// Volume bar functionality for dragging volume level
		var volumebarClickStatus = document.querySelector(".volume-bar .progress-bar");
		volumebarClickStatus.addEventListener("mousedown", function() {
			mouseDown = true;
		});

		var volumebarDrag = document.querySelector(".volume-bar .progress-bar");
		volumebarDrag.addEventListener("mousemove", function(event) {
			if (mouseDown == true) {
				var volumePercentage = event.offsetX / volumebarDrag.offsetWidth;
				if (volumePercentage >= 0 && volumePercentage <= 1) {
					audioElement.audio.volume = volumePercentage;
				}
			}
		});

		var volumebarDragComplete = document.querySelector(".volume-bar .progress-bar");
		volumebarDragComplete.addEventListener("mouseup", function(event) {
			var volumePercentage = event.offsetX / volumebarDrag.offsetWidth;
			if (volumePercentage >= 0 && volumePercentage <= 1) {
				audioElement.audio.volume = volumePercentage;
			}
		});


		document.addEventListener('mouseup', function() {
			mouseDown = false;
		});
	});

	function timeFromOffset(mouse, progressBar) {
		var percentage = mouse.offsetX / progressBar.offsetWidth * 100;
		var seconds = audioElement.audio.duration * (percentage / 100);
		audioElement.setTime(seconds);
	}

	function previousSong() {
		// Check whether song is at least 3 seconds in, or if it is first song in playlist
		if (audioElement.audio.currentTime >= 3 || currentIndex == 0) {
			// Restart same song
			audioElement.setTime(0);
		} else {
			// Go back to previous song
			currentIndex--;
			setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
		}
	}

	function nextSong() {
		if (repeat == true) {
			audioElement.setTime(0);
			playSong();
			return;
		}

		if (currentIndex == currentPlaylist.length - 1) {
			currentIndex = 0;
		} else {
			currentIndex++;
		}

		var trackToPlay = shuffle ? shuffledPlaylist[currentIndex] : currentPlaylist[currentIndex];
		setTrack(trackToPlay, currentPlaylist, true);
	}

	function setRepeat() {
		repeat = !repeat;
		var imageName = repeat ? "repeat-button-active.png" : "repeat-button-inactive.png";

		var repeatButton = document.querySelector(".control-button.repeat-button img");
		repeatButton.src = "assets/images/icons/" + imageName;
	}

	function setMute() {
		audioElement.audio.muted = !audioElement.audio.muted;
		var volumeImage = audioElement.audio.muted ? "volume-mute-button.png" : "volume-button.png";

		var muteStatus = document.querySelector(".control-button.volume img");
		muteStatus.src = "assets/images/icons/" + volumeImage;
	}

	function setShuffle() {
		shuffle = !shuffle;
		var shuffleImage = shuffle ? "shuffle-button-active.png" : "shuffle-button-inactive.png";

		var shuffleButton = document.querySelector(".control-button.shuffle-button img");
		shuffleButton.src = "assets/images/icons/" + shuffleImage;

		if (shuffle == true) {
			// shufflePlaylist contains copy of original playlist
			randomizePlaylist(shuffledPlaylist);
			// set song currently playing to new index it gets in shuffled playlist and start from there in shuffled playlist
			currentIndex = shuffledPlaylist.indexOf(audioElement.currentlyPlaying.id);
		} else {
			// Return to unshuffled playlist, set index back to original
			currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
		}
	}

	function randomizePlaylist(playlist) {
		var index, random, temp;
		for (index = playlist.length; index; index--) {
			random = Math.floor(Math.random() * index);
			temp = playlist[index - 1];
			playlist[index - 1] = playlist[random];
			playlist[random] = temp;
		}
	}

	function setTrack(trackId, newPlaylist, play) {
		if (newPlaylist != currentPlaylist) {
			// create copy of playlist in shufflePlaylist
			currentPlaylist = newPlaylist;
			shuffledPlaylist = currentPlaylist.slice();
			randomizePlaylist(shuffledPlaylist);
		}

		if (shuffle == true) {
			currentIndex = shuffledPlaylist.indexOf(trackId);
		} else {
			currentIndex = currentPlaylist.indexOf(trackId);
		}
	
		pauseSong();

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
		  audioElement.setTrack(track);
		  if (play == true) {
			playSong();
		  }
		});

		});
	}

	function playSong() {
		if (audioElement.audio.currentTime == 0) {
		const playcountURL = "includes/handlers/ajax/update-plays.php";
		const playcountData = new FormData();
		playcountData.append('songId', audioElement.currentlyPlaying.id);

		fetch(playcountURL, { method: 'POST', body: playcountData });
		}

		const playing = document.querySelector(".play-button");
		const paused = document.querySelector(".pause-button");
		playing.classList.add("hidden");
		paused.classList.remove("hidden");
		audioElement.play();
	}

	function pauseSong() {
		const playing = document.querySelector(".play-button");
		const paused = document.querySelector(".pause-button");
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
					<button class="control-button shuffle-button" title="Shuffle Button" onclick="setShuffle()">
						<img src="./assets/images/icons/shuffle-button-inactive.png" alt="Shuffle" />
					</button>
					<button class="control-button previous-button" title="Previous Button" onclick="previousSong()">
						<img src="./assets/images/icons/previous-button.png" alt="Previous" />
					</button>
					<button class="control-button play-button" title="Play Button" onclick="playSong()">
						<img src="./assets/images/icons/play-button.png" alt="Play" />
					</button>
					<button class="control-button pause-button hidden" title="Pause Button" onclick="pauseSong()">
						<img src="./assets/images/icons/pause-button.png" alt="Pause" />
					</button>
					<button class="control-button next-button" title="Next Button" onclick="nextSong()">
						<img src="./assets/images/icons/next-button.png" alt="Next" />
					</button>
					<button class="control-button repeat-button" title="Repeat Button" onclick="setRepeat()">
						<img src="./assets/images/icons/repeat-button-inactive.png" alt="Repeat" />
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
				<button class="control-button volume" title="Volume Button" onclick="setMute()">
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