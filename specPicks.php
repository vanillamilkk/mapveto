<?php
	include 'dbConn.php';
	$mapCon = createDBConn();
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
		if($tmap == "Club House") {
			$tmap = "clubhouse";
			$mapname = "Club House";
		} else if($tmap == "Kafe Dostoyevsky") {
			$tmap = "kafe";
			$mapname = "Kafe Dostoyevsky";
		} else {
			$mapname = $tmap;
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
		if($key=="BanOne") {
			echo '$("#one").attr("id", "'.$tmap.'");';
			echo '$("#'.$tmap.'").addClass("'.$pickType.'");';
			echo '$("#'.$tmap.'").html("'.$mapname.'");';
		}
		if($key=="BanTwo") {
			echo '$("#two").attr("id", "'.$tmap.'");';
			echo '$("#'.$tmap.'").addClass("'.$pickType.'");';
			echo '$("#'.$tmap.'").html("'.$mapname.'");';
		}
		if($key=="BanThree") {
			echo '$("#three").attr("id", "'.$tmap.'");';
			echo '$("#'.$tmap.'").addClass("'.$pickType.'");';
			echo '$("#'.$tmap.'").html("'.$mapname.'");';
		}
		if($key=="BanFour") {
			echo '$("#four").attr("id", "'.$tmap.'");';
			echo '$("#'.$tmap.'").addClass("'.$pickType.'");';
			echo '$("#'.$tmap.'").html("'.$mapname.'");';
		}
		if($key=="BanFive") {
			echo '$("#five").attr("id", "'.$tmap.'");';
			echo '$("#'.$tmap.'").addClass("'.$pickType.'");';
			echo '$("#'.$tmap.'").html("'.$mapname.'");';
		}
		if($key=="BanSix") {
			echo '$("#six").attr("id", "'.$tmap.'");';
			echo '$("#'.$tmap.'").addClass("'.$pickType.'");';
			echo '$("#'.$tmap.'").html("'.$mapname.'");';
		}
		if($key=="BanPickOne") {
			echo '$("#seven").attr("id", "'.$tmap.'");';
			echo '$("#'.$tmap.'").addClass("'.$pickType.'");';
			echo '$("#'.$tmap.'").html("'.$mapname.'");';
		}
		if($key=="BanPickTwo") {
			echo '$("#eight").attr("id", "'.$tmap.'");';
			echo '$("#'.$tmap.'").addClass("'.$pickType.'");';
			echo '$("#'.$tmap.'").html("'.$mapname.'");';
		}
		if($key=="BanPickThree") {
			echo '$("#nine").attr("id", "'.$tmap.'");';
			echo '$("#'.$tmap.'").addClass("'.$pickType.'");';
			echo '$("#'.$tmap.'").html("'.$mapname.'");';
		}
	}
	$mapCon->close();
?>