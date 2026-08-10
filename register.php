<?php
include "db_connect.php";

$message = "";

if(isset($_POST['register'])){
 $username     = trim($_POST['username'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $raw_password = $_POST['password'] ?? '';
    $role         = $_POST['role'] ?? 'user';// 'user' or 'admin'
    // Choose target table based on role
    $table = ($role === 'admin') ? 'admin' : 'users';
       // --- ADDED: Backend Password Validation Matching app.js Rules ---
    $has_min_len = strlen($raw_password) >= 8;
    $has_uppercase = preg_match('/[A-Z]/', $raw_password);
    $has_number    = preg_match('/[0-9]/', $raw_password);
    $has_special   = preg_match('/[^A-Za-z0-9]/', $raw_password);

    if (!$has_min_len || !$has_uppercase || !$has_number || !$has_special) {
        $message = "Password does not meet safety standards! (Min 8 chars, 1 uppercase, 1 digit, 1 special char required).";
    } 
else {
  $check_stmt = $pdo->prepare("SELECT id FROM $table WHERE email = :email");
        $check_stmt->execute(['email' => $email]);

        if ($check_stmt->fetch()){

        $message = "Email already exists in $role database!!";

    }else{
  $password = password_hash($raw_password, PASSWORD_DEFAULT);

       // FIXED: Dynamically insert based on role table
            if ($role === 'admin') {
               $sql = "INSERT INTO admin (username, email, password) VALUES (:username, :email, :password)";
            } else {
                $sql = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, 'user')";
            }
                $insert_stmt = $pdo->prepare($sql);
                $inserted = $insert_stmt->execute([
                    'username' => $username,
                    'email'    => $email,
                    'password' => $password
                ]);


        if($inserted){
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

<h2>Create Account</h2>
    <!-- XSS Protection with htmlspecialchars -->
<?php if (!empty($message)): ?>
    <p style="color:red;"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>
<form method="POST">
<label for="role">Register As:</label><br>
<select name="role" id="role" required style="padding:8px; margin-bottom:10px;">
    <option value="user">User</option>
    <option value="admin">Admin</option>
</select><br><br>
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