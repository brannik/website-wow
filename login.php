
<?php
include'/config/connect.php';
$connection = mysql_connect($servername, $username, $password,$dbname);
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
if(isset($_POST['regBtn'])){
	session_start();
	session_destroy(); // Destroying All Sessions
	?>
	<script>
		top.frames['main'].location.href = '../register/index.php';
	</script>
	<?php
}
if(isset($_POST['logout'])){
	session_start();
	session_destroy(); // Destroying All Sessions

	?>
	<script>
		top.frames['main'].location.href = '../main.php';
		top.frames['menu'].location.href = '../menu.php';
		top.frames['rmenu'].location.href = 'index.php';
	</script>
	<?php
}
if (isset($_POST['submit'])) {
if (empty($_POST['username']) || empty($_POST['password'])) {
$error = "Username or Password is invalid";
echo'<text>Username or Password is invalid</text>';
}

else
{
// Define $username and $password
$username=$_POST['username'];
$password=$_POST['password'];
// Establishing Connection with Server by passing server_name, user_id and password as a parameter

// To protect MySQL injection for Security purpose

$username = stripslashes($username);
$password = stripslashes($password);

$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);
// Selecting Database
$db = mysql_select_db($db_auth, $connection);
// SQL query to fetch information of registerd users and finds user match.
// password encryption
$PASSWORD = SHA1(strtoupper($username).':'.strtoupper($password));
// password encryption
$query = mysql_query("select * from account where sha_pass_hash='".$PASSWORD."' AND username='$username'", $connection);
$rows = mysql_num_rows($query);
if ($rows == 1) {
$_SESSION['login_user']=$username; // Initializing Session
	
	include'/config/connect.php';
	$conn = new mysqli($servername, $username, $password, $db_auth);
	$username_upper = strtoupper($_SESSION['login_user']);
	$update_acc = "SELECT id FROM account WHERE username='".$username_upper."'";
	$result = $conn->query($update_acc);
	foreach($result as $row){
	$id=$row["id"];
	$update_acc_rank = "SELECT gmlevel FROM account_access WHERE id='".$id."'";
	$result22 = $conn->query($update_acc_rank);
	foreach($result22 as $row2){
		
		$gmlevel = $row2["gmlevel"];
	}
}	
	$lower = strtolower($username_upper);
	$update_acc_final = "UPDATE site.account SET id='".$id."',rank='" . $gmlevel . "' WHERE username='" . $lower . "'";
	$result33 = $conn->query($update_acc_final);
	$conn->close();
	?>
	<script>
		top.frames['main'].location.href = '../main.php';
		top.frames['menu'].location.href = '../menu.php';
		top.frames['rmenu'].location.href = 'index.php';
	</script>
	<?php
} else {
$error = "Username or Password is invalid";
}
mysql_close($connection); // Closing Connection
}
}
?>