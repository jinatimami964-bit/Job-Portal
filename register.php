<?php
include "db_connect.php";

$message = "";

if(isset($_POST['register'])){

    $username = $_POST['username'];
    $email = $_POST['email'];
    $raw_password = $_POST['password'];
       // --- ADDED: Backend Password Validation Matching app.js Rules ---
    $has_min_len = strlen($raw_password) >= 8;
    $has_uppercase = preg_match('/[A-Z]/', $raw_password);
    $has_number    = preg_match('/[0-9]/', $raw_password);
    $has_special   = preg_match('/[^A-Za-z0-9]/', $raw_password);

    if (!$has_min_len || !$has_uppercase || !$has_number || !$has_special) {
        $message = "Password does not meet safety standards! (Min 8 chars, 1 uppercase, 1 digit, 1 special char required).";
    } 
else {
    $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check)>0){

        $message = "Email already exists!";

    }else{
  $password = password_hash($raw_password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(username,email,password)
                VALUES('$username','$email','$password')";
               


        if(mysqli_query($conn,$sql)){
            header("Location: login.php");
            exit();
        }else{
            $message = "Registration Failed!";
        }
    }
  
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="login-register.css">
</head>
<body>

<h2>Create Account</h2>

<?php echo $message; ?>

<form method="POST">

<input type="text" name="username" placeholder="Username" required><br><br>

<input type="email" name="email" placeholder="Email" required><br><br>

<input type="password" name="password" placeholder="Password" required><br><br>

<button type="submit" name="register">Register</button>

</form>
<p style="text-align:center; margin-top:15px; font-family:Arial;">
    Already have an account?
    <a href="login.php" style="color:blue; text-decoration:none; font-weight:bold;">
        Log In
    </a>
</p>
</body>
</html>