<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="../error.css">
<script type="text/javascript" src="http://static.wowhead.com/widgets/power.js"></script>
<script>var wowhead_tooltips = { "colorlinks": true, "iconizelinks": true, "renamelinks": true }</script>
<script type="text/JavaScript">
function popup(entry){
	alert('You want to buy ' + entry);
	window.location.href = "send.php";
}
</script>
<?php
include '../config/connect.php';
include'../session_special.php';
// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	$conn2 = new mysqli($servername, $username, $password, $db_char);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
if($_SESSION['login_user']!=''){

echo'<h1>Item shop</h1>';



echo'<form method="post">';

echo'<table><th><text style="color:white;font-size:18px;">Select your item , select your character and click send</text></th>';
echo'<tr><td style="text-align:center;"><select name="Char" style"width:200px;font-size:22px;width:50px;">';

if(isset($_SESSION['login_user'])){
$sql = "SELECT id,username FROM account where username='" . $_SESSION['login_user'] . "'" ;
$result = $conn->query($sql);
 while($row = $result->fetch_assoc()) {
		$sql2="SELECT guid,name FROM characters WHERE account='" . $row["id"] . "'";
		$result2 = $conn2->query($sql2);
		foreach($result2 as $row2) {
			echo'<option value=' . $row2["guid"] . '>' . $row2["name"] . '</option>';
		}
    }
}
echo'</table>';


$sql3 = "SELECT id, entry,cost,cost_type,Name FROM items";
$result3 = $conn->query($sql3);
if ($result3->num_rows > 0) {
    // output data of each row
	echo '<table><tr id="head"><td id="number">#</td><td id="name_cell">NAME</td><td id="price_cell">PRICE</td><td id="button_cell">SEND</td></tr>';
    while($row3 = $result3->fetch_assoc()) {
        // echo "id: " . $row["id"]. " - Name: " . $row["username"]. " " . $row["password"]. "<br>";
		echo'<tr id="items">';	
		echo"<td>" . $row3["id"] . "</td>" ;
		echo'<td id="ItemName"><a href=http://www.wowhead.com/item=' . $row3["entry"] . "/>" . $row3["Name"] ." </td>";
		if($row3["cost_type"] == 1){
			echo '<td>' . $row3["cost"] . "<img src='gold.png' style=height:15px;width:15px></td>";
		}
		if($row3["cost_type"] == 2){
			echo '<td>' . $row3["cost"] . "<img src='copper.png' style=height:15px;width:15px></td>";
		}
		if($row3["cost_type"] == 3){
			echo '<td>' . $row3["cost"] . "<img src='blizz.png' style=height:15px;width:25px></td>";
		}
		echo '<td><input type="submit" name="sendItem" value="'.$row3["entry"].'"></td>';
		
    }
	echo'</table>';
	echo'</form>';
} else {
    echo "0 results";
}
function send_item() {
	include '../config/connect.php';
	$conn = new mysqli($servername, $username, $password, $dbname);
	$conn2 = new mysqli($servername, $username, $password, $db_char);
		$numeric = preg_replace('/[^\d]/', '', $_POST['sendItem']);
		$findItem = $conn->query("SELECT cost,cost_type FROM items WHERE entry='". $numeric . "'");
		$COST = 0;
		$COST_TYPE = 0;
		$goldP =0;
		$copperP=0;
		$blizzP=0;
		$ACC_ID=0;
		if($findItem){
			foreach($findItem as $FoundItem){
				$COST = $FoundItem["cost"];
				$COST_TYPE = $FoundItem["cost_type"];
			}
		}
		$findPlayerIdFromCharId = $conn2->query("SELECT account FROM characters WHERE guid='".$_POST["Char"]."'");
		if($findPlayerIdFromCharId){
			foreach($findPlayerIdFromCharId as $accID){
				$ACC_ID = $accID["account"];
			}
		}
		$checkPlayer = $conn->query("SELECT g_points,c_points,blizz_points FROM account WHERE id='".$ACC_ID."'");
		if($checkPlayer){
			foreach($checkPlayer as $PointsCount){
				$goldP = $PointsCount["g_points"];
				$copperP = $PointsCount["c_points"];
				$blizzP = $PointsCount["blizz_points"];
			}
		}
		if($COST_TYPE == 1){
			if($goldP>=$COST){
				// send item
				// suspend points
				$temp =0;
				$max_mail_id = $conn2->query("SELECT id FROM mail");
				if($max_mail_id ){
					foreach($max_mail_id as $maxMailId){
						if($temp<$maxMailId["id"]){
							$temp = $maxMailId["id"];
						}
					}
				}
				
				$conn2->query("INSERT INTO mail VALUES('".($temp+1)."','0','61','0','16128','".$_POST["Char"]."','Website shop','Enjoy your new item','1','1432729867','10','0','0','0')");
				$temp2 =0;
				$max_item_guid = $conn2->query("SELECT guid FROM item_instance");
				if($max_item_guid ){
					foreach($max_item_guid as $MaxItemGuid){
						if($temp2<$MaxItemGuid["guid"]){
							$temp2 = $MaxItemGuid["guid"];
						}
					}
				}
				$conn2->query("INSERT INTO item_instance VALUES('".($temp2+1)."','".$numeric."','".$_POST["Char"]."','0','0','1','0','0','0','0','0','1','0','a')");
				$conn2->query("INSERT INTO mail_items VALUES('".($temp+1)."','".($temp2+1)."','".$_POST["Char"]."')");
				echo'<text style="color:white;text-size:20px;vertical-align:top;">This item is send to your character - </text><a href=http://www.wowhead.com/item=' . $numeric . '/a>';
				$goldP -= $COST;
				$conn->query("UPDATE account SET g_points='".$goldP."' WHERE id='".$ACC_ID."'");
			}
			if($goldP<$COST){
				echo'<text style="color:white;text-size:20px;vertical-align:top;">You dont have enought points</text>';
			}
		}
		
		
		if($COST_TYPE == 2){
			if($copperP>=$COST){
				// send item
				// suspend points
				$temp =0;
				$max_mail_id = $conn2->query("SELECT id FROM mail");
				if($max_mail_id ){
					foreach($max_mail_id as $maxMailId){
						if($temp<$maxMailId["id"]){
							$temp = $maxMailId["id"];
						}
					}
				}
				$conn2->query("INSERT INTO mail VALUES('".($temp+1)."','0','61','0','16128','".$_POST["Char"]."','Website shop','Enjoy your new item','1','1432729867','10','0','0','0')");
				$temp2 =0;
				$max_item_guid = $conn2->query("SELECT guid FROM item_instance");
				if($max_item_guid ){
					foreach($max_item_guid as $MaxItemGuid){
						if($temp2<$MaxItemGuid["guid"]){
							$temp2 = $MaxItemGuid["guid"];
						}
					}
				}
				$conn2->query("INSERT INTO item_instance VALUES('".($temp2+1)."','".$numeric."','".$_POST["Char"]."','0','0','1','0','0','0','0','0','1','0','a')");
				$conn2->query("INSERT INTO mail_items VALUES('".($temp+1)."','".($temp2+1)."','".$_POST["Char"]."')");
				echo'<text style="color:white;text-size:20px;vertical-align:top;">This item is send to your character - </text><a href=http://www.wowhead.com/item=' . $numeric . '/a>';
				$copperP -= $COST;
				$conn->query("UPDATE account SET c_points='".$copperP."' WHERE id='".$ACC_ID."'");
			}
			if($copperP<$COST){
				echo'<text style="color:white;text-size:20px;vertical-align:top;">You dont have enought points</text>';
			}
		}
		if($COST_TYPE == 3){
			if($blizzP>=$COST){
				// send item
				// suspend points
				$temp =0;
				$max_mail_id = $conn2->query("SELECT id FROM mail");
				if($max_mail_id ){
					foreach($max_mail_id as $maxMailId){
						if($temp<$maxMailId["id"]){
							$temp = $maxMailId["id"];
						}
					}
				}
				$conn2->query("INSERT INTO mail VALUES('".($temp+1)."','0','61','0','16128','".$_POST["Char"]."','Website shop','Enjoy your new item','1','1432729867','10','0','0','0')");
				$temp2 =0;
				$max_item_guid = $conn2->query("SELECT guid FROM item_instance");
				if($max_item_guid ){
					foreach($max_item_guid as $MaxItemGuid){
						if($temp2<$MaxItemGuid["guid"]){
							$temp2 = $MaxItemGuid["guid"];
						}
					}
				}
				$conn2->query("INSERT INTO item_instance VALUES('".($temp2+1)."','".$numeric."','".$_POST["Char"]."','0','0','1','0','0','0','0','0','1','0','a')");
				$conn2->query("INSERT INTO mail_items VALUES('".($temp+1)."','".($temp2+1)."','".$_POST["Char"]."')");
				echo'<text style="color:white;text-size:20px;vertical-align:top;">This item is send to your character - </text><a href=http://www.wowhead.com/item=' . $numeric . '/a>';
				$blizzP -= $COST;
				$conn->query("UPDATE account SET blizz_points='".$blizzP."' WHERE id='".$ACC_ID."'");
			}
			if($blizzP<$COST){
				echo'<text style="color:white;text-size:20px;vertical-align:top;">You dont have enought points</text>';
			}
		}
		
  }
if (isset($_POST['sendItem'])) {
    send_item();
  }
$conn->close();
$conn2->close();
}
else{
	echo'<h1 id="errorHeader">error<h1>';
	echo'<form id="errorForm">';
	echo'<ul id="errorList">';
	echo'<li>Pleace login in your account or register new!!!</li>';
	echo'</ul>';
	echo'</form>';
}
?>