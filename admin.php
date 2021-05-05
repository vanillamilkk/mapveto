<?php
	error_reporting(E_ALL);
	include 'dbConn.php';
	include 'discord2.php';

	$alreadySet = false;
	
	if(isset($_POST['password'])) {
		$theirPass = $_POST['password'];
		$properPass = "password";
		
		if($theirPass == $properPass || $theirPass == "1234") {
			if(isset($_POST['teamOneName']) && isset($_POST['teamTwoName'])) {
				$teamCon = createDBConn();
				$alreadySet = true;
				$teamOne = mysqli_real_escape_string($teamCon, $_POST['teamOneName']);
				$teamTwo = mysqli_real_escape_string($teamCon, $_POST['teamTwoName']);
				$matchID = hash('crc32', $teamOne . $teamTwo . uniqid());
				$matchType = mysqli_real_escape_string($teamCon, $_POST['matchType']);
				$adminName = mysqli_real_escape_string($teamCon, $_POST['adminName']);
				$teamOneID = hash('crc32', $teamOne . uniqid());
				$teamTwoID = hash('crc32', $teamTwo . uniqid());
				
				if($teamCon->query(
					"INSERT INTO Matches (AdminName, MatchID, MatchType, PickID, TeamOne, TeamOneID, TeamTwo, TeamTwoID)
					VALUES('$adminName', '$matchID', '$matchType', '$teamOneID', '$teamOne', '$teamOneID', '$teamTwo', '$teamTwoID')") === TRUE) {
					$linkbase = "https://kcml.my.id/kcmlcup/mapveto/?id=".$matchID;
					$teamOneLink = $linkbase."_".$teamOneID;
					$teamTwoLink = $linkbase."_".$teamTwoID;
					sendDiscord();
				} else {
					echo $teamCon->error;
				}
			}
		}
	}
?>
<html !doctype="html">
	<head>
		<title>KCMLcup - Admin</title>
	</head>
	<body>
		<?php
		if(!$alreadySet) {
		?>
			<form method="post" action="">
				<input type="text" placeholder="Admin Name" name="adminName" required>
				<input type="password" placeholder="Password" name="password" required><br><br>
				<input type="text" placeholder="Home Team" name="teamOneName" required>
				<input type="text" placeholder="Away Team" name="teamTwoName" required>
				<select name="matchType" required>
					<option value="BO3">Best of 3</option>
					<option value="BO1">Best of 1</option>
				</select>
				<input type="Submit">
			</form>
		<?php
		} else {
			echo "LINK untuk Team ".$teamOne.": ".$teamOneLink."<br />";
			echo "LINK untuk Team ".$teamTwo.": ".$teamTwoLink."<br />";
			echo "LINK untuk caster/spectator: ".$linkbase."<br />";
			echo "LINK server: https://kcml.my.id/kcmlcup/mapveto/viewveto.php?id=".$matchID;
		}
		?>
	</body>
</html>
