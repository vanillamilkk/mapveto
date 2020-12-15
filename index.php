<?php
	error_reporting(E_ALL);
	include 'dbConn.php';
?>
<html !doctype="html">
	<head>
		<title>Maciel Solutions MapVote System</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="main.css" />
		<script>
			teamID = 0;
			$(function(){ updateFeed(); });
			function updateFeed(){
				$.ajax({
					url: 'getPicks.php',
					data: {teamID: teamID, matchID: matchID},
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
				if(isset($_GET['id'])) {
					$id = $_GET['id'];
					$id = explode("_", $id);
					if(isset($id[1])) {
						$teamID = $id[1];
					} else {
						$teamID = 0;
					}
					$id = $id[0];
				} else {
					$id = 0;
					$teamID = 0;
				}
				echo '<script>var matchID = "'.$id.'";</script>';
				$canPick = false;
				$teamInfo = $thisCon->query("SELECT `TeamOneID`, `TeamOneConnected`, `TeamTwoID`, `TeamTwoConnected` FROM `Matches` WHERE `TeamOneID`='$teamID' OR `TeamTwoID`='$teamID'");
				$teamInfo = $teamInfo->fetch_assoc();
				if(!empty($teamID)) {
					if($teamID == $teamInfo['TeamOneID']) {
						if($teamInfo['TeamOneConnected'] == 1) {
							die("Team already connected! Use the <a href='http://crazyman.tk/mapveto/?id=".$id."'>spectator link</a> to monitor picks");
						}
						//$updateTeam = $thisCon->query('UPDATE `Matches` SET `TeamOneConnected`="1" WHERE `MatchID`="'.$id.'"');
						$canPick = true;
						$scriptPick = true;
					} elseif($teamID == $teamInfo['TeamTwoID']) {
						if($teamInfo['TeamTwoConnected'] == 1) {
							die("Team already connected! Use the spectator link to monitor picks: http://crazyman.tk/mapveto/?id=".$id);
						}
						//$updateTeam = $thisCon->query('UPDATE `Matches` SET `TeamTwoConnected`="1" WHERE `MatchID`="'.$id.'"');
						$canPick = true;
						$scriptPick = false;
					}
				}
				$matchInfo = $thisCon->query('SELECT `TeamOne`, `TeamTwo` FROM `Matches` WHERE `MatchID`="'.$id.'"');
				$matchInfo = $matchInfo->fetch_assoc();
				if($canPick) {
					if($scriptPick) {
						echo '<script>var canPick = true;</script>';
					} else {
						echo '<script>var canPick = false;</script>';
					}
					echo '<script>var teamID = "'.$teamID.'";</script>';
					echo '<script src="selectscript.js"></script>';
				}
			?>
			<div id="header">
				Match ID: <?php echo $id; ?><br />
				<p id="teamOneP">Home Team: <?php echo $matchInfo['TeamOne']; ?></p>
				<p id="teamTwoP">Away Team: <?php echo $matchInfo['TeamTwo']; ?></p>
			</div>
			<div id="votePanels">
				<h2>Current <span id="curPick">Ban: <?php echo $matchInfo['TeamOne']; ?></span></h3>
				<table id="mapSelectTable">
					<tr><th><?php echo $matchInfo['TeamOne']; ?></th><th></th><th><?php echo $matchInfo['TeamTwo']; ?></th></tr>
					<tr><td class="teamOne"></td><td class="mapT">Bank</td><td class="teamTwo"></td></tr>
					<tr><td class="teamOne"></td><td class="mapT">Border</td><td class="teamTwo"></td></tr>
					<tr><td class="teamOne"></td><td class="mapT">Chalet</td><td class="teamTwo"></td></tr>
					<tr><td class="teamOne"></td><td class="mapT">Club House</td><td class="teamTwo"></td></tr>
					<tr><td class="teamOne"></td><td class="mapT">Coastline</td><td class="teamTwo"></td></tr>
					<tr><td class="teamOne"></td><td class="mapT">Consulate</td><td class="teamTwo"></td></tr>
					<tr><td class="teamOne"></td><td class="mapT">Kafe Dostoyevsky</td><td class="teamTwo"></td></tr>
					<tr><td class="teamOne"></td><td class="mapT">Oregon</td><td class="teamTwo"></td></tr>
					<tr><td class="teamOne"></td><td class="mapT">Skyscraper</td><td class="teamTwo"></td></tr>
				</table>
			</div>
		</div>
	</body>
	<?php $thisCon->close(); ?>
</html>