<?php
$_SESSION['lang'] = 'ja';
$language = 'ja';
if (
    !isset($_SESSION['form_data']) || 
    empty($_SESSION['form_data']) ||
    !is_array($_SESSION['form_data'])
) {
    header("Location: /register"); 
    exit;
}
// echo $language;
$translations = json_decode(file_get_contents(__DIR__."/../lang/ja.json"), true);

// print_r($translations);die;
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
?>

<style>
.btn-loading {
    position: relative;
    pointer-events: none;
    opacity: .8;
}

.btn-loading::after {
    content: "";
    width: 18px;
    height: 18px;
    border: 2px solid white;
    border-top: 2px solid transparent;
    border-radius: 50%;
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    animation: spin .7s linear infinite;
}

@keyframes spin {
    to { transform: translateY(-50%) rotate(360deg); }
}

.slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    height: 22px;
    width: 22px;
    border-radius: 50%;
    background: #1d4ed8;
    cursor: pointer;
    border: 3px solid white;
    box-shadow: 0 2px 6px rgba(0,0,0,.2);
}
/* Question Navigation Buttons */
.question-nav {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    margin-bottom: 20px;
}

.question-btn {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: 2px solid #d1d5db;
    background: #ffffff;
    color: #374151;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
}

.question-btn:hover {
    border-color: #1d4ed8;
    color: #1d4ed8;
}

.question-btn.active {
    border-color: #1d4ed8;
    box-shadow: 0 0 0 3px rgba(29,78,216,0.2);
}

.question-btn.answered {
    background: #1d4ed8;
    color: #ffffff;
    border-color: #1d4ed8;
}

.question-btn.disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

button.question-btn.answered , button.question-btn.visited {cursor:pointer;}

