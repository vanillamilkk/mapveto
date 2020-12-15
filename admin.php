<?php
	error_reporting(E_ALL);
	include 'dbConn.php';

	$alreadySet = false;
	
	if(isset($_POST['password'])) {
		$theirPass = $_POST['password'];
		$properPass = "se^G2uArPyQ2NWhs";
		
		if(/*$theirPass == $properPass ||*/ $theirPass == "tempCCSPass" /*|| $theirPass == "wildRedFlamingo"*/) {
			if(isset($_POST['teamOneName']) && isset($_POST['teamTwoName'])) {
				$teamCon = createDBConn();
				$alreadySet = true;
				$teamOne = mysqli_real_escape_string($teamCon, $_POST['teamOneName']);
				$teamTwo = mysqli_real_escape_string($teamCon, $_POST['teamTwoName']);
				$matchID = uniqid();
				$matchType = mysqli_real_escape_string($teamCon, $_POST['matchType']);
				$adminName = mysqli_real_escape_string($teamCon, $_POST['adminName']);
				$teamOneID = uniqid();
				$teamTwoID = uniqid();
				
				if($teamCon->query(
					"INSERT INTO Matches (AdminName, MatchID, MatchType, PickID, TeamOne, TeamOneID, TeamTwo, TeamTwoID)
					VALUES('$adminName', '$matchID', '$matchType', '$teamOneID', '$teamOne', '$teamOneID', '$teamTwo', '$teamTwoID')") === TRUE) {
					$linkbase = "http://crazyman.tk/mapveto/?id=".$matchID;
					$teamOneLink = $linkbase."_".$teamOneID;
					$teamTwoLink = $linkbase."_".$teamTwoID;
				} else {
					echo $teamCon->error;
				}
			}
		}
	}
?>
<html !doctype="html">
	<head>
		<title>Maciel Solutions MapVote Admin</title>
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
					<option value="BO5">Best of 5</option>
					<option value="BO1">Best of 1</option>
				</select>
				<input type="Submit">
			</form>
		<?php
		} else {
			echo "Give this link to ".$teamOne.": ".$teamOneLink."<br />";
			echo "Give this link to ".$teamTwo.": ".$teamTwoLink."<br />";
			echo "This link can be used for watching the ban process: ".$linkbase."<br />";
			echo "This is the link should be given to the broadcaster before the teams get their links: http://crazyman.tk/mapveto/viewveto.php?id=".$matchID;
		}
		?>
	</body>
</html>