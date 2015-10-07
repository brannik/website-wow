<?php
session_start();
if(session_destroy()) // Destroying All Sessions
{
header("Location: main.php"); // Redirecting To Home Page
}
?>