<?php
/**
 * Shared entry point for every public-facing root page (index.php,
 * tracking.php, about.php, ...). Each of those files is just:
 *
 *     <?php require __DIR__ . '/resources/theme_dispatch.php';
 *
 * so the site's public URLs never change no matter which theme is active --
 * this figures out the active theme and hands off to that theme's copy of
 * whichever page was actually requested.
 */

require_once __DIR__ . '/config.php';
/** @var array $row Site settings row, set in config.php (SELECT * FROM site) */

$page = basename($_SERVER['SCRIPT_FILENAME'] ?? '');
$themesDir = __DIR__ . '/../themes';

// Only letters, digits, underscore and hyphen -- never let a folder name
// coming from the database be used to climb out of themes/ (e.g. "../../etc").
$activeTheme = preg_replace('/[^a-zA-Z0-9_-]/', '', $row['active_theme'] ?? '');
if ($activeTheme === '' || !is_dir($themesDir . '/' . $activeTheme)) {
    $activeTheme = 'theme1';
}

$target = $themesDir . '/' . $activeTheme . '/' . $page;

// The selected theme might not have every page yet (e.g. a partially built
// theme) -- fall back to theme1's copy of the same page rather than 404ing.
if (!is_file($target)) {
    $target = $themesDir . '/theme1/' . $page;
}

if (!is_file($target)) {
    http_response_code(404);
    echo 'Page not found.';
    return;
}

require $target;
