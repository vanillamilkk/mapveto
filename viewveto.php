<?php
	include 'dbConn.php';
?>
<html !doctype="html">
	<head>
		<title>KCMLCUP - Map Veto</title>
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
			<table>
				<tr id="maps">
					<td id="one"></td>
					<td id="three"></td>
					<td id="five"></td>
                </tr>
                <tr id="none">
                    <td id="none">⠀</td>
                </tr>
                <tr id="teams">
                <?php
						for($i=0; $i < 3; $i++) {
								echo '<td>'.$matchInfo['TeamOne'].'</td>';
                        }?>
                </tr>
                <tr id="none">
                    <td id="none">⠀</td>
                </tr>
                <tr id="maps">
                    <td id="none"></td>
                    <td id="seven"></td>
                    <td id="none"></td>
                </tr>
                <tr id="none">
                    <td id="none">⠀</td>
                </tr>
                <tr id="none">
                    <td id="none">⠀</td>
                </tr>
                <tr id="maps">
					<td id="two"></td>
					<td id="four"></td>
					<td id="six"></td>
				</tr>
				<tr id="none">
                    <td id="none">⠀</td>
                </tr>
				<tr id="teams">
                    <?php
						for($i=0; $i < 3; $i++) {
								echo '<td>'.$matchInfo['TeamTwo'].'</td>';
                        }?>
				</tr>
			</table>
		</div>
	</body>
</html>
