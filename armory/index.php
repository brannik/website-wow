<link rel="stylesheet" type="text/css" href="index.css">
<link rel="stylesheet" type="text/css" href="style.css">
<?php
echo'<h1>armory</h1>';
echo'<form action="" method="post" id="hidenForm" style="background: none; box-shadow: none;">';
	echo'<div style="background-image: url(../armory/search-plate.png);background-repeat: no-repeat; width: 505px; height:90px;">';
	echo'<input type="text" name="serchTxt" id="serchTxt" style="height: 30px; width: 230px; margin-top: 20px; margin-left: 135px;">';
	echo'<br><input type="submit" name="serchBtn" id="serchBtn" value="Search" style="margin-top:16px; margin-left: 260px; width: 95px; height: 18px; font-size: 13px;">';
	echo'</div>';
echo'</form>';
include'search.php';
?>