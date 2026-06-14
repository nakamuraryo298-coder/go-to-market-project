<?php 
include '../inc/session.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$isReturningFromQuestions = ($_GET['from'] ?? '') === 'questions';
$formData = $_SESSION['form_data'] ?? [];

function registerOldValue(array $formData, string $key): string {
    return htmlspecialchars((string)($formData[$key] ?? ''), ENT_QUOTES, 'UTF-8');
}

function registerSelected(array $formData, string $key, string $value): string {
    return (($formData[$key] ?? '') === $value) ? ' selected' : '';
}
?>
<?php include 'inc/head.php'; ?>
<?php include 'inc/header.php'; ?>
<script src="https://cdn.tailwindcss.com"></script>
<section class="bg-lightBlue py-9 sm:py-16 md:py-20 lg:py-24" id="strategies">
    <div class="max-w-2xl mx-auto my-12 px-4 sm:px-6 lg:px-8 py-8 bg-white rounded-lg shadow-md col-8 registrationDiv">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-blueBrand mb-2">User Registration</h1>
            <p class="text-grayText">Please complete your registration to access the GTM Assessment.</p>
        </div>
        <form id="registerForm" class="space-y-6" onsubmit="return false">
            <input type="hidden" name="lang" value="en" id="lang" />
            <input type="hidden" name="resumeAssessment" value="<?= $isReturningFromQuestions ? '1' : '0'; ?>" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="firstName">First Name <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        id="firstName"
                        class="w-full px-3 py-2 rounded-md bg-sky-50 focus:ring-0 focus:outline-none focus:ring-0 focus:outline-none border-gray-300"
                        name="firstName"
                        placeholder="Please enter your first name"
                        value="<?= registerOldValue($formData, 'firstName'); ?>"
                        style="--tw-ring-color: #0c5395"
                    />
                    <p class="mt-1 ml-3 text-xs text-red-600" data-error="firstName"></p>
                </div>
                <div>
                    <label for="lastName">Last Name <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        id="lastName"
                        class="w-full px-3 py-2 rounded-md bg-sky-50 focus:ring-0 focus:outline-none focus:ring-0 focus:outline-none border-gray-300"
                        name="lastName"
                        placeholder="Please enter your surname"
                        value="<?= registerOldValue($formData, 'lastName'); ?>"
                        style="--tw-ring-color: #0c5395"
                    />
                    <p class="mt-1 ml-3 text-xs text-red-600" data-error="lastName"></p>
                </div>
            </div>
            <div>
                <label for="email">Company Email <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    id="email"
                    class="w-full px-3 py-2 rounded-md bg-sky-50 focus:ring-0 focus:outline-none focus:ring-0 focus:outline-none border-gray-300"
                    name="email"
                    placeholder="Please enter your company email"
                    value="<?= registerOldValue($formData, 'email'); ?>"
                    style="--tw-ring-color: #0c5395"
                />
                <p class="mt-1 ml-3 text-xs text-gray-500">
                    Personal email addresses (Gmail, Yahoo, etc.) are not allowed.
                </p>
                <p class="mt-1 ml-3 text-xs text-red-600" data-error="email"></p>
            </div>
            <div>
                <label for="company">Company Name <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    id="company"
                    class="w-full px-3 py-2 rounded-md bg-sky-50 focus:ring-0 focus:outline-none focus:ring-0 focus:outline-none focus:ring-0 focus:outline-none"
                    placeholder="Please enter your company name"
                    name="company"
                    value="<?= registerOldValue($formData, 'company'); ?>"
                />
                <p class="mt-1 ml-3 text-xs text-red-600" data-error="company"></p>
            </div>
            <div>
                <label for="revenueRange">Revenue <span class="text-red-500">*</span></label>
                <select
                    id="revenueRange"
                    class="w-full px-3 py-2 rounded-md text-slate-400 bg-sky-50 focus:ring-0 focus:outline-none focus:ring-0 focus:outline-none border-gray-300"
                    style="--tw-ring-color: #0c5395"
                    name="revenueRange"
                >
                    <option value="" class="border-none">Select revenue range</option>
                    <?php foreach(revenueOptions('en') as $value =>$label){?>
                    <option value="<?= $value;?>"<?= registerSelected($formData, 'revenueRange', $value); ?>><?= $label;?></option>
                    <?php } ?>
                </select>
                <p class="mt-1 ml-3 text-xs text-red-600" data-error="revenueRange"></p>
            </div>
            <div>
                <label for="jobTitle">Job Title <span class="text-red-500">*</span></label>
                <select
                    id="jobTitle"
                    class="w-full px-3 py-2 rounded-md text-slate-400 bg-sky-50 focus:ring-0 focus:outline-none focus:ring-0 focus:outline-none border-gray-300"
                    style="--tw-ring-color: #0c5395"
                    name="jobTitle"
                >
                    <option value="">Select job title</option>
                    <?php foreach(jobTitleOptions('en') as $value =>$label){?>
                    <option value="<?= $value;?>"<?= registerSelected($formData, 'jobTitle', $value); ?>><?= $label;?></option>
                    <?php } ?>
                </select>
                <p class="mt-1 ml-3 text-xs text-red-600" data-error="jobTitle"></p>
            </div>
            <div>
                <label for="department">Department <span class="text-red-500">*</span></label>
                <select
                    id="department"
                    class="w-full px-3 py-2 text-slate-400 rounded-md bg-sky-50 focus:ring-0 focus:outline-none focus:ring-0 focus:outline-none border-gray-300"
                    name="department"
                    style="--tw-ring-color: #0c5395"
                >
                    <option value="">Select department</option>
                    <?php foreach(departmentOptions('en') as $value =>$label){?>
                    <option value="<?= $value;?>"<?= registerSelected($formData, 'department', $value); ?>><?= $label;?></option>
                    <?php } ?>
                </select>
                <p class="mt-1 ml-3 text-xs text-red-600" data-error="department"></p>
            </div>
            <div class="flex items-start gap-2">
                <div class="relative flex items-center">
                    <input
                        type="checkbox"
                        id="consent"
                        name="consent"
                        class="w-4 h-4 border border-gray-300 rounded-sm focus:ring-2 focus:border-transparent"
                        style="--tw-ring-color: #0c5395"
                        <?= $isReturningFromQuestions ? 'checked' : ''; ?>
                    />
                </div>

                <label for="consent" class="text-sm font-medium text-grayText">
                    I agree to the 
                    <a href="https://go-to-market.jp/en/terms/" target="_blank" rel="noopener noreferrer" class="text-blue-600 underline">Terms & Conditions</a>, 
                    <a href="https://go-to-market.jp/en/privacy-policy/" target="_blank" rel="noopener noreferrer" class="text-blue-600 underline">Privacy Policy</a>
                    <span class="text-red-500">*</span>
                </label>
            </div>
            <p class="mt-1 ml-3 text-xs text-red-600" data-error="consent"></p>
            <div class="flex items-start gap-2">
                <div class="relative flex items-center">
                    <input
                        type="checkbox"
                        id="marketing_consent"
                        name="marketing_consent"
                        class="w-4 h-4 border border-gray-300 rounded-sm focus:ring-2 focus:border-transparent"
                        style="--tw-ring-color: #0c5395"
                        <?= $isReturningFromQuestions ? 'checked' : ''; ?>
                    />
                </div>

                <label for="marketing_consent" class="text-sm font-medium text-grayText">
                    I agree to receive updates and communications from the Go-to-Market Service Office.
                    <span class="text-red-500">*</span>
                </label>
            </div>
            <p class="mt-1 ml-3 text-xs text-red-600" data-error="marketing_consent"></p>
            <div class="pt-6">
                <button
                    type="submit"
                    id="submitBtn"
                    class="w-full py-3 px-4 rounded-lg font-bold text-white bg-green-600"
                >
                    <span id="btnText">Register & Start Assessment</span>
                </button>
            </div>
        </form>
    </div>
    <div
            id="successBox"
            class="max-w-2xl mx-auto my-8 px-4 sm:px-6 lg:px-8 py-8 bg-white rounded-lg shadow-md hidden"
        >
            <div class="text-center">
                <div class="mb-6">
                    <svg
                        class="w-16 h-16 text-green-500 mx-auto mb-4"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>

                <h1 id="successTitle" class="text-2xl font-bold mb-4"></h1>

                <p id="successText" class="mb-6"></p>

                <div
                    class="animate-spin rounded-full h-8 w-8 border-b-2 mx-auto"
                    style="border-bottom-color:#0c5395"
                ></div>
            </div>
        </div>
