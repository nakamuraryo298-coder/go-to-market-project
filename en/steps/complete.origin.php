<?php
/**
 * ----------------------------------------------------
 * 1. Language & translations
 * ----------------------------------------------------
 */
$language = 'en';
$_SESSION['lang'] = $language;

$translations = json_decode(
    file_get_contents(__DIR__ . "/../lang/$language.json"),
    true
);

function t($key)
{
    global $translations;
    $parts = explode('.', $key);
    $value = $translations;
    foreach ($parts as $p) {
        if (!isset($value[$p])) return $key;
        $value = $value[$p];
    }
    return $value;
}

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
foreach ($session['answers'] ?? [] as $index => $value) {
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
    'email'   => $session['form_data']['email'] ?? null,
    'name'    => trim(
        ($session['form_data']['firstName'] ?? '') . ' ' .
        ($session['form_data']['lastName'] ?? '')
    ),
    'firstName'=>$session['form_data']['firstName'] ?? null,
    'lastName'=>$session['form_data']['lastName'] ?? null,
    'company' => $session['form_data']['company'] ?? null,
    'revenue_range'=>$session['form_data']['revenueRange'] ?? null,
    'job_title'=>$session['form_data']['jobTitle'] ?? null,
    'department'=>$session['form_data']['department'] ?? null,
];

/**
 * ----------------------------------------------------
 * 8. Selected challenges
 * ----------------------------------------------------
 */
$selectedChallenges = array_map(
    fn($c) => (int)str_replace('challenge', '', $c),
    $session['selected_challenges'] ?? []
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

<body class="bg-slate-100">
    <div class="max-w-4xl mx-auto px-5 py-8">
        <div class="max-w-2xl mx-auto p-6">
            <div class="text-center mb-12">
                <div
                    class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6"
                   
                >
                    <svg class="w-10 h-10 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-800 mb-4"><?= t('assessment.assessmentComplete');?></h1>
                <p class="text-lg text-gray-600">
                    <?= t('assessment.complete.thankYou');?>
                </p>
            </div>
            <div class="space-y-4">
                <button id="get_report"
                    class="w-full py-4 px-6 text-white rounded-lg font-semibold text-lg transition-all duration-200 shadow-lg hover:opacity-90"
                    style="background-color: rgb(12, 83, 149)"
                >
                    <?= t('assessment.complete.getYourReport');?></button
                ><button id="back_to_top"
                    class="w-full py-4 px-6 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold text-lg transition-all duration-200 hover:bg-gray-50 hover:border-gray-400"
                >
                    <?= t('assessment.complete.backToTop')?></button
                ><button id="book_consultation"
                    class="w-full py-4 px-6 border-2 rounded-lg font-semibold text-lg transition-all duration-200 hover:opacity-90"
                    style="border-color: rgb(12, 83, 149); color: rgb(12, 83, 149); background-color: transparent"
                >
                    <?= t('assessment.complete.bookConsultation');?>
                </button>
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
<script>
document.getElementById("get_report")?.addEventListener("click", function () {

    const payload = <?= $payloadJson ?>;
    // console.log("REQUEST PAYLOAD:", payload);

    fetch("https://gotomarketfrontend.rewainfotech.com/api/generate-gtm-pdf.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload)
    })
    .then(async res => {
        const data = await res.json(); // 👈 read response body

        if (!res.ok) {
            console.error("API ERROR RESPONSE:", data);
            throw new Error(data.message || "Request failed");
        }

        console.log("API SUCCESS RESPONSE:", data); // 👈 PRINT RESPONSE
        return data;
    })
    .then(data => {
        // optional redirect
        window.location.href = "<?= BASE_URL ?>/en/gtm-assessment?step=success";
    })
    .catch(err => {
        console.error("FETCH ERROR:", err);
        alert("Something went wrong. Please try again.");
    });
});


document.getElementById("back_to_top")?.addEventListener("click", () => {
    window.location.href = "/";
});

document.getElementById("book_consultation")?.addEventListener("click", () => {
    window.open("https://timerex.net/s/contact_7539_31e1/4233e744/", "_blank");
});
</script>
