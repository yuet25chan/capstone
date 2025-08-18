<?php


$servername = "localhost";
$username = "kusho";
$password = "AA3bJfmHgF0pNSM";
$dbname = "yuetsdb";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


?>
