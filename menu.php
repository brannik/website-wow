<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="styles.css" />
<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
<?php
include'session_special.php';
include'config/connect.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT id, text,link,acces,class FROM menu ORDER BY acces ASC";
$result = $conn->query($sql);
$sql2 = "SELECT rank FROM account where username='" . $_SESSION['login_user'] . "'" ;
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();
echo'<body>';
echo'<div id="main">';

echo'<ul id="navigationMenu">';
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		if($_SESSION['login_user']!=''){
			if($row["acces"]<=$row2["rank"]){
				echo'<li>';
				$link_name = ucfirst($row["text"]);
					echo'<a class="'.$row["class"].'" href=' . $row["link"] . '><base target="main">';
						echo'<span>' . $link_name . '</span>';
					echo'</a>';
				echo'</li>';
				
			}
		}
		else{
			if($row["acces"]==0){
				echo'<li>';
				$link_name = ucfirst($row["text"]);
					echo'<a class="'.$row["class"].'" href=' . $row["link"] . '>';
						echo'<span>' . $link_name . '</span>';
					echo'<base target="main"></a>';
				echo'</li>';
			}
		}
    }
	
	echo'</ul>';
	echo'</form>';
	echo'</body>';
} else {
    echo "0 results";
}
$conn->close();
?>
