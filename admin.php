<?php
session_start();
include "db_connect.php";

// Access Control: Only allow logged-in Admin users
if(!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'] ?? 'Admin';
// Fetch applications securely using PDO
try {
    $sql = "SELECT 
                a.id AS application_id, 
                u.username AS name, 
                u.email AS email, 
                j.title AS job_title, 
                c.company_name,
                a.status,
                a.applied_at
            FROM applications a
            JOIN users u ON a.user_id = u.id
            JOIN jobs j ON a.job_id = j.id
            LEFT JOIN companies c ON j.company_id = c.id
            ORDER BY a.id DESC";
    
    $stmt = $pdo->query($sql);
    $applications = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log($e->getMessage());
    $applications = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AOSH Portal - Admin Control Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-900 text-white font-sans p-6">

    <div class="portal-glass-container max-w-6xl mx-auto p-6 rounded-2xl border border-slate-800 bg-slate-900/90 shadow-2xl">
        
        <!-- Admin Navigation Header -->
        <header class="flex justify-between items-center border-b border-slate-800 pb-6 mb-8">
            <div class="logo-brand text-xl font-extrabold text-blue-500">
                💼 AOSH<span class="text-white"> Admin Panel</span>
            </div>
            <nav class="flex items-center gap-6 text-sm font-medium">
                <a href="index.php" class="text-slate-400 hover:text-white transition">View Public Portal</a>
                <span class="text-blue-400">Welcome, <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?> (Admin)</span>
                <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">Sign Out</a>
            </nav>
        </header>

        <!-- Main Applicants Section -->
        <main>
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-white mb-2">Job Applicants Dashboard</h2>
                <p class="text-sm text-slate-400">Review all candidate submissions captured from active listing postings.</p>
            </section>

            <div class="bg-slate-800 border border-slate-700 rounded-xl overflow-hidden shadow-lg">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-300">
                        <thead class="bg-slate-900/90 text-blue-400 uppercase text-xs font-semibold">
                            <tr>
                                <th class="p-4">ID</th>
                                <th class="p-4">Applicant Name</th>
                                <th class="p-4">Email Address</th>
                                <th class="p-4">Applied Position</th>
                                <th class="p-4">Company</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Submission Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/60">
                            <?php if (!empty($applications)): ?>
                            <?php foreach ($applications as $row): ?>
                                    <tr class="hover:bg-slate-700/40 transition">
                                        <!-- XSS Protection with htmlspecialchars -->
                                        <td class="p-4 font-mono text-slate-400">#<?php echo htmlspecialchars($row['application_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="p-4 font-semibold text-white"><?php echo htmlspecialchars($row['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="p-4 text-blue-400"><?php echo htmlspecialchars($row['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="p-4"><?php echo htmlspecialchars($row['job_title'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="p-4 text-slate-300"><?php echo htmlspecialchars($row['company_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="p-4">
                                            <span class="bg-blue-500/10 text-blue-400 px-2.5 py-1 rounded-full text-xs border border-blue-500/20">
                                                <?php echo htmlspecialchars($row['status'] ?? 'Pending', ENT_QUOTES, 'UTF-8'); ?>
                                            </span>
                                        </td>
                                        <td class="p-4 text-xs text-slate-400"><?php echo htmlspecialchars($row['applied_at'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="p-6 text-center text-slate-400">No job applications found in database.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <footer class="mt-12 text-center text-xs text-slate-500 pt-6 border-t border-slate-800">
            &copy; 2026 AOSH Job Portal Ecosystem — Administrative Suite
        </footer>
    </div>

</body>
</html>