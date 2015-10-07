
<?php 
include'../config/connect.php';
include'../session_special.php';
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(isset($_POST['postBtn'])){ 
	if($_POST["title"] != NULL && $_POST["text"] != NULL){
	$sql = "INSERT INTO news (title,text,autor)VALUES ('" . $_POST["title"] . "', '" . $_POST["text"]."','" . $_SESSION['login_user'] . "')";

	if ($conn->query($sql) === TRUE) {
		header('Location: ../main.php'); 
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error; 
	}
	}
	else{
		header('Location: ../main.php'); 
		echo "<script type='text/javascript'>alert('Title/text is empty!!!')</script>";
	}
}
else{
		$option = $_POST['dellOption'];
		$sql = "DELETE FROM news WHERE id=" . $option;
		if ($conn->query($sql) === TRUE) {
		header('Location: ../main.php'); 
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
		header('Location: ../main.php'); 
	}
		
}
	$conn->close();
	 
?>