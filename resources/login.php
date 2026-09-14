<?php
include('log.php'); // Includes Login Script

// Ensure session is not active before calling session_start()
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['login_user'])) {
    // Check if $link is defined
    if (isset($link)) {
        header("location: " . $link . "");
    } else {
        // Define a default behavior if $link is not set
        // For example, redirect to a specific page or show an error message
        header("location: ../index.php");
        exit(); // Ensure no further execution after redirection
    }
}

// log.php's own login handling reassigns $row to the attempted userlog
// record (or null, on a failed/unknown login) -- so it can't be relied on
// here for the site logo/name. Fetch the site row fresh and independently
// instead; $conn (mysqli, OOP) comes from config.php via log.php's include
// chain and is untouched by that reassignment.
$siteRow = $conn->query("SELECT * FROM site WHERE id = 20")->fetch_assoc() ?: [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Log in &middot; <?= htmlspecialchars($siteRow['name'] ?? 'Admin') ?></title>
    <link href="img/<?= htmlspecialchars($siteRow['favicon'] ?? '') ?>" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <style>
        :root {
            --bs-primary: #4f46e5;
            --bs-primary-rgb: 79, 70, 229;
            --admin-sidebar-bg: #111827;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #f3f4f6;
            color: #1f2937;
            min-height: 100vh;
        }
        .login-shell {
            min-height: 100vh;
            display: flex;
        }
        /* Left brand panel -- mirrors the dashboard's dark sidebar so the
           login screen reads as the front door of the same admin, not a
           bolted-on generic template. Hidden on narrow screens. */
        .login-brand {
            background-color: var(--admin-sidebar-bg);
            color: #cbd5e1;
            width: 42%;
            display: none;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
        }
        @media (min-width: 992px) {
            .login-brand { display: flex; }
        }
        .login-brand .brand-mark {
            display: flex;
            align-items: center;
            gap: .6rem;
            font-weight: 700;
            font-size: 1.25rem;
            color: #fff;
        }
        .login-brand .brand-mark i { color: var(--bs-primary); font-size: 1.5rem; }
        .login-brand .brand-tagline {
            font-size: 1.4rem;
            font-weight: 600;
            color: #fff;
            line-height: 1.4;
            max-width: 22rem;
        }
        .login-brand .brand-foot { font-size: .8rem; color: #6b7280; }

        .login-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
        }
        .login-card {
            width: 100%;
            max-width: 380px;
        }
        .login-card .logo-row {
            display: flex;
            align-items: center;
            gap: .6rem;
            margin-bottom: 1.75rem;
        }
        .login-card .logo-row img { max-height: 40px; max-width: 160px; }
        .login-card .logo-row strong { font-size: 1.05rem; }
        .login-card h1 {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: .25rem;
        }
        .login-card .subtitle {
            color: #6b7280;
            font-size: .9rem;
            margin-bottom: 1.75rem;
        }
        .form-label { font-weight: 600; font-size: .85rem; }
        .form-control {
            padding: .6rem .85rem;
            border-color: #d1d5db;
        }
        .form-control:focus {
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 .2rem rgba(var(--bs-primary-rgb), .15);
        }
        .btn-primary {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
            font-weight: 600;
            padding: .65rem 1rem;
        }
        .btn-primary:hover, .btn-primary:focus {
            background-color: #4338ca;
            border-color: #4338ca;
        }
        .login-foot {
            margin-top: 1.75rem;
            font-size: .8rem;
            color: #9ca3af;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="login-shell">
        <div class="login-brand">
            <div class="brand-mark"><i class="bi bi-truck"></i> <?= htmlspecialchars($siteRow['name'] ?? 'Courier Admin') ?></div>
            <div class="brand-tagline">Manage shipments, tracking, and site settings from one dashboard.</div>
            <div class="brand-foot">&copy; <?= date('Y') ?> <?= htmlspecialchars($siteRow['name'] ?? '') ?>. All rights reserved.</div>
        </div>

        <div class="login-main">
            <div class="login-card">
                <div class="logo-row">
                    <?php if (!empty($siteRow['image'])): ?>
                        <img src="img/<?= htmlspecialchars($siteRow['image']) ?>" alt="<?= htmlspecialchars($siteRow['name'] ?? 'Site logo') ?>">
                    <?php else: ?>
                        <strong><?= htmlspecialchars($siteRow['name'] ?? 'Courier Admin') ?></strong>
                    <?php endif; ?>
                </div>

                <h1>Welcome back</h1>
                <p class="subtitle">Sign in to access the admin dashboard.</p>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger py-2 small"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form action="" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label" for="name">User name / Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                            <input type="text" id="name" name="username" class="form-control" placeholder="you@example.com" autofocus>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                            <input id="password" name="password" type="password" class="form-control" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;">
                        </div>
                    </div>
                    <button class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2" name="submit" type="submit">
                        Log in <i class="bi bi-arrow-right"></i>
                    </button>
                </form>

                <div class="login-foot">Protected admin area &middot; authorized users only</div>
            </div>
        </div>
    </div>
</body>

</html>
