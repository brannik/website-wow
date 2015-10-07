<script type="text/javascript" src="http://static.wowhead.com/widgets/power.js"></script>
<script>var wowhead_tooltips = { "colorlinks": false, "iconizelinks": false, "renamelinks": false  }</script>
<?php
	$url = 'http://www.wowhead.com/item=12064&xml';
	$xml = simplexml_load_file($url);
	$title=$xml->item[0]->icon;
	echo'<a href="http://www.wowhead.com/item=12064"><img src="/armory/ICONS/' . $title .'.png"></a>';
?>