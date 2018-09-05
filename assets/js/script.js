var currentPlaylist = [];
var shuffledPlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;

function renderPage(url) {
	// If no query marker (?) in url, add one
	if (url.indexOf("?") == -1) {
		url = url + "?";
	}

	// encodeURI converts characters into URL-friendly chars
	// (eg, Dev Digression -> Dev%20Digression)
	var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);

	$("#main-content").load(encodedUrl);
	// fetch(encodedUrl)
	// 	.then(function(response) {
	// 		return response.text();
	// 	})
	// 	.then(function(body) {
	// 		console.log(body);
	// 		var pageContent = document.getElementById("main-content");
	// 		pageContent.innerHTML = body;
	// 	});
}

function formatTime(seconds) {
	var time = Math.round(seconds);
	var minutes = Math.floor(time / 60);
	var seconds = time - minutes * 60;

	var extraZero = seconds < 10 ? "0" : "";

	return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
	var current = document.querySelector(".progress-time.current");
	current.textContent = formatTime(audio.currentTime);
	var remaining = document.querySelector(".progress-time.remaining");
	remaining.textContent = formatTime(audio.duration - audio.currentTime);

	var percentComplete = audio.currentTime / audio.duration * 100;
	var progress = document.querySelector(".playback-bar .progress");
	progress.style.width = percentComplete + "%";
}

function updateVolumeProgressBar(audio) {
	var volumeLevel = audio.volume * 100;
	var volume = document.querySelector(".volume-bar .progress");
	volume.style.width = volumeLevel + "%";
}

function Audio() {
	this.currentlyPlaying;
	this.audio = document.createElement("audio");

	this.audio.addEventListener("ended", function() {
		nextSong();
	});

	this.audio.addEventListener("canplay", function() {
		var duration = formatTime(this.duration);
		var remainingTime = document.querySelector(".progress-time.remaining");
		remainingTime.textContent = duration;
	});

	this.audio.addEventListener("timeupdate", function() {
		if (this.duration) {
			updateTimeProgressBar(this);
		}
	});

	this.audio.addEventListener("volumechange", function() {
		updateVolumeProgressBar(this);
	});

	this.setTrack = function(track) {
		this.currentlyPlaying = track;
		this.audio.src = track.path;
	};

	this.play = function() {
		this.audio.play();
	};

	this.pause = function() {
		this.audio.pause();
	};

	this.setTime = function(seconds) {
		this.audio.currentTime = seconds;
	};
}
