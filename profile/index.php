<link rel="stylesheet" type="text/css" href="index.css">
<?php
	// zaredi profile pic ot db
	include'../config/connect.php';
	include'../session_special.php';
	$conn = new mysqli($servername, $username, $password, $dbname);
	echo'<h1>my profile</h1>';
	
	
	if(isset($_SESSION['login_user'])){
	$sql = "SELECT id,g_points,c_points,blizz_points,rank,pic FROM account where username='" . $_SESSION['login_user'] . "'" ;
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()) {
		$rank = $row["rank"];
		$id = $row["id"];
		$g_points = $row["g_points"];
		$c_points = $row["c_points"];
		$blizz_points = $row["blizz_points"];
		$pic = $row["pic"];
	}
	
	echo'<div id="framePos">';
	echo'<form>';
	echo'<table><tr><th rowspan="5"><div id="pic"><img src="' . $pic . '"></div></th>';
	echo' <th><text>'. strtoupper( $_SESSION['login_user']) . '</text></th>';
	echo'</tr>';
	echo'<tr>';
	
	if($rank == 0){
		echo'<td><text>Player</text></td>';
	}
	if($rank == 1){
		echo'<td><text style="color:blue;">Game Master</text></td>';
	}
		if($rank == 2){
			echo'<td><text style="color:orange;">Developer</text></td>';
		}
		if($rank == 3){
			echo'<td><text style="color:red;">Server Administrator</text></td>';
		}
		
		$conn2 = new mysqli($servername, $username, $password, "auth");
		$sql2="SELECT email,joindate,last_ip,locked,last_login FROM account WHERE id='" . $id . "'";
		$result2 = $conn2->query($sql2);
		if($result2){
			foreach($result2 as $row2){
			
			echo'</tr>';
			echo'<tr>';
			echo'<td><text>'. $row2["email"]. '</text></td>';
			echo'</tr>';
			echo'<tr>';
			echo'<td><text>Website points</text></td>';
			echo'<td><text>'.$g_points.'<img src="gold.png" style="width:15px;height:15px;vertical-align:middle;">&nbsp;/&nbsp;'.$c_points.'<img src="copper.png" style="width:15px;height:15px;vertical-align:middle;">&nbsp;/&nbsp;'.$blizz_points.'<img src="blizz.png" style="width:25px;height:15px;vertical-align:middle;"></text></td>';
			echo'</tr>';
			echo'<tr>';
			
			$conn3 = new mysqli($servername, $username, $password, $db_char);
			$sql3="SELECT money FROM characters WHERE account='" . $id . "'";
			$result3 = $conn3->query($sql3);
			$money=0;
			if($result3){
				foreach($result3 as $row3){
					$money += $row3["money"];
				}
			}
			$gold = $money / 10000;
			$silver = $money % 10000;
			if($silver!="0"){
				$silver = ($silver / 100) -1;
			}
			$silver = ($silver / 100);
			$copper = $money % 100;
			
			echo'<td><text>Money in all characters</text></td>';
			echo'<td><text>' . number_format($gold, 0)  . '<img src="gold.png" style="width:15px;height:15px;vertical-align:middle;">&nbsp;
				' . number_format($silver, 0)  . '<img src="silver.png" style="width:15px;height:15px;vertical-align:middle;">&nbsp;
				' . $copper  . '<img src="copper.png" style="width:15px;height:15px;vertical-align:middle;">&nbsp;</text></td>';
			echo'</tr>';
			echo'<tr>';
			echo'<td><text>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Account status</text></td>';
			if($row2["locked"] == 0){
				echo'<td><text style="color:yellow;">Active</text></td>';
			}
			if($row2["locked"] == 1){
				echo'<td><text style="color:red;">Suspended</text></td>';
			}
			echo'</tr>';
			echo'</table>';
			
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			
			
			echo'<table>';
			echo'<tr><td><text>Last login:&nbsp;</text></td><td><text>'.$row2["last_login"].'</text></td></tr>';
			echo'<tr><td><text>Last IP:&nbsp;</text></td><td><text>'.$row2["last_ip"].'</text></td></tr>';
			echo'<tr><td><text>Registered on:&nbsp;</text></td><td><text>'. $row2["joindate"].'</text></td></tr>';
			echo'<tr><td><text>IP:&nbsp;</text></td><td><text>'. $ip .'</text></td></tr>';
			}
			}
		}
	echo'</table>';
	echo'</form>';
	echo'</div>';
?>