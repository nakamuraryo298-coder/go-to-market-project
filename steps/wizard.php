<?php
// session_start();

$language = $_SESSION['lang'] ?? ($_GET['lang'] ?? 'en');
$_SESSION['lang'] = $language;


?>
<?php
/* Values coming from controller / session */
$language = $_GET['lang'] ?? ($_SESSION['form_data']['lang'] ?? 'ja');
$currentStep = $_GET['step'] ?? 'questions'; // questions | challenges | complete | success

$error = $_SESSION['error'] ?? '';
$successMessage = $_SESSION['success'] ?? '';

/* Labels */
$steps = [
    ['key' => 'questions',  'label' => $language === 'en' ? 'Questions'  : '質問'],
    ['key' => 'challenges', 'label' => $language === 'en' ? 'Challenges' : '課題'],
    ['key' => 'complete',   'label' => $language === 'en' ? 'Complete'   : '完了'],
    ['key' => 'success',    'label' => $language === 'en' ? 'Success'    : '成功'],
];

/* Step index helper */
$stepIndex = [
    'questions'  => 0,
    'challenges' => 1,
    'complete'   => 2,
    'success'    => 3,
];
?>
<body class="bg-slate-100">

<!-- STEP INDICATOR -->
<div class="max-w-4xl mx-auto mt-6 mb-10 flex justify-center gap-4">

    <div class="flex items-center justify-center gap-1 sm:gap-2 lg:gap-3 overflow-x-auto pb-2">

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

            <!-- Circle -->
            <div class="step-circle flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full <?= $circleClass ?>">
                <span class="text-xs sm:text-sm font-medium">
                    <?= $index + 1 ?>
                </span>
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
                <div class="step-line ml-2 sm:ml-3 lg:ml-4 w-8 sm:w-10 lg:w-14 h-0.5 flex-shrink-0 <?= $lineClass ?>"></div>
            <?php } ?>

        </div>
        <?php } ?>
    </div>

</div>

<!-- WIZARD -->
<div id="wizard">

    <!-- STEP 1 -->
    <div class="step" data-step="questions">
        <?php include 'steps/questions.php'; ?>
    </div>

    <!-- STEP 2 -->
    <div class="step hidden" data-step="challenges">
        <?php include 'steps/challenges.php'; ?>
    </div>

    <!-- STEP 3 -->
    <div class="step hidden" data-step="complete">
        <?php include 'steps/complete.php'; ?>
    </div>

    <!-- STEP 4 -->
    <div class="step hidden" data-step="success">
        <?php include 'steps/success.php'; ?>
    </div>

</div>

<script>
let currentStep = 'questions';

function showStep(step){

    document.querySelectorAll('.step').forEach(el=>{
        el.classList.add('hidden');
    });

    document.querySelector(`.step[data-step="${step}"]`).classList.remove('hidden');

    const order = ['questions','challenges','complete','success'];
    const idx = order.indexOf(step);

    document.querySelectorAll('.step-circle').forEach((c,i)=>{
        if(i < idx){
            c.className = 'step-circle flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-greenBg text-white';
        }else if(i === idx){
            c.className = 'step-circle flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blueBrand text-white';
        }else{
            c.className = 'step-circle flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-white text-grayText';
        }
    });

    document.querySelectorAll('.step-line').forEach((line, i) => {
        line.className = `step-line ml-2 sm:ml-3 lg:ml-4 w-8 sm:w-10 lg:w-14 h-0.5 flex-shrink-0 ${i < idx ? 'bg-greenBg' : 'bg-gray-300'}`;
    });

    currentStep = step;
}

showStep(<?= json_encode($currentStep, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>);
</script>

</body>
</html>