</section>
<script>
const RETURNING_FROM_QUESTIONS = <?= json_encode($isReturningFromQuestions); ?>;

document.getElementById('registerForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = this;
    const btn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const lang = 'en';

    // Clear errors
    document.querySelectorAll('[data-error]').forEach(el => el.textContent = '');

    // Loading state
    btn.disabled = true;
    btnText.textContent = 'Registering...';

    fetch('<?= BASE_URL;?>/api/validation.php', {
        method: 'POST',
        body: new FormData(form)
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) {
            // Restore button
            btn.disabled = false;
            btnText.textContent = 'Register & Start Assessment';

            for (const field in data.errors) {
                const errorEl = document.querySelector(`[data-error="${field}"]`);
                if (errorEl) errorEl.textContent = data.errors[field];
            }
            return;
        }

        // ✅ SUCCESS
        form.classList.add('hidden');

        document.querySelector('.registrationDiv')?.classList.add('hidden');
        document.getElementById('successBox').classList.remove('hidden');

        document.getElementById('successTitle').textContent = 'Registration Successful!';

        document.getElementById('successText').textContent = 'Thank you for registering. You will be redirected to the GTM Assessment shortly.';

        // Redirect after 5 seconds
        // setTimeout(() => {
            
        // }, 3000);
        window.location.href = RETURNING_FROM_QUESTIONS ? `<?= BASE_URL;?>/en/gtm-assessment?from=register` : `<?= BASE_URL;?>/en/gtm-assessment`;
    })
    .catch(() => {
        btn.disabled = false;
        btnText.textContent = 'Register & Start Assessment';
        alert('Something went wrong. Please try again.');
    });
});
document.querySelectorAll('#registerForm input, #registerForm select').forEach(field => {
    field.addEventListener('input', () => {
        const errorEl = document.querySelector(`[data-error="${field.name}"]`);
        if (errorEl) errorEl.textContent = '';
    });

    field.addEventListener('change', () => {
        const errorEl = document.querySelector(`[data-error="${field.name}"]`);
        if (errorEl) errorEl.textContent = '';
    });
});

function updateSelectTextColor(selectEl) {
    if (!(selectEl instanceof HTMLSelectElement)) return;

    if (selectEl.value && selectEl.value.trim() !== '') {
        selectEl.classList.remove('text-slate-400');
        selectEl.classList.add('text-black');
        return;
    }

    selectEl.classList.remove('text-black');
    selectEl.classList.add('text-slate-400');
}

document.querySelectorAll('#registerForm select').forEach(selectEl => {
    updateSelectTextColor(selectEl);
    selectEl.addEventListener('change', () => updateSelectTextColor(selectEl));
});
</script>


<?php include 'inc/footer.php'; ?>
