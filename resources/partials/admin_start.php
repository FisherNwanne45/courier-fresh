<?php
/**
 * Shared admin shell: <head>, topbar (notifications, quick settings, profile
 * menu), and the sidebar nav. Every admin page includes this, prints its own
 * content, then includes admin_end.php.
 *
 * Expects, set by the including page before this include:
 *   $pageTitle  (string) e.g. 'Dashboard'
 *   $activeNav  (string) a key from $navItems below
 *
 * Relies on globals already in scope from session.php + config.php:
 *   $login_session, $name (site name), $conn
 */
$pageTitle = $pageTitle ?? 'Admin';
$activeNav = $activeNav ?? '';

$navItems = [
    'dashboard' => ['index.php', 'bi-speedometer2', 'Dashboard'],
    'tracking' => ['identity.php', 'bi-box-seam', 'Create Tracking'],
    'vault' => ['users.php', 'bi-people', 'Vault Users'],
    'vault_create' => ['create_user.php', 'bi-person-plus', 'Create Vault User'],
    'settings' => ['settings.php', 'bi-gear', 'Site Settings'],
    'appearance' => ['appearance.php', 'bi-palette', 'Appearance'],
    'email_settings' => ['email_settings.php', 'bi-envelope-at', 'Email / SMTP'],
    'email_templates' => ['email_templates.php', 'bi-file-earmark-text', 'Email Templates'],
    'email_log' => ['email_log.php', 'bi-clock-history', 'Notification Log'],
    'password' => ['change_password.php', 'bi-key', 'Change Password'],
];

$notifications = function_exists('getAdminNotifications') && isset($conn)
    ? getAdminNotifications($conn)
    : ['failed_emails' => ['count' => 0, 'items' => []], 'security' => ['count' => 0, 'items' => []]];
$notifTotal = $notifications['failed_emails']['count'] + $notifications['security']['count'];
$siteName = $name ?? 'Courier Admin';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> &middot; <?= htmlspecialchars($siteName) ?> Admin</title>
    <link href="img/<?= htmlspecialchars($favicon ?? '') ?>" rel="shortcut icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="assets/admin.css?v=<?= @filemtime(__DIR__ . '/../assets/admin.css') ?: '1' ?>">
    <?php if (!empty($extraHead)) echo $extraHead; ?>
</head>

<body>
    <div class="admin-shell">
        <div class="offcanvas-lg offcanvas-start admin-sidebar" tabindex="-1" id="adminSidebar">
            <div class="offcanvas-header d-lg-none">
                <span class="admin-brand" style="padding:0;border:0;"><i class="bi bi-truck"></i> <?= htmlspecialchars($siteName) ?></span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#adminSidebar" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column p-0">
                <div class="admin-brand d-none d-lg-flex">
                    <i class="bi bi-truck"></i> <span><?= htmlspecialchars($siteName) ?></span>
                </div>
                <nav class="admin-nav flex-grow-1">
                    <ul class="nav flex-column">
                        <?php foreach ($navItems as $key => [$href, $icon, $label]): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $activeNav === $key ? 'active' : '' ?>" href="<?= htmlspecialchars($href) ?>">
                                    <i class="bi <?= htmlspecialchars($icon) ?>"></i> <span><?= htmlspecialchars($label) ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
                <div class="admin-nav-footer">
                    <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> <span>Logout</span></a>
                </div>
            </div>
        </div>

        <div class="admin-content-wrap">
            <nav class="admin-topbar navbar navbar-expand">
                <div class="container-fluid">
                    <button class="admin-menu-btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar" aria-label="Toggle sidebar">
                        <i class="bi bi-list"></i>
                    </button>
                    <span class="admin-topbar-title d-none d-md-inline ms-2"><?= htmlspecialchars($pageTitle) ?></span>

                    <div class="ms-auto d-flex align-items-center gap-1">
                        <!-- Notifications -->
                        <div class="dropdown">
                            <button class="admin-icon-btn position-relative" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-label="Notifications">
                                <i class="bi bi-bell"></i>
                                <?php if ($notifTotal > 0): ?>
                                    <span class="badge rounded-pill bg-danger admin-notif-badge"><?= $notifTotal > 9 ? '9+' : $notifTotal ?></span>
                                <?php endif; ?>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end admin-notif-panel shadow-sm">
                                <h6 class="dropdown-header">Notifications</h6>
                                <?php if ($notifTotal === 0): ?>
                                    <div class="px-3 py-4 text-center text-muted small">
                                        <i class="bi bi-check2-circle d-block mb-1" style="font-size:1.4rem;"></i>
                                        You're all caught up.
                                    </div>
                                <?php else: ?>
                                    <?php if ($notifications['security']['count'] > 0): ?>
                                        <div class="dropdown-header text-uppercase text-danger" style="font-size:.7rem;">Security</div>
                                        <?php foreach ($notifications['security']['items'] as $item): ?>
                                            <div class="admin-notif-item">
                                                <i class="bi bi-shield-exclamation text-danger"></i>
                                                <div>
                                                    <div class="small"><?= htmlspecialchars($item['message']) ?></div>
                                                    <div class="text-muted" style="font-size:11px;"><?= htmlspecialchars($item['time']) ?></div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php if ($notifications['failed_emails']['count'] > 0): ?>
                                        <div class="dropdown-header text-uppercase text-warning" style="font-size:.7rem;">Email Delivery</div>
                                        <?php foreach ($notifications['failed_emails']['items'] as $item): ?>
                                            <a class="dropdown-item admin-notif-item" href="email_log.php?status=failed">
                                                <i class="bi bi-envelope-exclamation text-warning"></i>
                                                <div>
                                                    <div class="small"><?= htmlspecialchars($item['message']) ?></div>
                                                    <div class="text-muted" style="font-size:11px;"><?= htmlspecialchars($item['time']) ?></div>
                                                </div>
                                            </a>
                                        <?php endforeach; ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-center small text-primary" href="email_log.php?status=failed">View all failed emails</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Quick settings -->
                        <div class="dropdown admin-quick-settings">
                            <button class="admin-icon-btn" type="button" data-bs-toggle="dropdown" aria-label="Quick settings">
                                <i class="bi bi-gear"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end shadow-sm">
                                <h6 class="dropdown-header">Quick Settings</h6>
                                <a class="dropdown-item" href="settings.php"><i class="bi bi-gear me-2"></i>Site Settings</a>
                                <a class="dropdown-item" href="email_settings.php"><i class="bi bi-envelope-at me-2"></i>Email / SMTP</a>
                                <a class="dropdown-item" href="email_templates.php"><i class="bi bi-file-earmark-text me-2"></i>Email Templates</a>
                                <a class="dropdown-item" href="email_log.php"><i class="bi bi-clock-history me-2"></i>Notification Log</a>
                            </div>
                        </div>

                        <!-- Profile -->
                        <div class="dropdown">
                            <button class="admin-icon-btn d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-label="Account menu">
                                <span class="admin-avatar"><?= htmlspecialchars(strtoupper(substr($login_session ?? 'A', 0, 1))) ?></span>
                                <span class="d-none d-md-inline small"><?= htmlspecialchars($login_session ?? '') ?></span>
                                <i class="bi bi-chevron-down small"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end shadow-sm">
                                <a class="dropdown-item" href="change_password.php"><i class="bi bi-key me-2"></i>Change Password</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="admin-main">
