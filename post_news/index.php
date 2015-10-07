<link rel="stylesheet" type="text/css" href="index.css">
<?php
include'../config/connect.php';
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

echo'<h1>menage news</h1>';
echo'<form method="post" action="submit.php">';
echo'<h1>post news</h1>';
echo'<text>Title&nbsp;</text>';
echo'<input type="text" name="title" id="titleText"><br>';
echo'<textarea name="text" cols="40" rows="5" size="400"></textarea><br>';
echo'<input type="submit" id="postBtn" name="postBtn" value="Post">';
echo'<hr>';
echo'<h1>delete news</h1>';
$sql = "SELECT id, title FROM news";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo'<select name="dellOption" id="dellOption">';
    while($row = $result->fetch_assoc()) {
        // echo "id: " . $row["id"]. " - Name: " . $row["username"]. " " . $row["password"]. "<br>";
		// <li><a href="../home.html#home" target="main">Home</a></li>
		echo'<option value="' . $row["id"] . '">' . $row["title"] . '</option>';		
    }
	echo'</select>';
} else {
	echo'<select>';
    echo'<option value="1" >No news</option>';
	echo'</select>';
}
echo'<input type="submit" name="delBtn" id="delBtn" value="delete">';
echo'</form>';
$conn->close();
?>