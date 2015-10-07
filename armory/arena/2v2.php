<?php
// 2vs2 team
include'../config/connect.php';

$conv11 = strtolower($_POST["serchTxt"]); // all to lower
$CHAR_NAME = ucfirst ( $conv11 ); // 1-st letter capital

$teamConn = new mysqli($servername, $username, $password, $db_char);
$sql_find_char = "SELECT guid FROM characters WHERE name='" .$CHAR_NAME. "'";
$result_name = $teamConn->query($sql_find_char);
if($result_name){
	foreach($result_name as $row_name){
		$CHAR_GUID = $row_name["guid"];
	}
}
$sql = "SELECT arenaTeamId,weekGames,weekWins,seasonGames,seasonWins,personalRating FROM arena_team_member WHERE guid='" . $CHAR_GUID ."'"; // get this member
$result = $teamConn->query($sql);
if($result){
	foreach($result as $row){
		$S2TEAMID = $row["arenaTeamId"];
		$sql2= "SELECT name,captainGuid,rating,seasonGames,seasonWins,weekGames,weekWins,rank FROM arena_team WHERE arenaTeamId='" . $S2TEAMID . "' AND type='2'"; // get arena team of this member
		$result2 = $teamConn->query($sql2);
		if($result2){
			foreach($result2 as $row2){
				// PLAYER DATA
				$S2TEAM_ID = $row["arenaTeamId"];
				$S2PLR_WEEK_GAMES = $row["weekGames"];
				$S2PLR_WEEK_WINS = $row["weekWins"];
				$S2PLR_SEASON_GAMES = $row["seasonGames"];
				$S2PLR_SEASON_WINS = $row["seasonWins"];
				$S2PLR_PERSONAL_RATING = $row["personalRating"];
				// TEAM DATA
				$S2TEAM_NAME = $row2["name"];
				$sql3 = "SELECT name FROM characters WHERE guid='" . $row2["captainGuid"] . "'";
				$result3=$teamConn->query($sql3);
				if($result3){
					foreach($result3 as $row3){
						$S2TEAM_CAPITAN_NAME = $row3["name"];
					}
				}				
				$S2TEAM_RATING = $row2["rating"];
				$S2TEAM_SEASON_GAMES = $row2["seasonGames"];
				$S2TEAM_SEASON_WINS = $row2["seasonWins"];
				$S2TEAM_WEEK_GAMES = $row2["weekGames"];
				$S2TEAM_WEEK_WINS = $row2["weekWins"];
				$S2TEAM_RANK = $row2["rank"];
			}
		}
	}
}
$teamConn->close();
?>