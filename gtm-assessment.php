<?php include 'inc/session.php'; 
$_SESSION['lang'] = 'ja';
if (
    !isset($_SESSION['form_data']) || 
    empty($_SESSION['form_data']) ||
    !is_array($_SESSION['form_data'])
) {
    header("Location: /register"); 
    exit;
}
?>

<!doctype html>
<html lang="ja" class="scroll-smooth">

<?php include 'inc/head.php'; ?>
<?php include 'inc/header.php'; ?>

<?php

$language = 'ja';
$currentStep = $_GET['step'] ?? 'questions'; 
$fromStep = $_GET['from'] ?? '';

if($currentStep === 'questions' && !in_array($fromStep, ['challenges', 'register'], true)):
    $_SESSION['current_question'] = 0;
    $_SESSION['answers'] = [];
    $_SESSION['selected_challenges'] = [];
    $_SESSION['last_question'] = 0;
 
endif;

$error = $_SESSION['error'] ?? '';
$successMessage = $_SESSION['success'] ?? '';

/* Labels */
$steps = [
    ['key' => 'questions',  'label' => '質問'],
    ['key' => 'challenges', 'label' => '課題'],
    ['key' => 'complete',   'label' => '完了'],
    ['key' => 'success',    'label' => '成功'],
];

/* Step index helper */
$stepIndex = [
    'questions'  => 0,
    'challenges' => 1,
    'complete'   => 2,
    'success'    => 3,
];

?>
<script src="https://cdn.tailwindcss.com"></script>
<section class="bg-lightBlue py-7 sm:py-16 md:py-20 lg:py-24" id="strategies">
    <div class="max-w-7xl min-h-[calc(100vh-120px)] mx-auto my-10 px-4 lg:px-8 py-8 bg-skyBlueBg max-lg:py-16">

        <!-- Error Message -->
        <?php if (!empty($error)) { ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <span class="text-red-800"><?= htmlspecialchars($error) ?></span>
                </div>
            </div>
        <?php } ?>

        <!-- Success Message -->
        <?php if (!empty($successMessage)) { ?>
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <span class="text-green-800"><?= htmlspecialchars($successMessage) ?></span>
                </div>
            </div>
        <?php } ?>

        <!-- Step Indicator -->
        <div class="mb-4 sm:mb-8" id="step-form">
            <div class="flex items-center justify-center gap-1 sm:gap-2 lg:gap-3 overflow-x-auto pb-2 pt-4 sm:pt-0">

                <?php foreach ($steps as $index => $step) { 
                    $currentIndex = $stepIndex[$currentStep];
                    $isActive = $currentStep === $step['key'];
                    $isCompleted = $index < $currentIndex;

                    if ($isActive) {
                        $circleClass = "bg-blueBrand text-white";
                    } elseif ($isCompleted) {
                        $circleClass = "bg-greenBg text-white";
                    } else {
                        $circleClass = "bg-white text-grayText";
                    }
                ?>
                <div class="flex items-center flex-shrink-0">

                    <div class="flex flex-col items-center">
                        <div class="mb-1 text-center text-[12px] leading-none font-medium text-grayText whitespace-nowrap sm:hidden">
                            <?= $step['label'] ?>
                        </div>

                        <!-- Circle -->
                        <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full <?= $circleClass ?>">
                            <span class="text-xs sm:text-sm font-medium">
                                <?= $index + 1 ?>
                            </span>
                        </div>
                    </div>

                    <!-- Label -->
                    <div class="ml-1.5 sm:ml-2 lg:ml-3 hidden sm:block">
                        <div class="text-xs sm:text-sm font-medium text-grayText whitespace-nowrap">
                            <?= $step['label'] ?>
                        </div>
                    </div>

                    <!-- Line -->
                    <?php if ($index < 3) { 
                        $lineClass = ($index < $currentIndex) ? 'bg-greenBg' : 'bg-gray-300';
                    ?>
                        <div class="ml-2 sm:ml-3 lg:ml-4 w-8 sm:w-10 lg:w-14 h-0.5 flex-shrink-0 <?= $lineClass ?>"></div>
                    <?php } ?>

                </div>
                <?php } ?>
            </div>

            <!-- STEP CONTENT -->
            <div>

            <?php
            switch ($currentStep) {

                case 'questions':
                    include 'steps/questions.php';
                    break;

                case 'challenges':
                    include 'steps/challenges.php';
                    break;

                case 'complete':
                    include 'steps/complete.php';
                    break;

                case 'success':
                    include 'steps/success.php';
                    break;
            }
            ?>

            </div>

            <script>
            document.addEventListener("DOMContentLoaded", function () {
                const currentStep = <?= json_encode($currentStep, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
                const trackingLanguage = 'ja';

                function trackAssessmentEvent(eventName, params = {}) {
                    if (typeof window.gtag !== 'function') return;
                    window.gtag('event', eventName, Object.assign({
                        event_category: 'assessment',
                        language: trackingLanguage
                    }, params));
                }

                if (currentStep === 'complete') {
                    trackAssessmentEvent('assessment_completion_reached', { step: 'complete' });
                } else if (currentStep === 'success') {
                    trackAssessmentEvent('assessment_success_view', { step: 'success' });
                }

                const consultationButton = document.getElementById('book_consultation');
                if (consultationButton) {
                    consultationButton.addEventListener('click', function () {
                        trackAssessmentEvent('assessment_free_consult_click', { step: currentStep });
                    });
                }
            });
            </script>
        </div>

    </div>

</section>
<?php include 'inc/footer.php'; ?>
