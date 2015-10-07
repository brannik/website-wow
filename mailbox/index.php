<link rel="stylesheet" type="text/css" href="index.css">
<script type="text/javascript" src="http://static.wowhead.com/widgets/power.js"></script>
<script>var wowhead_tooltips = { "colorlinks": true, "iconizelinks": true, "renamelinks": true }</script>
<?php

include'../config/connect.php';
include'../session_special.php';
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$id=0;
$sql = "SELECT id FROM account WHERE username='" . $_SESSION['login_user'] . "'";
$result = $conn->query($sql);
if($result){
	foreach($result as $row){
		$id = $row["id"];
	}
}
$sql2 = "SELECT id,autor,title,text,isreaden,time FROM messages WHERE reciever='" . $id . "' ORDER BY isreaden ASC,time DESC";
$result2 = $conn->query($sql2);
	echo'<h1>mail box</h1>';
	echo'<a href="index.php?new=true">New Message</a>';
	function NEW_msg() {
		echo'<form method="post">';
		echo'<table id="messageDesign">';
		echo'<th colspan="2"><text>Send new message</text></th>';
		echo'<tr><td colspan="2"><text>To:</text>&nbsp;&nbsp;<input type="text" name="msgReciever"></td><tr>';
		echo'<tr><td colspan="2"><text>Title</text><input type="text" name="msgTitle"></td></tr>';
		echo'<tr><td colspan="2"><text>Message</text></td></tr><tr><td colspan="2"><textarea style="width: 450px;height: 200px;resize: none;" name="msgText"></textarea></td></tr>';
		echo'<tr><td colspan="2" style="align:left;"><input type="submit" name="send" value="Send"></td></tr>';
		echo'</table>';
		echo'</form>';
	}
	if (isset($_GET['new'])) {
		NEW_msg();
	}
	
	$conn33 = new mysqli($servername, $username, $password, $dbname);
	$sql33 = "SELECT id FROM account where username='" . $_SESSION['login_user'] . "'" ;
	$result33 = $conn33->query($sql33);
	$row33 = $result33->fetch_assoc();
	$USR_ID = $row33["id"];
	
	
	$conn22 = new mysqli($servername, $username, $password, $db_char);
	$sqll = "SELECT guid FROM characters WHERE account='".$USR_ID."'";
	$resultt = $conn22->query($sqll);
	$COUNT = 0;
	if($resultt){
		foreach($resultt as $roww){
			$qsll2 = "SELECT id FROM mail WHERE receiver='" . $roww["guid"] . "'";
			$resultt2 = $conn22->query($qsll2);
			if($resultt2){
				foreach($resultt2 as $roww2){
					$COUNT +=1;
				}
			}
		}
	}
	$conn22->close();
	$conn33->close();
