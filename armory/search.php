<script type="text/javascript" src="http://static.wowhead.com/widgets/power.js"></script>
<script>var wowhead_tooltips = { "colorlinks": false, "iconizelinks": false, "renamelinks": false }</script>
<?php
if(isset($_POST['serchBtn'])){
	include'../config/connect.php';
	include'../armory/definitions.php';
	// prevent errors in query from AaAAAaaaAA type text
	$conv1 = strtolower($_POST["serchTxt"]); // all to lower
	$conv2 = ucfirst ( $conv1 ); // 1-st letter capital
	$conn = new mysqli($servername, $username, $password, $db_char);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	$sql = "SELECT guid,race,class,gender,level,totaltime,leveltime,totalHonorPoints, todayHonorPoints, yesterdayHonorPoints,totalKills,todayKills,yesterdayKills,
		chosenTitle,health,power1,power2,power4,power7 FROM characters WHERE name='" . $conv2  .  "'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		foreach($result as $row) {
			$CHAR_GUID = $row["guid"];
			$NAME = $conv2;
			$RACE = $row["race"];
			$CLASS = $row["class"];
			$GENDER = $row["gender"];
			$LEVEL = $row["level"];
			$TOTAL_TIME = $row["totaltime"];
			$LEVEL_TIME = $row["leveltime"];
			$TOTAL_HONOR = $row["totalHonorPoints"];
			$TODAY_HONOR = $row["todayHonorPoints"];
			$YESTERDAY_HONOR = $row["yesterdayHonorPoints"];
			$TOTAL_KILLS = $row["totalKills"];
			$TODAY_KILLS = $row["todayKills"];
			$YESTERDAY_KILLS = $row["yesterdayKills"];
			$CHOSEN_TITLE = $row["chosenTitle"];
			$HP = $row["health"];
			$MANA_POW = $row["power1"];
			$RAGE_POW = $row["power2"];
			$ENERGY_POW = $row["power4"];
			$RUNIC_POW = $row["power7"];
		}
		
		$sql_guild= "SELECT guildid FROM guild_member WHERE guid='" . $CHAR_GUID ."'";
		$result = $conn->query($sql_guild);
		foreach($result as $guildID);
		if($guildID){
			$sql_guild2= "SELECT name FROM guild WHERE guildid='" . $guildID["guildid"] ."'";
			$result = $conn->query($sql_guild2);
			foreach($result as $CharGuild);
			$GUILD = $CharGuild["name"];
		}
		else{
			$GUILD = "No Guild";
		}
		
		//<text style="color:darkorange">HP:&nbsp;'.$HP.'</text><br>'.$POWER.'
		
		// rogue  || 
		if($CLASS == 4 ){
			
			$POWER = '<table style="width:100%; text-align:center; padding:0px; margin:0px;" cellspacing="0" cellpadding="0"><tr style="background-image: url(../armory/bars/bar-life.gif);"><td ><text style="color:black">HP:&nbsp;</text></td><td><text style="color:black">' . $HP . '</text></td></tr>
			<tr style="background-image: url(../armory/bars/bar-energy.gif);"><td><text style="color:black;">Energy:&nbsp;</text></td><td><text style="color:black;">'.$ENERGY_POW.'</text></td><tr></table>';
		}
		if($CLASS == 1){
			$POWER = '<table style="width:100%; text-align:center; padding:0px; margin:0px;" cellspacing="0" cellpadding="0"><tr style="background-image: url(../armory/bars/bar-life.gif);" ><td><text style="color:black">HP:&nbsp;</text></td><td><text style="color:black">' . $HP . '</text></td></tr>
			<tr style="background-image: url(../armory/bars/bar-rage.gif);"><td><text style="color:white;">Rage:&nbsp;</text></td><td><text style="color:white;">'.$RAGE_POW.'</text></td><tr></table>';
		}
		// DK 
		if($CLASS == 6){
			$POWER = '<table style="width:100%; text-align:center; padding:0px; margin:0px;" cellspacing="0" cellpadding="0"><tr style="background-image: url(../armory/bars/bar-life.gif);"><td><text style="color:black">HP:&nbsp;</text></td><td ><text style="color:black">' . $HP . '</text></td></tr>
			<tr style="background-image: url(../armory/bars/bar-runic.gif);"><td><text style="color:black;">Runic Power:&nbsp;</text></td><td><text style="color:black;">'.$RUNIC_POW.'</text></td><tr></table>';
			
		}
		// paladin od hunter or priest or shaman or mage or warlock or druid
		if($CLASS == 2 || $CLASS == 3 || $CLASS == 5 || $CLASS == 7 || $CLASS == 8 || $CLASS == 9 || $CLASS == 11){
			$POWER = '<table style="width:100%; text-align:center; padding:0px; margin:0px;" cellspacing="0" cellpadding="0"><tr style="background-image: url(../armory/bars/bar-life.gif);"><td ><text style="color:black">HP:&nbsp;</text></td><td ><text style="color:black">' . $HP . '</text></td></tr>
			<tr style="background-image: url(../armory/bars/bar-mana.gif);"><td><text style="color:white;">Mana:&nbsp;</text></td><td><text style="color:white;">'.$MANA_POW.'</text></td><tr></table>';
		}
		
		// head slot 0
		$sql_head= "SELECT item FROM character_inventory WHERE guid='" . $CHAR_GUID ."' AND slot='0' AND bag='0'";
		$result = $conn->query($sql_head);
		foreach($result as $head);
		$sql_head_final="SELECT itemEntry FROM item_instance WHERE guid='" . $head["item"] . "'";
		$result2 = $conn->query($sql_head_final);
		foreach($result2 as $head_entry);
		// head end
		//neck slot 1
		$sql_neck= "SELECT item FROM character_inventory WHERE guid='" . $CHAR_GUID ."' AND slot='1' AND bag='0'";
		$result = $conn->query($sql_neck);
		foreach($result as $neck);
		$sql_neck_final="SELECT itemEntry FROM item_instance WHERE guid='" . $neck["item"] . "'";
		$result2 = $conn->query($sql_neck_final);
		foreach($result2 as $neck_entry);
		//neck end
		// Shoulders slot 2
		$sql_shoulders= "SELECT item FROM character_inventory WHERE guid='" . $CHAR_GUID ."' AND slot='2' AND bag='0'";
		$result = $conn->query($sql_shoulders);
		foreach($result as $shoulders);
		$sql_shoulders_final="SELECT itemEntry FROM item_instance WHERE guid='" . $shoulders["item"] . "'";
		$result2 = $conn->query($sql_shoulders_final);
		foreach($result2 as $shoulders_entry);
		// Shoulders end
		// body ??? slot 3 shirt
		$sql_shirt= "SELECT item FROM character_inventory WHERE guid='" . $CHAR_GUID ."' AND slot='3' AND bag='0'";
		$result = $conn->query($sql_shirt);
		foreach($result as $shirt);
		$sql_shirt_final="SELECT itemEntry FROM item_instance WHERE guid='" . $shirt["item"] . "'";
		$result2 = $conn->query($sql_shirt_final);
		foreach($result2 as $shirt_entry);
		// body end
		// chest slot 4
		$sql_chest= "SELECT item FROM character_inventory WHERE guid='" . $CHAR_GUID ."' AND slot='4' AND bag='0'";
		$result = $conn->query($sql_chest);
		foreach($result as $chest);
		$sql_chest_final="SELECT itemEntry FROM item_instance WHERE guid='" . $chest["item"] . "'";
		$result2 = $conn->query($sql_chest_final);
		foreach($result2 as $chest_entry);
		// chest end
		// waist slot 5
		$sql_waist= "SELECT item FROM character_inventory WHERE guid='" . $CHAR_GUID ."' AND slot='5' AND bag='0'";
		$result = $conn->query($sql_waist);
		foreach($result as $waist);
		$sql_waist_final="SELECT itemEntry FROM item_instance WHERE guid='" . $waist["item"] . "'";
		$result2 = $conn->query($sql_waist_final);
		foreach($result2 as $waist_entry);
		// waist end
		// legs slot 6
		$sql_legs= "SELECT item FROM character_inventory WHERE guid='" . $CHAR_GUID ."' AND slot='6' AND bag='0'";
		$result = $conn->query($sql_legs);
		foreach($result as $legs);
		$sql_legs_final="SELECT itemEntry FROM item_instance WHERE guid='" . $legs["item"] . "'";
		$result2 = $conn->query($sql_legs_final);
		foreach($result2 as $legs_entry);
		//legs end
		//feet slot 7
		$sql_feet= "SELECT item FROM character_inventory WHERE guid='" . $CHAR_GUID ."' AND slot='7' AND bag='0'";
		$result = $conn->query($sql_feet);
		foreach($result as $feet);
		$sql_feet_final="SELECT itemEntry FROM item_instance WHERE guid='" . $feet["item"] . "'";
		$result2 = $conn->query($sql_feet_final);
		foreach($result2 as $feet_entry);
		//feet end
		// wrist lot 8 
		$sql_wrist= "SELECT item FROM character_inventory WHERE guid='" . $CHAR_GUID ."' AND slot='8' AND bag='0'";
		$result = $conn->query($sql_wrist);
		foreach($result as $wrist);
		$sql_wrist_final="SELECT itemEntry FROM item_instance WHERE guid='" . $wrist["item"] . "'";
		$result2 = $conn->query($sql_wrist_final);
		foreach($result2 as $wrist_entry);
		//wrist end
		// hands slot 9
		$sql_hands= "SELECT item FROM character_inventory WHERE guid='" . $CHAR_GUID ."' AND slot='9' AND bag='0'";
		$result = $conn->query($sql_hands);
		foreach($result as $hands);
		$sql_hands_final="SELECT itemEntry FROM item_instance WHERE guid='" . $hands["item"] . "'";
		$result2 = $conn->query($sql_hands_final);
		foreach($result2 as $hands_entry);
		//hands end
		//finger1 slot 10
		$sql_finger1= "SELECT item FROM character_inventory WHERE guid='" . $CHAR_GUID ."' AND slot='10' AND bag='0'";
		$result = $conn->query($sql_finger1);
		foreach($result as $finger1);
		$sql_finger1_final="SELECT itemEntry FROM item_instance WHERE guid='" . $finger1["item"] . "'";
		$result2 = $conn->query($sql_finger1_final);
		foreach($result2 as $finger1_entry);
		//finger1 end
		//finger2 slot 11
		$sql_finger2= "SELECT item FROM character_inventory WHERE guid='" . $CHAR_GUID ."' AND slot='11' AND bag='0'";
		$result = $conn->query($sql_finger2);
		foreach($result as $finger2);
		$sql_finger2_final="SELECT itemEntry FROM item_instance WHERE guid='" . $finger2["item"] . "'";
		$result2 = $conn->query($sql_finger2_final);
		foreach($result2 as $finger2_entry);
		//finger2 end
		//trinket1 slot 12
		$sql_trinket1= "SELECT item FROM character_inventory WHERE guid='" . $CHAR_GUID ."' AND slot='12' AND bag='0'";
		$result = $conn->query($sql_trinket1);
		foreach($result as $trinket1);
		$sql_trinket1_final="SELECT itemEntry FROM item_instance WHERE guid='" . $trinket1["item"] . "'";
		$result2 = $conn->query($sql_trinket1_final);
		foreach($result2 as $trinket1_entry);
		// trinket1 end
		//trinket2 slot 13
		$sql_trinket2= "SELECT item FROM character_inventory WHERE guid='" . $CHAR_GUID ."' AND slot='13' AND bag='0'";
		$result = $conn->query($sql_trinket2);
		foreach($result as $trinket2);
		$sql_trinket2_final="SELECT itemEntry FROM item_instance WHERE guid='" . $trinket2["item"] . "'";
		$result2 = $conn->query($sql_trinket2_final);
		foreach($result2 as $trinket2_entry);
		//trinket2 end
		//back slot 14
		$sql_back= "SELECT item FROM character_inventory WHERE guid='" . $CHAR_GUID ."' AND slot='14' AND bag='0'";
		$result = $conn->query($sql_back);
		foreach($result as $back);
		$sql_back_final="SELECT itemEntry FROM item_instance WHERE guid='" . $back["item"] . "'";
		$result2 = $conn->query($sql_back_final);
		foreach($result2 as $back_entry);
		//back end
		// main hand slot 15
		$sql_mainhand= "SELECT item FROM character_inventory WHERE guid='" . $CHAR_GUID ."' AND slot='15' AND bag='0'";
		$result = $conn->query($sql_mainhand);
		foreach($result as $mainhand);
		$sql_mainhand_final="SELECT itemEntry FROM item_instance WHERE guid='" . $mainhand["item"] . "'";
		$result2 = $conn->query($sql_mainhand_final);
		foreach($result2 as $mainhand_entry);
		// mainhand end
		// offhand slot 16
		$sql_offhand= "SELECT item FROM character_inventory WHERE guid='" . $CHAR_GUID ."' AND slot='16' AND bag='0'";
		$result = $conn->query($sql_offhand);
		foreach($result as $offhand);
		$sql_offhand_final="SELECT itemEntry FROM item_instance WHERE guid='" . $offhand["item"] . "'";
		$result2 = $conn->query($sql_offhand_final);
		foreach($result2 as $offhand_entry);
		//offhand end
		//relic slot 17
		$sql_relic= "SELECT item FROM character_inventory WHERE guid='" . $CHAR_GUID ."' AND slot='17' AND bag='0'";
		$result = $conn->query($sql_relic);
		foreach($result as $relic);
		$sql_relic_final="SELECT itemEntry FROM item_instance WHERE guid='" . $relic["item"] . "'";
		$result2 = $conn->query($sql_relic_final);
		foreach($result2 as $relic_entry);
		// relic end
		// tabard slot 18
		$sql_tabard= "SELECT item FROM character_inventory WHERE guid='" . $CHAR_GUID ."' AND slot='18' AND bag='0'";
		$result = $conn->query($sql_tabard);
		foreach($result as $tabard);
		$sql_tabard_final="SELECT itemEntry FROM item_instance WHERE guid='" . $tabard["item"] . "'";
		$result2 = $conn->query($sql_tabard_final);
		foreach($result2 as $tabard_entry);
		//tabard end
		echo'<div id="move">';
		echo'<form id="view">';
		
		echo'<table><tr>';
		$xml= simplexml_load_file('titles.xml');
		$temp =0;
		$TITLE_TEXT = '#s No Title';
		if($CHOSEN_TITLE){
		while($temp != $xml->count_conf->text ){
			if($xml->title[$temp]->id == $CHOSEN_TITLE){
				$TITLE_TEXT = $xml->title[$temp]->text;
				$temp = $xml->count_conf->text;
			}
			else{
				$temp++;
			}
		}
		}
		else{
			$TITLE_TEXT = '#s No Title';
		}
		$TITLE_TEXT_FINAL = str_replace('#s', $NAME, $TITLE_TEXT);
		echo'<th colspan="7"><text>' . $LEVEL . '&nbsp;lvl&nbsp;</text><img src="ICONS/race/' . $RACE . $GENDER . '.gif " style="width:20px;height:20px;vertical-align:middle;">&nbsp;&nbsp;<img src="icons/class/'. $CLASS .'.gif " style="width:20px;height:20px;vertical-align:middle;">&nbsp;
		<br><text>'. $TITLE_TEXT_FINAL .'</text><br><text>< '. $GUILD .' ></text></th>';
		
		
		echo'</tr><tr> ';
		// head slot
		if($head_entry["itemEntry"]){
			$url = 'http://www.wowhead.com/item='. $head_entry["itemEntry"] .'&xml';
			$xml = simplexml_load_file($url);
			$head_icon=$xml->item[0]->icon;
		}
		if($head_icon){
			echo'<td id="side"><a href="http://www.wowhead.com/item='. $head_entry["itemEntry"] .'"><img src="../armory/ICONS/' . $head_icon .'.png"></a></td>';
		}
		else{
			echo'<td id="side"><img src="icons/head.png" ></td>';
		}
		
		
		// portrait
		if($RACE == 1 || $RACE == 3 || $RACE == 4 || $RACE == 7 || $RACE == 11){
			
			$PORTRAIT = '<img src="icons/portrait/'. $GENDER . '-'. $RACE . '-'. $CLASS .'.gif" style="width:160px;height:160px;vertical-align:middle;
			box-shadow: 3px 3px 3px blue, 0 0 30px violet, 0 0 5px blue;margin:2px;" >';
		}
		if($RACE == 2 || $RACE == 5 || $RACE == 6 || $RACE == 8 || $RACE == 10){
			$PORTRAIT = '<img src="icons/portrait/'. $GENDER . '-'. $RACE . '-'. $CLASS .'.gif" style="width:160px;height:160px;vertical-align:middle;
			box-shadow: 3px 3px 3px orange, 0 0 30px red, 0 0 5px orange;margin:2px;" >';
		}
		// generate model view
		
		
		include'./MV.php';
		$mv = new ModelViewer();
		$mv->ObjectHeight = 370;
		$mv->ObjectWidth = 220;
		
		// get gender
		if($GENDER == 1){
			$mv->SetGender( GENDER_FEMALE );
		}
		if($GENDER == 0){
			$mv->SetGender( GENDER_MALE );
		}
		// get gender
		// get race
		if($RACE == 1){
			$mv->SetRace( RACE_HUMAN );
		}
		if($RACE == 2){
			$mv->SetRace( RACE_ORC );
		}
		if($RACE == 3){
			$mv->SetRace( RACE_DWARF );
		}
		if($RACE == 4){
			$mv->SetRace( RACE_NIGHTELF );
		}
		if($RACE == 5){
			$mv->SetRace( RACE_UNDEAD );
		}
		if($RACE == 6){
			$mv->SetRace( RACE_TAUREN );
		}
		if($RACE == 7){
			$mv->SetRace( RACE_GNOME );
		}
		if($RACE == 8){
			$mv->SetRace( RACE_TROLL );
		}
		if($RACE == 10){
			$mv->SetRace( RACE_BLOODELF );
		}
		if($RACE == 11){
			$mv->SetRace( RACE_DRAENEI );
		}
		//get race
		
		// get item display id's
		$connn = new mysqli($servername, $username, $password, $db_world);
			// head
		$findDID="SELECT displayid FROM item_template WHERE entry='" . $head_entry["itemEntry"] . "'";
		$DISPLAY_ID1 = $connn->query($findDID);
		if($DISPLAY_ID1){
			foreach($DISPLAY_ID1 as $DispId1)
			$mv->EquipItem( SLOT_HEAD, $DispId1["displayid"] );
		}
		else{
			$mv->UnequipItem( SLOT_HEAD);
		}
			// end head
			// hands
		$findDID="SELECT displayid FROM item_template WHERE entry='" . $hands_entry["itemEntry"] . "'";
		$DISPLAY_ID2 = $connn->query($findDID);
		if($DISPLAY_ID2){
			foreach($DISPLAY_ID2 as $DispId2)
			$mv->EquipItem( SLOT_HANDS, $DispId2["displayid"] );
		}
		else{
			$mv->UnequipItem( SLOT_HANDS);
		}
			// end hands
	
		// shoulders
		$findDID="SELECT displayid FROM item_template WHERE entry='" . $shoulders_entry["itemEntry"] . "'";
		$DISPLAY_ID3 = $connn->query($findDID);
		if($DISPLAY_ID3){
			foreach($DISPLAY_ID3 as $DispId3)
			$mv->EquipItem( SLOT_SHOULDERS, $DispId3["displayid"] );
		}
		else{
			$mv->UnequipItem( SLOT_SHOULDERS);
		}	
			// end shoulders
			
			// tabard
		$findDID="SELECT displayid FROM item_template WHERE entry='" . $tabard_entry["itemEntry"] . "'";
		$DISPLAY_ID4 = $connn->query($findDID);
		if($DISPLAY_ID4){
			foreach($DISPLAY_ID4 as $DispId4)
			$mv->EquipItem( SLOT_TABARD, $DispId4["displayid"] );
		}
		else{
			$mv->UnequipItem( SLOT_TABARD);
		}
			// tabard
			
			// shirt
		$findDID="SELECT displayid FROM item_template WHERE entry='" . $shirt_entry["itemEntry"] . "'";
		$DISPLAY_ID5 = $connn->query($findDID);
		if($DISPLAY_ID5){
			foreach($DISPLAY_ID5 as $DispId5)
			$mv->EquipItem( SLOT_SHIRT, $DispId5["displayid"] );
		}
		else{
			$mv->UnequipItem( SLOT_SHIRT);
		}
			// end shirt
			
			
			// chest
		$findDID="SELECT displayid FROM item_template WHERE entry='" . $chest_entry["itemEntry"] . "'";
		$DISPLAY_ID6 = $connn->query($findDID);
		if($DISPLAY_ID6){
			foreach($DISPLAY_ID6 as $DispId6)
			$mv->EquipItem( SLOT_CHEST, $DispId6["displayid"] );
		}
		else{
			$mv->UnequipItem( SLOT_CHEST);
		}
			//end chest
			
			// legs
		$findDID="SELECT displayid FROM item_template WHERE entry='" . $legs_entry["itemEntry"] . "'";
		$DISPLAY_ID6 = $connn->query($findDID);
		if($DISPLAY_ID6){
			foreach($DISPLAY_ID6 as $DispId6)
			$mv->EquipItem( SLOT_LEGS, $DispId6["displayid"] );
		}
		else{
			$mv->UnequipItem( SLOT_LEGS);
		}	
			//end legs
			// back
		$findDID="SELECT displayid FROM item_template WHERE entry='" . $back_entry["itemEntry"] . "'";
		$DISPLAY_ID6 = $connn->query($findDID);
		if($DISPLAY_ID6){
			foreach($DISPLAY_ID6 as $DispId6)
			$mv->EquipItem( SLOT_BACK, $DispId6["displayid"] );
		}
		else{
			$mv->UnequipItem( SLOT_BACK);
		}
			// end back
			// feet 
		$findDID="SELECT displayid FROM item_template WHERE entry='" . $feet_entry["itemEntry"] . "'";
		$DISPLAY_ID6 = $connn->query($findDID);
		if($DISPLAY_ID6){
			foreach($DISPLAY_ID6 as $DispId6)
			$mv->EquipItem( SLOT_FEET, $DispId6["displayid"] );
		}
		else{
			$mv->UnequipItem( SLOT_FEET);
		}
			//end feet
			// waist
		$findDID="SELECT displayid FROM item_template WHERE entry='" . $waist_entry["itemEntry"] . "'";
		$DISPLAY_ID6 = $connn->query($findDID);
		if($DISPLAY_ID6){
			foreach($DISPLAY_ID6 as $DispId6)
			$mv->EquipItem( SLOT_WAIST, $DispId6["displayid"] );
		}
		else{
			$mv->UnequipItem( SLOT_WAIST);
		}	
			//end waist
			// wrist
		$findDID="SELECT displayid FROM item_template WHERE entry='" . $wrist_entry["itemEntry"] . "'";
		$DISPLAY_ID6 = $connn->query($findDID);
		if($DISPLAY_ID6){
			foreach($DISPLAY_ID6 as $DispId6)
			$mv->EquipItem( SLOT_WRISTS, $DispId6["displayid"] );
		}
		else{
			$mv->UnequipItem( SLOT_WRISTS);
		}	
			// end wrist
			// main hand
		$findDID="SELECT displayid FROM item_template WHERE entry='" . $mainhand_entry["itemEntry"] . "'";
		$DISPLAY_ID6 = $connn->query($findDID);
		if($DISPLAY_ID6){
			foreach($DISPLAY_ID6 as $DispId6)
			$mv->EquipItem( SLOT_MAINHAND, $DispId6["displayid"] );
		}
		else{
			$mv->UnequipItem( SLOT_MAINHAND);
		}
			//end main hand
			// off hand
		$findDID="SELECT displayid FROM item_template WHERE entry='" . $offhand_entry["itemEntry"] . "'";
		$DISPLAY_ID6 = $connn->query($findDID);
		if($DISPLAY_ID6){
			foreach($DISPLAY_ID6 as $DispId6)
			$mv->EquipItem( SLOT_OFFHAND, $DispId6["displayid"] );
		}
		else{
			$mv->UnequipItem( SLOT_OFFHAND);
		}
			// end offhand
			
		// get item display id's
		$connn->close();
		echo'<td colspan="5" rowspan="7" id="middle">' . $mv->GetCharacterHtml(). '</td>';

		
		//hands 
		if($hands_entry["itemEntry"]){
		$url = 'http://www.wowhead.com/item='. $hands_entry["itemEntry"] .'&xml';
		$xml = simplexml_load_file($url);
		$hands_icon=$xml->item[0]->icon;
		}
		if($hands_icon){
			echo'<td id="side"><a href="http://www.wowhead.com/item='. $hands_entry["itemEntry"] .'"><img src="../armory/ICONS/' . $hands_icon .'.png"></a></td>';
		}
		else{
			echo'<td id="side"><img src="icons/hands.png"></td>';
		}
		echo'</tr><tr>';
		//neck
		if($neck_entry["itemEntry"]){
		$url = 'http://www.wowhead.com/item='. $neck_entry["itemEntry"] .'&xml';
		$xml = simplexml_load_file($url);
		$neck_icon=$xml->item[0]->icon;
		}
		if($neck_icon){
			echo'<td id="side"><a href="http://www.wowhead.com/item='. $neck_entry["itemEntry"] .'"><img src="../armory/ICONS/' . $neck_icon .'.png"></a></td>';
		}
		else{
			echo'<td id="side"><img src="icons/neck.png"></td>';
		}
		// waist
		if($waist_entry["itemEntry"]){
		$url = 'http://www.wowhead.com/item='. $waist_entry["itemEntry"] .'&xml';
		$xml = simplexml_load_file($url);
		$waist_icon=$xml->item[0]->icon;
		}
		if($waist_icon){
			echo'<td id="side"><a href="http://www.wowhead.com/item='. $waist_entry["itemEntry"] .'"><img src="../armory/ICONS/' . $waist_icon .'.png"></a></td>';
		}
		else{
			echo'<td id="side"><img src="icons/waist.png"></td>';
		}
		echo'</tr><tr >';
		//shoulders
		if($shoulders_entry["itemEntry"]){
		$url = 'http://www.wowhead.com/item='. $shoulders_entry["itemEntry"] .'&xml';
		$xml = simplexml_load_file($url);
		$shoulders_icon=$xml->item[0]->icon;
		}
		if($shoulders_icon){
			echo'<td id="side"><a href="http://www.wowhead.com/item='. $shoulders_entry["itemEntry"] .'"><img src="../armory/ICONS/' . $shoulders_icon .'.png"></a></td>';
		}
		else{
			echo'<td id="side"><img src="icons/shoulder.png"></td>';
		}
		//legs 
		if($legs_entry["itemEntry"]){
		$url = 'http://www.wowhead.com/item='. $legs_entry["itemEntry"] .'&xml';
		$xml = simplexml_load_file($url);
		$legs_icon=$xml->item[0]->icon;
		}
		if($legs_icon){
		echo'<td id="side"><a href="http://www.wowhead.com/item='. $legs_entry["itemEntry"] .'"><img src="../armory/ICONS/' . $legs_icon .'.png"></a></td>';
		}
		else{
			echo'<td id="side"><img src="icons/legs.png"></td>';
		}
		echo'</tr><tr>';
		// back
		if($back_entry["itemEntry"]){
		$url = 'http://www.wowhead.com/item='. $back_entry["itemEntry"] .'&xml';
		$xml = simplexml_load_file($url);
		$back_icon=$xml->item[0]->icon;
		}
		if($back_icon){
			echo'<td id="side"><a href="http://www.wowhead.com/item='. $back_entry["itemEntry"] .'"><img src="../armory/ICONS/' . $back_icon .'.png"></a></td>';
		}
		else{
			echo'<td id="side"><img src="icons/back.png"></td>';
		}
		/*
		// stats	
		function secondsToTime($seconds) {
			$dtF = new DateTime("@0");
			$dtT = new DateTime("@$seconds");
			return $dtF->diff($dtT)->format('%a days, %h hr, %i min, %s sec');
		}
		echo'<td colspan="5" rowspan="1" id="middle"><text>Played time:<br>'. secondsToTime($TOTAL_TIME)  .'</text><br><text>Played on this level:<br>'. secondsToTime($LEVEL_TIME).'</text><br><text>Honor points(total/today):<br>'.$TOTAL_HONOR.'/'.$TODAY_HONOR.'</text>
		<br><text>H Points yesterday:&nbsp;'.$YESTERDAY_HONOR.'</text>
		<br><text>Honorable kills(total/today):<br>'.$TOTAL_KILLS.'/'.$TODAY_KILLS.'</text>
		<br><text>Kills yesterday:&nbsp;'.$YESTERDAY_KILLS.'</td>';
		*/
		
		// feet
		if($feet_entry["itemEntry"]){
		$url = 'http://www.wowhead.com/item='. $feet_entry["itemEntry"] .'&xml';
		$xml = simplexml_load_file($url);
		$feet_icon=$xml->item[0]->icon;
		}
		if($feet_icon){
			echo'<td id="side"><a href="http://www.wowhead.com/item='. $feet_entry["itemEntry"] .'"><img src="../armory/ICONS/' . $feet_icon .'.png"></a></td>';
		}
		else{
			echo'<td id="side"><img src="icons/feet.png"></td>';
		}
		echo'</tr><tr>';
		//chest
		if($chest_entry["itemEntry"]){
		$url = 'http://www.wowhead.com/item='. $chest_entry["itemEntry"] .'&xml';
		$xml = simplexml_load_file($url);
		$chest_icon=$xml->item[0]->icon;
		}
		if($chest_icon){
			echo'<td id="side"><a href="http://www.wowhead.com/item='. $chest_entry["itemEntry"] .'"><img src="../armory/ICONS/' . $chest_icon .'.png"></a></td>';
		}
		else{
			echo'<td id="side"><img src="icons/chest.png"></td>';
		}
		//finger1
		if($finger1_entry["itemEntry"]){
		$url = 'http://www.wowhead.com/item='. $finger1_entry["itemEntry"] .'&xml';
		$xml = simplexml_load_file($url);
		$finger1_icon=$xml->item[0]->icon;
		}
		if($finger1_icon){
			echo'<td id="side"><a href="http://www.wowhead.com/item='. $finger1_entry["itemEntry"] .'"><img src="../armory/ICONS/' . $finger1_icon .'.png"></td>';
		}
		else{
			echo'<td id="side"><img src="icons/ring.png"></td>';
		}
		echo'</tr><tr>';
		//shirt
		if($shirt_entry["itemEntry"]){
		$url = 'http://www.wowhead.com/item='. $shirt_entry["itemEntry"] .'&xml';
		$xml = simplexml_load_file($url);
		$shirt_icon=$xml->item[0]->icon;
		}
		if($shirt_icon){
			echo'<td id="side"><a href="http://www.wowhead.com/item='. $shirt_entry["itemEntry"] .'"><img src="../armory/ICONS/' . $shirt_icon .'.png"></td>';
		}
		else{
			echo'<td id="side"><img src="icons/shirt.png"></td>';
		}
		//finger2
		$url = 'http://www.wowhead.com/item='. $finger2_entry["itemEntry"] .'&xml';
		$xml = simplexml_load_file($url);
		$finger2_icon=$xml->item[0]->icon;
		if($finger2_icon){
			echo'<td id="side"><a href="http://www.wowhead.com/item='. $finger2_entry["itemEntry"] .'"><img src="../armory/ICONS/' . $finger2_icon .'.png"></td>';
		}
		else{
			echo'<td id="side"><img src="icons/ring.png"></td>';
		}
		echo'</tr><tr>';
		//tabard
		if($tabard_entry["itemEntry"]){
		$url = 'http://www.wowhead.com/item='. $tabard_entry["itemEntry"] .'&xml';
		$xml = simplexml_load_file($url);
		$tabard_icon=$xml->item[0]->icon;
		}
		if($tabard_icon){
			echo'<td id="side"><a href="http://www.wowhead.com/item='. $tabard_entry["itemEntry"] .'"><img src="../armory/ICONS/' . $tabard_icon .'.png"></td>';
		}
		else{
			echo'<td id="side"><img src="icons/tabard.png"></td>';
		}
		//trinket1
		if($trinket1_entry["itemEntry"] ){
		$url = 'http://www.wowhead.com/item='. $trinket1_entry["itemEntry"] .'&xml';
		$xml = simplexml_load_file($url);
		$trinket1_icon=$xml->item[0]->icon;
		}
		if($trinket1_icon){
			echo'<td id="side"><a href="http://www.wowhead.com/item='. $trinket1_entry["itemEntry"] .'"><img src="../armory/ICONS/' . $trinket1_icon .'.png"></td>';
		}
		else{
			echo'<td id="side"><img src="icons/trinket.png"></td>';
		}
		
		
		
		echo'</tr><tr>';
		// wrist
		if($wrist_entry["itemEntry"]){
		$url = 'http://www.wowhead.com/item='. $wrist_entry["itemEntry"] .'&xml';
		$xml = simplexml_load_file($url);
		$wrist_icon=$xml->item[0]->icon;
		}
		if($wrist_icon){
			echo'<td id="side"><a href="http://www.wowhead.com/item='. $wrist_entry["itemEntry"] .'"><img src="../armory/ICONS/' . $wrist_icon .'.png"></td>';
		}
		else{
			echo'<td id="side"><img src="icons/bracer.png"></td>';
		}
		
		echo'<td colspan="5">'.$POWER.'</td>';
		
		//trinket2
		if($trinket2_entry["itemEntry"]){
		$url = 'http://www.wowhead.com/item='. $trinket2_entry["itemEntry"] .'&xml';
		$xml = simplexml_load_file($url);
		$trinket2_icon=$xml->item[0]->icon;
		}
		if($trinket2_icon){
			echo'<td id="side"><a href="http://www.wowhead.com/item='. $trinket2_entry["itemEntry"] .'"><img src="../armory/ICONS/' . $trinket2_icon .'.png"></td>';
		}
		else{
			echo'<td id="side"><img src="icons/trinket.png"></td>';
		}
		echo'</tr><tr>';
		echo'<td id="side" colspan="2"></td>';
		//mainhand
		if($mainhand_entry["itemEntry"]){
		$url = 'http://www.wowhead.com/item='. $mainhand_entry["itemEntry"] .'&xml';
		$xml = simplexml_load_file($url);
		$mainhand_icon=$xml->item[0]->icon;
		}
		if($mainhand_icon){
			echo'<td id="side"><a href="http://www.wowhead.com/item='. $mainhand_entry["itemEntry"] .'"><img src="../armory/ICONS/' . $mainhand_icon .'.png"></td>';
		}
		else{
			echo'<td id="side"><img src="icons/mainhand.png"></td>';
		}
		// offhand
		if($offhand_entry["itemEntry"]){
		$url = 'http://www.wowhead.com/item='. $offhand_entry["itemEntry"] .'&xml';
		$xml = simplexml_load_file($url);
		$offhand_icon=$xml->item[0]->icon;
		}
		if($offhand_icon){
			echo'<td id="side"><a href="http://www.wowhead.com/item='. $offhand_entry["itemEntry"] .'"><img src="../armory/ICONS/' . $offhand_icon .'.png"></td>';
		}
		else{
			echo'<td id="side"><img src="icons/offhand.png"></td>';
		}
		//relic
		if($relic_entry["itemEntry"]){
		$url = 'http://www.wowhead.com/item='. $relic_entry["itemEntry"] .'&xml';
		$xml = simplexml_load_file($url);
		$relic_icon=$xml->item[0]->icon;
		}
		if($relic_icon){
			echo'<td id="side"><a href="http://www.wowhead.com/item='. $relic_entry["itemEntry"] .'"><img src="../armory/ICONS/' . $relic_icon .'.png"></td>';
		}
		else{
			echo'<td id="side"><img src="icons/relic.png"></td>';
		}
		echo'<td id="side" colspan="2"></td></tr>';
		echo'</table>';
		echo'</form>';
		echo'</div>';
		$conn->close();
		
		// display arena team data
		include'/arena/2v2.php';
		include'/arena/3v3.php';
		include'/arena/5v5.php';
		
		
		if($S2TEAM_NAME){
			$twoVsTwoTeamData = '<div><table style="width: 190px; padding:0px;margin:0px;"><tr><td><text>Personal rating</text></td><td><text style="color:yellow;">'.$S2PLR_PERSONAL_RATING.'</text></td></tr><th colspan="2"><text>Team</text></th><tr><td colspan="2" style=" text-align:center;"><text style="color:orange;">'.$S2TEAM_NAME.'</text></td></tr><tr><td><text style="color:yellow;">'.$S2TEAM_CAPITAN_NAME.'</text></td><td><text>(CPT)</text></td></tr><tr><td><text>Rating</text></td><td><text style="color:yellow;">'.$S2TEAM_RATING.'</text></td></tr><tr><td><text>Rank</text></td><td><text style="color:yellow;">'.$S2TEAM_RANK.'</text></td></tr></table></div>';
		}
		else{
			$twoVsTwoTeamData = '<div><text>There is no 2 vs 2 arena team</text></div>';
		}
		if($S3TEAM_NAME){
			$treeVsTreeTeamData = '<div><table style="width: 190px; padding:0px;margin:0px;"><tr><td><text>Personal rating</text></td><td><text style="color:yellow;">'.$S3PLR_PERSONAL_RATING.'</text></td></tr><th colspan="2"><text>Team</text></th><tr><td colspan="2" style=" text-align:center;"><text style="color:orange;">'.$S3TEAM_NAME.'</text></td></tr><tr><td><text style="color:yellow;">'.$S3TEAM_CAPITAN_NAME.'</text></td><td><text>(CPT)</text></td></tr><tr><td><text>Rating</text></td><td><text style="color:yellow;">'.$S3TEAM_RATING.'</text></td></tr><tr><td><text>Rank</text></td><td><text style="color:yellow;">'.$S3TEAM_RANK.'</text></td></tr></table></div>';
		}
		else{
			$treeVsTreeTeamData = '<div><text>There is no 3 vs 3 arena team</text></div>';
		}
		if($S5TEAM_NAME){
			$fiveVsFiveTeamData = '<div><table style="width: 190px; padding:0px;margin:0px;"><tr><td><text>Personal rating</text></td><td><text style="color:yellow;">'.$S5PLR_PERSONAL_RATING.'</text></td></tr><th colspan="2"><text>Team</text></th><tr><td colspan="2" style=" text-align:center;"><text style="color:orange;">'.$S5TEAM_NAME.'</text></td></tr><tr><td><text style="color:yellow;">'.$S5TEAM_CAPITAN_NAME.'</text></td><td><text>(CPT)</text></td></tr><tr><td><text>Rating</text></td><td><text style="color:yellow;">'.$S5TEAM_RATING.'</text></td></tr><tr><td><text>Rank</text></td><td><text style="color:yellow;">'.$S5TEAM_RANK.'</text></td></tr></table></div>';
		}
		else{
			$fiveVsFiveTeamData = '<div><text>There is no 5 vs 5 arena team</text></div>';
		}
		echo'<form id="arena" style="width: 606px;height:265px; margin-left:70px;">';
		echo'<table style="text-align:center; width: 600px; height: 260px; padding-left:3px;margin-left:3px;">';
		echo'<th colspan="3" id="headerArena"><text>Arena team info</text></th>'; 
		echo'<tr><td id="subHeaderArena"  style="border-bottom:1px solid orange;"><text>2v2</text></td><td id="subHeaderArena"  style="border-bottom:1px solid orange;"><text>3v3</text></td><td id="subHeaderArena"  style="border-bottom:1px solid orange;"><text>5v5</text></td></tr>';
		echo'<tr><td id="body2vs2">'.$twoVsTwoTeamData.'</td><td id="body3vs3">'.$treeVsTreeTeamData.'</td><td id="body5vs5">'.$fiveVsFiveTeamData.'</td></tr>';
		echo'</table>';
		echo'</form>';
		
	}
	else{
		echo'<form><br><br><text style="font-size: 30px;margin-left: 35%;">Not found</text></form>';
	}
}
?>

	
	
	
