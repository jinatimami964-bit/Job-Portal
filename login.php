<?php
session_start();
include "db_connect.php";

$error = "";

if(isset($_POST['login'])){

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email'";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)==1){

$user = mysqli_fetch_assoc($result);

if(password_verify($password,$user['password'])){

$_SESSION['user_id']=$user['id'];
$_SESSION['username']=$user['username'];
// --- CHANGED / ADDED LINE BELOW: Track login timestamp for session timeout ---
$_SESSION['last_activity'] = time();
header("Location: dashboard.php");
exit();

}else{

$error="Wrong Password";

}

}else{

$error="User Not Found";

}

}
?>

<!DOCTYPE html>

<html>

<head>

<title>Login</title>

</head>

<body>

<h2>Login</h2>

<?php echo $error; ?>

<form method="POST">

<input type="email" name="email" placeholder="Email" required><br><br>

<!-- ADDED: id="password" so JavaScript can reference it -->
<input type="password" id="password" name="password" placeholder="Password" required>

<!-- ADDED: Show/Hide Checkbox directly next to the password input -->
<input type="checkbox" onclick="togglePasswordVisibility()"> Show Password

<br><br>

<button type="submit" name="login">Login</button>

</form>
<!-- ADDED: JavaScript function to switch input type between "password" and "text" -->
<script>
function togglePasswordVisibility() {
  const passwordInput = document.getElementById("password");
  if (passwordInput.type === "password") {
    passwordInput.type = "text";
  } else {
    passwordInput.type = "password";
  }
}
</script>
</body>

</html>