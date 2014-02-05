


////////////////
// Navigation //
////////////////

// Use this variable to set the breakpoint at which the menu changes.
var breakPoint = 700;


// This function uses CSS classes to change the appearance of the menu.
function adjustNav() {

	if ($(document).width() < breakPoint) {

		$("nav.main-menu").removeClass("full").addClass("compact");
		$("nav.main-menu ul").hide();
	}

	else {

		$("nav.main-menu").removeClass("compact").addClass("full");
		$("nav.main-menu ul").show();
	}
}

// When the document loads, adjust the nav and add click handlers for the
// mobile view of the menu.

$(document).ready(function () {

	adjustNav();
	countdownTimer();

	$(".menu-toggle").click(function (evt) {

		$("nav.main-menu ul").slideToggle();
		evt.preventDefault();
	});


	$(".videos article.video").on("click", function () {

		if ($(this).hasClass("checked")) {

			$(this).removeClass("checked");
		}

		else {

			$("article.video").each(function () {

				$(this).removeClass("checked");
			});

			$(this).addClass("checked");
		}
	});
	setInterval(function() { countdownTimer(); }, 1000);

});


// On window resize, reevaluate the view of the navigation.
$(window).resize(function () {

	adjustNav();
});




//Countdown Timer

function timer() {

	var target_date = new Date("April 5, 2014").getTime();
 
	var days, hours, minutes, seconds;
 
	var countdown = document.getElementById("countdown");
 
    var current_date = new Date().getTime();
    var seconds_left = (target_date - current_date) / 1000;
 
    days = parseInt(seconds_left / 86400);
    seconds_left = seconds_left % 86400;
     
    hours = parseInt(seconds_left / 3600);
    seconds_left = seconds_left % 3600;
     
    minutes = parseInt(seconds_left / 60);
    seconds = parseInt(seconds_left % 60);
     
    countdown.innerHTML = days + " " + hours + " "
    + minutes + " " + seconds + " ";  
 
}


function countdownTimer() {

	var endTime = new Date("5 April 2014");			
	endTime = (Date.parse(endTime) / 1000);

	var now = new Date();
	now = (Date.parse(now) / 1000);

	var timeLeft = endTime - now;

	var days = Math.floor(timeLeft / 86400); 
	var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
	var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
	var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

	if (hours < "10") { hours = "0" + hours; }
	if (minutes < "10") { minutes = "0" + minutes; }
	if (seconds < "10") { seconds = "0" + seconds; }

	$("#days").html(days + "<span class='countdown-label'>Days</span>");
	$("#hours").html(hours + "<span class='countdown-label'>Hours</span>");
	$("#minutes").html(minutes + "<span class='countdown-label'>Minutes</span>");
	$("#seconds").html(seconds + "<span class='countdown-label'>Seconds</span>");		

}