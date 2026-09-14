<?php
/**
 * Seeds the tables install/schema.sql just created with the defaults a
 * fresh install ships with. Idempotent -- every insert uses INSERT IGNORE
 * or ON DUPLICATE KEY, so re-running the installer (or this step) never
 * duplicates rows or clobbers data an admin already changed.
 *
 * Called from install/index.php once the schema step succeeds, with $conn
 * (mysqli, OOP) already connected to the freshly-created database.
 */

function installSeedDefaults(mysqli $conn): void
{
    // --- site: a single placeholder row (id=20 -- every admin page that
    // reads/writes site settings assumes this id) with blank branding.
    // The Site Settings / Appearance wizard steps fill in the real values;
    // this just guarantees the row exists so those UPDATEs have something
    // to update.
    $conn->query("
        INSERT IGNORE INTO `site` (`id`, `name`, `active_theme`, `track_color_scheme`, `home_variant`)
        VALUES (20, 'My Courier Company', 'theme1', 'red', 'courier-service')
    ");

    // --- mail_settings: a single blank row (id=1) so getMailSettings()
    // has a row to read (falling back to its own empty defaults) until the
    // SMTP wizard step -- or the dashboard later -- saves real values.
    $conn->query("INSERT IGNORE INTO `mail_settings` (`id`) VALUES (1)");

    // --- "Prima Credito" demo vault user -- a ready-made login for the
    // client vault (resources/vault.php) so a fresh install has something
    // to show immediately. Password is the legacy plaintext '1234'; the
    // login flow (resources/log.php) auto-upgrades it to a bcrypt hash the
    // first time it's used, exactly like every pre-existing plaintext
    // password in this app.
    $stmt = $conn->prepare("
        INSERT INTO `userlog`
            (`username`, `password`, `image`, `name`, `rank`, `cid`, `phone`, `type`, `amt`,
             `rate`, `dur`, `paydate`, `status`, `remark`, `loc1`, `mail2`, `phone2`, `mail`, `paym`, `cdt`)
        VALUES (?, '1234', '', 'Confidential', '$400', '0000', 'Cleared', 'Not Cleared', 'user',
                '', '$400', 'Not Cleared', '$700', 'Prima Credito', '$500', 'Not Cleared', '$1000', '$200', 'Cleared', 'Not Cleared')
        ON DUPLICATE KEY UPDATE `username` = `username`
    ");
    $vaultUsername = 'user@user.com';
    $stmt->bind_param('s', $vaultUsername);
    $stmt->execute();
    $stmt->close();

    // --- Demo tracking record (cid 1234) -- lets the tracking page and the
    // Prima Credito vault account both show a real result out of the box.
    $exists = $conn->query("SELECT id FROM `user` WHERE `cid` = '1234' LIMIT 1");
    if ($exists && $exists->num_rows === 0) {
        $conn->query("
            INSERT INTO `user`
                (`image`, `name`, `rank`, `cid`, `phone`, `type`, `dur`, `paydate`, `status`,
                 `remark`, `loc1`, `rank2`, `mail`, `cdt`, `cdt2`, `status2`, `loc2`, `rmk`)
            VALUES
                ('', 'Taner Kislali', 'Yesil Altinkent Sitesi No:2 Cayyolu ANKARA, 06810', '1234', '7146878997',
                 'Fresh container', '12kg', '2000', 'fresh',
                 'Philip Morris', 'Japan', 'NH890 Brdigestone, Ohio Canada', '',
                 '2024-07-06', '12 Oct', 'Fresh delivery', 'Viking land', 'Picked by Courier')
        ");
    }

    // --- Default email templates (parcel_created, status_updated) -- body
    // content lives alongside this file so it isn't retyped as escaped PHP
    // string literals.
    $templates = [
        [
            'key' => 'parcel_created',
            'name' => 'New Parcel Created',
            'description' => 'Sent to the receiver when a new tracking record is created.',
            'subject' => '{{site_name}} - {{receiver_name}}, Your New Parcel Tracking',
        ],
        [
            'key' => 'status_updated',
            'name' => 'Shipment Status Updated',
            'description' => "Sent to the receiver when a tracking record's status/history is edited.",
            'subject' => '{{site_name}} - {{receiver_name}}, New Status of Shipment - {{tracking_number}}',
        ],
    ];

    $stmt = $conn->prepare("
        INSERT INTO `email_templates` (`template_key`, `name`, `description`, `subject`, `html_body`, `text_body`, `updated_at`)
        VALUES (?, ?, ?, ?, ?, ?, NOW())
        ON DUPLICATE KEY UPDATE `template_key` = `template_key`
    ");
    foreach ($templates as $t) {
        $html = file_get_contents(__DIR__ . '/seed-data/' . $t['key'] . '.html') ?: '';
        $text = file_get_contents(__DIR__ . '/seed-data/' . $t['key'] . '.txt') ?: '';
        $stmt->bind_param(
            'ssssss',
            $t['key'],
            $t['name'],
            $t['description'],
            $t['subject'],
            $html,
            $text
        );
        $stmt->execute();
    }
    $stmt->close();
}
