<?php
// 5vs5 team
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
		$S5TEAMID = $row["arenaTeamId"];
		$sql2= "SELECT name,captainGuid,rating,seasonGames,seasonWins,weekGames,weekWins,rank FROM arena_team WHERE arenaTeamId='" . $S5TEAMID . "' AND type='5'"; // get arena team of this member
		$result2 = $teamConn->query($sql2);
		if($result2){
			foreach($result2 as $row2){
				// PLAYER DATA
				$S5TEAM_ID = $row["arenaTeamId"];
				$S5PLR_WEEK_GAMES = $row["weekGames"];
				$S5PLR_WEEK_WINS = $row["weekWins"];
				$S5PLR_SEASON_GAMES = $row["seasonGames"];
				$S5PLR_SEASON_WINS = $row["seasonWins"];
				$S5PLR_PERSONAL_RATING = $row["personalRating"];
				// TEAM DATA
				$S5TEAM_NAME = $row2["name"];
				$sql3 = "SELECT name FROM characters WHERE guid='" . $row2["captainGuid"] . "'";
				$result3=$teamConn->query($sql3);
				if($result3){
					foreach($result3 as $row3){
						$S5TEAM_CAPITAN_NAME = $row3["name"];
					}
				}				
				$S5TEAM_RATING = $row2["rating"];
				$S5TEAM_SEASON_GAMES = $row2["seasonGames"];
				$S5TEAM_SEASON_WINS = $row2["seasonWins"];
				$S5TEAM_WEEK_GAMES = $row2["weekGames"];
				$S5TEAM_WEEK_WINS = $row2["weekWins"];
				$S5TEAM_RANK = $row2["rank"];
			}
		}
	}
}
$teamConn->close();
?>