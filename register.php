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
   <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-slate-900 text-white font-sans min-h-screen flex flex-col items-center justify-center p-4">

    <!-- Single container target where app.js mounts the complete form & audit terminal -->
    <div id="app" class="w-full flex flex-col items-center"></div>

    <?php if(!empty($message)): ?>
        <!-- Safe JS alert dispatch -->
        <script>
            setTimeout(() => { alert("<?php echo addslashes($message); ?>"); }, 100);
        </script>
    <?php endif; ?>


    <script src="app.js"></script>
    <script>
        renderRegister();
    </script>
</body>
</html>