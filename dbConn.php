<?php
	function createDBConn() {
		$dbUser = 'matchAdmin';
		$dbPass = '7PaPx1xML0waQQjO';
		$dbName = 'Matches';
		$mysqli = new mysqli('localhost', $dbUser, $dbPass, $dbName);
		if($mysqli->connect_error) {
			die('Connection error. '.$mysqli->connect_errno . $mysqli->connect_error);
		} else {
			return $mysqli;
		}
	}
?>