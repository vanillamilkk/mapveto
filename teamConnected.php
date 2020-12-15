<?php
	include 'dbConn.php';
	$mapCon = createDBConn();
	$matchID = $_POST['matchID'];
	$teamID = $_POST['teamID'];
	$teamInfo = $mapCon->query("SELECT `TeamOneID`, `TeamOneConnected`, `TeamTwoID`, `TeamTwoConnected` FROM `Matches` WHERE `TeamOneID`='$teamID' OR `TeamTwoID`='$teamID'");
	$teamInfo = $teamInfo->fetch_assoc();
	if(!empty($teamID)) {
		if($teamID == $teamInfo['TeamOneID']) {
			if(!($teamInfo['TeamOneConnected'] == 1)) {
				$updateTeam = $mapCon->query('UPDATE `Matches` SET `TeamOneConnected`="1" WHERE `MatchID`="'.$matchID.'"');
			}
		} elseif($teamID == $teamInfo['TeamTwoID']) {
			if(!($teamInfo['TeamTwoConnected'] == 1)) {
				$updateTeam = $mapCon->query('UPDATE `Matches` SET `TeamTwoConnected`="1" WHERE `MatchID`="'.$matchID.'"');
			}
		}
	}
	$mapCon->close();
?>