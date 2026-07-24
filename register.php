<?php
include "db_connect.php";

$message = "";

if(isset($_POST['register'])){

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check)>0){

        $message = "Email already exists!";

    }else{

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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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