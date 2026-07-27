<?php
session_start();
// 3 minutes in seconds
$timeout_duration = 180;

// Check if last activity timestamp exists
if (isset($_SESSION['last_activity'])) {
    $elapsed_time = time() - $_SESSION['last_activity'];
    
    // If more than 3 minutes have passed, destroy session and redirect
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
    <link rel="stylesheet" href="login-register.css">

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

/* ADDED: Style for the live session badge */
        .timer-badge {
            background: #fef3c7;
            color: #d97706;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 15px;
            border: 1px solid #fde68a;
        }
        .timer-badge.warning {
            background: #fee2e2;
            color: #dc2626;
            border-color: #fca5a5;
        }

    </style>
</head>
<body>

<div class="box">
    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
<!-- ADDED: Live 3-Minute Session Countdown Badge -->
    <div id="session-badge" class="timer-badge">
        Session Timeout: <span id="session-timer">03:00</span>
    </div>
    <p>Login Successful.</p>

<!-- REAL-TIME AUDIT LOG TERMINAL -->
    <div style="margin-top: 20px; text-align: left; background: #1e293b; color: #f8fafc; padding: 15px; border-radius: 8px; font-family: monospace; font-size: 12px;">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #334155; padding-bottom: 8px; margin-bottom: 10px;">
            <span style="font-weight: bold; color: #38bdf8;">⚡ Live Security Audit Terminal</span>
            <button id="clear-audit-logs" style="background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 11px;">Clear</button>
        </div>
        <div id="audit-log-terminal" style="max-height: 120px; overflow-y: auto;">
            <div style="color: #64748b;">[SYSTEM INIT] Terminal active and monitoring...</div>
        </div>
    </div>
    <a href="index.php">Go to Main Website</a>
</div>
<!-- ADDED: JavaScript Live Countdown Timer Engine                             -->
<!-- ========================================================================= -->
<script>
let timeRemaining = <?php echo $timeout_duration; ?>; // Pass 180 seconds

function startSessionTimer() {
    const timerDisplay = document.getElementById("session-timer");
    const sessionBadge = document.getElementById("session-badge");

    const timerInterval = setInterval(() => {
        let minutes = Math.floor(timeRemaining / 60);
        let seconds = timeRemaining % 60;

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        if (timerDisplay) {
            timerDisplay.textContent = `${minutes}:${seconds}`;
        }

        // Change badge to red warning when 30 seconds left
        if (timeRemaining <= 30 && sessionBadge) {
            sessionBadge.classList.add("warning");
        }

        // Redirect automatically when timer hits zero
        if (timeRemaining <= 0) {
            clearInterval(timerInterval);
            alert("Your 3-minute session has expired. Please log in again.");
            window.location.href = "login.php?timeout=1";
        }

        timeRemaining--;
    }, 1000);
}

document.addEventListener("DOMContentLoaded", startSessionTimer);
</script>
</body>
</html>