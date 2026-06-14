<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION['lang'] = 'en';
$language = 'en';

if (
    !isset($_SESSION['form_data']) || 
    empty($_SESSION['form_data']) ||
    !is_array($_SESSION['form_data'])
) {
    header("Location: /en/register"); 
    exit;
}

$translations = json_decode(file_get_contents(__DIR__."/../../lang/en.json"), true);

function t($key) {
    global $translations;
    $parts = explode('.', $key);
    $value = $translations;
    foreach ($parts as $p) {
        if (!isset($value[$p])) return $key;
        $value = $value[$p];
    }
    return $value;
}
$_SESSION['selected_challenges'] = $_SESSION['selected_challenges'] ?? [];
$selected = $_SESSION['selected_challenges'];
?>


<div class="bg-slate-100">
    <div class="max-w-4xl mx-auto px-5 py-8">
        <div class="max-w-4xl mx-auto p-6">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4"><?=  t("assessment.challenges.title")?></h2>
                <p class="text-lg text-gray-600">
                    <?=  t("assessment.challenges.subtitle")?>
                </p>
            </div>
            <?php 
            $challenges = $translations['gtmChallenges'] ?? [];
            ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <?php foreach ($challenges as $key => $text): 
                    $isChecked = in_array($key, $selected);
                ?>

                <label class="challenge-card flex items-start gap-4 p-5 bg-white rounded-xl shadow cursor-pointer border-2 transition
                    <?= $isChecked ? 'border-blue-600 bg-blue-50' : 'border-transparent hover:border-blue-300' ?>">

                    <input type="checkbox"
                           name="challenges[]"
                           value="<?= $key ?>"
                           class="hidden challenge-checkbox"
                           <?= $isChecked ? 'checked' : '' ?>>

                    <!-- Radio style circle -->
                    <div class="w-5 h-5 mt-1 rounded-full border-2 flex-shrink-0 flex items-center justify-center
                        <?= $isChecked ? 'border-blue-600 bg-blue-600' : 'border-gray-300' ?> check-icon">
                        <?php if ($isChecked): ?>
                            <span class="text-white text-xs">✓</span>
                        <?php endif; ?>
                    </div>

                    <span class="block flex-1 min-w-0 text-gray-800 text-sm leading-relaxed"><?= htmlspecialchars(trim((string)$text), ENT_QUOTES, 'UTF-8') ?></span>

                </label>

                <?php endforeach; ?>
            </div>


            <div id="selectedBox"
                 class="mb-6 p-4 bg-green-50 border border-green-300 rounded-lg flex items-center gap-3">

                <span class="text-green-600 text-xl">✔</span>
                <span id="selectedCountText" class="text-green-800 font-medium">
                    0 of 5 challenges selected
                </span>
            </div>
            <div class="flex justify-between">
                <button class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200" onclick="prevStep()">
                    <?= t('assessment.question.back') ?></button
                >
                <button disabled="" onclick="saveAndNext()" id="nextChallengeBtn" class="px-6 py-3 rounded-lg font-medium transition-all duration-200 bg-gray-300 text-gray-500 cursor-not-allowed">
                    <?= t('assessment.question.next') ?>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    const STORAGE_KEY = "selected_challenges";
    const GA_EVENT_TIMEOUT_MS = 2000;
    const REDIRECT_FALLBACK_MS = 400;
    const checkboxes   = document.querySelectorAll('.challenge-checkbox');
    const selectedBox = document.getElementById('selectedBox');
    const selectedText= document.getElementById('selectedCountText');
    const nextBtn     = document.getElementById('nextChallengeBtn');

    /* ---------------- SAVE TO LOCAL ---------------- */
    function saveToLocal(){
        const values = [];
        document.querySelectorAll('.challenge-checkbox:checked').forEach(cb=>{
            values.push(cb.value);
        });

        localStorage.setItem(STORAGE_KEY, JSON.stringify(values));
    }


    /* ---------------- LOAD FROM LOCAL ---------------- */
    function loadFromLocal(){
        const saved = localStorage.getItem(STORAGE_KEY);
        if(!saved) return;

        let values = [];
        try{
            values = JSON.parse(saved);
        }catch(e){
            return;
        }

        checkboxes.forEach(cb=>{
            if(values.includes(cb.value)){
                cb.checked = true;

                /* Apply UI state */
                const card = cb.closest('.challenge-card');
                const icon = card.querySelector('.check-icon');

                card.classList.add('border-blue-600','bg-blue-50');
                icon.classList.add('bg-blue-600','border-blue-600');
                icon.innerHTML = '<span class="text-white text-xs">✓</span>';
            }
        });
    }
    function getCheckedCount() {
        return document.querySelectorAll('.challenge-checkbox:checked').length;
    }


    function updateUI() {
        const count = getCheckedCount();

        if (count > 0) {
            selectedBox.classList.remove('hidden');
            selectedText.innerText = `${count} of 5 challenges selected`;
        } else {
            selectedBox.classList.add('hidden');
        }

        if (count > 0) {
            nextBtn.disabled = false;
            nextBtn.classList.remove('bg-gray-300','text-gray-500','cursor-not-allowed');
            nextBtn.classList.add('bg-blue-700','text-white','hover:bg-blue-800');
        } else {
            nextBtn.disabled = true;
            nextBtn.classList.remove('bg-blue-700','text-white','hover:bg-blue-800');
            nextBtn.classList.add('bg-gray-300','text-gray-500','cursor-not-allowed');
        }

        toggleRemainingCheckboxes(count >= 5);
    }

    function toggleRemainingCheckboxes(disable) {
        checkboxes.forEach(cb => {
            if (!cb.checked) {
                cb.disabled = disable;

                const card = cb.closest('.challenge-card');
                if (disable) {
                    card.classList.add('opacity-50','cursor-not-allowed');
                } else {
                    card.classList.remove('opacity-50','cursor-not-allowed');
                }
            }
        });
    }
    checkboxes.forEach(cb => {

        cb.addEventListener('change', function(){

            const card = this.closest('.challenge-card');
            const icon = card.querySelector('.check-icon');

            if (this.checked) {
                card.classList.add('border-blue-600','bg-blue-50');
                icon.classList.add('bg-blue-600','border-blue-600');
                icon.innerHTML = '<span class="text-white text-xs">✓</span>';
            } else {
                card.classList.remove('border-blue-600','bg-blue-50');
                icon.classList.remove('bg-blue-600','border-blue-600');
                icon.innerHTML = '';
            }

            saveToLocal();   // ⭐ IMPORTANT
            updateUI();
        });

    });


    /* ---------------- PAGE LOAD ---------------- */
    document.addEventListener("DOMContentLoaded", function(){
        loadFromLocal();   // ⭐ Restore
        updateUI();
    });


    /* ---------------- NAVIGATION ---------------- */
    function prevStep(){
        saveToLocal();
        window.location.href = '<?= BASE_URL ?>/en/gtm-assessment?step=questions&from=challenges';
    }

    function saveAndNext(){

        const btn = document.getElementById('nextChallengeBtn');

        /* Prevent double click */
        if(btn.disabled) return;

        /* Save Local First */
        saveToLocal();

        /* Disable + Loading UI */
        btn.disabled = true;
        btn.classList.remove('bg-blue-700','hover:bg-blue-800');
        btn.classList.add('bg-gray-400','cursor-not-allowed');

        /* Store Original Text */
        const originalText = btn.innerHTML;

        /* Show Loading */
        btn.innerHTML = 'Saving...';

        saveChallengesToSession()
        .then(res => res.json())
        .then(()=>{
            const redirectUrl = '<?= BASE_URL ?>/en/gtm-assessment?step=complete';
            let redirected = false;
            const go = () => {
                if (redirected) return;
                redirected = true;
                window.location.href = redirectUrl;
            };

            if (typeof window.gtag === 'function') {
                window.gtag('event', 'assessment_step2_complete', {
                    event_category: 'assessment',
                    language: 'en',
                    step: 'challenges',
                    transport_type: 'beacon',
                    event_callback: go,
                    event_timeout: GA_EVENT_TIMEOUT_MS
                });
                setTimeout(go, REDIRECT_FALLBACK_MS);
                return;
            }

            go();
        })
        .catch(()=>{
            /* Restore if error */
            btn.disabled = false;
            btn.innerHTML = originalText;

            btn.classList.remove('bg-gray-400','cursor-not-allowed');
            btn.classList.add('bg-blue-700','hover:bg-blue-800');
        });

    }

    function saveChallengesToSession() {
        const checked = document.querySelectorAll('.challenge-checkbox:checked');
        const values  = [];

        checked.forEach(cb => values.push(cb.value));

        return fetch('<?= BASE_URL ?>/api/ajax/save-challenges.php', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: 'challenges=' + encodeURIComponent(JSON.stringify(values)),
            credentials: 'same-origin'
        });
    }
</script>