if ($result2->num_rows > 0 || $COUNT > 0 ) {
	$char_name = " ";

	echo'<h5>This mail is opened</h5>';
	echo'<h6>This mail is not opened</h6>';
	echo'<h4 class="ingame">This mail is in game</h4>';
	$conn2 = new mysqli($servername, $username, $password, $db_char);
	$getMessagesInGame="SELECT guid FROM characters WHERE account='". $id ."'";
	$resultMessages = $conn2->query($getMessagesInGame);
	if($getMessagesInGame){
		foreach($resultMessages as $PlrGUID){
			$prepareMessage = "SELECT id,receiver,subject,body,has_items,checked FROM mail WHERE receiver='" .$PlrGUID["guid"]. "'";
			$ReadMSG = $conn2->query($prepareMessage);
			if($ReadMSG){
				foreach($ReadMSG as $MsgText){
					$getReciever = "SELECT name FROM characters WHERE guid='" . $MsgText["receiver"] . "'";
					$RecName = $conn2->query($getReciever);
					if($RecName){
						foreach($RecName as $REC_NAME){
							$char_name=$REC_NAME["name"];
						}
					}
					if($MsgText["has_items"] == 0 && $MsgText["checked"] !== 1){
						// print messages without attached items
						echo'<form >';
						echo'<h4 class="ingame" style="padding-top:10px;">'.$MsgText["subject"].'&nbsp;<text style="color:red;">msg</text> in character - '.$char_name.'</h4>';
						echo'<text>' . $MsgText["body"] . '</text>';
						echo'</form>';
						
					}
					if($MsgText["has_items"] == 1 && $MsgText["checked"] !== 1){
						$prepareItemsInMsg = "SELECT item_guid FROM mail_items WHERE mail_id='" .$MsgText["id"]. "'";
						$FindItem = $conn2->query($prepareItemsInMsg);
						echo'<form >';
						echo'<h4 class="ingame" style="padding-top:10px;">'.$MsgText["subject"].'&nbsp;<text style="color:red;">msg</text> in character - '.$char_name.'</h4>';
						echo'<text>' . $MsgText["body"] . '</text>';
						echo'<hr>';
						echo'<text>Attached items</text>';
						echo'<table>';
						if($FindItem){
							foreach($FindItem as $Items){
								$FinalItemEntry = "SELECT itemEntry,count FROM item_instance WHERE guid='".$Items["item_guid"]."'";
								$FinalEntryID = $conn2->query($FinalItemEntry);
								if($FinalEntryID){
									foreach($FinalEntryID as $ENTRY_ID){
										//print messages with attached items
										echo'<tr><td style="padding-left:20px;"><text>'.$ENTRY_ID["count"].'&nbspX</text></td><td><a href="http://www.wowhead.com/item=' . $ENTRY_ID["itemEntry"] . '"</a></td></tr>';
										
									}
								}
							}
						}
						echo'</table>';
						echo'</form>';
					}
				}
			}
		}
	}
	$conn2->close();
	while($row2 = $result2->fetch_assoc()) {
		$sql3 = "SELECT username FROM account WHERE id='" . $row2["autor"] . "'";
		$result3 = $conn->query($sql3);
		if($result3){
			foreach($result3 as $row3){
				$avtor = $row3["username"];
			}
		}
		echo'<form >';
		if($row2["isreaden"] == 1){
			echo'<div id="buttonsPos">';
			echo'<table id="buttons"><tr>';
			echo'<td><a href="index.php?delete='.$row2["id"].'">Delete</a>&nbsp;</td>';
			echo'<td><a href="index.php?reply='.$row2["id"].'">Reply</a>&nbsp;</td>';
			echo'</tr></table></div>';
			echo'<h2>From:&nbsp;' . $avtor . '</h2>';
		}
		if($row2["isreaden"] == 0){
			echo'<div id="buttonsPos">';
			echo'<table id="buttons"><tr>';
			echo'<td><a href="index.php?seen='.$row2["id"].'">Mark as seen</a>&nbsp;</td>';
			echo'<td><a href="index.php?delete='.$row2["id"].'">Delete</a>&nbsp;</td>';
			echo'<td><a href="index.php?reply='.$row2["id"].'">Reply</a>&nbsp;</td>';
			echo'</tr></table></div>';
			echo'<h4>From:&nbsp;' . $avtor . '</h4>';
		}
		echo'<text>' . $row2["title"] . '</text><br>';
		echo'<text>' . $row2["text"] . '</text>';
		echo'<h3>' . $row2["time"] . '</h3>';
		
		echo'</form>';
	}
	
}
else{
	echo'<form>';
	echo'<h2>messages</h2>';
	echo'<text>Mesage box is empty</text>';
	echo'</form>';
}
function DELETE() {
		$numeric = preg_replace('/[^\d]/', '', $_GET['delete']);
		include'../config/connect.php';
		$conn2 = new mysqli($servername, $username, $password, $dbname);
		$sql2 = "DELETE FROM messages WHERE id='" . $numeric . "'";
		$result2 = $conn2->query($sql2);
		$conn2->close();
		header("Location:index.php");
  }
  function REPLY() {
		$numeric = preg_replace('/[^\d]/', '', $_GET['reply']);
		include'../config/connect.php';
		$conn2 = new mysqli($servername, $username, $password, $dbname);
		$find_sender = "SELECT autor FROM messages WHERE id='".$numeric. "'";
		$result20 = $conn2->query($find_sender);
		foreach($result20 as $row2){
			$sender = $row2["autor"];
		}
		$find_sender_name = "SELECT username FROM account WHERE id='" . $sender . "'";
		$result30 = $conn2->query($find_sender_name);
		foreach($result30 as $row3){
			$sender_username = $row3["username"];
		}
				
		echo'<form method="post">';
		echo'<table id="messageDesign">';
		echo'<th colspan="2"><text>Reply to message</text></th>';
		echo'<tr><td colspan="2"><text>To:</text>&nbsp;&nbsp;<input type="text" name="msgReciever" readonly value='.$sender_username.'></td><tr>';
		echo'<tr><td colspan="2"><text>Title</text><input type="text" name="msgTitle"></td></tr>';
		echo'<tr><td colspan="2"><text>Message</text></td></tr><tr><td colspan="2"><textarea style="width: 450px;height: 200px;resize: none;" name="msgText"></textarea></td></tr>';
		echo'<tr><td colspan="2" style="align:left;"><input type="submit" name="send" value="Send"></td></tr>';
		echo'</table>';
		echo'</form>';
		
		
  }
  function SEEN() {
		$numeric = preg_replace('/[^\d]/', '', $_GET['seen']);
		include'../config/connect.php';
		$conn2 = new mysqli($servername, $username, $password, $dbname);
		$sql2 = "UPDATE messages SET isreaden='1' WHERE id='" . $numeric . "'";
		$result2 = $conn2->query($sql2);
		$conn2->close();
		header("Location:index.php");
  }
  function SEND_msg(){
	include'../config/connect.php';
	$conn2 = new mysqli($servername, $username, $password, $dbname);
	$reciever_formated = strtolower($_POST["msgReciever"]);
	$find_rec = "SELECT id FROM account WHERE username='". $reciever_formated. "'";
	$result10 = $conn2->query($find_rec);
	foreach($result10 as $row10){
		$reciever = $row10["id"];
	}
	$autor_temp = $_SESSION['login_user'];
	$find_autor_id = "SELECT id FROM account WHERE username='" . $_SESSION['login_user'] . "'" ;
	$result11 = $conn2->query($find_autor_id);
	foreach($result11 as $row11){
		$autor = $row11["id"];
	}
	if($reciever_formated == $_SESSION['login_user']){
		echo'<text>You cant send message to yourself</text>';
	}
	if($reciever && $reciever_formated != $_SESSION['login_user']){
		$sql2 = "INSERT INTO messages (autor,reciever,title,text) VALUES ('".$autor."','".$reciever."','".$_POST["msgTitle"]."','".$_POST["msgText"]. "')";
		$result2 = $conn2->query($sql2);
		$conn2->close();
		header('Location:index.php');
	}
	if(!$reciever){
		echo'<text>Reciever not found</text>';
	}
  }

  if (isset($_GET['delete'])) {
    DELETE($_GET['delete']);
  }
  if (isset($_GET['reply'])) {
    REPLY($_GET['reply']);
  }
  if (isset($_GET['seen'])) {
    SEEN($_GET['seen']);
  }
  
  if (isset($_POST['send'])) {
    SEND_msg();
  }
$conn->close();
?>