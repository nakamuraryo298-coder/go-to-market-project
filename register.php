<?php 
include 'inc/session.php';

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
            <h1 class="text-3xl font-bold text-blueBrand mb-2">ユーザー登録</h1>
            <p class="text-grayText">GTMアセスメントにアクセスするには、登録を完了してください。</p>
        </div>
        <form id="registerForm" class="space-y-6" onsubmit="return false">
            <input type="hidden" name="lang" value="ja" id="lang" />
            <input type="hidden" name="resumeAssessment" value="<?= $isReturningFromQuestions ? '1' : '0'; ?>" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="lastName">姓 <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        id="lastName"
                        class="w-full px-3 py-2 rounded-md bg-sky-50 focus:ring-0 focus:outline-none focus:ring-0 focus:outline-none border-gray-300"
                        name="lastName"
                        placeholder="姓を入力してください"
                        value="<?= registerOldValue($formData, 'lastName'); ?>"
                        style="--tw-ring-color: #0c5395"
                    />
                    <p class="mt-1 ml-3 text-xs text-red-600" data-error="lastName"></p>
                </div>
                <div>
                    <label for="firstName">名 <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        id="firstName"
                        class="w-full px-3 py-2 rounded-md bg-sky-50 focus:ring-0 focus:outline-none focus:ring-0 focus:outline-none border-gray-300"
                        name="firstName"
                        placeholder="名を入力してください"
                        value="<?= registerOldValue($formData, 'firstName'); ?>"
                        style="--tw-ring-color: #0c5395"
                    />
                    <p class="mt-1 ml-3 text-xs text-red-600" data-error="firstName"></p>
                </div>
            </div>
            <div>
                <label for="email">会社メールアドレス <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    id="email"
                    class="w-full px-3 py-2 rounded-md bg-sky-50 focus:ring-0 focus:outline-none focus:ring-0 focus:outline-none border-gray-300"
                    name="email"
                    placeholder="会社のメールアドレスを入力してください"
                    value="<?= registerOldValue($formData, 'email'); ?>"
                    style="--tw-ring-color: #0c5395"
                />
                <p class="mt-1 ml-3 text-xs text-gray-500">
                    個人のメールアドレス（Gmail、Yahooなど）は使用できません。
                </p>
                <p class="mt-1 ml-3 text-xs text-red-600" data-error="email"></p>
            </div>
            <div>
                <label for="company">会社名 <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    id="company"
                    class="w-full px-3 py-2 rounded-md bg-sky-50 focus:ring-0 focus:outline-none focus:ring-0 focus:outline-none focus:ring-0 focus:outline-none"
                    placeholder="会社名を入力してください"
                    name="company"
                    value="<?= registerOldValue($formData, 'company'); ?>"
                />
                <p class="mt-1 ml-3 text-xs text-red-600" data-error="company"></p>
            </div>
            <div>
                <label for="revenueRange">収益 <span class="text-red-500">*</span></label>
                <select
                    id="revenueRange"
                    class="w-full px-3 py-2 rounded-md text-slate-400 bg-sky-50 focus:ring-0 focus:outline-none focus:ring-0 focus:outline-none border-gray-300"
                    style="--tw-ring-color: #0c5395"
                    name="revenueRange"
                >
                    <option value="" class="border-none">収益範囲を選択してください</option>
                    <?php foreach(revenueOptions('ja') as $value =>$label){?>
                    <option value="<?= $value;?>"<?= registerSelected($formData, 'revenueRange', $value); ?>><?= $label;?></option>
                    <?php } ?>
                </select>
                <p class="mt-1 ml-3 text-xs text-red-600" data-error="revenueRange"></p>
            </div>
            <div>
                <label for="jobTitle">役職 <span class="text-red-500">*</span></label>
                <select
                    id="jobTitle"
                    class="w-full px-3 py-2 rounded-md text-slate-400 bg-sky-50 focus:ring-0 focus:outline-none focus:ring-0 focus:outline-none border-gray-300"
                    style="--tw-ring-color: #0c5395"
                    name="jobTitle"
                >
                    <option value="">役職を選択してください</option>
                    <?php foreach(jobTitleOptions('ja') as $value =>$label){?>
                    <option value="<?= $value;?>"<?= registerSelected($formData, 'jobTitle', $value); ?>><?= $label;?></option>
                    <?php } ?>
                </select>
                <p class="mt-1 ml-3 text-xs text-red-600" data-error="jobTitle"></p>
            </div>
            <div>
                <label for="department">部門 <span class="text-red-500">*</span></label>
                <select
                    id="department"
                    class="w-full px-3 py-2 text-slate-400 rounded-md bg-sky-50 focus:ring-0 focus:outline-none focus:ring-0 focus:outline-none border-gray-300"
                    name="department"
                    style="--tw-ring-color: #0c5395"
                >
                    <option value="">部署を選択してください</option>
                    <?php foreach(departmentOptions('ja') as $value =>$label){?>
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
                    <a href="https://go-to-market.jp/terms/" target="_blank" rel="noopener noreferrer" class="text-blue-600 underline">利用規約</a>と
                    <a href="https://go-to-market.jp/privacy-policy/" target="_blank" rel="noopener noreferrer" class="text-blue-600 underline">プライバシーポリシー</a>に同意します
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
                    Go-to-Marketサービス事務局からの最新情報やご案内を受け取ることに同意します。
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
                    <span id="btnText">登録して診断に進む</span>
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
    const lang = 'ja';

    // Clear errors
    document.querySelectorAll('[data-error]').forEach(el => el.textContent = '');

    // Loading state
    btn.disabled = true;
    btnText.textContent = '登録中...';

    fetch('api/validation.php', {
        method: 'POST',
        body: new FormData(form)
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) {
            // Restore button
            btn.disabled = false;
            btnText.textContent = '登録して診断に進む';

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

        document.getElementById('successTitle').textContent = '登録完了！';

        document.getElementById('successText').textContent ='ご登録ありがとうございます。まもなくGTMアセスメントにリダイレクトされます。';

        // Redirect after 5 seconds
        // setTimeout(() => {
        //     window.location.href = `gtm-assessment`;
        // }, 3000);
        window.location.href = RETURNING_FROM_QUESTIONS ? `gtm-assessment?from=register` : `gtm-assessment`;
    })
    .catch(() => {
        btn.disabled = false;
        btnText.textContent = '登録して診断に進む';
        alert('問題が発生しました。もう一度お試しください。');
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
