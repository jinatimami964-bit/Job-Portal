<?php
session_start();
// 2 minutes in seconds
$timeout_duration = 120;

// Check if last activity timestamp exists
if (isset($_SESSION['last_activity'])) {
    $elapsed_time = time() - $_SESSION['last_activity'];
    
    // If more than 2 minutes have passed, destroy session and redirect
    if ($elapsed_time > $timeout_duration) {
        session_unset();
        session_destroy();
        header("Location: login.php?timeout=1");
        exit();
    }
}

// Update last activity time for active session refresh
$_SESSION['last_activity'] = time();

// --- ADDED BLOCK END ---

// Standard check to verify if the user is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f4f4f4;
            text-align:center;
            margin-top:100px;
        }
        .box{
            width:400px;
            margin:auto;
            background:white;
            padding:30px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,.2);
        }
        a{
            display:inline-block;
            margin-top:20px;
            padding:10px 20px;
            background:#007bff;
            color:white;
            text-decoration:none;
            border-radius:5px;
        }
        a:hover{
            background:#0056b3;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>

    <p>Login Successful.</p>

    <a href="index.php">Go to Main Website</a>
</div>

</body>
</html>