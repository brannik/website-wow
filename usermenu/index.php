<link rel="stylesheet" type="text/css" href="main.css">
<link rel="stylesheet" type="text/css" href="acp.css">
<?php
include('../login.php'); // Includes Login Script
include'../config/connect.php';
if(isset($_SESSION['login_user'])){
	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "SELECT id,rank FROM account where username='" . $_SESSION['login_user'] . "'" ;
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$sql2 = "SELECT autor,title,text,isreaden FROM messages WHERE reciever='" . $row["id"] . "'" ;
	$USR_ID = $row["id"];
	$result2 = $conn->query($sql2);
	$msgcount =0;
	$mailicon="mail.png";
	if($result2){
	foreach($result2 as $row2){
		if($row2["isreaden"] == 0){
			$msgcount ++;
		}
	}
	}
	$conn2 = new mysqli($servername, $username, $password, $db_char);
	$sqll = "SELECT guid FROM characters WHERE account='".$USR_ID."'";
	$resultt = $conn2->query($sqll);
	$COUNT = 0;
	if($resultt){
		foreach($resultt as $roww){
			$qsll2 = "SELECT id FROM mail WHERE receiver='" . $roww["guid"] . "'";
			$resultt2 = $conn2->query($qsll2);
			if($resultt2){
				foreach($resultt2 as $roww2){
					$COUNT +=1;
				}
			}
		}
	}
	$msgcount += $COUNT;
	
	echo'<div id="acp">';
	if($msgcount>=1){
		echo'<form class="myGlower" action="" method="post">';	
	}
	if($msgcount == 0){
		echo'<form id="loginDesign" action="" method="post">';	
	}
	echo'<div id="acpPos">';
	echo'<table ><tr>';
	
	
	if($msgcount>=1){
		$mailicon='<img  class="blink" src="mail_msg.png" style="width:20px;height:20px;vertical-align:middle;">';
	}
	if($msgcount == 0 ){
		$mailicon='<img src="mail.png" style="width:20px;height:20px;vertical-align:middle;">';
	}
	echo'<td><text>Hello&nbsp;</text></td><td><text><a href="../profile/index.php"><base target="main" />'. strtoupper($_SESSION['login_user']) .'&nbsp;&nbsp;<a  href="../mailbox/index.php"><base target="main" />(' . $msgcount . $mailicon.')</a></text></td></tr>';
	echo'<tr><td><text>Rank</text></td><td>';
	$ticket_count =0;
	$conn3 = new mysqli($servername, $username, $password, $db_char);
	$sql3 = "SELECT ticketId FROM gm_tickets WHERE closedBy=0 AND viewed=0";
	$result3 = $conn3->query($sql3);
	if($result3){
		foreach($result3 as $row3){
			$ticket_count+=1;
		}
	}
	
	if($row["rank"] == 3){
		echo'<text id="admin" >Administrator&nbsp;<a style="color:yellow;" href="../admin/tickets.php"><base target="main" />('.$ticket_count.')</text><td><tr>';
	}
	if($row["rank"] == 2){
		echo'<text id="developer" >Developer&nbsp;<a style="color:yellow;" href="../admin/tickets.php"><base target="main" />('.$ticket_count.')</text><td><tr>';
	}
	if($row["rank"] == 1){
		echo'<text id="donor" >Game Master</text><td><tr>';
	}
	if($row["rank"] == 0){
		echo'<text id="user" >Player</text><td><tr>';
	}
	echo'<tr><td><text>Points:&nbsp;</text></td>';
	$sql = "SELECT id,g_points,c_points,blizz_points FROM account where username='" . $_SESSION['login_user'] . "'" ;
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	echo'<td><text>'.$row["g_points"].'<img src="gold.png" style="width:15px;height:15px;vertical-align:middle;">&nbsp;/&nbsp;'.$row["c_points"].'<img src="copper.png" style="width:15px;height:15px;vertical-align:middle;">&nbsp;/&nbsp;'.$row["blizz_points"].'<img src="blizz.png" style="width:25px;height:15px;vertical-align:middle;"></text></td></tr>';
	
	$conn2 = new mysqli($servername, $username, $password, $db_char);
	$sql2="SELECT money FROM characters WHERE account='" . $row["id"] . "'";
	$result2 = $conn2->query($sql2);
	$money=0;
	if($result2){
		foreach($result2 as $row10){
			$money += $row10["money"];
		}
	}
	$gold = $money / 10000;
	$silver = $money % 10000;
	if($silver!="0"){
		$silver = ($silver / 100) -1;
	}
	$silver = ($silver / 100);
	$copper = $money % 100;
	echo'<tr><td><text>Money:&nbsp;</text></td>';
	echo'<td><text>' . number_format($gold, 0)  . '<img src="gold.png" style="width:15px;height:15px;vertical-align:middle;">&nbsp;
	' . number_format($silver, 0)  . '<img src="silver.png" style="width:15px;height:15px;vertical-align:middle;">&nbsp;
	' . $copper  . '<img src="copper.png" style="width:15px;height:15px;vertical-align:middle;">&nbsp;
	</text></td></tr>';
	echo'<tr><td colspan="2" id="BtnCell"><input id="Btn" name="logout" type="submit" value="Logout"></td></tr>';
	echo'</table>';
	echo'</div>';
	echo'</form>';
	echo'</div>';
	}
	else{
	echo'<div id="login">';
	echo'<form id="loginDeign" action="" method="post">';
	echo'<table><tr>';
	echo'<td></td><td><text>Logged as:&nbsp;Guest</text></td></tr>';
	echo'<tr><td><text>Username:&nbsp;</text></td>';
	echo'<td><input type="text" name="username" id="username"></td></tr>';
	echo'<tr><td><text>Pasword:&nbsp</text></td>';
	echo'<td><input type="password" name="password" id="password"></td></tr>';
	echo'<tr><td></td><td><input id="Btn" name="submit" type="submit" value="Login">';
	echo'<input type="submit" id="Btn" name="regBtn" value="Register"></td></tr>';
	echo'</table>';
	echo'</form>';
	echo'</div>';
	}
	$ip=0;
	$realm=0;
	$pop=0;
	$online=0;
	$status = "OFFLINE";
	$conn = new mysqli($servername, $username, $password, $db_auth);
	if ($conn->connect_error) {
		$status="SERVER DOWN";
	} 
	
	
	else{
		$sql = "SELECT name,address,port FROM realmlist";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$realm = $row["name"];
		$ip = $row["address"];
		$port = $row["port"];
		$connection = @fsockopen($servername, $port);
		if (is_resource($connection))
		{
			$status = "ONLINE";
			fclose($connection);
		}
		else
		{
			$status = "OFFLINE";
		}
		
		
		$sql2 = "SELECT online FROM account";
		$result2 = $conn->query($sql2);
		if($result2->num_rows > 0){
			while($row2 = $result2->fetch_assoc()){
				$pop +=1;
				if($row2["online"] == 1){
					$online+=1;
				}
			}
		}
	}
	$conn->close();
	echo'<div id="status">';
	echo'<form id="statusDesign">';
	echo'<table><tr><th colspan="2"><text>SERVER STATUS</text></th><tr>';
	if($status=="ONLINE"){
		echo'<tr><td colspan="2" id="fieldStatus"><text id="colloredON">'. $status . '</text></td></tr>';
	}
	if($status=="OFFLINE"){
		echo'<tr><td colspan="2" id="fieldStatus"><text id="colloredOFF">'. $status . '</text></td></tr>';
	}
	echo'<tr><td colspan="2" style="text-align:center;"><text>REALMNAME</text></td></tr>';
	echo'<tr><td colspan="2" id="fieldD" style="text-align:center;"><text id="collored">'. $realm . '</text></td></tr>';
	echo'<tr><td colspan="2" style="text-align:center;"><text>SET REALMLIST:</text></td></tr>';
	echo'<tr><td colspan="2" id="fieldD" style="text-align:center;"><text id="collored">' . $ip . '</text></td></tr>';
	echo'<tr><td><text>POPULATION:</text></td><td id="fieldD"><text id="collored">' . $pop . '</text></td></tr>';
	// get alliance and horde count
	$conn = new mysqli($servername, $username, $password, $db_char);
	$sql = "SELECT race,totalKills,todayKills FROM characters";
	$result = $conn->query($sql);
	$ALLY_COUNT =0;
	$HORDE_COUNT =0;
	$ALLY_KILLS_TOT =0;
	$HORDE_KILLS_TOT = 0;
	$ALLY_KILLS_DAY =0;
	$HORDE_KILLS_DAY = 0;
	foreach($result as $row){
		if($row["race"] == 1 || $row["race"] == 3 || $row["race"] == 4 || $row["race"] == 7 || $row["race"] == 11){
			$ALLY_COUNT +=1;
			$ALLY_KILLS_TOT += $row["totalKills"];
			$ALLY_KILLS_DAY += $row["todayKills"];
		}
		if($row["race"] == 2 || $row["race"] == 5 || $row["race"] == 6 || $row["race"] == 8 || $row["race"] == 10){
			$HORDE_COUNT +=1;
			$HORDE_KILLS_TOT += $row["totalKills"];
			$HORDE_KILLS_DAY += $row["todayKills"];
		}
	}
	$all_players = $ALLY_COUNT + $HORDE_COUNT;

	$percent_ally = $ALLY_COUNT/$all_players;
	$percent_horde = $HORDE_COUNT/$all_players;
	$alli_percent = number_format( $percent_ally * 100, 2 ) . '%';
	$horde_percent = number_format( $percent_horde * 100, 2 ) . '%';
	echo'<tr><td colspan="2" style="text-align:center;"><text>ALLIANCE vs HORDE:</text></td><td></td></tr>';
	echo'<tr><td id="fieldD" colspan="2" style="text-align:center;"><text style="color:blue; font-weight: bold;">'.$alli_percent.'</text><text id="collored">vs</text><text style="color:red; font-weight: bold;">'.$horde_percent.'</text></td></tr>';
	echo'<tr><td><text>ONLINE:</text></td><td id="fieldD"><text id="collored">' . $online . '</text></td></tr>';
	
	echo'<tr><td colspan="2"  style="text-align:center;"><text>HONORABLE KILLS TOTAL</text><td></tr>';
	echo'<tr><td><text>ALLIANCE:</text></td><td id="fieldD"><text id="collored">'.$ALLY_KILLS_TOT.'</text></td></tr>';
	echo'<tr><td ><text>HORDE:</text></td><td id="fieldD"><text id="collored">'.$HORDE_KILLS_TOT.'</text></td></tr>';
	
	echo'<tr><td colspan="2"  style="text-align:center;"><text>HONORABLE KILLS TODAY</text><td></tr>';
	echo'<tr><td><text>ALLIANCE:</text></td><td id="fieldD"><text id="collored">'.$ALLY_KILLS_DAY.'</text></td></tr>';
	echo'<tr><td ><text>HORDE:</text></td><td id="fieldD"><text id="collored">'.$HORDE_KILLS_DAY.'</text></td></tr>';
	echo'</table>';
	echo'</form>';
	echo'</div>';
	echo'<footer style="position: absolute;bottom: 10px;right:10px;"><text>&copy;&nbsp;BRANNIK&nbsp;-&nbsp;2015</text></footer>';
	$conn->close();
	?>