<?php
	include 'dbConn.php';
	$mapCon = createDBConn();
	$pickType = "banned";
	if($_POST['teamID'] != 0) {
		$teamID = $_POST['teamID'];
	}
	$matchID = $_POST['matchID'];
	$checkMap = $mapCon->query(
		"SELECT BanOne, BanTwo, BanThree, BanFour, BanFive, BanSix, BanPickOne, BanPickTwo, BanPickThree 
		FROM `Matches` 
		WHERE MatchID = '$matchID'"
	);
	$checkMatchType = $mapCon->query(
		"SELECT MatchType FROM Matches WHERE MatchID = '$matchID'"
	);
	$checkMatchType = $checkMatchType->fetch_assoc();
	$matchType = $checkMatchType['MatchType'];
	$checkMap = $checkMap->fetch_assoc();
	foreach($checkMap as $key => $tmap) {
		if(empty($tmap)) {
			break;
		}
		if($matchType=="BO3" || $matchType=="BO5") {
			if(strstr($key, "Pick")) {
				$pickType = "picked";
			} else if($key=="BanFive" || $key=="BanSix") {
				$pickType="picked";
			} else {
				$pickType = "banned";
			}
		} else {
			if($key=="BanPickThree") {
				$pickType = "picked";
			} else {
				$pickType = "banned";
			}
		}
		echo '$("td:contains('.$tmap.')").removeClass("mapT");';
		echo '$("td:contains('.$tmap.')").addClass("'.$pickType.'");';
		if($key == "BanOne" || $key == "BanThree" || $key == "BanFive" || $key == "BanPickOne") {
			echo '$("td:contains('.$tmap.')").prev().html("'.$pickType.'");';
		} elseif($key != "BanPickThree") {
			echo '$("td:contains('.$tmap.')").next().html("'.$pickType.'");';
		}
	}
	if($_POST['teamID'] != 0) {
		$changeTeam = $mapCon->query(
			"SELECT PickID, TeamOne, TeamTwo, TeamOneID, TeamTwoID FROM Matches WHERE MatchID = '$matchID'"
		);
		$changeTeam = $changeTeam->fetch_assoc();
		$checkMap = $mapCon->query(
			"SELECT BanOne, BanTwo, BanThree, BanFour, BanFive, BanSix, BanPickOne, BanPickTwo, BanPickThree 
			FROM `Matches` 
			WHERE MatchID = '$matchID'"
		);
		$checkMatchType = $mapCon->query(
			"SELECT MatchType FROM Matches WHERE MatchID = '$matchID'"
		);
		$checkMatchType = $checkMatchType->fetch_assoc();
		$matchType = $checkMatchType['MatchType'];
		$checkMap = $checkMap->fetch_assoc();
		echo "console.log('$matchType');";
		foreach($checkMap as $key => $tmap) {
			if(empty($tmap)) {
				break;
			}
			if($matchType=="BO3" || $matchType=="BO5") {
				if(strstr($key, "Pick")) {
					$pickType = "picked";
				} else if($key=="BanFive" || $key=="BanSix") {
					$pickType="picked";
				} else {
					$pickType = "banned";
				}
			} else {
				if($key=="BanPickThree") {
					$pickType = "picked";
				} else {
					$pickType = "banned";
				}
			}
		}
		$bootbox = 
			'if(bootboxB) {
				bootbox.prompt({
					title: "Select starting side:",
					inputType: "select",
					inputOptions: [
						{
							text: "Offense",
							value: "offense",
						},
						{
							text: "Defense",
							value: "defense",
						}
					],
					callback: function (result) {
						console.log(result);
					}
				});
				bootboxB = false;
			};';
		if($changeTeam['PickID'] == $teamID) {
			echo 'canPick = true;';
		}
		echo 'console.log("'.$pickType.'");';
		if($pickType == "banned") {
			if($changeTeam['TeamOneID'] == $changeTeam['PickID']) {
				echo '$("#curPick").html("Pick: '.$changeTeam['TeamOne'].'");';
			}
			if($changeTeam['TeamTwoID'] == $changeTeam['PickID']) {
				echo '$("#curPick").html("Pick: '.$changeTeam['TeamTwo'].'");';
			}
		} else {
			if($changeTeam['TeamOneID'] == $changeTeam['PickID']) {
				echo '$("#curPick").html("Pick: '.$changeTeam['TeamOne'].'");';
			}
			if($changeTeam['TeamTwoID'] == $changeTeam['PickID']) {
				echo '$("#curPick").html("Pick: '.$changeTeam['TeamTwo'].'");';
			}
		}
	}
	$mapCon->close();
?>