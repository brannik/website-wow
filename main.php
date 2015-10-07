<link rel="stylesheet" type="text/css" href="main.css">
<link rel="stylesheet" type="text/css" href="acp.css">
<?php
include'config/connect.php';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT title,text,date,autor FROM news ORDER BY id DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	
	echo'<h1>main page</h1>';
	while($row = $result->fetch_assoc()) {
		echo'<form>';
		echo'<h2>' . $row["title"] . '</h2>';
		echo'<p>' . $row["text"] . '</p>';
		echo'<h3>' . $row["date"] . '&nbsp;by&nbsp;-&nbsp;&nbsp;'. $row["autor"].'</h3>';
		echo'</form>';
	}
}
else{
	echo'<h1>main page</h1>';
	echo'<form>';
	echo'<h2>news</h2>';
	echo'<p>News page is empty</p>';
	echo'</form>';
}
$conn->close();
?>