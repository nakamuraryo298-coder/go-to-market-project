<?php
$_SESSION['lang'] = 'en';
if (
    !isset($_SESSION['form_data']) || 
    empty($_SESSION['form_data']) ||
    !is_array($_SESSION['form_data'])
) {
    header("Location: /en/register"); 
    exit;
}
$language = 'en';
// echo $language;
$translations = json_decode(file_get_contents(__DIR__."/../../lang/en.json"), true);

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
$formDataBackup = $_SESSION['form_data'] ?? null;
$answersBackup = $_SESSION['answers'] ?? null;
$selectedChallengesBackup = $_SESSION['selected_challenges'] ?? null;
$currentQuestionBackup = $_SESSION['current_question'] ?? null;

unset($_SESSION['form_data']);
unset($_SESSION['answers']);
unset($_SESSION['selected_challenges']);
unset($_SESSION['current_question']);


/**
 * ----------------------------------------------------
 * 2. Include assessment scoring logic (SOURCE OF TRUTH)
 * ----------------------------------------------------
 */
require_once __DIR__ . '/../../en/inc/assessment-scoring.php';
require_once __DIR__ . '/../../en/inc/assessment-question-builder.php';
$session = $_SESSION;

/**
 * ----------------------------------------------------
 * 3. Prepare answers (Record<number, number>)
 * ----------------------------------------------------
 */
$questions = [];

$questions = buildQuestions($language);
$answers = [];
foreach ($answersBackup ?? [] as $index => $value) {
    $answers[$index + 1] = (int)$value; // questionId => score
}

/**
 * ----------------------------------------------------
 * 4. Prepare questions (Question[])
 * MUST match Vite.js logic
 * ----------------------------------------------------
 */

/**
 * ----------------------------------------------------
 * 5. Validate answers
 * ----------------------------------------------------
 */

// echo '<pre>';
// print_r($answers);
// echo '<br/></hr/>';
// echo '----------------------';
// print_r($questions);
if (!validateAnswers($answers, $questions)) {
    die('Invalid or incomplete answers');
}

/**
 * ----------------------------------------------------
 * 6. Process assessment (JS-equivalent)
 * ----------------------------------------------------
 */
$assessmentResult = processAssessment(
    $answers,
    $questions,
    $language
);

/**
 * ----------------------------------------------------
 * 7. User info
 * ----------------------------------------------------
 */
// echo $session['form_data']['revenueRange'];
// print_r($session['form_data']);die;
$user = [
    'email'   => $formDataBackup['email'] ?? null,
    'name'    => trim(
        ($formDataBackup['firstName'] ?? '') . ' ' .
        ($formDataBackup['lastName'] ?? '')
    ),
    'firstName'=>$formDataBackup['firstName'] ?? null,
    'lastName'=>$formDataBackup['lastName'] ?? null,
    'company' => $formDataBackup['company'] ?? null,
    'revenue_range'=>$formDataBackup['revenueRange'] ?? null,
    'job_title'=>$formDataBackup['jobTitle'] ?? null,
    'department'=>$formDataBackup['department'] ?? null,
];

/**
 * ----------------------------------------------------
 * 8. Selected challenges
 * ----------------------------------------------------
 */
$selectedChallenges = array_map(
    fn($c) => (int)str_replace('challenge', '', $c),
    $selectedChallengesBackup ?? []
);

/**
 * ----------------------------------------------------
 * 9. Final payload (API-ready)
 * ----------------------------------------------------
 */
$payload = [
    'language'           => $language,
    'assessmentResult'   => $assessmentResult,
    'answers'            => $answers,
    'selectedChallenges' => $selectedChallenges,
    'questions'          => $questions,
    'user'               => $user,
];

$payloadJson = json_encode(
    $payload,
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
);
?>

