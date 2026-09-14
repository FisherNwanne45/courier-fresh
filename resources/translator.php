<?php
/**
 * Language-picker widget, included by every theme's header (and by the
 * shared tracking-result page) so the language list only has to be
 * configured once, from admin Appearance settings ($row['translate_source']
 * / $row['translate_languages'], both plain DB columns on `site`).
 *
 * ARCHITECTURE (rewritten -- see the snapshot taken before this rewrite,
 * under courier-backups/translator-snapshot-<timestamp>/, to revert if
 * this doesn't hold up):
 *
 * Two earlier approaches were tried and abandoned this session:
 *   1. Hide Google's widget off-screen and drive a same-looking custom
 *      <select> by bridging to an internal <select class="goog-te-combo">
 *      -- confirmed (by inspecting Google's live bundle AND a live page's
 *      DOM) that the SIMPLE layout used here no longer creates that
 *      element at all. Bridging to a control that doesn't exist meant the
 *      visible picker never did anything.
 *   2. Render Google's real SIMPLE-layout widget directly and style it in
 *      place -- worked, but its popup language list lives inside a
 *      genuinely cross-origin <iframe> (confirmed directly: inspecting a
 *      menu item showed it inside its own separate <body>). No CSS or JS
 *      on this page can reach in there at all -- that's a hard browser
 *      security boundary, not a bug -- so only the iframe's own box
 *      (border/shadow/corners/position) was ever stylable, never the list
 *      itself (colors, fonts, hover states, or forcing English labels
 *      regardless of the visitor's browser locale).
 *
 * This version sidesteps both problems by not touching Google's rendered
 * UI at all. Instead it drives translation the way Google's own widget
 * drives itself internally: a `googtrans` cookie holding "/<source>/<target>",
 * read by Google's script on page load to auto-apply that translation.
 * Confirmed directly against Google's live widget bundle (el_main.js, not
 * assumed from old blog posts) that:
 *   - it still reads the cookie via
 *     document.cookie.match(/(^|; )googtrans=(.*?)(;|$)/)
 *   - its own menu-click handler still writes that same cookie via a
 *     dx()/ex() pair that sets `googtrans=/<source>/<target>;path=/` twice
 *     -- once host-only, once with `;domain=.<registrable-domain>` (walking
 *     up window.location.hostname's labels to the last two) -- and clears
 *     it the same way with `=none;expires=<past date>`.
 * Reproducing exactly that cookie read/write means this doesn't depend on
 * any internal DOM structure of Google's (which has already changed twice
 * under us this session) -- only on the cookie contract, which is the part
 * of this widget Google can't change without breaking every site's saved
 * language cookies.
 *
 * Google's TranslateElement is still initialized (kept off-screen, real
 * non-zero dimensions -- a fully collapsed/hidden container was confirmed
 * earlier to break its internal rendering, since it reads
 * offsetWidth/offsetHeight/getBoundingClientRect) purely so its script is
 * present on the page to notice the cookie and actually translate the DOM.
 * Its own rendered trigger/popup/banner are never shown; our own markup
 * below is the only visible control, built from translatorLanguageCatalog()
 * so labels are always in English no matter the visitor's browser locale.
 *
 * Callers must already have $row available (everything that includes this
 * already requires resources/config.php beforehand, which is also where
 * translatorLanguageCatalog() lives). Each include on a page renders its
 * own ids so the same theme can drop the widget in more than one spot
 * without collisions.
 */

$GLOBALS['__translatorInstance'] = ($GLOBALS['__translatorInstance'] ?? 0) + 1;
$translatorInstance = $GLOBALS['__translatorInstance'];
$googleHostId = 'google_translate_element_' . $translatorInstance;
$wrapId = 'site_translator_' . $translatorInstance;

$translateSource = !empty($row['translate_source']) ? $row['translate_source'] : 'en';
$translateLangsCsv = !empty($row['translate_languages']) ? $row['translate_languages'] : 'en,fr,es,de,it,pt,ar,zh-CN,ko,ja,ru,hi';

$catalog = translatorLanguageCatalog();
$translateLangCodes = array_values(array_filter(array_map('trim', explode(',', $translateLangsCsv))));

