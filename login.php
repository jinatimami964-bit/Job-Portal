<?php
session_start();
include "db_connect.php";

$error = "";
// ADDED: Check if redirected from a 3-minute session timeout
// =========================================================================
if (isset($_GET['timeout'])) {
    $error = "Your 3-minute session expired. Please log in again.";
}
if(isset($_POST['login'])){

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email'";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)==1){

$user = mysqli_fetch_assoc($result);

if(password_verify($password, $user['password'])){

    // Regenerate session ID for security
    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
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
    <link rel="stylesheet" href="login-register.css">


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
<p style="text-align:center; margin-top:15px; font-family:Arial;">
    Don't have an account?
    <a href="register.php" style="color:blue; text-decoration:none; font-weight:bold;">
        Create account
    </a>

    <div id="app" class="hidden"></div>
<div id="main-dashboard" class="hidden"></div>

<script src="https://cdn.tailwindcss.com"></script>
<script src="app.js"></script>
</body>

</html>