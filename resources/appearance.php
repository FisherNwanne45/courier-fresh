<?php
include('session.php');
/** @var array $row Logged-in user's row, set in session.php (reassigned below to the site settings row) */
/** @var string $login_session Logged-in username, set in session.php */

if ($row['amt'] == 'user') {
    header('Location: vault.php');
    exit();
}
include_once 'config.php';
require_once 'security.php';

// Fetch the row to edit
$sql = "SELECT * FROM site WHERE id = 20";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$message = '';

$themes = listThemes();
$schemes = colorSchemes();

// A theme may optionally ship a home_variants.php manifest declaring
// several alternate homepage designs (see themes/theme3/home_variants.php
// for the shape). Themes without one -- theme1, theme2 -- just don't have
// the file, and no variant picker is shown for them.
function themeHomeVariants(string $themeKey): array
{
    $path = __DIR__ . '/../themes/' . $themeKey . '/home_variants.php';
    return is_file($path) ? (require $path) : [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $postedTheme = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['active_theme'] ?? '');
    $postedScheme = $_POST['track_color_scheme'] ?? '';

    $themeKeys = array_column($themes, 'key');
    $themeValid = in_array($postedTheme, $themeKeys, true);
    $schemeValid = array_key_exists($postedScheme, $schemes);

    $variants = themeHomeVariants($postedTheme);
    $postedVariant = preg_replace('/[^a-z0-9-]/', '', $_POST['home_variant'] ?? '');
    $variantValid = empty($variants) || isset($variants[$postedVariant]);

    $languageCatalog = translatorLanguageCatalog();
    $postedLanguages = array_values(array_intersect((array) ($_POST['translate_languages'] ?? []), array_keys($languageCatalog)));
    $postedSource = $_POST['translate_source'] ?? 'en';
    $sourceValid = array_key_exists($postedSource, $languageCatalog);
    $languagesValid = !empty($postedLanguages);

    if (!$themeValid) {
        $message = '<div class="alert alert-danger">Please choose a valid theme.</div>';
    } elseif (!$schemeValid) {
        $message = '<div class="alert alert-danger">Please choose a valid color scheme.</div>';
    } elseif (!$variantValid) {
        $message = '<div class="alert alert-danger">Please choose a valid default homepage.</div>';
    } elseif (!$sourceValid) {
        $message = '<div class="alert alert-danger">Please choose a valid translator source language.</div>';
    } elseif (!$languagesValid) {
        $message = '<div class="alert alert-danger">Please select at least one translator language.</div>';
    } else {
        // Always include the source language among the offered languages --
        // Google's widget expects pageLanguage to also appear in the list.
        if (!in_array($postedSource, $postedLanguages, true)) {
            $postedLanguages[] = $postedSource;
        }
        $translateLanguagesStr = implode(',', $postedLanguages);

        if (!empty($variants)) {
            $stmt = $conn->prepare("UPDATE site SET active_theme = ?, track_color_scheme = ?, home_variant = ?, translate_source = ?, translate_languages = ? WHERE id = 20");
            $stmt->bind_param('sssss', $postedTheme, $postedScheme, $postedVariant, $postedSource, $translateLanguagesStr);
        } else {
            $stmt = $conn->prepare("UPDATE site SET active_theme = ?, track_color_scheme = ?, translate_source = ?, translate_languages = ? WHERE id = 20");
            $stmt->bind_param('ssss', $postedTheme, $postedScheme, $postedSource, $translateLanguagesStr);
        }
        $stmt->execute();
        $stmt->close();

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $message = '<div class="alert alert-success">Appearance settings saved.</div>';
    }
}

$activeTheme = $row['active_theme'] ?? 'theme1';
$activeScheme = $row['track_color_scheme'] ?? 'red';
$activeVariant = $row['home_variant'] ?? '';
$activeThemeVariants = themeHomeVariants($activeTheme);

$languageCatalog = translatorLanguageCatalog();
$activeSourceLang = $row['translate_source'] ?? 'en';
$activeLanguages = array_filter(array_map('trim', explode(',', $row['translate_languages'] ?? 'en')));