// The source language itself is always offered too, as the "show original"
// choice -- if admin didn't separately include it in the target list, add
// it at the front so it doesn't just silently vanish from the menu.
$menuLangs = [];
if (!in_array($translateSource, $translateLangCodes, true)) {
    $menuLangs[$translateSource] = $catalog[$translateSource] ?? strtoupper($translateSource);
}
foreach ($translateLangCodes as $code) {
    $menuLangs[$code] = $catalog[$code] ?? strtoupper($code);
}
$currentLabel = $catalog[$translateSource] ?? strtoupper($translateSource);
?>
<div class="site-translator" id="<?= htmlspecialchars($wrapId) ?>" data-source="<?= htmlspecialchars($translateSource, ENT_QUOTES) ?>">
    <div id="<?= htmlspecialchars($googleHostId) ?>" class="site-translator-google-host" aria-hidden="true"></div>

    <div class="site-translator-trigger" tabindex="0" role="button" aria-haspopup="listbox" aria-expanded="false">
        <a href="#" class="site-translator-trigger-link" onclick="return false;">
            <span class="site-translator-trigger-label"><?= htmlspecialchars($currentLabel) ?></span>
        </a>
    </div>
    <div class="site-translator-menu" role="listbox" hidden>
        <?php foreach ($menuLangs as $code => $label): ?>
            <a href="#" class="site-translator-menu-item" role="option" data-lang="<?= htmlspecialchars($code, ENT_QUOTES) ?>"><?= htmlspecialchars($label) ?></a>
        <?php endforeach; ?>
    </div>
</div>
<script>
    (function () {
        var wrapId = <?= json_encode($wrapId) ?>;
        var sourceLang = <?= json_encode($translateSource) ?>;

        // Several instances of this widget can appear on one page (a custom
        // homepage header plus a mobile-menu copy, say). Google's callback
        // only fires once for the whole page, so every instance queues its
        // own init and the first callback to fire drains the whole queue.
        window.__siteTranslatorQueue = window.__siteTranslatorQueue || [];
        window.__siteTranslatorQueue.push(function () {
            try {
                new google.translate.TranslateElement({
                    pageLanguage: '<?= htmlspecialchars($translateSource, ENT_QUOTES) ?>',
                    includedLanguages: '<?= htmlspecialchars($translateLangsCsv, ENT_QUOTES) ?>',
                    autoDisplay: false,
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                }, '<?= htmlspecialchars($googleHostId, ENT_QUOTES) ?>');
            } catch (e) {
                console.error('[site-translator] Google TranslateElement failed to initialize:', e);
            }
        });

        if (!window.googleTranslateElementInit) {
            window.googleTranslateElementInit = function () {
                window.__siteTranslatorQueue.forEach(function (fn) { fn(); });
            };
        }

        if (!window.__siteTranslatorScriptLoaded) {
            window.__siteTranslatorScriptLoaded = true;
            var s = document.createElement('script');
            s.src = '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
            s.onerror = function () {
                console.error('[site-translator] translate.google.com/translate_a/element.js failed to load.');
            };
            document.body.appendChild(s);
        } else if (window.google && window.google.translate) {
            window.__siteTranslatorQueue[window.__siteTranslatorQueue.length - 1]();
        }

        // Mirrors Google's own cookie read/write exactly (reverse-engineered
        // from their live bundle, see the docblock above) so this stays
        // compatible with however their script itself applies the cookie on
        // load, without depending on any of their DOM/class internals.
        function setGoogTransCookie(value) {
            var hostParts = window.location.hostname.split('.');
            while (hostParts.length > 2) hostParts.shift();
            var domainSuffix = ';domain=.' + hostParts.join('.');
            var cookieStr;
            if (value !== null) {
                cookieStr = 'googtrans=' + value;
            } else {
                var past = new Date();
                past.setTime(past.getTime() - 1);
                cookieStr = 'googtrans=none;expires=' + past.toUTCString();
            }
            cookieStr += ';path=/';
            document.cookie = cookieStr;
            try { document.cookie = cookieStr + domainSuffix; } catch (e) { /* ignore */ }
        }

        function currentGoogTransTarget() {
            var m = document.cookie.match(/(^|; )googtrans=([^;]*)/);
            if (!m || !m[2] || m[2] === 'none') return '';
            var parts = decodeURIComponent(m[2]).split('/');
            return parts[2] || '';
        }

        function initDropdown() {
            var root = document.getElementById(wrapId);
            if (!root) return;
            var trigger = root.querySelector('.site-translator-trigger');
            var menu = root.querySelector('.site-translator-menu');
            var labelEl = root.querySelector('.site-translator-trigger-label');
            var items = root.querySelectorAll('.site-translator-menu-item');

            var current = currentGoogTransTarget() || sourceLang;
            items.forEach(function (item) {
                if (item.getAttribute('data-lang') === current) {
                    item.classList.add('is-active');
                    if (labelEl) labelEl.textContent = item.textContent;
                }
            });

            function closeMenu() {
                menu.hidden = true;
                trigger.setAttribute('aria-expanded', 'false');
            }
            function openMenu() {
                menu.hidden = false;
                trigger.setAttribute('aria-expanded', 'true');
            }

            trigger.addEventListener('click', function (e) {
                e.preventDefault();
                if (menu.hidden) openMenu(); else closeMenu();
            });
            trigger.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    if (menu.hidden) openMenu(); else closeMenu();
                } else if (e.key === 'Escape') {
                    closeMenu();
                }
            });
            document.addEventListener('click', function (e) {
                if (!root.contains(e.target)) closeMenu();
            });

            items.forEach(function (item) {
                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    var lang = item.getAttribute('data-lang');
                    closeMenu();
                    if (lang === sourceLang) {
                        setGoogTransCookie(null);
                    } else {
                        setGoogTransCookie('/' + sourceLang + '/' + lang);
                    }
                    window.location.reload();
                });
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initDropdown);
        } else {
            initDropdown();
        }

        // Once a translation is actually applied (the cookie is set and
        // Google's script picks it up on this load), Google inserts its own
        // "Translated by Google / Traduci / Tradotta in: ..." banner
        // <iframe> as a top-level child of <body> -- independent of the
        // off-screen host div above, so hiding that host doesn't hide this.
        // It carries the generic "skiptranslate" class and nothing else on
        // this page does, since our own dropdown never touches Google's UI
        // at all any more (no menu iframe of theirs is ever opened -- we
        // bypass it entirely via the cookie). Same inline-!important
        // technique as before (beats any external stylesheet regardless of
        // load order) and same whole-document poll (a MutationObserver on
        // document.body's subtree never fired for these earlier -- they
        // land as a sibling of <body>, not inside it).
        function forceImportant(el, props) {
            for (var prop in props) {
                el.style.setProperty(prop, props[prop], 'important');
            }
        }
        function hideBanner(frame) {
            forceImportant(frame, { display: 'none', visibility: 'hidden', height: '0' });
            document.body.style.setProperty('top', '0px', 'important');
        }
        if (!window.__siteTranslatorBannerPoll) {
            window.__siteTranslatorBannerPoll = setInterval(function () {
                document.querySelectorAll('iframe.skiptranslate').forEach(hideBanner);
            }, 200);
        }
    })();
