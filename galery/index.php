<link rel="stylesheet" type="text/css" href="index.css">
<?php
include'../config/connect.php';
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id,link FROM galery";
$temp=1;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo'<h1>galery</h1>';
	echo'<table id="galery" >';
    while($row = $result->fetch_assoc()) {
		if($temp==1){
			echo'<tr>';
		}
		if($temp <=4){
			echo'<td>';
			echo'<form class="grow" >';
			echo'<img src="' . $row["link"] . '">';
			echo'</form>';
			echo'</td>';
			$temp++;
		}
		if($temp ==4){
			echo'</tr><br>';
			$temp=1;
		}
    }
	echo'<table>';
} else {
    echo "0 results";
}
$conn->close();
?>