$pageTitle = 'Appearance';
$activeNav = 'appearance';
$extraHead = <<<'HTML'
<style>
.theme-option, .scheme-option { transition: border-color .15s, box-shadow .15s; border-color: #e5e7eb !important; }
.theme-radio:checked + .theme-option,
.scheme-radio:checked + .scheme-option,
.theme-option-active {
    border-color: var(--admin-primary, #4f46e5) !important;
    box-shadow: 0 0 0 3px rgba(79,70,229,.12);
}
/* 6 languages per row, at any width -- smaller text/checkbox and tighter
   wrapping so that many columns stays legible instead of overflowing. */
.lang-grid .form-check { min-width: 0; }
.lang-grid .form-check-input { width: .9em; height: .9em; margin-top: .2em; }
.lang-grid .form-check-label {
    font-size: .78rem;
    line-height: 1.2;
    overflow-wrap: break-word;
}
@media (max-width: 767px) {
    .lang-grid > [class^="col-"] { flex: 0 0 33.3333%; max-width: 33.3333%; }
}
</style>
HTML;
include 'partials/admin_start.php';
?>
                <div class="mb-4">
                    <h1 class="h4 mb-0">Appearance</h1>
                    <div class="text-muted small">Choose the site's front-end theme and the accent color used on the public tracking-result page.</div>
                </div>

                <?= $message ?>

                <form action="" method="post">
                    <?php echo csrf_field(); ?>

                    <div class="admin-card mb-4">
                        <div class="admin-card-header">
                            <h2><i class="bi bi-layout-text-window-reverse me-2 text-primary"></i>Theme</h2>
                        </div>
                        <div class="admin-card-body">
                            <?php if (empty($themes)): ?>
                                <p class="text-muted mb-0">No theme folders found under <code>themes/</code>.</p>
                            <?php else: ?>
                                <div class="row g-3">
                                    <?php foreach ($themes as $theme): ?>
                                        <div class="col-sm-6 col-lg-4">
                                            <label class="d-block h-100" style="cursor:<?= $theme['ready'] ? 'pointer' : 'not-allowed' ?>;">
                                                <input type="radio" name="active_theme" value="<?= htmlspecialchars($theme['key']) ?>"
                                                    class="form-check-input d-none theme-radio"
                                                    <?= $activeTheme === $theme['key'] ? 'checked' : '' ?>
                                                    <?= $theme['ready'] ? '' : 'disabled' ?>>
                                                <div class="theme-option border rounded-3 p-3 h-100 <?= $activeTheme === $theme['key'] ? 'theme-option-active' : '' ?> <?= $theme['ready'] ? '' : 'opacity-50' ?>">
                                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                                        <strong><?= htmlspecialchars($theme['label']) ?></strong>
                                                        <?php if ($activeTheme === $theme['key']): ?>
                                                            <span class="badge text-bg-primary"><i class="bi bi-check2 me-1"></i>Active</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="text-muted small"><code><?= htmlspecialchars($theme['key']) ?>/</code></div>
                                                    <?php if (!$theme['ready']): ?>
                                                        <div class="text-warning small mt-2">
                                                            <i class="bi bi-exclamation-triangle me-1"></i>Not yet adapted (no index.php)
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php
                    // Build one variant-picker block per theme that declares
                    // home_variants.php; JS shows only the one matching
                    // whichever theme radio is currently checked.
                    $themeVariantBlocks = [];
                    foreach ($themes as $theme) {
                        $tv = themeHomeVariants($theme['key']);
                        if (!empty($tv)) {
                            $themeVariantBlocks[$theme['key']] = $tv;
                        }
                    }
                    ?>
                    <?php if (!empty($themeVariantBlocks)): ?>
                        <div class="admin-card mb-4">
                            <div class="admin-card-header">
                                <h2><i class="bi bi-house-door me-2 text-primary"></i>Default Homepage</h2>
                            </div>
                            <div class="admin-card-body">
                                <p class="text-muted small">
                                    Some themes ship more than one homepage design. Pick which one that theme
                                    shows at the site's home address -- the others remain reachable at their
                                    own pages regardless.
                                </p>
                                <?php foreach ($themeVariantBlocks as $themeKey => $variants): ?>
                                    <div class="home-variant-block" data-theme-key="<?= htmlspecialchars($themeKey) ?>" style="display:none;">
                                        <div class="row g-3">
                                            <?php foreach ($variants as $variantKey => $variant): ?>
                                                <div class="col-sm-6 col-lg-4">
                                                    <label class="d-block h-100" style="cursor:pointer;">
                                                        <input type="radio" name="home_variant" value="<?= htmlspecialchars($variantKey) ?>"
                                                            class="form-check-input d-none scheme-radio"
                                                            <?= ($activeTheme === $themeKey && $activeVariant === $variantKey) ? 'checked' : '' ?>>
                                                        <div class="scheme-option border rounded-3 p-3 h-100 <?= ($activeTheme === $themeKey && $activeVariant === $variantKey) ? 'theme-option-active' : '' ?>">
                                                            <strong><?= htmlspecialchars($variant['label']) ?></strong>
                                                            <div class="text-muted small"><code><?= htmlspecialchars($variant['file']) ?></code></div>
                                                        </div>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="admin-card mb-4">
                        <div class="admin-card-header">
                            <h2><i class="bi bi-palette me-2 text-primary"></i>Tracking Page Color</h2>
                        </div>
                        <div class="admin-card-body">
                            <p class="text-muted small">
                                Sets the accent color and gradient used on the public tracking-result page
                                (hero banner, buttons, status badges). Each color is a fixed, pre-designed
                                gradient &mdash; there's nothing else to configure.
                            </p>
                            <div class="row g-3">
                                <?php foreach ($schemes as $key => $scheme): ?>
                                    <div class="col-sm-6 col-lg-3">
                                        <label class="d-block h-100" style="cursor:pointer;">
                                            <input type="radio" name="track_color_scheme" value="<?= htmlspecialchars($key) ?>"
                                                class="form-check-input d-none scheme-radio"
                                                <?= $activeScheme === $key ? 'checked' : '' ?>>
                                            <div class="scheme-option border rounded-3 p-3 h-100 <?= $activeScheme === $key ? 'theme-option-active' : '' ?>">
                                                <div class="rounded-2 mb-2" style="height:48px;background:<?= $scheme['gradient'] ?>;"></div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <strong><?= htmlspecialchars($scheme['label']) ?></strong>
                                                    <?php if ($activeScheme === $key): ?>
                                                        <span class="badge text-bg-primary"><i class="bi bi-check2 me-1"></i>Active</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="admin-card mb-4">
                        <div class="admin-card-header">
                            <h2><i class="bi bi-translate me-2 text-primary"></i>Translator</h2>
                        </div>
                        <div class="admin-card-body">
                            <p class="text-muted small">
                                Adds a language-picker widget to every theme's header (and the tracking-result
                                page) so visitors can machine-translate the site. Pick which languages it
                                offers, and the language the site's own content is written in.
                            </p>
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6 col-md-4">
                                    <label class="form-label">Site content language</label>
                                    <select name="translate_source" class="form-select">
                                        <?php foreach ($languageCatalog as $code => $label): ?>
                                            <option value="<?= htmlspecialchars($code) ?>" <?= $activeSourceLang === $code ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($label) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <label class="form-label">Languages to offer</label>
                            <div class="row g-2 lang-grid">
                                <?php foreach ($languageCatalog as $code => $label): ?>
                                    <div class="col-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="translate_languages[]"
                                                value="<?= htmlspecialchars($code) ?>" id="lang-<?= htmlspecialchars($code) ?>"
                                                <?= in_array($code, $activeLanguages, true) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="lang-<?= htmlspecialchars($code) ?>">
                                                <?= htmlspecialchars($label) ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="admin-card-header border-top border-bottom-0">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check2-circle me-1"></i>Save Appearance</button>
                        </div>
                    </div>
                </form>
<?php
$extraScripts = <<<'HTML'
<script>
function updateHomeVariantVisibility() {
    var checked = document.querySelector('input[name="active_theme"]:checked');
    var themeKey = checked ? checked.value : null;
    document.querySelectorAll('.home-variant-block').forEach(function (block) {
        var show = block.getAttribute('data-theme-key') === themeKey;
        block.style.display = show ? 'block' : 'none';
        if (!show) {
            // Don't submit a variant choice for a theme that isn't selected.
            block.querySelectorAll('input[name="home_variant"]').forEach(function (input) {
                input.disabled = true;
            });
        } else {
            block.querySelectorAll('input[name="home_variant"]').forEach(function (input) {
                input.disabled = false;
            });
        }
    });
}
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('input[name="active_theme"]').forEach(function (radio) {
        radio.addEventListener('change', updateHomeVariantVisibility);
    });
    updateHomeVariantVisibility();
});
</script>
HTML;
include 'partials/admin_end.php';
