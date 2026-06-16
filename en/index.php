<?php include '../inc/session.php'; ?>
<?php $isHomeV2 = true; // light split-hero redesign: scopes the light header treatment to the homepage ?>
<!doctype html>
<html lang="en" class="scroll-smooth">


<?php include 'inc/head.php'; ?>
<?php include 'inc/header.php'; ?>
<?php 
$_SESSION['lang'] = 'en';
$redirectUrl = BASE_URL . '/en/register';


if (!empty($_SESSION['form_data'])) {
    $lang = $_SESSION['form_data']['lang'] ?? 'en';
    $redirectUrl = BASE_URL . '/en/gtm-assessment';
}
?>
            <!-- ===== Top view slider: slide 1 = redesign (Figma 案02_ver02), slides 2-3 = existing ===== -->
            <div class="w-full relative z-0">
                <div class="swiper default-carousel swiper-container">
                    <div class="swiper-wrapper">
                        <!-- Slide 1: new top view -->
                        <div class="swiper-slide">
                <section class="hero-v2">
                    <div class="hero-v2__board">
                        <img class="hl hl--blob-main"   src="<?= asset('assets/images/hero/blob-main.png'); ?>"   alt="" aria-hidden="true">
                        <img class="hl hl--blob-sp"     src="<?= asset('assets/images/hero/blob-main-sp.png'); ?>" alt="" aria-hidden="true">
                        <img class="hl hl--blob-left"   src="<?= asset('assets/images/hero/blob-left.png'); ?>"   alt="" aria-hidden="true">
                        <img class="hl hl--circle-3"    src="<?= asset('assets/images/hero/circle-3.png'); ?>"    alt="" aria-hidden="true">
                        <img class="hl hl--circle-1"    src="<?= asset('assets/images/hero/circle-1.png'); ?>"    alt="" aria-hidden="true">
                        <img class="hl hl--circle-2"    src="<?= asset('assets/images/hero/circle-2.png'); ?>"    alt="" aria-hidden="true">
                        <img class="hl hl--circle-solid" src="<?= asset('assets/images/hero/circle-solid.png'); ?>" alt="" aria-hidden="true">
                        <img class="hl hl--icon-network" src="<?= asset('assets/images/hero/icon-network.png'); ?>" alt="" aria-hidden="true">
                        <img class="hl hl--icon-coins"  src="<?= asset('assets/images/hero/icon-coins.png'); ?>"  alt="" aria-hidden="true">
                        <img class="hl hl--icon-chart"  src="<?= asset('assets/images/hero/icon-chart.png'); ?>"  alt="" aria-hidden="true">
                        <img class="hl hl--laptop"      src="<?= asset('assets/images/hero/laptop-en.png'); ?>"   alt="Sample of the GTM Maturity Assessment report" fetchpriority="high">
                        <img class="hl hl--report-page" src="<?= asset('assets/images/hero/report-page-en.png'); ?>" alt="" aria-hidden="true">
                        <img class="hl hl--character"   src="<?= asset('assets/images/hero/character.png'); ?>"   alt="" aria-hidden="true">
                        <div class="hl hero-callout-en">Here&rsquo;s a sneak peek at part of the<br>report you&rsquo;ll actually receive!</div>
                    </div>
                    <div class="hero-v2__inner">
                        <div class="hero-v2__copy">
                            <h1 class="hero-v2__title">
                                Identify gaps in your<br>
                                <span class="hero-v2__quote">&ldquo;GTM strategy&rdquo;</span><br>
                                in <span class="hero-v2__accent">just 3 minutes.</span>
                            </h1>
                            <p class="hero-v2__lead">
                                Get a practical report <br>highlighting improvement opportunities <br>across market strategy, sales, and marketing.
                            </p>
                            <a href="#free" class="hero-v2__cta hero-v2__cta--en">
                                <span>START FREE ASSESSMENT<small>(TAKES ABOUT 3 MINUTE)</small></span>
                                <svg class="hero-v2__cta-arrow" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                        </div>
                    </div>
                    <!-- mobile-only CTA: shown after the images (text → images → CTA) -->
                    <a href="#free" class="hero-v2__cta hero-v2__cta--en hero-v2__cta--sp">
                        <span>START FREE ASSESSMENT<small>(TAKES ABOUT 3 MINUTE)</small></span>
                        <svg class="hero-v2__cta-arrow" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </section>
                        </div>
                        <!-- Slide 2: existing top view -->
                        <div class="swiper-slide">
                            <div class="bg-banner-01 lg-bg-banner-01 bg-cover bg-no-repeat bg-center mx-auto md:w-full px-4 sm:py-4 max-md:py-[30px] lg:pb-[40px] h-[90vh] max-h-[1024px] lg:min-h-[780px] flex flex-col">
                                <div class="flex flex-1 items-end max-lg:justify-center pb-8 max-lg:text-center lg:text-left lg:justify-start w-full max-w-[1280px] mx-auto lg:px-8">
                                    <div class="w-full text-white">
                                        <h1 class="text-[30px] md:text-[54px] pb-2 mx-auto lg:mx-0 md:w-full leading-tight text-shadow-lg">Are You Confident in Your<br><span class="text-skyBlue w-2 lg:text-blueText font-bold">GTM Strategy?</span></h1>
                                        <h2 class="text-[16px] md:text-[21px] pt-2 mb-[16px] lg:pb-6 lg:py-4">Go-to-Market strategy starts with building repeatable revenue growth.<br>Let’s define what to sell, to whom, and how to win.</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 3: existing top view -->
                        <div class="swiper-slide">
                            <div class="bg-banner-03  lg-bg-banner-03 bg-cover bg-no-repeat bg-center mx-auto md:w-full px-4 sm:py-4 max-md:py-[30px] lg:pb-[40px] h-[90vh] max-h-[1024px] lg:min-h-[780px] flex flex-col">
                                <div class="flex flex-1 items-end max-lg:justify-center pb-8 max-lg:text-center lg:text-left lg:justify-start w-full max-w-[1280px] mx-auto lg:px-8">
                                    <div class="w-full text-white">
                                        <h1 class="text-[30px] md:text-[54px] pb-2 mx-auto lg:mx-0 md:w-full leading-tight text-shadow-lg">Unlock Your GTM Advantage<br><span class="text-skyBlue w-2 lg:text-blueText font-bold">Select Your Intro Offer</span></h1>
                                        <h2 class="text-[16px] md:text-[21px] pt-2 lg:pb-2 lg:py-4">Select one of the following:<br>• 50% off your first two months<br>• One-month GTM strategy & action-plan review at a special rate</h2>
                                        <p>Perfect for teams who want to start small and see results before scaling.</p>
                                        <p class="text-[14px] mt-2 lg:mt-0">※Offer valid through February 2026.</p><a href="https://go-to-market.jp/en/#contact" class="bg-[#e45b11] hover:bg-orange-600 h-auto inline-block md:w-[320px] lg:w-md px-10 py-4 font-bold my-[20px] mt-3 text-white text-center rounded uppercase">Book a free consultation</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination max-w-[1280px] lg:absolute lg:right-0 m-auto lg:flex lg:gap-1.5 px-11 mb-4"></div>
                </div>
            </div>
        </div>
        <section class="bg-lightBlue py-7 sm:py-16 md:py-20 lg:py-24" id="strategies">
            <div class="w-[95%] sm:w-[85%] lg:w-[82%] max-w-7xl mx-auto px-4">
                <h1 class="relative text-center uppercase text-2xl md:text-3xl lg:text-[39px] py-6 lg:py-9 after:content-[''] after:block after:w-20 sm:after:w-28 lg:after:w-36 after:h-[2px] after:bg-blueBrand after:mx-auto after:mt-4 lg:after:mt-8">What Is a <span class="font-semibold text-blueBrand">Go-to-Market Strategy?</span></h1>
                <div class="lg:flex justify-center gap-7 py-6">
                    <div class="lg:w-[50%]">
                        <h2 class="lg:text-center text-blueBrand uppercase text-lg mb-3">According to a recent study by dervix(2025):</h2><img src="../assets/images/strategy.webp" loading="lazy" alt="Graph" class="w-[650px] mx-auto max-w-full h-auto">
                        <p class="text-center mx-auto pt-8 pb-4 text-[14px]">Source: “25 Statistics to Influence Your 2025 GTM Plan” by Devrix</p>
                    </div>
                    <div class="flex flex-col justify-center text-center lg:text-left leading-tight" id="freeassessment">
                        <h1 class="font-bold text-darkBlue tracking-tighter text-[102px] md:text-[162px]">84.6%</h1>
                        <h2 class="text-[20px] md:text-[27px] font-poppins text-gray mx-auto lg:mx-0 w-5/6 md:w-sm pl-4 max-lg:text-center lg:text-left">of U.S. companies have already defined a Go-to-Market (GTM) strategy</h2>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-white py-7 sm:py-16 md:py-20 lg:py-24 max-w-7xl w-[90%] lg:w-[82%] mx-auto lg:pb-36">
            <h1 class="relative text-center uppercase text-2xl md:text-[39px] py-9 after:content-[''] after:block after:w-20 lg:after:w-36 after:h-[2px] after:bg-blueBrand after:mx-auto after:mt-4 lg:after:mt-8">common <span class="font-semibold text-blueBrand">business challenges</span></h1>
            <div class="max-lg:hidden lg:block">
                <div class="mx-auto grid grid-cols-2 sm:grid-cols-1 grid-rows-3 sm:grid-rows-6">
                    <div class="flex flex-col items-start text-left pr-7 pl-0 xl:pl-7 py-11 border-b border-r border-blueBrand space-y-2"><img src="../assets/images/icon1.webp" alt="Customer support" class="size-14 ml-7.5 xl:ml-10 mb-3">
                        <h2 class="text-blueBrand uppercase font-bold text-2xl xl:text-[28px] mb-[15px] flex items-start"><span class="w-4 aspect-square border-2 border-blueBrand bg-white rounded-full inline-block mt-1.5 mr-2 mt-2.5 md:mr-4"></span> Understand the market and customer</h2>
                        <div class="leading-snug ml-7 text-black text-[16px] xl:text-[20px]">
                            <p class="font-semibold">Weak understanding of market & positioning</p>
                            <p>Targeting based on internal assumptions</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-start text-left pr-0 xl:pr-7 pl-7 py-11 border-b border-blueBrand space-y-2"><img src="../assets/images/icon2.webp" alt="Messages" class="size-14 ml-7.5 xl:ml-10 mb-3">
                        <h2 class="text-blueBrand uppercase font-bold text-2xl xl:text-[28px] mb-[15px] flex items-start"><span class="w-2 lg:w-4 aspect-square border-2 border-blueBrand bg-white rounded-full inline-block mt-1.5 mr-2 mt-2.5 md:mr-4"></span> Define differentiation and messaging</h2>
                        <div class="leading-snug ml-7 text-black text-[16px] xl:text-[20px]">
                            <p class="font-semibold">Poor differentiation leads to price battles</p>
                            <p>No lasting impression of unique strengths</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-start text-left pr-7 pl-0 xl:pl-7 py-11 border-b lg:border-r border-blueBrand space-y-2"><img src="../assets/images/icon3.webp" alt="Targeting" class="size-14 ml-7.5 xl:ml-10 mb-3">
                        <h2 class="text-blueBrand uppercase font-bold text-2xl xl:text-[28px] mb-[15px] flex items-start"><span class="w-2 lg:w-4 aspect-square border-2 border-blueBrand bg-white rounded-full inline-block mt-1.5 mr-2 lg:mt-2.5 md:mr-4"></span> Clarify targeting and positioning</h2>
                        <div class="leading-snug ml-7 text-black text-[16px] xl:text-[20px]">
                            <p class="font-semibold">Lack of focus spreads resources thin</p>
                            <p>No clear path to win based on strengths</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-start text-left pr-0 xl:pr-7 pl-7 py-11 border-b border-blueBrand space-y-2"><img src="../assets/images/icon4.webp" alt="Channels" class="size-14 ml-7.5 xl:ml-10 mb-3">
                        <h2 class="text-blueBrand uppercase font-bold text-2xl xl:text-[28px] mb-[15px] flex items-start"><span class="w-2 lg:w-4 aspect-square border-2 border-blueBrand bg-white rounded-full inline-block mt-1.5 mr-2 lg:mt-2.5 md:mr-4"></span> Structure Sales Channels & GTM Process</h2>
                        <div class="leading-snug ml-7 text-black text-[16px] xl:text-[20px]">
                            <p class="font-semibold">Sales and marketing are out of sync</p>
                            <p>Sales depends on individuals, not process</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-start text-left pr-7 pl-0 xl:pl-7 py-11 max-lg:border-b lg:border-r border-blueBrand space-y-2"><img src="../assets/images/icon5.webp" alt="value proposition" class="size-14 ml-7.5 xl:ml-10 mb-3">
                        <h2 class="text-blueBrand uppercase font-bold text-2xl xl:text-[28px] mb-[15px] flex items-start"><span class="w-2 lg:w-4 aspect-square border-2 border-blueBrand bg-white rounded-full inline-block mt-1.5 mr-2 lg:mt-2.5 md:mr-4"></span> Design the offering & value proposition</h2>
                        <div class="leading-snug ml-7 text-black text-[16px] xl:text-[20px]">
                            <p class="font-semibold">Solutions misaligned with customer needs</p>
                            <p>Messaging fixates on features, not value</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-start text-left pr-0 xl:pr-7 pl-7 py-11 border-blueBrand space-y-2"><img src="../assets/images/icon6.webp" alt="strategic tuning" class="size-14 ml-7.5 xl:ml-10 mb-3">
                        <h2 class="text-blueBrand uppercase font-bold text-2xl xl:text-[28px] mb-[15px] flex items-start"><span class="w-2 lg:w-4 aspect-square border-2 border-blueBrand bg-white rounded-full inline-block mt-1.5 mr-2 lg:mt-2.5 md:mr-4"></span> Execute, measure and optimize</h2>
                        <div class="leading-snug ml-7 text-black text-[16px] xl:text-[20px]">
                            <p class="font-semibold">Short-term chasing with no strategic tuning</p>
                            <p>Sales becomes transactional, not strategic</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:hidden mx-auto">
                <div class="w-full relative">
                    <div class="swiper business-carousel swiper-container">
                        <div class="swiper-wrapper pb-[80px]">
                            <div class="swiper-slide">
                                <div class="flex flex-col items-center text-center py-8 border-b border-blueBrand space-y-2"><img src="../assets/images/icon1.webp" alt="Customer support" class="w-[80px] h-[80px] mb-3" onerror='this.src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiByeD0iNCIgZmlsbD0iIzI1NjNlYiIvPgo8dGV4dCB4PSIxNiIgeT0iMjAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0id2hpdGUiPjE8L3RleHQ+Cjwvc3ZnPgo="'>
                                    <h2 class="text-blueBrand uppercase font-bold text-xl mb-[16px]">Understand the market and customer</h2>
                                    <div class="flex flex-col gap-1.5 leading-snug text-black text-sm">
                                        <p>Weak understanding of market & positioning</p>
                                        <p>Targeting based on internal assumptions</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center text-center py-8 border-b border-blueBrand space-y-2"><img src="../assets/images/icon2.webp" alt="Messages" class="w-[80px] h-[80px] mb-3" onerror='this.src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiByeD0iNCIgZmlsbD0iIzI1NjNlYiIvPgo8dGV4dCB4PSIxNiIgeT0iMjAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0id2hpdGUiPjI8L3RleHQ+Cjwvc3ZnPgo="'>
                                    <h2 class="text-blueBrand uppercase font-bold text-xl mb-[16px]">Clarify targeting and positioning</h2>
                                    <div class="flex flex-col gap-1.5 leading-snug text-black text-sm">
                                        <p>Lack of focus spreads resources thin</p>
                                        <p>No clear path to win based on strengths</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center text-center py-8 border-b border-blueBrand space-y-2"><img src="../assets/images/icon3.webp" alt="Targeting" class="w-[80px] h-[80px] mb-3" onerror='this.src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiByeD0iNCIgZmlsbD0iIzI1NjNlYiIvPgo8dGV4dCB4PSIxNiIgeT0iMjAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0id2hpdGUiPjM8L3RleHQ+Cjwvc3ZnPgo="'>
                                    <h2 class="text-blueBrand uppercase font-bold text-xl mb-[16px]">Design the offering & value proposition</h2>
                                    <div class="flex flex-col gap-1.5 leading-snug text-black text-sm">
                                        <p>Solutions misaligned with customer needs</p>
                                        <p>Messaging fixates on features, not value</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="flex flex-col items-center text-center py-8 border-b border-blueBrand space-y-2"><img src="../assets/images/icon4.webp" alt="Channels" class="w-[80px] h-[80px] mb-3" onerror='this.src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiByeD0iNCIgZmlsbD0iIzI1NjNlYiIvPgo8dGV4dCB4PSIxNiIgeT0iMjAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0id2hpdGUiPjQ8L3RleHQ+Cjwvc3ZnPgo="'>
                                    <h2 class="text-blueBrand uppercase font-bold text-xl mb-[16px]">Define differentiation and messaging</h2>
                                    <div class="flex flex-col gap-1.5 leading-snug text-black text-sm">
                                        <p>Poor differentiation leads to price battles</p>
                                        <p>No lasting impression of unique strengths</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center text-center py-8 border-b border-blueBrand space-y-2"><img src="../assets/images/icon5.webp" alt="value proposition" class="w-[80px] h-[80px] mb-3" onerror='this.src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiByeD0iNCIgZmlsbD0iIzI1NjNlYiIvPgo8dGV4dCB4PSIxNiIgeT0iMjAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0id2hpdGUiPjU8L3RleHQ+Cjwvc3ZnPgo="'>
                                    <h2 class="text-blueBrand uppercase font-bold text-xl mb-[16px]">Structure Sales Channels & GTM Process</h2>
                                    <div class="flex flex-col gap-1.5 leading-snug text-black text-sm">
                                        <p>Sales and marketing are out of sync</p>
                                        <p>Sales depends on individuals, not process</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center text-center py-8 border-b border-blueBrand space-y-2"><img src="../assets/images/icon6.webp" alt="strategic tuning" class="w-[80px] h-[80px] mb-3" onerror='this.src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiByeD0iNCIgZmlsbD0iIzI1NjNlYiIvPgo8dGV4dCB4PSIxNiIgeT0iMjAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0id2hpdGUiPjY8L3RleHQ+Cjwvc3ZnPgo="'>
                                    <h2 class="text-blueBrand uppercase font-bold text-xl mb-[16px]">Execute, measure and optimize</h2>
                                    <div class="flex flex-col gap-1.5 leading-snug text-black text-sm">
                                        <p>Short-term chasing with no strategic tuning</p>
                                        <p>Sales becomes transactional, not strategic</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination bottom-0"></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-[#f2f8fa]">
            <div class="bg-tintedbg lg-bg-tintedbg bg-bottom md:bg-cover bg-no-repeat">
                <div class="py-7 sm:py-16 md:py-20 lg:py-24 max-w-7xl w-[90%] lg:w-[82%] mx-auto lg:pb-36">
                    <div class="mx-auto text-center">
                        <h2 class="relative text-center uppercase text-2xl md:text-[39px] py-9 after:content-[''] after:block after:w-20 lg:after:w-36 after:h-[2px] after:bg-blueBrand after:mx-auto after:mt-4 lg:after:mt-8">OUR 6 STEPS<br><span class="font-bold text-blueBrand">GTM APPROACH</span></h2>
                        <p class="text-center mx-auto text-[14px] md:text-2xl pb-8 text-gray font-semibold">Who to reach, what to deliver, and how to deliver it.<br>A GTM strategy is your blueprint for building a scalable and repeatable growth engine.</p>
                    </div>
                    <div class="relative mx-auto">
                        <div class="max-lg:hidden lg:block absolute left-1/2 top-[40px] h-[calc(100%-40px)] w-[1px] bg-gray-800 shadow-[inset_1px_0px_1px_#fff] -translate-x-1/2"></div>
                        <div class="space-y-[40px] lg:-space-y-10">
                            <div class="relative flex items-center lg:flex-row justify-between">
                                <div class="lg:w-[calc(50%-56px)] max-lg:w-full"><span class="block max-lg:text-[48px] lg:text-[60px] font-bold text-steelMist leading-none">01 WHO</span>
                                    <div class="-mt-[20px] relative bg-white px-6 md:px-11 py-8 inline-block text-left w-full">
                                        <div class="flex items-center gap-2"><img class="mr-4 md:mr-[30px] w-9 lg-w-full" src="../assets/images/timeline-who.webp" alt="Timeline step - Who">
                                            <h4 class="lg:text-2xl text-blueBrand font-bold">Understand the Market and Customer</h4>
                                        </div>
                                        <p class="mt-3 text-sm md:text-lg text-grayText font-semibold">who are you targeting?<br>(market research, customer pain points)</p>
                                    </div>
                                </div>
                                <div class="max-lg:hidden lg:block absolute left-1/2 -translate-x-1/2 top-[40px]">
                                    <div class="w-[4px] h-[50px] bg-blue-600 arrow_left arrow_box"></div>
                                </div>
                            </div>
                            <div class="relative flex items-center lg:flex-row max-lg:flex-col justify-between">
                                <div class="w-5/12"></div>
                                <div class="max-lg:hidden lg:block absolute left-1/2 -translate-x-1/2 top-[40px]">
                                    <div class="w-[4px] h-[50px] bg-blue-600 arrow_right arrow_box"></div>
                                </div>
                                <div class="lg:w-[calc(50%-56px)] max-lg:w-full text-left"><span class="block max-lg:text-[48px] lg:text-[60px] font-bold text-steelMist leading-none">02 WHERE</span>
                                    <div class="-mt-[20px] relative bg-white px-6 md:px-11 py-8 inline-block text-left w-full">
                                        <div class="flex items-center gap-2"><img class="mr-4 md:mr-[30px] w-9 lg-w-full" src="../assets/images/timeline-where.webp" alt="Timeline step - where">
                                            <h4 class="lg:text-2xl text-blueBrand font-bold">Clarify Targeting and Positioning</h4>
                                        </div>
                                        <p class="mt-3 text-sm md:text-lg text-grayText font-semibold">Where will you compete?<br>(Persona definition, market positioning)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="relative flex items-center lg:flex-row max-lg:flex-col justify-between">
                                <div class="lg:w-[calc(50%-56px)] max-lg:w-full"><span class="block max-lg:text-[48px] lg:text-[60px] font-bold text-steelMist leading-none">03 WHAT</span>
                                    <div class="-mt-[20px] relative bg-white px-6 md:px-11 py-8 inline-block text-left w-full">
                                        <div class="flex items-center gap-2"><img class="mr-4 md:mr-[30px] w-9 lg-w-full" src="../assets/images/timeline-what.webp" alt="Timeline step - what">
                                            <h4 class="lg:text-2xl text-blueBrand font-bold">Design the Offering and Value Proposition</h4>
                                        </div>
                                        <p class="mt-3 text-sm md:text-lg text-grayText font-semibold">What will you deliver?<br>(Product/service features and value)</p>
                                    </div>
                                </div>
                                <div class="absolute max-lg:hidden lg:block left-1/2 -translate-x-1/2 top-[40px]">
                                    <div class="w-[4px] h-[50px] bg-blue-600 arrow_left arrow_box"></div>
                                </div>
                                <div class="w-5/12"></div>
                            </div>
                            <div class="relative flex items-center lg:flex-row max-lg:flex-col justify-between">
                                <div class="w-5/12"></div>
                                <div class="absolute max-lg:hidden lg:block left-1/2 -translate-x-1/2 top-[40px]">
                                    <div class="w-[4px] h-[50px] bg-blue-600 arrow_right arrow_box"></div>
                                </div>
                                <div class="lg:w-[calc(50%-56px)] max-lg:w-full text-left"><span class="block max-lg:text-[48px] lg:text-[60px] font-bold text-steelMist leading-none">04 WHY</span>
                                    <div class="-mt-[20px] relative bg-white px-6 md:px-11 py-8 inline-block text-left w-full">
                                        <div class="flex items-center gap-2"><img class="mr-4 md:mr-[30px] w-9 lg-w-full" src="../assets/images/timeline-why.webp" alt="Timeline step - why">
                                            <h4 class="lg:text-2xl text-blueBrand font-bold">Define Differentiation and Messaging</h4>
                                        </div>
                                        <p class="mt-3 text-sm md:text-lg text-grayText font-semibold">Why should customers choose you?<br>(Your competitive advantages and core strengths)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="relative flex items-center lg:flex-row max-lg:flex-col justify-between">
                                <div class="lg:w-[calc(50%-56px)] max-lg:w-full"><span class="block max-lg:text-[48px] lg:text-[60px] font-bold text-steelMist leading-none">05 HOW</span>
                                    <div class="-mt-[20px] relative bg-white px-6 md:px-11 py-8 inline-block text-left w-full">
                                        <div class="flex items-center gap-2"><img class="mr-4 md:mr-[30px] w-9 lg-w-full" src="../assets/images/timeline-how.webp" alt="Timeline step - how">
                                            <h4 class="lg:text-2xl text-blueBrand font-bold">Structure Sales Channels and GTM Processes</h4>
                                        </div>
                                        <p class="mt-3 text-sm md:text-lg text-grayText font-semibold">How will you reach them?<br>(Sales model, funnels, customer journey)</p>
                                    </div>
                                </div>
                                <div class="absolute max-lg:hidden lg:block left-1/2 -translate-x-1/2 top-[40px]">
                                    <div class="w-[4px] h-[50px] bg-blue-600 arrow_left arrow_box"></div>
                                </div>
                                <div class="w-5/12"></div>
                            </div>
                            <div class="relative pb-20 flex items-center lg:flex-row max-lg:flex-col justify-between">
                                <div class="w-5/12"></div>
                                <div class="absolute max-lg:hidden lg:block left-1/2 -translate-x-1/2 top-[40px]">
                                    <div class="w-[4px] h-[50px] bg-blue-600 arrow_right arrow_box"></div>
                                </div>
                                <div class="lg:w-[calc(50%-56px)] max-lg:w-full text-left"><span class="block max-lg:text-[48px] lg:text-[60px] font-bold text-steelMist leading-none">06 WHEN</span>
                                    <div class="-mt-[20px] relative bg-white px-6 md:px-11 py-8 inline-block text-left w-full">
                                        <div class="flex items-center gap-2"><img class="mr-4 md:mr-[30px] w-9 lg-w-full" src="../assets/images/timeline-when.webp" alt="Timeline step - when">
                                            <h4 class="lg:text-2xl text-blueBrand font-bold">Execute, Measure and Optimize</h4>
                                        </div>
                                        <p class="mt-3 text-sm md:text-lg text-grayText font-semibold">When and how will you adapt?<br>(Action plans, KPIs, PDCA cycles)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-8 text-center"><a href="https://go-to-market.jp/en/#contact" class="bg-[#f7722b] hover:bg-orange-500 cursor-pointer transition-colors duration-200 inline-block md:w-[320px] py-4 px-7 text-white uppercase font-bold">Get a free consultation</a></div>
                </div>
            </div>
        </section>
        <section id="service" class="bg-service lg-bg-service bg-cover bg-center">
            <div class="py-7 sm:py-16 md:py-20 lg:py-24 max-w-7xl w-[90%] lg:w-[82%] mx-auto lg:pb-36">
                <h2 class="relative text-center uppercase text-2xl md:text-[39px] py-9 after:content-[''] after:block after:w-20 lg:after:w-36 after:h-[2px] after:bg-[#2BCAFF] after:mx-auto after:mt-4 lg:after:mt-8 text-[#003361]">SERVICE<br><span class="text-white">Introduction</span></h2>
                <ul class="flex max-lg:flex-col max-lg:gap-10 lg:gap-6 lg:flex-wrap lg:justify-center pt-8">
                    <li class="bg-white rounded-2xl max-lg:py-4 lg:py-6 max-lg:px-4 lg:px-6 flex flex-col gap-3 lg:w-[30%] xl:min-h-[190px]">
                        <h3 class="text-[18px] lg:text-[16px] text-blueBrand text-center font-bold">Core GTM Strategy Design<br>(Core Service)</h3>
                        <p class="text-[16px] lg:text-[14px]">End-to-end GTM design covering target definition, positioning, value proposition, channel strategy, and sales process architecture.</p>
                    </li>
                    <li class="bg-white rounded-2xl max-lg:py-4 lg:py-6 max-lg:px-4 lg:px-6 flex flex-col gap-3 lg:w-[30%] xl:min-h-[190px]">
                        <h3 class="text-[18px] lg:text-[16px] text-blueBrand text-center font-bold">Target & Segmentation<br>Redefinition</h3>
                        <p class="text-[16px] lg:text-[14px]">Refine your Ideal Customer Profile (ICP) using existing customer data and market insights to optimize targeting.</p>
                    </li>
                    <li class="bg-white rounded-2xl max-lg:py-4 lg:py-6 max-lg:px-4 lg:px-6 flex flex-col gap-3 lg:w-[30%] xl:min-h-[190px]">
                        <h3 class="text-[18px] lg:text-[16px] text-blueBrand text-center font-bold">Messaging & Value Proposition Development</h3>
                        <p class="text-[16px] lg:text-[14px]">Define and articulate the compelling reasons why customers choose your solution—your unique differentiation.</p>
                    </li>
                    <li class="bg-white rounded-2xl max-lg:py-4 lg:py-6 max-lg:px-4 lg:px-6 flex flex-col gap-3 lg:w-[30%] xl:min-h-[190px]">
                        <h3 class="text-[18px] lg:text-[16px] text-blueBrand text-center font-bold">Sales Process Optimization & Channel Design</h3>
                        <p class="text-[16px] lg:text-[14px]">Design integrated execution across inside sales, field sales, and partner channels to maximize efficiency.</p>
                    </li>
                    <li class="bg-white rounded-2xl max-lg:py-4 lg:py-6 max-lg:px-4 lg:px-6 flex flex-col gap-3 lg:w-[30%] xl:min-h-[190px]">
                        <h3 class="text-[18px] lg:text-[16px] text-blueBrand text-center font-bold">GTM Execution Support &<br>Review (PMO)</h3>
                        <p class="text-[16px] lg:text-[14px]">Provide monthly reviews and continuous improvement support to strengthen GTM execution and drive revenue growth.</p>
                    </li>
                </ul>
            </div>
        </section>
        <section id="free" class="bg-lightBlue py-7 sm:py-16 md:py-20 lg:py-24 lg:pb-36">
            <div class="bg-blueBrand text-white flex max-md:flex-col justify-center items-center gap-4 lg:gap-10 max-w-[890px] w-[90%] lg:w-[82%] mx-auto py-6 px-6 rounded-2xl">
                <div class="w-[84px] shrink-0 flex justify-center"><img src="../assets/images/cta.svg" loading="lazy" alt="" class="w-full h-auto"></div>
                <div class="flex flex-col gap-4 w-full max-w-[560px]">
                    <h2 class="flex items-center justify-center gap-2 max-lg:text-[18px] lg:text-[28px] font-bold">Free GTM Maturity Assessment<img src="../assets/images/icon-cta.svg" loading="lazy" alt=""></h2>
                    <p class="text-4">Answer just 8 questions to assess your current Go-to-Market maturity.<br>You’ll receive a concise report with your score and recommended next steps.</p>

                    <a href="<?= $redirectUrl;?>" class="bg-[#F2BD2D] hover:bg-[#e0ac1f] px-4 rounded text-center transition-colors duration-200 w-full mx-auto text-black font-bold cta-mobile-btn"><span class="cta-label"><span>Start Free Assessment</span><span class="cta-break-sp cta-break-sp-en">(Takes about 1 minute)</span></span></a>
                </div>
            </div>
        </section>
        <section class="bg-white py-7 sm:py-16 md:pt-20 lg:py-24 max-w-7xl w-[90%] lg:w-[82%] mx-auto" id="case">
            <h2 class="relative lg:hidden text-center uppercase text-2xl md:text-[39px] py-9 after:content-[''] after:block after:w-20 lg:after:w-36 after:h-[2px] after:bg-blueBrand after:mx-auto after:mt-4 lg:after:mt-8">case <span class="font-bold text-blueBrand">study</span></h2>
            <div class="w-full relative">
                <div class="swiper case-carousel swiper-container">
                    <div class="swiper-wrapper pb-[80px]">
                        <div class="swiper-slide">
                            <div class="flex max-lg:flex-col lg:flex-row items-center justify-between max-lg:gap-5 lg:gap-10">
                                <div class="flex-1">
                                    <h3 class="text-blueBrand pb-7 max-lg:text-[20px] lg:text-[32px] max-lg:text-center font-bold">Global SaaS Company</h3>
                                    <div class="max-w-full sm:w-[70%] lg:w-full max-lg:max-w-[580px] m-auto"><a href="<?= BASE_URL;?>/en/case-study1"><img src="../assets/images/case-01.webp" loading="lazy" alt="Global SaaS Company case study"></a></div>
                                </div>
                                <div class="flex-1">
                                    <p class="max-lg:hidden lg:block relative text-left uppercase text-2xl md:text-[39px] pb-9 after:content-[''] after:block after:w-20 lg:after:w-36 after:h-[2px] after:bg-blueBrand after:mt-4">case <span class="font-bold text-blueBrand">study</span></p>
                                    <h4 class="text-skyBlue max-lg:text-[20px] md:text-[24px] max-lg:text-center font-bold pb-3">Building a Reproducible Growth Engine with GTM</h4>
                                    <p class="max-lg:text-[16px] lg:text-[20px] text-grayText">Moved away from founder- or individual-dependent sales by designing a target-focused go-to-market strategy.<br>From the early stage of launch, systemization was prioritized, establishing a scalable and repeatable foundation for growth.</p>
                                    <a href="<?= BASE_URL;?>/en/case-study1" class="inline-block mt-4 text-blueBrand hover:underline">View Details →</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="flex max-lg:flex-col lg:flex-row items-center justify-between max-lg:gap-5 lg:gap-10">
                                <div class="flex-1">
                                    <h3 class="text-blueBrand pb-7 max-lg:text-[20px] lg:text-[32px] max-lg:text-center font-bold">Large IT Company</h3>
                                    <div class="max-w-full sm:w-[70%] lg:w-full max-lg:max-w-[580px] m-auto"><a href="<?= BASE_URL;?>/en/case-study2"><img src="../assets/images/case-02.webp" loading="lazy" alt="Large IT Company case study"></a></div>
                                </div>
                                <div class="flex-1">
                                    <p class="max-lg:hidden lg:block relative text-left uppercase text-2xl md:text-[39px] pb-9 after:content-[''] after:block after:w-20 lg:after:w-36 after:h-[2px] after:bg-blueBrand after:mt-4">case <span class="font-bold text-blueBrand">study</span></p>
                                    <h4 class="text-skyBlue max-lg:text-[20px] md:text-[24px] max-lg:text-center font-bold pb-3">Restarting Growth Through GTM Redesign</h4>
                                    <p class="max-lg:text-[16px] lg:text-[20px] text-grayText">Identified the factors behind stagnating new customer acquisition and redefined both the target segments and value proposition.<br>Rebuilt the sales process and transitioned to a repeatable, sustainable growth model.</p>
                                    <a href="<?= BASE_URL;?>/en/case-study2" class="inline-block mt-4 text-blueBrand hover:underline">View Details →</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination bottom-0"></div>
                </div>
            </div>
        </section>
        <section class="bg-lightBlue py-7 sm:py-16 md:py-20 lg:py-24" id="about">
            <div class="w-[95%] sm:w-[85%] lg:w-[82%] max-w-7xl mx-auto px-4">
                <h2 class="text-center md:text-left text-2xl md:text-3xl lg:text-[39px] py-6 md:pt-9 md:pb-4 uppercase font-normal">about<span class="text-blueBrand font-bold inline-block pl-1">us</span></h2>
                <div class="flex justify-between lg:flex-row flex-col-reverse py-7 items-center lg:items-start md:gap-4 lg:gap-10">
                    <div class="lg:flex-1 max-lg:w-full text-grayText leading-relaxed">
                        <p class="text-[16px] lg:text-[18px]">Over the past 20 years, Sales and Marketing functions have become increasingly specialized. From inside sales to field sales, from customer success to diversified marketing roles— fragmentation has created silos and blurred responsibilities.</p>
                        <ul class="leading-loose text-justify justify-center py-8 text-[13px] lg:text-[15px] font-bold">
                            <li class="flex items-center gap-2"><span class="w-4 aspect-square bg-yellowdot rounded-full inline-block"></span>We don't just offer strategy.</li>
                            <li class="flex items-center gap-2"><span class="w-4 aspect-square bg-bluedot rounded-full inline-block"></span>We don't just support execution.</li>
                            <li class="flex items-start gap-2"><span class="w-4 aspect-square bg-greendot rounded-full inline-block mt-2"></span>We redesign the entire system end-to-end.</li>
                        </ul>
                        <p class="text-[18px]">We collaborate with both frontline teams and executive leadership to build <span class="font-semibold">self-sustaining, high-performing organizations</span> —as a system, not just a mindset.</p>
                        <p class="text-[18px] pt-4 max-md:block md:hidden">This is our approach</p>
                    </div>
                    <div class="max-lg:w-full lg:w-[42%] mb-4"><img src="../assets/images/aboutUs.webp" alt="About us"></div>
                </div>
            </div>
        </section>
        <section class="py-7 sm:py-16 md:py-20 lg:py-24">
            <h2 class="relative text-center text-blueBrand text-2xl md:text-3xl lg:text-[39px] py-6 lg:py-9 after:content-[''] after:block after:w-20 sm:after:w-28 lg:after:w-36 after:h-[2px] after:bg-blueBrand after:mx-auto after:mt-4 lg:after:mt-8 font-bold">FAQS</h2>
            <div class="w-[95%] sm:w-[85%] lg:w-[82%] max-w-5xl mx-auto px-4 max-lg:space-y-4 lg:space-y-8">
                <div class="w-full"><button class="w-full flex items-center justify-between pl-2 pr-4 sm:px-6 md:px-8 lg:px-10 py-3 lg:py-3 text-left bg-grayBg gap-2 cursor-pointer" aria-expanded="false" aria-controls="acc1" onclick='toggleAccordion("acc1")'>
                        <h3 class="flex justify-start items-center space-x-2 flex-1 cursor-pointer" role="region" aria-labelledby="btn-acc1"><span class="flex-none -ml-6 sm:-ml-8 md:-ml-14 text-center leading-[40px] max-md:w-8 max-md:h-8 md:w-14 md:h-14 aspect-square text-white border-4 sm:border-6 md:border-8 border-white bg-blueBrand rounded-full font-semibold flex items-center justify-center">1 </span><span class="text-[16px] md:text-lg font-semibold text-blue-900 flex-1">What Is a Go-to-Market (GTM) Strategy?</span></h3><svg id="icon-acc1" class="max-md:w-3 max-md:h-3 md:w-6 md:h6 text-blue-900 transform transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    <div id="acc1" class="max-h-0 text-[14px] md:text-[16px] overflow-hidden transition-all duration-500 ease-in-out text-gray-700 bg-white">
                        <p class="pt-2">A GTM strategy clarifies “who to sell to, what to sell, and how to sell,” enabling a structured approach to revenue generation. It applies to both new product launches and revamping existing sales and marketing efforts.</p>
                    </div>
                </div>
                <div class="w-full"><button class="w-full flex items-center justify-between pl-2 pr-4 sm:px-6 md:px-8 lg:px-10 py-3 lg:py-3 text-left bg-grayBg gap-2 cursor-pointer" aria-expanded="false" aria-controls="acc2" onclick='toggleAccordion("acc2")'>
                        <h3 class="flex justify-start items-center space-x-2 flex-1 cursor-pointer" role="region" aria-labelledby="btn-acc2"><span class="flex-none -ml-6 sm:-ml-8 md:-ml-14 text-center leading-[40px] max-md:w-8 max-md:h-8 md:w-14 md:h-14 aspect-square text-white border-4 sm:border-6 md:border-8 border-white bg-blueBrand rounded-full font-semibold flex items-center justify-center">2</span> <span class="text-[16px] md:text-lg font-semibold text-blue-900 flex-1">Why is GTM strategy important?</span></h3><svg id="icon-acc2" class="max-md:w-3 max-md:h-3 md:w-6 md:h6 text-blue-900 transform transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" Faqs />
                        </svg>
                    </button>
                    <div id="acc2" class="max-h-0 text-[14px] md:text-[16px] overflow-hidden transition-all duration-500 ease-in-out text-gray-700 bg-white">
                        <p class="pt-2">You can expect more leads, higher deal conversion, better sales efficiency, and stronger value messaging. Past clients have seen 3x lead growth and 20–50% monthly revenue increases.</p>
                    </div>
                </div>
                <div class="w-full"><button class="w-full flex items-center justify-between pl-2 pr-4 sm:px-6 md:px-8 lg:px-10 py-3 lg:py-3 text-left bg-grayBg gap-2 cursor-pointer" aria-expanded="false" aria-controls="acc3" onclick='toggleAccordion("acc3")'>
                        <h3 class="flex justify-start items-center space-x-2 flex-1 cursor-pointer" role="region" aria-labelledby="btn-acc3"><span class="flex-none -ml-6 sm:-ml-8 md:-ml-14 text-center leading-[40px] max-md:w-8 max-md:h-8 md:w-14 md:h-14 aspect-square text-white border-4 sm:border-6 md:border-8 border-white bg-blueBrand rounded-full font-semibold flex items-center justify-center">3</span> <span class="text-[16px] md:text-lg font-semibold text-blue-900 flex-1">How is this different from other consulting firms?</span></h3><svg id="icon-acc3" class="max-md:w-3 max-md:h-3 md:w-6 md:h6 text-blue-900 transform transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    <div id="acc3" class="max-h-0 text-[14px] md:text-[16px] overflow-hidden transition-all duration-500 ease-in-out text-gray-700 bg-white">
                        <p class="pt-2">Unlike typical firms, we go beyond strategy—we help with execution too, from pitch decks to landing pages. Our strength is in cross-functional implementation.</p>
                    </div>
                </div>
                <div class="w-full"><button class="w-full flex items-center justify-between pl-2 pr-4 sm:px-6 md:px-8 lg:px-10 py-3 lg:py-3 text-left bg-grayBg gap-2 cursor-pointer" aria-expanded="false" aria-controls="acc4" onclick='toggleAccordion("acc4")'>
                        <h3 class="flex justify-start items-center space-x-2 flex-1 cursor-pointer" role="region" aria-labelledby="btn-acc4"><span class="flex-none -ml-6 sm:-ml-8 md:-ml-14 text-center leading-[40px] max-md:w-8 max-md:h-8 md:w-14 md:h-14 aspect-square text-white border-4 sm:border-6 md:border-8 border-white bg-blueBrand rounded-full font-semibold flex items-center justify-center">4</span> <span class="text-[16px] md:text-lg font-semibold text-blue-900 flex-1">What are the steps involved in a typical project?</span></h3><svg id="icon-acc4" class="max-md:w-3 max-md:h-3 md:w-6 md:h6 text-blue-900 transform transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    <div id="acc4" class="max-h-0 text-[14px] md:text-[16px] overflow-hidden transition-all duration-500 ease-in-out text-gray-700 bg-white">
                        <p class="pt-2">We follow six steps: Discovery → Targeting → Messaging → Channel Design → Execution → Optimization. The process can be tailored to your needs.</p>
                    </div>
                </div>
                <div class="w-full"><button class="w-full flex items-center justify-between pl-2 pr-4 sm:px-6 md:px-8 lg:px-10 py-3 lg:py-3 text-left bg-grayBg gap-2 cursor-pointer" aria-expanded="false" aria-controls="acc5" onclick='toggleAccordion("acc5")'>
                        <h3 class="flex justify-start items-center space-x-2 flex-1 cursor-pointer" role="region" aria-labelledby="btn-acc5"><span class="flex-none -ml-6 sm:-ml-8 md:-ml-14 text-center leading-[40px] max-md:w-8 max-md:h-8 md:w-14 md:h-14 aspect-square text-white border-4 sm:border-6 md:border-8 border-white bg-blueBrand rounded-full font-semibold flex items-center justify-center">5</span> <span class="text-[16px] md:text-lg font-semibold text-blue-900 flex-1">What if we don’t have a marketing person in-house?</span></h3><svg id="icon-acc5" class="max-md:w-3 max-md:h-3 md:w-6 md:h6 text-blue-900 transform transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    <div id="acc5" class="max-h-0 text-[14px] md:text-[16px] overflow-hidden transition-all duration-500 ease-in-out text-gray-700 bg-white">
                        <p class="pt-2">No problem. We design and support execution even without in-house marketers. Many clients started from zero.</p>
                    </div>
                </div>
                <div class="w-full"><button class="w-full flex items-center justify-between pl-2 pr-4 sm:px-6 md:px-8 lg:px-10 py-3 lg:py-3 text-left bg-grayBg gap-2 cursor-pointer" aria-expanded="false" aria-controls="acc6" onclick='toggleAccordion("acc6")'>
                        <h3 class="flex justify-start items-center space-x-2 flex-1 cursor-pointer" role="region" aria-labelledby="btn-acc6"><span class="flex-none -ml-6 sm:-ml-8 md:-ml-14 text-center leading-[40px] max-md:w-8 max-md:h-8 md:w-14 md:h-14 aspect-square text-white border-4 sm:border-6 md:border-8 border-white bg-blueBrand rounded-full font-semibold flex items-center justify-center">6</span> <span class="text-[16px] md:text-lg font-semibold text-blue-900 flex-1">Is this only for B2B, or can B2C companies benefit too?</span></h3><svg id="icon-acc6" class="max-md:w-3 max-md:h-3 md:w-6 md:h6 text-blue-900 transform transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    <div id="acc6" class="max-h-0 text-[14px] md:text-[16px] overflow-hidden transition-all duration-500 ease-in-out text-gray-700 bg-white">
                        <p class="pt-2">While we mainly serve B2B, our frameworks apply to B2C—especially for high-touch or subscription-based offerings.</p>
                    </div>
                </div>
                <div class="w-full"><button class="w-full flex items-center justify-between pl-2 pr-4 sm:px-6 md:px-8 lg:px-10 py-3 lg:py-3 text-left bg-grayBg gap-2 cursor-pointer" aria-expanded="false" aria-controls="acc7" onclick='toggleAccordion("acc7")'>
                        <h3 class="flex justify-start items-center space-x-2 flex-1 cursor-pointer" role="region" aria-labelledby="btn-acc7"><span class="flex-none -ml-6 sm:-ml-8 md:-ml-14 text-center leading-[40px] max-md:w-8 max-md:h-8 md:w-14 md:h-14 aspect-square text-white border-4 sm:border-6 md:border-8 border-white bg-blueBrand rounded-full font-semibold flex items-center justify-center">7</span> <span class="text-[16px] md:text-lg font-semibold text-blue-900 flex-1">What if we have a limited budget?</span></h3><svg id="icon-acc7" class="max-md:w-3 max-md:h-3 md:w-6 md:h6 text-blue-900 transform transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    <div id="acc7" class="max-h-0 text-[14px] md:text-[16px] overflow-hidden transition-all duration-500 ease-in-out text-gray-700 bg-white">
                        <p class="pt-2">Yes. We can scale the support based on your budget—from spot consulting to partial engagements. Let's talk.</p>
                    </div>
                </div>
                <div class="w-full"><button class="w-full flex items-center justify-between pl-2 pr-4 sm:px-6 md:px-8 lg:px-10 py-3 lg:py-3 text-left bg-grayBg gap-2 cursor-pointer" aria-expanded="false" aria-controls="acc8" onclick='toggleAccordion("acc8")'>
                        <h3 class="flex justify-start items-center space-x-2 flex-1 cursor-pointer" role="region" aria-labelledby="btn-acc8"><span class="flex-none -ml-6 sm:-ml-8 md:-ml-14 text-center leading-[40px] max-md:w-8 max-md:h-8 md:w-14 md:h-14 aspect-square text-white border-4 sm:border-6 md:border-8 border-white bg-blueBrand rounded-full font-semibold flex items-center justify-center">8</span> <span class="text-[16px] md:text-lg font-semibold text-blue-900 flex-1">Which industries do you specialize in?</span></h3><svg id="icon-acc8" class="max-md:w-3 max-md:h-3 md:w-6 md:h6 text-blue-900 transform transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    <div id="acc8" class="max-h-0 text-[14px] md:text-[16px] overflow-hidden transition-all duration-500 ease-in-out text-gray-700 bg-white">
                        <p class="pt-2">We've worked across IT, SaaS, finance, education, and manufacturing—especially where challenges are complex and multi-layered.</p>
                    </div>
                </div>
                <div class="w-full"><button class="w-full flex items-center justify-between pl-2 pr-4 sm:px-6 md:px-8 lg:px-10 py-3 lg:py-3 text-left bg-grayBg gap-2 cursor-pointer" aria-expanded="false" aria-controls="acc9" onclick='toggleAccordion("acc9")'>
                        <h3 class="flex justify-start items-center space-x-2 flex-1 cursor-pointer" role="region" aria-labelledby="btn-acc9"><span class="flex-none -ml-6 sm:-ml-8 md:-ml-14 text-center leading-[40px] max-md:w-8 max-md:h-8 md:w-14 md:h-14 aspect-square text-white border-4 sm:border-6 md:border-8 border-white bg-blueBrand rounded-full font-semibold flex items-center justify-center">9</span> <span class="text-[16px] md:text-lg font-semibold text-blue-900 flex-1">Can you support global or cross-border GTM initiatives?</span></h3><svg id="icon-acc9" class="max-md:w-3 max-md:h-3 md:w-6 md:h6 text-blue-900 transform transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    <div id="acc9" class="max-h-0 text-[14px] md:text-[16px] overflow-hidden transition-all duration-500 ease-in-out text-gray-700 bg-white">
                        <p class="pt-2">Yes. We assist with global GTM—positioning, messaging, and sales enablement in English-speaking markets included.</p>
                    </div>
                </div>
                <div class="w-full"><button class="w-full flex items-center justify-between pl-2 pr-4 sm:px-6 md:px-8 lg:px-10 py-3 lg:py-3 text-left bg-grayBg gap-2 cursor-pointer" aria-expanded="false" aria-controls="acc10" onclick='toggleAccordion("acc10")'>
                        <h3 class="flex justify-start items-center space-x-2 flex-1 cursor-pointer" role="region" aria-labelledby="btn-acc10"><span class="flex-none -ml-6 sm:-ml-8 md:-ml-14 text-center leading-[40px] max-md:w-8 max-md:h-8 md:w-14 md:h-14 aspect-square text-white border-4 sm:border-6 md:border-8 border-white bg-blueBrand rounded-full font-semibold flex items-center justify-center">10</span> <span class="text-[16px] md:text-lg font-semibold text-blue-900 flex-1">How long does it take to see results?</span></h3><svg id="icon-acc10" class="max-md:w-3 max-md:h-3 md:w-6 md:h6 text-blue-900 transform transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    <div id="acc10" class="max-h-0 text-[14px] md:text-[16px] overflow-hidden transition-all duration-500 ease-in-out text-gray-700 bg-white">
                        <p class="pt-2">You may start seeing changes in 1–2 months, with more meaningful results over 3–6 months. We plan for both short and long term.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="relative" id="contact">
            <div class="flex max-lg:flex-col lg:flex-row justify-center items-center mx-auto w-full lg:w-[82%] max-w-7xl">
                <div class="relative py-7 sm:py-16 md:py-20 max-lg:w-full lg:w-[50%] mx-auto max-lg:text-center lg:pr-[50px]"><span class="font-semibold">CONTACT US</span>
                    <h2 class="relative max-lg:text-center lg:text-left text-2xl md:text-3xl lg:text-[39px] pt-2 pb-6 lg:py-9 after:content-[''] after:block after:w-20 sm:after:w-28 lg:after:w-36 after:h-[2px] after:bg-blueBrand max-lg:after:mx-auto after:mt-4 lg:after:mt-8"><span class="font-semibold text-blueBrand">let's collaborate</span> on<br>your innovative ideas</h2>
                    <div class="text-lg max-lg:mx-auto text-grayText mt-8 px-4">
                        <p>Whether you're bringing a new product to market, repositioning your brand, or scaling your revenue engine—we're here to help you win with clarity and confidence.</p>
                        <p class="font-semibold">Let's start with a no-pressure conversation.</p><a href="https://go-to-market.jp/en/#contact" class="bg-[#f7722b] hover:bg-orange-500 py-3 px-5 font-bold text-sm mt-10 max-lg:w-[320px] mb-8 text-white uppercase inline-block">book your free consultation</a>
                        <p>Or reach out directly via the form</p>
                    </div><img src="../assets/images/bg-contact.webp" class="absolute bottom-0 left-0 -z-1 lg:hidden" alt="">
                </div>
                <div class="bg-skyBlueBg max-lg:w-full lg:w-[50%] z-1" id="contact02">
                    <div class="w-[95%] sm:w-[85%] mx-auto px-4 max-sm:py-7 md:py-4 lg:py-4">
                        <h2 class="text-blueBrand text-2xl md:text-3xl lg:text-[39px] py-6 lg:py-0 font-bold">Fill The Form</h2>
                        <form id="contact-form" class="space-y-4 flex text-grayText text-[16px] flex-col">

                            <!-- 言語フラグ -->
                            <input type="hidden" id="lang" value="en">

                            <div>
                                <input id="name" name="name" placeholder="Name"
                                    class="bg-white w-full px-4 max-lg:px-8 py-4 max-lg:py-[26px] ">
                                <p id="error-name" class="text-red text-sm mt-1 hidden"></p>
                            </div>

                            <div>
                                <input id="email" name="email" placeholder="Email"
                                    class="bg-white w-full px-4 max-lg:px-8 py-4 max-lg:py-[26px]">
                                <p id="error-email" class="text-red text-sm mt-1 hidden"></p>
                            </div>

                            <div>
                                <textarea id="message" name="message" placeholder="Message" rows="5"
                                    class="resize-none bg-white w-full px-4 max-lg:px-8 py-4 max-lg:py-[26px]"></textarea>
                                <p id="error-message" class="text-red text-sm mt-1 hidden"></p>
                            </div>

                            <div class="py-4 flex flex-col gap-3">
                                <div class="flex items-start gap-2">
                                    <input type="checkbox" id="agree-policy" class="mt-1">
                                    <label for="agree-policy" class="text-sm">
                                        I agree to the
                                        <a href="/en/privacy-policy/" target="_blank" class="text-blueBrand underline">
                                            Privacy Policy
                                        </a>.
                                    </label>
                                </div>
                                <p id="error-policy" class="text-red text-sm mt-1 hidden"></p>
                                <button
                                    type="button"
                                    id="submit-btn"
                                    class="max-md:text-sm md:text-base text-white bg-blueBrand block
                                        max-lg:w-1/2 lg:max-w-[280px] py-3 px-4 text-center rounded"
                                >
                                    Let's talk GTM
                                </button>
                                <!-- 成功メッセージ -->
                                <p id="success-message" class="text-green-600 text-sm hidden">
                                    Your message has been sent. Thank you!
                                </p>
                            </div>

                        </form>
                        <script>
                        document.addEventListener("DOMContentLoaded", () => {

                            // ▼ フリーメールドメイン
                            const freeDomains = [
                                "gmail.com", "yahoo.com", "yahoo.co.jp",
                                "outlook.com", "hotmail.com", "live.jp",
                                "icloud.com", "me.com"
                            ];

                            // ▼ 入力フィールド
                            const inputFields = [
                                { id: "name", error: "error-name" },
                                { id: "email", error: "error-email" },
                                { id: "message", error: "error-message" }
                            ];

                            inputFields.forEach(f => {
                                const input = document.getElementById(f.id);
                                const error = document.getElementById(f.error);

                                if (input && error) {
                                    input.addEventListener("input", () => {
                                        // エラー消す
                                        error.textContent = "";
                                        error.classList.add("hidden");

                                        // ▼ email の即時フリーメール判定
                                        if (f.id === "email") {
                                            const val = input.value.trim();
                                            const domain = val.split("@")[1]?.toLowerCase();

                                            if (domain && freeDomains.includes(domain)) {
                                                error.textContent = "Free email providers are not allowed.";
                                                error.classList.remove("hidden");
                                            }
                                        }
                                    });
                                }
                            });

                            // ▼ プライバシーポリシーチェック
                            const agree = document.getElementById("agree-policy");
                            const agreeError = document.getElementById("error-policy");

                            if (agree && agreeError) {
                                agree.addEventListener("change", () => {
                                    agreeError.textContent = "";
                                    agreeError.classList.add("hidden");
                                });
                            }
                        });

                        function showError(id, message) {
                            const el = document.getElementById(id);
                            el.textContent = message;
                            el.classList.remove("hidden");
                        }

                        function clearErrors() {
                            ["error-name", "error-email", "error-message", "error-policy"].forEach(id => {
                                const el = document.getElementById(id);
                                el.textContent = "";
                                el.classList.add("hidden");
                            });
                        }

                        document.getElementById("submit-btn").addEventListener("click", sendForm);

                        function sendForm() {

                            clearErrors();
                            document.getElementById("success-message").classList.add("hidden");

                            const name = document.getElementById("name").value.trim();
                            const email = document.getElementById("email").value.trim();
                            const message = document.getElementById("message").value.trim();
                            const agree = document.getElementById("agree-policy").checked;

                            let hasError = false;

                            // ▼ 必須チェック
                            if (!name) {
                                showError("error-name", "Please enter your name.");
                                hasError = true;
                            }
                            if (!email) {
                                showError("error-email", "Please enter your email address.");
                                hasError = true;
                            }
                            if (!message) {
                                showError("error-message", "Please enter your message.");
                                hasError = true;
                            }

                            // ▼ フリーメール拒否
                            if (email) {
                                const freeDomains = [
                                    "gmail.com", "yahoo.com", "yahoo.co.jp",
                                    "outlook.com", "hotmail.com", "live.jp",
                                    "icloud.com", "me.com"
                                ];
                                const domain = email.split("@")[1]?.toLowerCase();
                                if (freeDomains.includes(domain)) {
                                    showError("error-email", "Free email providers are not allowed.");
                                    hasError = true;
                                }
                            }

                            // ▼ 同意チェック
                            if (!agree) {
                                showError("error-policy", "You must agree to the Privacy Policy.");
                                hasError = true;
                            }

                            if (hasError) return;

                            // ▼ ボタンのローディング
                            const btn = document.getElementById("submit-btn");
                            btn.disabled = true;
                            btn.innerHTML = `<span class="loader mr-2"></span>Sending...`;

                            // ▼ 送信
                            const formData = new FormData();
                            formData.append("name", name);
                            formData.append("email", email);
                            formData.append("message", message);
                            formData.append("lang", "en");

                            fetch("<?= BASE_URL;?>/contact/send.php", {
                                method: "POST",
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                btn.disabled = false;
                                btn.innerHTML = "Send";

                                if (data.success) {
                                    document.getElementById("success-message").textContent =
                                        "Your message has been sent. Thank you!";
                                    document.getElementById("success-message").classList.remove("hidden");
                                    document.getElementById("contact-form").reset();
                                } else {
                                    showError("error-message", data.message || "Failed to send. Please try again.");
                                }
                            })
                            .catch(() => {
                                btn.disabled = false;
                                btn.innerHTML = "Send";
                                showError("error-message", "A network error occurred. Please try again.");
                            });
                        }
                        </script>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                            const el = document.querySelector(".default-carousel");

                            if (el) {
                                new Swiper(el, {
                                loop: true,
                                slidesPerView: 1,
                                autoHeight: true,
                                effect: "slide",
                                fadeEffect: { crossFade: true },
                                pagination: {
                                    el: ".swiper-pagination",
                                    clickable: true,
                                },
                                autoplay: {
                                    delay: 5000,
                                    disableOnInteraction: false,
                                },
                                speed: 1300, 
                                });
                            }
                            });
                        </script>



                    </div>
                </div>
            </div><img src="../assets/images/bg-contact.webp" class="absolute bottom-0 left-0 -z-1 max-lg:hidden lg:block w-[100vw]" alt="">
        </section>

<?php include 'inc/footer.php'; ?>
