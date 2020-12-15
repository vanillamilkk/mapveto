<?php
	include 'dbConn.php';
?>
<html !doctype="html">
	<head>
		<title>CCS MapVote System</title>
		<link rel="stylesheet" type="text/css" href="spectate.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script>
			teamID = 0;
			$(function(){ updateFeed(); });
			function updateFeed(){
				$.ajax({
					url: 'specPicks.php',
					data: {matchID: matchID},
					type: 'POST',
					success: function(response){
						eval(response);
						setTimeout(updateFeed,1000);
					}
				});
			}
		</script>
	</head>
	<body>
		<div id="wrapper">
			<?php
				$thisCon = createDBConn();
				$id = $_GET['id'];
				echo '<script>var matchID = "'.$id.'";</script>';
				$matchInfo = $thisCon->query('SELECT `TeamOne`, `TeamTwo` FROM `Matches` WHERE `MatchID`="'.$id.'"');
				$matchInfo = $matchInfo->fetch_assoc();
			?>
			<h1><?php echo $matchInfo['TeamOne']." vs ".$matchInfo['TeamTwo']; ?></h1>
			<table>
				<tr id="maps">
					<td id="one"></td>
					<td id="two"></td>
					<td id="three"></td>
					<td id="four"></td>
					<td id="five"></td>
					<td id="six"></td>
					<td id="seven"></td>
					<td id="eight"></td>
					<td id="nine"></td>
				</tr>
				<tr id="teams">
					<?php
						for($i=0; $i < 8; $i++) {
							if(($i % 2) == 0) {
								echo '<td>'.$matchInfo['TeamOne'].'</td>';
							} else {
								echo '<td>'.$matchInfo['TeamTwo'].'</td>';
							}
						}
					?>
				</tr>
			</table>
		</div>
	</body>
</html>