<link rel="stylesheet" type="text/css" href="index.css">
<?php
include'../config/connect.php';
	echo'<h1>in game staff</h1>';
	echo'<form>';
	echo'<div id="design">';
	echo'<table id="staffDesn">';
	echo'<tr><td>';
	echo'<table>';
	echo'<tr><td id="titleD"><h2>Administrators</h2><td></tr>';
	$conn = new mysqli($servername, $username, $password, $db_auth);
	$conn2 = new mysqli($servername, $username, $password, $db_char);
	$sql = "SELECT id,gmlevel FROM  account_access ORDER BY gmlevel DESC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if($row["gmlevel"] == 3){
				$sql2="SELECT name,online FROM characters WHERE account='" . $row["id"] . "'";
				$result2 = $conn2->query($sql2);
				foreach($result2 as $row2) {
					if($row2["online"] == 1){
						echo'<tr><td style="padding-left:30px;"><text style="color:red;">' . $row2["name"] . '</text>&nbsp;&nbsp;&nbsp;</td></tr>';
					}
				}
			}
		}
	}
	echo'</table>';
	echo'</td></tr>';
	$conn2->close();
	$conn->close();
	echo'<tr><td>';
	echo'<table>';
	echo'<tr><td id="titleD"><h2>Developers</h2><td></tr>';
	$conn = new mysqli($servername, $username, $password, $db_auth);
	$conn2 = new mysqli($servername, $username, $password, $db_char);
	$sql = "SELECT id,gmlevel FROM  account_access ORDER BY gmlevel DESC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if($row["gmlevel"] == 2){
				$sql2="SELECT name,online FROM characters WHERE account='" . $row["id"] . "'";
				$result2 = $conn2->query($sql2);
				foreach($result2 as $row2) {
					if($row2["online"] == 1){
						echo'<tr><td style="padding-left:30px;"><text style="color:orange;">' . $row2["name"] . '</text>&nbsp;&nbsp;&nbsp;</td></tr>';
					}
				}
			}
		}
	}
	echo'</table>';
	echo'</td></tr>';
	$conn2->close();
	$conn->close();
	echo'<tr><td>';
	echo'<table>';
	echo'<tr><td id="titleD"><h2>Game Masters</h2><td></tr>';
	$conn = new mysqli($servername, $username, $password, $db_auth);
	$conn2 = new mysqli($servername, $username, $password, $db_char);
	$sql = "SELECT id,gmlevel FROM  account_access ORDER BY gmlevel DESC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if($row["gmlevel"] == 1){
				$sql2="SELECT name,online FROM characters WHERE account='" . $row["id"] . "'";
				$result2 = $conn2->query($sql2);
				foreach($result2 as $row2) {
					if($row2["online"] == 1){
						echo'<tr><td style="padding-left:30px;"><text style="color:blue;">' . $row2["name"] . '</text>&nbsp;&nbsp;&nbsp;</td></tr>';
					}
				}
			}
		}
	}
	echo'</table>';
	echo'</td></tr>';
	$conn2->close();
	$conn->close();
	
	echo'</table>';
	echo'</div>';
	echo'</form>';
?>