<div class="bg-slate-100">
    <div class="max-w-4xl mx-auto px-5 py-8">
        <div class="max-w-2xl mx-auto p-6">
            <div class="text-center mb-12">
                <div
                    class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6"
                    style="background-color: rgb(53, 119, 24)"
                   
                >
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold mb-4" style="color: rgb(24, 57, 80)"><?= t('assessment.success.title');?></h1>
                <p class="text-lg mb-4" style="color: rgb(62, 62, 62)">
                    <?= t('assessment.success.description');?>
                </p>
                <div
                    class="p-4 rounded-lg mb-6"
                    style="background-color: rgb(248, 249, 250); border-color: rgb(53, 119, 24); border-width: 1px"
                   
                >   
                 <p class="font-medium" style="color: rgb(53, 119, 24)">Report generated and sent successfully!</p>
                </div>
            </div>
            <div class="space-y-4">
                <button id="back_to_top"
                    class="w-full py-4 px-6 text-white rounded-lg font-semibold text-lg transition-all duration-200 hover:opacity-90 shadow-lg"
                    style="background-color: rgb(12, 83, 149)">
                    <?= t('assessment.success.backToTop');?>
                </button>

                
                <button id="book_consultation"
                    class="w-full py-4 px-6 border-2 rounded-lg font-semibold text-lg transition-all duration-200 hover:opacity-90"
                    style="border-color: rgb(12, 83, 149); color: rgb(12, 83, 149); background-color: transparent"
                >
                    <?= t('assessment.success.bookConsultation');?>
                </button>
            </div>

            <div class="pt-5">
               <button id="get_report" class="btn btn-link" style="color:blue"><span id="btnText">Resend the report</span></button>
            </div>
            <div class="mt-12 p-6 bg-gray-50 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-3"><?= t('assessment.complete.whatsNext');?></h3>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"
                            ></path></svg
                        ><span><?= t('assessment.complete.downloadReportDesc');?></span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"
                            ></path></svg
                        ><span><?= t('assessment.complete.reviewResults');?></span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"
                            ></path></svg
                        ><span><?= t('assessment.complete.scheduleConsultation');?></span>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>
<script>
window.onload = function () {

    function disableBack() {
        window.history.forward();
    }

    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function () {
        alert("Returning from the success screen may cause data loss or errors.");
        disableBack();
    };

};
</script>
<script>
(function(){
    try {
        console.log('Before remove:', localStorage.getItem('assessment_answers'), localStorage.getItem('selected_challenges'));

        localStorage.removeItem('assessment_answers');
        localStorage.removeItem('selected_challenges');
        localStorage.removeItem('last_question_index');

        console.log('After remove:', localStorage.getItem('assessment_answers'), localStorage.getItem('selected_challenges'));
    } catch(e) {
        console.error('localStorage clear failed', e);
    }
})();
</script>
<script>
const btn = document.getElementById("get_report");
const btnText = document.getElementById("btnText");

btn?.addEventListener("click", function () {

    const payload = <?= $payloadJson ?>;

    // ✅ Show loader
    btn.disabled = true;
    btn.classList.add("opacity-70", "cursor-not-allowed");
    btnText.innerText = "Processing..."; // optional

    fetch("<?= BASE_URL;?>/api/generate-gtm-pdf.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload)
    })
    .then(async res => {
        const data = await res.json();

        if (!res.ok) {
            console.error("API ERROR RESPONSE:", data);
            throw new Error(data.message || "Request failed");
        }

        return data;
    })
    .then(data => {
        // console.log("API SUCCESS RESPONSE:", data);

        // optional redirect
        // window.location.href = "<?= BASE_URL ?>/en/gtm-assessment?step=success";
    })
    .catch(err => {
        console.error("FETCH ERROR:", err);
        alert("Something went wrong, please try again.");
    })
    .finally(() => {
        // ✅ Hide loader (if you stay on page)
        btn.disabled = false;
        btn.classList.remove("opacity-70", "cursor-not-allowed");
        // btnLoader.classList.add("hidden");
        btnText.innerText = "Resend the report";
    });
});
document.addEventListener("DOMContentLoaded", function () {


    document.getElementById("back_to_top")?.addEventListener("click", function () {
        window.location.href = "/en/";
    });

    document.getElementById("book_consultation")?.addEventListener("click", function () {
        window.open(
            "https://go-to-market.jp/en/#contact",
            "_blank"
        );
    });

});
</script>
