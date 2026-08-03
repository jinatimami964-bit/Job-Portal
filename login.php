<?php
session_start();
include "db_connect.php";

$error = "";
// Display alert if redirected from admin check
if (isset($_GET['msg']) && $_GET['msg'] === 'admin_not_registered') {
    $error = "Admin account not found. Please register first!";
}
// ADDED: Check if redirected from a 3-minute session timeout
// =========================================================================
if (isset($_GET['timeout'])) {
    $error = "Your 3-minute session expired. Please log in again.";
}
if(isset($_POST['login'])){

$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

    $table = ($role === 'admin') ? 'admin' : 'users';
$sql = "SELECT * FROM $table WHERE email='$email'";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)==1){

$user = mysqli_fetch_assoc($result);

if(password_verify($password, $user['password'])){

    // Regenerate session ID for security
    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['last_activity'] = time();

    $_SESSION['role'] = $role; // Set session role

            // Redirect based on role
            if ($role === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit();

}else{

$error="Wrong Password";

}
}else{
// Redirect to Register page if Admin is not registered
        if ($role === 'admin') {
            header("Location: register.php?msg=admin_not_registered");
            exit();
        }
else{

$error="User Not Found";

}}

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
<label for="role">Login As:</label><br>
<select name="role" id="role" required style="padding:8px; margin-bottom:10px;">
    <option value="user">User</option>
    <option value="admin">Admin</option>
</select><br><br>

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

</body>

</html>