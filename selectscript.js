$(function(){
	$.post("teamConnected.php", {
		matchID: matchID,
		teamID: teamID
	}, function(data, status){}, "script");
	
	$('.mapT').click(function() {
		if(canPick) {
			var map = $(this).html();
			$.post("processPicks.php",
			{
				map: map,
				matchID: matchID,
				teamID: teamID
			}, function(data, status){}, "script");
			canPick = false;
		}
	});
});


