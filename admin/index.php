<link rel="stylesheet" type="text/css" href="index.css">
<script type="text/JavaScript">
function clear_add(){
	var val = document.getElementById("entry");
	val.value = ""; 
	var val2 = document.getElementById("itemName");
	val2.value = ""; 
	var val3 = document.getElementById("price");
	val3.value = ""; 
}
function clear_upd(){
	var val = document.getElementById("priceEdit");
	val.value = ""; 
	var val2 = document.getElementById("serchTxt");
	val2.value = ""; 
}
</script>
<?php
	
	echo'<h1>admin controll panel</h1>';
	echo'<h2>Menage shop items</h2>';
	echo'<table><tr><td>';
	
	echo'<form>';
	echo'<text>Add item to shop</text>';
	
	echo'<table id="tblPos">';
	echo'<tr><td><text>Entry:&nbsp;</text></td><td><input type"text" name="entry" id="entry"></td></tr>';
	echo'<tr><td><text>Name:&nbsp;</text></td><td><input type"text" name="itemName" id="itemName"></td></tr>';
	echo'<tr><td><text>Price:&nbsp;</text></td><td><input type"text" name="price" id="price"></td></tr>';
	echo'<tr><td><text>Price type:&nbsp;</text></td><td><select name="priceType"><option value="1">Gold Coins</option><option value="2">Copper Coins</option><option value="3">Blizz Emblems</option></select></td></tr>';
	echo'<tr><td></td><td><input type="submit" name="add" value="Add Item">&nbsp;<input type="button" name="clear" value="Reset form" onclick="clear_add()"></td></tr>';
	echo'</table>';
	echo'</form>';

	
	echo'</td><td>';
	

	echo'<form>';
	
	
	
	echo'<text>Modify price of item in shop</text><br>';
	echo'<table id="tblPos"><tr><td><text>Serch item by</text></td></tr>';
	echo'<tr><td><select>';
		echo'<option value="1">Entry</option>';
		echo'<option value="2">Name</option>';
	echo'</select></td>';
	echo'<td><input type="button" name="serchBtn" value="Serch" onclick="serch_item()"></td></tr>';
	echo'<tr><td><text>Result</text></td><td><input type="text" name="serchTxt" id="serchTxt"></td></tr>';
	echo'<tr><td><text>Price</text></td><td><input type="text" name="priceEdit" id="priceEdit"></td></tr>';
	echo'<tr><td><text>Price type:&nbsp;</text></td><td><select name="priceType"><option value="1">Gold Coins</option><option value="2">Copper Coins</option><option value="3">Blizz Emblems</option></select></td></tr>';
	echo'<tr><td></td><td><input type="submit" name="update" id="update" value="Update">&nbsp;<input type="button" name="resetUpd" id="resetUpd" value="Reset" onclick="clear_upd()"></td></tr>';
	echo'</table>';
	
	echo'</form>';
	
	echo'</td></tr><tr><td colspan="2" id="mergedCol" >';
	echo'<div>';
	echo'<form >';
	
	echo'<text>Delete item from shop</text><br>';

	echo'</form>';
	echo'</div>';
	echo'</td></tr></table><hr>';
	
	echo'<h2>Menage accounts</h2>';
	echo'<table><tr><td>';
	echo'<form>';
	
	echo'<text>Edit account</text><br>';
	
	echo'</form>';
	
	echo'</td><td>';
	
	echo'<form>';
	
	echo'<text>Delete account</text><br>';
	
	echo'</form>';
	
	echo'</td></tr><tr><td>';
	
	echo'<form>';
	
	echo'<text>Ban account</text><br>';
	
	echo'</form>';
	
	echo'</td><td>';
	
	echo'<form>';
	
	echo'<text>Unban account</text><br>';
	
	echo'</form>';
	
	echo'</td></tr>';
	echo'</table>';
?>