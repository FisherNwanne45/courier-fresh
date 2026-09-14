<?php
/**
 * theme3 ships several distinct homepage designs (see home_variants.php).
 * This file is the one the dispatcher always resolves "index.php" to; it
 * just hands off to whichever variant is currently selected in Site
 * Settings > Appearance, defaulting to Courier Service if the stored value
 * is missing or no longer valid.
 */
require_once __DIR__ . '/../../resources/config.php';

$variants = require __DIR__ . '/home_variants.php';
$selected = preg_replace('/[^a-z0-9-]/', '', $row['home_variant'] ?? '');

if ($selected === '' || !isset($variants[$selected])) {
    $selected = 'courier-service';
}

$targetFile = __DIR__ . '/' . $variants[$selected]['file'];

if (!is_file($targetFile)) {
    // Fall back to the one variant we know always exists.
    $targetFile = __DIR__ . '/' . $variants['courier-service']['file'];
}

require $targetFile;
