
var secondsRemaining;
var intervalHandle;

function tick(){
	// grab the h1
	var timeDisplay = document.getElementById("time");

	// turn the seconds into mm:ss
	var min = Math.floor(secondsRemaining / 60);
	var sec = secondsRemaining - (min * 60);

	//add a leading zero (as a string value) if seconds less than 10
	if (sec < 10) {
		sec = "0" + sec;
	}

	// concatenate with colon
	var message = min.toString() + ":" + sec;

	// now change the display
	timeDisplay.innerHTML = message;

	// stop is down to zero
	if (secondsRemaining === 0){
		alert("Done!");
    clearInterval(intervalHandle);
    window.open("http://homestead.test/dashboard");
	}

	//subtract from seconds remaining
	secondsRemaining--;

}

function startCountdown(time){

	secondsRemaining = time * 60;
	
	//every second, call the "tick" function
	// have to make it into a variable so that you can stop the interval later!!!
	intervalHandle = setInterval(tick, 1000);

}

window.onload = function(){
	
	var startButton = document.querySelector(".start");
	startButton.onclick = function(){
		startCountdown(0.1);
	};	

}



var request = new XMLHttpRequest();
request.open('GET', 'http://homestead.test/api/getstats', true);

request.onload = function() {
  if (request.status >= 200 && request.status < 400) {
    // Success!
	var resp = JSON.parse(request.response);
	document.getElementById('useravatar').setAttribute("src", resp.userAvatar);
	document.getElementById('useravatar').setAttribute("alt", resp.userName);
	document.getElementById('username').innerText = resp.userName;
	var totalSteps = resp.totalSteps;
	var stepsGoal = resp.stepsGoal;
	document.getElementById('data__activity--details').innerText = totalSteps + " from " + stepsGoal;
	if(totalSteps >= stepsGoal) {
		var stepsPercentage = 100;
	} else {
		// 100-(C3-B3)/100
		var stepsPercentage = 100-(stepsGoal-totalSteps)/100;
	}
	document.getElementById('data__activity--steps').style.width = stepsPercentage + "%";
	

  } else {
    // We reached our target server, but it returned an error
	console.log("We reached our target server, but it returned an error");
  }
};

request.onerror = function() {
  // There was a connection error of some sort
  console.log("There was a connection error of some sort");
};

request.send();