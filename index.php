<link rel="stylesheet" type="text/css" href="error.css">
<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
<?php
include'config/connect.php';
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo'<form id="errorForm">';
	echo'<h1 id="errorHeader">грешка<h1>';
	echo'<ul id="errorList">';
	echo'<li>Този сайт изисква MYSQL сървър. Ако виждате това съобщение значи сървъра не работи или няма създадена таблица/и.</li>';
	echo'<li>Тблиците се намират в папка TABLES.</li>';
	echo'<li>Настройките за свързването са в CONFIG/CONNECT.PHP.</li>';
	echo'<li>Сървъра се стартита от DATABASE/mysql_start.bat</li>';
	echo'</ul>';
	echo'</form>';
} 
?>

<frameset cols="15%,*,25%" FRAMEBORDER=NO FRAMESPACING=0 BORDER=0>
	<frame name="menu" src="menu.php" noresize="noresize" scrolling="no">
	<frame name="main" src="main.php" noresize="noresize" scrolling="yes" >
	<frame name="rmenu" src="/usermenu/index.php" noresize="noresize" scrolling="yes">
</frameset>