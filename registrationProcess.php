

<?php
$x = rand(1, 10000000); 
$original_password = $_POST['username'] . $x;
//password_hash is safer
$epassword = password_hash($original_password, PASSWORD_DEFAULT);

include 'db_credentials.php';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (username, email, user_password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hashed_password);

// Set parameters and execute
$username = $_POST['username'];
$email = $_POST['email'];
$hashed_password = $epassword;

$to = $_POST['email'];
$subject = "Thank you for Registering";
$text = "Your username is <i>" . $_POST['username'] . "</i><br> Your password is <i>" . $original_password . "</i>";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <noreply@yuetchan.opalstacked.com>' . "\r\n";

mail($to, $subject, $text, $headers);

if ($stmt->execute()) {
  header('Location:index.php'); exit();
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
