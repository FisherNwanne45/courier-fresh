<?php
/**
 * Declares theme3's alternate homepage designs. Themes that don't need this
 * concept (theme1, theme2) simply don't have a file like this one -- see
 * resources/appearance.php and this theme's index.php, which both check for
 * its existence before doing anything variant-related.
 *
 * Each entry's "file" is the real, independently-browsable page for that
 * design (e.g. freight.php) -- index.php just includes whichever one is
 * currently selected as the default in Site Settings > Appearance.
 */
return [
    'courier-service' => ['label' => 'Courier Service', 'file' => 'courier-service.php'],
    'main-home' => ['label' => 'Main Home', 'file' => 'home-main.php'],
    'freight' => ['label' => 'Freight', 'file' => 'freight.php'],
    'international-logistics' => ['label' => 'International Logistics', 'file' => 'international-logistics.php'],
    'maritime-transport' => ['label' => 'Maritime Transport', 'file' => 'maritime-transport.php'],
];