</script>
<style>
    /* Google's widget is kept alive purely so its script can read/apply the
       googtrans cookie -- moved off-screen with real, non-zero dimensions
       rather than display:none or a clipped 1x1 box (confirmed earlier
       this session that a fully collapsed container breaks its internal
       rendering, since it reads offsetWidth/offsetHeight/getBoundingClientRect).
       Its own trigger/popup/banner are simply never seen because nothing
       ever scrolls this into view. */
    .site-translator {
        position: relative;
        display: inline-block;
    }
    /* Same-tick fallback for Google's top banner iframe, for the instant
       before the poll's first 200ms tick runs -- see the JS above
       (hideBanner()) for why this can't just be a CSS-only fix (inline
       !important, forced by JS, is the only thing guaranteed to win
       regardless of when Google's own async stylesheet loads). */
    iframe.skiptranslate {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
    }
    body {
        top: 0 !important;
        position: static !important;
    }
    .site-translator-google-host {
        position: absolute;
        left: -9999px;
        top: 0;
        width: 200px;
        height: 40px;
        overflow: visible;
    }
    .goog-text-highlight { background: none !important; box-shadow: none !important; }

    /* The actual visible control -- fully ours, fully stylable. Each theme
       points its own colors/spacing at .site-translator-trigger /
       .site-translator-trigger a / .site-translator-trigger a span
       (added alongside the old .goog-te-gadget-simple rules, which are
       now unused but left in place). */
    .site-translator-trigger {
        cursor: pointer;
        user-select: none;
    }
    .site-translator-trigger-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .site-translator-trigger-link::after {
        content: '';
        display: inline-block;
        width: 0;
        height: 0;
        margin-left: 2px;
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-top: 5px solid currentColor;
        opacity: .7;
    }

    .site-translator-menu {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        min-width: 190px;
        max-height: 320px;
        overflow-y: auto;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .12);
        z-index: 100000;
        padding: 6px 0;
    }
    .site-translator-menu[hidden] { display: none; }
    .site-translator-menu-item {
        display: block;
        padding: 8px 16px;
        font-size: 13px;
        line-height: 1.4;
        color: #333;
        text-decoration: none;
        white-space: nowrap;
    }
    .site-translator-menu-item:hover,
    .site-translator-menu-item.is-active {
        background: #f2f4f7;
        color: #111;
    }
</style>
