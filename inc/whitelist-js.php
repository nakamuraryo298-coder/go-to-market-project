<?php
/**
 * ステージング用: フロントJSにメールホワイトリストを埋め込む
 * フリーメールブロックをホワイトリストのアドレスに対してのみバイパスする
 *
 * このファイルは xserver ステージング環境専用。
 */
require_once __DIR__ . '/../config/env.php';
$wl = env('EMAIL_WHITELIST', '');
$wlArray = $wl ? array_map('trim', explode(',', $wl)) : [];
?>
<script>
(function(){
    var wl = <?= json_encode(array_map('strtolower', $wlArray)) ?>;
    if (!wl.length) return;
    // Override Array.prototype.includes only for freeDomains check
    var _origIncludes = Array.prototype.includes;
    Array.prototype.includes = function(item) {
        // Detect freeDomains array by checking for gmail.com member
        if (this.length > 2 && _origIncludes.call(this, "gmail.com") && typeof item === "string") {
            // If checking a domain, see if full email is whitelisted
            var emailInputs = document.querySelectorAll('input[type="email"], input[name="email"]');
            for (var i = 0; i < emailInputs.length; i++) {
                var val = (emailInputs[i].value || "").trim().toLowerCase();
                if (val && wl.indexOf(val) !== -1) {
                    return false; // bypass block
                }
            }
        }
        return _origIncludes.apply(this, arguments);
    };
})();
</script>
