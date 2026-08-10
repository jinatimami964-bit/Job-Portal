<?php
session_start();
include "db_connect.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
// SECURE: Fetching company details using PDO
try {
    $stmt = $pdo->query("SELECT * FROM companies");
    $companies = $stmt->fetchAll();
} catch (PDOException $e) {
    $companies = [];
}

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

```
<title>Companies - AOSH JobPortal</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet" href="style.css">
```

</head>

<body class="bg-gray-900 text-white font-sans">

```
<div class="max-w-6xl mx-auto p-6">

    <!-- Header -->
    <header class="flex justify-between items-center border-b border-slate-800 pb-6 mb-8">

        <div class="text-xl font-extrabold text-blue-500">
            💼 AOSH<span class="text-white">Portal</span>
        </div>

        <nav class="flex gap-6 text-sm font-medium text-slate-400">

            <a href="index.php" class="hover:text-blue-400">
                Find Jobs
            </a>

            <a href="companies.php" class="text-blue-400 underline underline-offset-4">
                Companies
            </a>

            <a href="dashboard.php" class="hover:text-blue-400">
                Dashboard
            </a>

            <a href="logout.php" class="hover:text-red-400">
                Sign Out
            </a>

        </nav>

    </header>


    <!-- Page Title -->
    <section class="mb-8">

        <h1 class="text-3xl font-bold text-white mb-2">
            Explore Companies
        </h1>

        <p class="text-slate-400">
            Discover companies and explore available job opportunities.
        </p>

    </section>


    <!-- Companies Grid -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <?php if (mysqli_num_rows($companies) > 0) { ?>

            <?php while ($company = mysqli_fetch_assoc($companies)) { ?>

                <div class="bg-slate-800 border border-slate-700 p-6 rounded-xl shadow-lg hover:border-blue-500 transition">

                    <!-- Company Icon -->
                    <div class="text-4xl mb-4">
                        🏢
                    </div>

                    <!-- Company Name -->
                    <h2 class="text-xl font-bold text-white mb-3">
                        <?php echo htmlspecialchars($company['company_name']); ?>
                    </h2>

                    <!-- Company Description -->
                    <?php if (isset($company['description']) && !empty($company['description'])) { ?>

                        <p class="text-slate-400 text-sm mb-4">
                            <?php echo htmlspecialchars($company['description']); ?>
                        </p>

                    <?php } ?>

                    <!-- Company Location -->
                    <?php if (isset($company['location']) && !empty($company['location'])) { ?>

                        <p class="text-sm text-slate-400 mb-2">
                            📍 <?php echo htmlspecialchars($company['location']); ?>
                        </p>

                    <?php } ?>

                    <!-- Company Website -->
                    <?php if (isset($company['website']) && !empty($company['website'])) { ?>

                        <a 
                            href="<?php echo htmlspecialchars($company['website']); ?>"
                            target="_blank"
                            class="text-blue-400 text-sm hover:underline">
                            Visit Website →
                        </a>

                    <?php } ?>

                </div>

            <?php } ?>

        <?php } else { ?>

            <!-- No Company Found -->
            <div class="col-span-full text-center py-12">

                <p class="text-slate-400 text-lg">
                    No companies found in the database.
                </p>

            </div>

        <?php } ?>

    </section>


    <!-- Footer -->
    <footer class="text-center pt-8 mt-10 border-t border-slate-800 text-xs text-slate-500">

        <p>
            &copy; 2026 AOSH Job Portal Ecosystem.
        </p>

    </footer>

</div>
```

</body>
</html>
