<?php
session_start();

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