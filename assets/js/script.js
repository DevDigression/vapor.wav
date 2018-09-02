var currentPlaylist = [];
var audioElement;
var mouseDown = false;

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

function Audio() {
	this.currentlyPlaying;
	this.audio = document.createElement("audio");

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
