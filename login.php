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

$email = trim($_POST['email']);
$password = trim($_POST['password']);
$role = $_POST['role'];

    $table = ($role === 'admin') ? 'admin' : 'users';
//$sql = "SELECT * FROM $table WHERE email='$email'";

//$result = mysqli_query($conn,$sql);
$stmt = $pdo->prepare("SELECT * FROM $table WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

if($user){

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
                header("Location: dashboard.php");
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
   <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">


</head>

<body class="bg-slate-900 text-white font-sans min-h-screen flex flex-col items-center justify-center p-4">

    <!-- Container matching register layout -->
    <div class="w-full max-w-md bg-slate-800 p-8 rounded-2xl shadow-xl border border-slate-700">
        
        <header class="mb-6 text-center">
            <h1 class="text-2xl font-extrabold text-blue-400">AOSH <span class="text-white">Portal</span></h1>
            <p class="text-slate-400 text-sm mt-1">Account Authentication</p>
        </header>

        <!-- Display Error Banner if error exists -->
        <?php if(!empty($error)): ?>
            <div class="mb-4 p-3 bg-red-500/10 border border-red-500/30 rounded-lg text-red-400 text-sm text-center">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php" class="space-y-5">
            <div>
                <label for="role" class="block text-sm font-medium text-slate-300 mb-1">Login As</label>
                <select name="role" id="role" required class="w-full bg-slate-900 border border-slate-600 rounded-lg p-2.5 text-white focus:outline-none focus:border-blue-500 transition cursor-pointer">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Email Address</label>
                <input type="email" name="email" class="w-full bg-slate-900 border border-slate-600 rounded-lg p-2.5 text-white focus:outline-none focus:border-blue-500 transition" placeholder="you@example.com" required>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-300 mb-1">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" class="w-full bg-slate-900 border border-slate-600 rounded-lg p-2.5 text-white focus:outline-none focus:border-blue-500 transition pr-10" placeholder="••••••••" required>
                </div>
                
                <div class="flex items-center gap-2 mt-2">
                    <input type="checkbox" id="show-pass" onclick="togglePasswordVisibility()" class="rounded bg-slate-900 border-slate-600 text-blue-600 focus:ring-0 cursor-pointer">
                    <label for="show-pass" class="text-xs text-slate-400 cursor-pointer select-none">Show Password</label>
                </div>
            </div>

            <button type="submit" name="login" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-lg transition duration-200 shadow-lg shadow-blue-900/30">
                Log In
            </button>
        </form>

<p class="text-align:center; margin-top:15px; font-family:Arial;">
    Don't have an account?
    <a href="register.php" style="color:blue; text-decoration:none; font-weight:bold;">
        Create account
    </a>
    </p>

</p>
    </div>
    <div id="app" class="hidden"></div>
<div id="main-dashboard" class="hidden"></div>
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
<script src="app.js"></script>
</body>

</html>