button.question-btn {
    cursor: no-drop;
}
</style>
<div class="bg-slate-100">

    <div class="max-w-4xl mx-auto px-5 py-8">


        <!-- Header -->
        <div class="mb-6">
            <!-- QUESTION NAVIGATION (must be here) -->
            <div id="questionNav" class="question-nav"></div>

            <div class="flex justify-between text-sm text-gray-700 mb-2">
                <div id="progress"></div>
                <div id="category"></div>
            </div>

            <!-- Progress bar -->
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div id="progressBar" class="h-2 rounded-full bg-blue-700 transition-all" style="width:12%"></div>
            </div>
        </div>

        <!-- Question Card -->
        <div class="bg-white rounded-xl shadow-md p-8 text-center">

            <!-- Question -->
            <h2 id="questionText" class="text-2xl font-bold mb-4 leading-relaxed">
                <!-- Do you have a clearly defined Ideal Customer Profile (ICP) with specific criteria? -->
            </h2>

            <!-- Score -->
            <div class="mb-4" id="scoreSection">
                <div id="scoreText" class="text-gray-400 text-xl font-medium">
                </div>

                <div id="scoreLabel" class="mt-4 hidden">
                    <span id="labelBox" class="px-4 py-2 rounded-full text-white text-sm font-medium"></span>
                </div>
            </div>

            <!-- Slider -->
            <input type="range" min="1" max="10" id="slider" value="1"
                class="w-full h-2 bg-gradient-to-r from-sky-300 to-blue-700 rounded-lg appearance-none cursor-pointer slider">

            <!-- Scale -->
            <div class="flex justify-between mt-3 text-sm text-gray-600 px-1">
                <?php for($i=1;$i<=10;$i++): ?><span><?= $i ?></span><?php endfor; ?>
            </div>

            <!-- Legend -->
            <div class="flex justify-center gap-8 mt-6 text-sm text-gray-600 items-center">
                <span class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-gray-400"></span> 1-3 <?= t('assessment.weak') ?>
                </span>
                <span class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-sky-400"></span> 4-6 <?= t('assessment.moderate') ?>
                </span>
                <span class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-blue-700"></span> 7-10 <?= t('assessment.strong') ?>
                </span>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between mt-10">
                <button id="backBtn" class="px-8 py-3 rounded border border-gray-300 bg-gray-100 text-gray-500" disabled><?= t('assessment.question.back') ?></button>

                <button id="nextBtn" class="px-8 py-3 rounded bg-blue-700 text-white"><?= t('assessment.question.next') ?></button>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function(){

    let currentQuestionIndex = 0;
    const TRACKING_LANGUAGE = 'ja';
    const GA_EVENT_TIMEOUT_MS = 2000;
    const REDIRECT_FALLBACK_MS = 400;
    const FROM_STEP = <?= json_encode($_GET['from'] ?? '', JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

    /* ===========================
       Helpers
    =========================== */

    function getAnswers(){
        return JSON.parse(localStorage.getItem('assessment_answers') || '{}');
    }

    function saveLocal(index, value){
        let answers = getAnswers();
        answers[index] = value;
        localStorage.setItem('assessment_answers', JSON.stringify(answers));
    }

    function setLoading(btn, state){
        if(state){
            btn.classList.add('btn-loading');
            btn.disabled = true;
        }else{
            btn.classList.remove('btn-loading');
            btn.disabled = false;
        }
    }

    function trackAndRedirect(eventName, redirectUrl, params = {}){
        let redirected = false;

        const go = () => {
            if (redirected) return;
            redirected = true;
            window.location.href = redirectUrl;
        };

        if (typeof window.gtag === 'function') {
            window.gtag('event', eventName, Object.assign({
                event_category: 'assessment',
                language: TRACKING_LANGUAGE,
                transport_type: 'beacon',
                event_callback: go,
                event_timeout: GA_EVENT_TIMEOUT_MS
            }, params));
            setTimeout(go, REDIRECT_FALLBACK_MS);
            return;
        }

        go();
    }
    /* ===========================
       Render Navigation Buttons
    =========================== */
    function renderQuestionNav(total, current){
        const nav = document.getElementById('questionNav');
        nav.innerHTML = '';

        const answers = JSON.parse(localStorage.getItem('assessment_answers') || '{}');

        for(let i=0;i<total;i++){

            const btn = document.createElement('button');
            btn.type = "button";
            btn.innerText = i+1;
            btn.className = "question-btn";

            if(answers[i] !== undefined){
                btn.classList.add('answered');
            }

            if(i === current){
                btn.classList.add('active');
                btn.classList.add('visited');            
                
            }
            
                nav.appendChild(btn);
        }
    }
    /* ===========================
       Load Question
    =========================== */
    function loadQuestion(init = false){
        // Get saved answers
        const answers = JSON.parse(localStorage.getItem('assessment_answers') || '{}');

        // If no answers saved, reset last_question_index
        if(Object.keys(answers).length === 0){
            localStorage.setItem('last_question_index', 0);
        }

        fetch('<?= BASE_URL;?>/api/ajax/get-question.php')
        .then(res => res.json())
        .then(data => {

            if(data.finished){
                const redirectUrl = '<?= BASE_URL;?>/gtm-assessment?step=challenges';
                trackAndRedirect('assessment_step1_complete', redirectUrl, { step: 'questions' });
                return;
            }

            // If no saved answers, start from first question
            if(Object.keys(answers).length === 0){
                currentQuestionIndex = 0;
            } else {
                currentQuestionIndex = data.index;
            }

            localStorage.setItem('last_question_index', currentQuestionIndex);

            // Update question text, category, progress
            document.getElementById('questionText').innerText = data.question;
            document.getElementById('category').innerText = data.category;
            document.getElementById('progress').innerText = '質問 ' + (data.index + 1) + ' / ' + data.total;
            document.getElementById('progressBar').style.width = ((currentQuestionIndex+1)/data.total)*100 + '%';

            // Determine final answer
            let finalAnswer;
            if(data.answer !== null){
                finalAnswer = data.answer;
            } else {
                finalAnswer = answers[currentQuestionIndex] ?? 1;
            }

            document.getElementById('slider').value = finalAnswer;
            document.getElementById('scoreText').innerText = finalAnswer;
            updateStrength(finalAnswer);

            document.getElementById('backBtn').disabled = false;

            // Update navigation buttons
            renderQuestionNav(data.total, currentQuestionIndex);

            if(init){
                // Mark active / answered buttons for initial load
                const activeBtn = document.querySelector('#questionNav button:nth-child(' + (currentQuestionIndex+1) + ')');
                if(activeBtn) activeBtn.classList.add('active');

                const ansBtn = document.querySelector('#questionNav button:nth-child(' + (currentQuestionIndex) + ')');
                if(ansBtn) ansBtn.classList.add('answered');
            }

        })
        .catch(err => console.error('Error loading question:', err));
    }

    /* ===========================
       Strength Label
    =========================== */

    function updateStrength(val){

        let label='', color='';

        if(val <=3){
            label='<?= t("assessment.weak") ?>';
            color='#9ca3af';
        }else if(val <=6){
            label='<?= t("assessment.moderate") ?>';
            color='#38bdf8';
        }else{
            label='<?= t("assessment.strong") ?>';
            color='#1d4ed8';
        }

        document.getElementById('scoreLabel').classList.remove('hidden');
        document.getElementById('labelBox').innerText = label;
        document.getElementById('labelBox').style.backgroundColor = color;
    }

    /* ===========================
       Slider Change
    =========================== */

    document.getElementById('slider').addEventListener('input', function(){

        let value = this.value;

        document.getElementById('scoreText').innerText = value;
        updateStrength(value);

        saveLocal(currentQuestionIndex, value);

        fetch('<?= BASE_URL;?>/api/ajax/save-answer.php', {
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:`answer=${value}&action=stay`
        });
    });

    /* ===========================
       Next Button (ALWAYS ENABLED)
    =========================== */

    document.getElementById('nextBtn').addEventListener('click', function(){

        setLoading(this, true);

        let answer = document.getElementById('slider').value;

        saveLocal(currentQuestionIndex, answer);

        fetch('<?= BASE_URL;?>/api/ajax/save-answer.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:`action=next&answer=${answer}`
        })
        .then(()=> loadQuestion(true))
        .finally(()=> setLoading(document.getElementById('nextBtn'), false));
    });

    /* ===========================
       Back Button
    =========================== */

    document.getElementById('backBtn').addEventListener('click', function(){

        setLoading(this, true);

        if(currentQuestionIndex === 0){
            const answer = document.getElementById('slider').value;
            saveLocal(currentQuestionIndex, answer);

            fetch('<?= BASE_URL;?>/api/ajax/save-answer.php',{
                method:'POST',
                headers:{'Content-Type':'application/x-www-form-urlencoded'},
                body:`action=stay&answer=${answer}`
            }).finally(() => {
                window.location.href = '<?= BASE_URL;?>/register?from=questions';
            });
            return;
        }

        fetch('<?= BASE_URL;?>/api/ajax/save-answer.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:'action=back'
        })
        .then(()=> loadQuestion(true))
        .finally(()=> setLoading(document.getElementById('backBtn'), false));
    });

    /* ===========================
       Restore On Load
    =========================== */

    function initQestions(){
        const savedIndex = localStorage.getItem('last_question_index');
        const answers = getAnswers();
        const hasSavedAnswers = Object.keys(answers).length > 0;

        if (FROM_STEP !== 'challenges' && FROM_STEP !== 'register') {
            localStorage.removeItem('assessment_answers');
            localStorage.removeItem('selected_challenges');
            localStorage.removeItem('last_question_index');

            fetch('<?= BASE_URL;?>/api/ajax/save-answer.php', {
                method: 'POST',
                headers: {'Content-Type':'application/x-www-form-urlencoded'},
                body: 'action=restore&index=0'
            }).then(() => loadQuestion());
            return;
        }

        if(savedIndex !== null && hasSavedAnswers){

            fetch('<?= BASE_URL;?>/api/ajax/save-answer.php',{
                method:'POST',
                headers:{'Content-Type':'application/x-www-form-urlencoded'},
                body:`action=restore&index=${savedIndex}`
            })
            .then(()=> loadQuestion());

        }else{
            fetch('<?= BASE_URL;?>/api/ajax/save-answer.php', {
                method: 'POST',
                headers: {'Content-Type':'application/x-www-form-urlencoded'},
                body: 'action=restore&index=0'
            }).then(() => loadQuestion());
        }
    }//initQestions
    initQestions();


    document.getElementById('questionNav').addEventListener('click', function(e){

        const btn = e.target.closest('.question-btn');
        if(!btn) return;

        const canAccess = btn.classList.contains('answered') || btn.classList.contains('visited');
        if(!canAccess) return;

        const index = parseInt(btn.innerText) - 1;
        fetch('<?= BASE_URL;?>/api/ajax/get-question.php?index=' + index)
        .then(res => res.json())
        .then(data => {

            console.log(data);

            if(data.finished){
                const redirectUrl = '<?= BASE_URL;?>/gtm-assessment?step=challenges';
                trackAndRedirect('assessment_step1_complete', redirectUrl, { step: 'questions' });
                return;
            }

            currentQuestionIndex = data.index;

            localStorage.setItem('last_question_index', data.index);

            document.getElementById('questionText').innerText = data.question;
            document.getElementById('category').innerText = data.category;

            document.getElementById('progress').innerText =
                '質問 ' + (data.index + 1) + ' / ' + data.total;

            document.getElementById('progressBar').style.width =
                ((data.index + 1) / data.total) * 100 + '%';

            let finalAnswer;

            if(data.answer !== null){
                finalAnswer = data.answer;
            } else {
                let localAns = getAnswers()[data.index];
                finalAnswer = localAns ?? 1;
            }

            document.getElementById('slider').value = finalAnswer;
            document.getElementById('scoreText').innerText = finalAnswer;

            updateStrength(finalAnswer);

            document.getElementById('backBtn').disabled = false;

            // ✅ FIXED NAV ACTIVE STATE
            // Remove active from all buttons
            document.querySelectorAll('#questionNav button')
                .forEach(btn => btn.classList.remove('active'));

            // Add active to current button (index is 0-based)
            const activeBtn = document.querySelector(
                '#questionNav button:nth-child(' + (data.index + 1) + ')'
            );

            if(activeBtn){
                activeBtn.classList.add('active');
            }
        });
    });//questionNav
});

</script>
