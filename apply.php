<?php

session_start();
include "db_connect.php";

if (!isset($_SESSION['user_id'])) {
    echo "Please login first";
    exit();
}

if (!isset($_POST['job_id']) || empty($_POST['job_id'])) {
    echo "Job ID is missing";
    exit();
}

$user_id = $_SESSION['user_id'];
$job_id = $_POST['job_id'];

// PDO Prepared Statement - parameterized query (SQL Injection )
try {
    $stmt = $pdo->prepare("INSERT INTO applications (user_id, job_id) VALUES (:user_id, :job_id)");
    $success = $stmt->execute([
        'user_id' => $user_id,
        'job_id'  => $job_id
    ]);

    if ($success) {
        echo "Application submitted successfully!";
    } else {
        echo "Application failed";
    }
} catch (PDOException $e) {
    echo "Application failed: " . $e->getMessage();
}

?>