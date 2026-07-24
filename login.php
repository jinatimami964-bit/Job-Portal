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

<input type="password" name="password" placeholder="Password" required><br><br>

<button type="submit" name="login">Login</button>

</form>

</body>

</html>