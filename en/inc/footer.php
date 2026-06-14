        <footer class="bg-footerBlue" id="site-footer">
            <div class="text-lightGray lg:text-base flex max-lg:flex-col sm:justify-between items-center w-[95%] max-w-7xl mx-auto py-8 sm:py-[62px] gap-6">
                <p class="font-normal text-center sm:text-left max-lg:order-2 text-[12px]">© GTM consulting service <span><?= date('Y');?></span> | All Rights Reserved</p>
                <div class="flex gap-5 order-1 text-[14px]"><a href="/en/privacy-policy/" class="hover:underline">Privacy</a> <a href="/en/terms/" class="hover:underline">Terms & Conditions</a> <a href="/en/sitemap/" class="hover:underline">Sitemap</a></div>
            </div>
        </footer>
    </div>
    <script>
        function clearAssessmentStorage() {
            try {
                // Force clear localStorage keys repeatedly to ensure they are gone
                const keysToClear = ["assessment_answers", "selected_challenges", "assessment_step"];

                keysToClear.forEach(key => {
                    localStorage.removeItem(key);
                });

                // Clear all sessionStorage
                sessionStorage.clear();

                // Optional: temporarily override setItem to prevent other scripts from restoring keys
                const originalSetItem = localStorage.setItem;
                localStorage.setItem = function(key, value) {
                    if(keysToClear.includes(key)) return; // ignore writes to cleared keys
                    originalSetItem.apply(this, arguments);
                };

                // Call backend to clear PHP session variables
                fetch("/api/ajax/clear-session.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ action: "clear_assessment" })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.status) {
                        console.log("Session cleared successfully");
                        // Optional redirect after clear
                        // window.location.href = '/gtm-assessment.php';
                    }
                })
                .catch(err => console.error("Error clearing session:", err));

            } catch (e) {
                console.error("Error clearing storage:", e);
            }
        }
    </script>
</body>

</html>
