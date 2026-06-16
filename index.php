<?php include 'inc/session.php'; ?>
<?php $isHomeV2 = true; // light split-hero redesign: scopes the light header treatment to the homepage ?>

<!doctype html>
<html lang="ja" class="scroll-smooth">

<?php include 'inc/head.php'; ?>
<?php include 'inc/header.php'; ?>
<?php  $_SESSION['lang'] = 'ja';

$redirectUrl = BASE_URL . '/register';

if (!empty($_SESSION['form_data'])) {
    $lang = $_SESSION['form_data']['lang'] ?? 'en';
    $redirectUrl = BASE_URL . '/gtm-assessment';
}
?>
<body class="overflow-x-hidden font-bold">

            <!-- ===== Top view slider: slide 1 = redesign (Figma 案02_ver02), slides 2-3 = existing ===== -->
            <div class="w-full relative z-0">
                <div class="swiper default-carousel">
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
                        <img class="hl hl--laptop"      src="<?= asset('assets/images/hero/laptop.png'); ?>"      alt="GTM成熟度診断レポートのサンプル" fetchpriority="high">
                        <img class="hl hl--report-page" src="<?= asset('assets/images/hero/report-page.png'); ?>" alt="" aria-hidden="true">
                        <img class="hl hl--character"   src="<?= asset('assets/images/hero/character.png'); ?>"   alt="" aria-hidden="true">
                        <div class="hl hero-callout">実際にお渡しする<br>レポートの一部を公開！</div>
                    </div>
                    <div class="hero-v2__inner">
                        <div class="hero-v2__copy">
                            <h2 class="hero-v2__title">
                                <span class="hero-v2__quote">&ldquo;売れる仕組み&rdquo;</span>の課題を、<br>
                                <span class="hero-v2__accent">3分</span>で<span class="hero-v2__accent">可視化</span>。
                            </h2>
                            <p class="hero-v2__lead">GTM成熟度を診断し、<br class="hero-v2__brk">市場・営業・マーケティングの<br class="hero-v2__brk">改善ポイントをレポート化。</p>
                            <a href="#free" class="hero-v2__cta">
                                <span>無料で診断する（約3分で完了）</span>
                                <svg class="hero-v2__cta-arrow" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                        </div>
                    </div>
                    <!-- mobile-only CTA: shown after the images (text → images → CTA) -->
                    <a href="#free" class="hero-v2__cta hero-v2__cta--sp">
                        <span>無料で診断する（約3分で完了）</span>
                        <svg class="hero-v2__cta-arrow" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </section>
                        </div>
                        <!-- Slide 2: existing top view -->
                        <div class="swiper-slide">
                            <div class="bg-banner-01 lg-bg-banner-01  bg-cover bg-no-repeat bg-center mx-auto md:w-full px-1 sm:py-4 max-md:py-[30px] lg:pb-[40px] h-[90vh] max-h-[1024px] lg:min-h-[780px] flex flex-col">
                                <div class="flex flex-1 items-end max-lg:justify-center pb-8 max-lg:text-center lg:text-left lg:justify-start w-full max-w-[1280px] mx-auto lg:px-8">
                                    <div class="w-full text-white">
                                        <h2 class="text-[30px] md:text-[54px] pb-2 mx-auto lg:mx-0 md:w-full leading-tight">「売れない原因」、<br><span class="text-skyBlue">営業だけの問題</span>にしていませんか？</h2>
                                        <h3 class="text-[16px] md:text-[21px] pt-2 mb-[40px] lg:pb-6 lg:py-4">マーケティング・営業・CSの分断を整理し、<br class="hidden sm:block">“売れる仕組み”をGo-to-Market（GTM）戦略から見直しましょう。</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 3: existing top view -->
                        <div class="swiper-slide">
                            <div class="bg-banner-03 lg-bg-banner-03 bg-cover bg-no-repeat bg-center mx-auto md:w-full px-4 sm:py-4 max-md:py-[30px] lg:pb-[40px] h-[90vh] max-h-[1024px] lg:min-h-[780px] flex flex-col">
                                <div class="flex flex-1 items-end max-lg:justify-center pb-8 max-lg:text-center lg:text-left lg:justify-start w-full max-w-[1280px] mx-auto lg:px-8">
                                    <div class="w-full text-white">
                                        <h2 class="text-[30px] md:text-[54px] pb-2 mx-auto lg:mx-0 md:w-full leading-tight">「営業任せ」の成長に、<br><span class="text-skyBlue">限界</span>を感じていませんか？</h2>
                                        <h3 class="text-[16px] md:text-[21px] pt-2 lg:pb-2 lg:py-4">まずは市場・顧客・営業プロセスを整理するところから。<br>課題や成長フェーズに合わせて、貴社にフィットするGTM 戦略を提案いたします。</h3>
                                        <a href="https://timerex.net/s/contact_d1e0_257d/86059caa" target="_blank" class="bg-[#e45b11] hover:bg-orange-600 h-auto inline-block md:w-[320px] px-10 py-4 font-bold text-[20px] my-[20px] mt-3 text-white text-center rounded uppercase">GTM 課題を相談してみる</a>
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
                <h2 class="relative text-center text-blueBrand text-2xl md:text-3xl lg:text-[39px] py-6 lg:py-9 after:content-[''] after:block after:w-20 sm:after:w-28 lg:after:w-36 after:h-[2px] after:bg-blueBrand after:mx-auto after:mt-4 lg:after:mt-8">Go-To-Market <span class="text-black">戦略とは</span></h2>
                <div class="lg:flex justify-center gap-7 py-6">
                    <div class="lg:w-[50%]">
                        <h3 class="lg:text-center text-blueBrand uppercase text-lg mb-3">明確なGo-to-Market戦略を<br class="lg:hidden">持たない米国企業:</h3><img src="<?= asset('assets/images/strategy.webp');?>" loading="lazy" alt="Graph" class="w-[650px] mx-auto max-w-full h-auto">
                    </div>
                    <div class="flex flex-col justify-center text-center lg:text-left leading-tight" id="freeassessment">
                        <p class="font-bold text-darkBlue er text-[102px] md:text-[162px]">84.6%</p>
                        <p class="text-[20px] md:text-[27px] font-poppins text-gray mx-auto lg:mx-0 w-5/6 md:w-sm pl-4 max-lg:text-center lg:text-left">米国企業の84.6%が既に<br>Go-to-Market(GTM)戦略を定義しています。</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-white py-7 sm:py-16 md:py-20 lg:py-24 max-w-7xl w-[90%] lg:w-[82%] mx-auto lg:pb-36">
            <h2 class="relative text-center uppercase text-2xl md:text-[39px] py-9 after:content-[''] after:block after:w-20 lg:after:w-36 after:h-[2px] after:bg-blueBrand after:mx-auto after:mt-4 lg:after:mt-8">こんな<span class="text-blueBrand">課題</span>、<br class="lg:hidden">抱えていませんか？</h2>
            <div class="max-lg:hidden lg:block">
                <div class="mx-auto grid grid-cols-2 sm:grid-cols-1 grid-rows-3 sm:grid-rows-6">
                    <div class="flex flex-col items-start text-left pr-7 pl-0 xl:pl-7 py-11 border-b border-r border-blueBrand space-y-2"><img src="<?= asset('assets/images/icon1.webp');?>" alt="Customer support" class="size-14 ml-7.5 xl:ml-10 mb-3">
                        <h3 class="text-blueBrand uppercase font-bold text-2xl xl:text-[28px] mb-[15px] flex items-start"><span class="w-4 aspect-square border-2 border-blueBrand bg-white rounded-full inline-block mt-1.5 mr-2 mt-2.5 md:mr-4"></span>市場と顧客理解の不足</h3>
                        <div class="leading-snug ml-7 text-black text-[16px] xl:text-[20px]">
                            <p>- 誰に売るべきかが曖昧で、営業の足並みが揃わない</p>
                            <p>- 顧客課題ではなく、自社の売りたい機能だけを訴求</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-start text-left pr-0 xl:pr-7 pl-7 py-11 border-b border-blueBrand space-y-2"><img src="<?= asset('assets/images/icon2.webp');?>" alt="Messages" class="size-14 ml-7.5 xl:ml-10 mb-3">
                        <h3 class="text-blueBrand uppercase font-bold text-2xl xl:text-[28px] mb-[15px] flex items-start"><span class="w-2 lg:w-4 aspect-square border-2 border-blueBrand bg-white rounded-full inline-block mt-1.5 mr-2 mt-2.5 md:mr-4"></span> 差別化ポイントと訴求の明確化</h3>
                        <div class="leading-snug ml-7 text-black text-[16px] xl:text-[20px]">
                            <p>- 他社との違いを伝えられず、価格競争に陥る</p>
                            <p>- 自社の強みを説明しても、相手の印象に残らない</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-start text-left pr-7 pl-0 xl:pl-7 py-11 border-b lg:border-r border-blueBrand space-y-2"><img src="<?= asset('assets/images/icon3.webp');?>" alt="Targeting" class="size-14 ml-7.5 xl:ml-10 mb-3">
                        <h3 class="text-blueBrand uppercase font-bold text-2xl xl:text-[28px] mb-[15px] flex items-start"><span class="w-2 lg:w-4 aspect-square border-2 border-blueBrand bg-white rounded-full inline-block mt-1.5 mr-2 lg:mt-2.5 md:mr-4"></span>ターゲットとポジショニングの曖昧さ</h3>
                        <div class="leading-snug ml-7 text-black text-[16px] xl:text-[20px]">
                            <p>- 誰にでも売ろうとして、結果リソースも分散している</p>
                            <p>- 勝てる市場・勝てる訴求が整理されていない</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-start text-left pr-0 xl:pr-7 pl-7 py-11 border-b border-blueBrand space-y-2"><img src="<?= asset('assets/images/icon4.webp');?>" alt="Channels" class="size-14 ml-7.5 xl:ml-10 mb-3">
                        <h3 class="text-blueBrand uppercase font-bold text-2xl xl:text-[28px] mb-[15px] flex items-start"><span class="w-2 lg:w-4 aspect-square border-2 border-blueBrand bg-white rounded-full inline-block mt-1.5 mr-2 lg:mt-2.5 md:mr-4"></span>マーケ・営業の分断とGTM 設計不足</h3>
                        <div class="leading-snug ml-7 text-black text-[16px] xl:text-[20px]">
                            <p>- マーケと営業が分断され、商談化につながらない</p>
                            <p>- 営業活動が属人的で、再現性が生まれない</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-start text-left pr-7 pl-0 xl:pl-7 py-11 max-lg:border-b lg:border-r border-blueBrand space-y-2"><img src="<?= asset('assets/images/icon5.webp');?>" alt="value proposition" class="size-14 ml-7.5 xl:ml-10 mb-3">
                        <h3 class="text-blueBrand uppercase font-bold text-2xl xl:text-[28px] mb-[15px] flex items-start"><span class="w-2 lg:w-4 aspect-square border-2 border-blueBrand bg-white rounded-full inline-block mt-1.5 mr-2 lg:mt-2.5 md:mr-4"></span>提供価値と顧客ニーズのズレ</h3>
                        <div class="leading-snug ml-7 text-black text-[16px] xl:text-[20px]">
                            <p>- 良い製品・サービスなのに、なぜか売れない</p>
                            <p>- 機能説明に終始し、顧客価値を伝えていない</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-start text-left pr-0 xl:pr-7 pl-7 py-11 border-blueBrand space-y-2"><img src="<?= asset('assets/images/icon6.webp');?>" alt="strategic tuning" class="size-14 ml-7.5 xl:ml-10 mb-3">
                        <h3 class="text-blueBrand uppercase font-bold text-2xl xl:text-[28px] mb-[15px] flex items-start"><span class="w-2 lg:w-4 aspect-square border-2 border-blueBrand bg-white rounded-full inline-block mt-1.5 mr-2 lg:mt-2.5 md:mr-4"></span>戦略不在と数字追求による現場の疲弊</h3>
                        <div class="leading-snug ml-7 text-black text-[16px] xl:text-[20px]">
                            <p>- 目先の数字に追われ、戦略改善にまで手が回らない</p>
                            <p>- 商談数を追うだけで、“売れる仕組み”が改善されない</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:hidden mx-auto">
                <div class="w-full relative">
                    <div class="swiper business-carousel swiper-container">
                        <div class="swiper-wrapper pb-[80px]">
                            <div class="swiper-slide">
                                <div class="flex flex-col items-center text-center py-8 border-b border-blueBrand space-y-2"><img src="<?= asset('assets/images/icon1.webp');?>" alt="Customer support" class="w-[80px] h-[80px] mb-3" onerror='this.src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiByeD0iNCIgZmlsbD0iIzI1NjNlYiIvPgo8dGV4dCB4PSIxNiIgeT0iMjAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0id2hpdGUiPjE8L3RleHQ+Cjwvc3ZnPgo="'>
                                    <h3 class="text-blueBrand uppercase font-bold text-xl mb-[16px]">市場と顧客の理解</h3>
                                    <div class="flex flex-col gap-1.5 leading-snug text-black text-sm">
                                        <p>顧客や競合の把握が甘く、自社の立ち位置が曖昧</p>
                                        <p>自社都合のターゲット設計になっている</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center text-center py-8 border-b border-blueBrand space-y-2"><img src="<?= asset('assets/images/icon2.webp');?>" alt="Messages" class="w-[80px] h-[80px] mb-3" onerror='this.src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiByeD0iNCIgZmlsbD0iIzI1NjNlYiIvPgo8dGV4dCB4PSIxNiIgeT0iMjAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0id2hpdGUiPjI8L3RleHQ+Cjwvc3ZnPgo="'>
                                    <h3 class="text-blueBrand uppercase font-bold text-xl mb-[16px]">差別化ポイントと<br>訴求の明確化</h3>
                                    <div class="flex flex-col gap-1.5 leading-snug text-black text-sm">
                                        <p>他社との違いが伝わらず、価格競争に陥る</p>
                                        <p>強みがぼんやりして、相手の記憶に残らない</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center text-center py-8 border-b border-blueBrand space-y-2"><img src="<?= asset('assets/images/icon3.webp');?>" alt="Targeting" class="w-[80px] h-[80px] mb-3" onerror='this.src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiByeD0iNCIgZmlsbD0iIzI1NjNlYiIvPgo8dGV4dCB4PSIxNiIgeT0iMjAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0id2hpdGUiPjM8L3RleHQ+Cjwvc3ZnPgo="'>
                                    <h3 class="text-blueBrand uppercase font-bold text-xl mb-[16px]">ターゲットと<br>ポジショニングの明確化</h3>
                                    <div class="flex flex-col gap-1.5 leading-snug text-black text-sm">
                                        <p>狙う市場を絞りきれず、社内リソースが分散</p>
                                        <p>自社の強みを活かした勝ちパターンが見えていない</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="flex flex-col items-center text-center py-8 border-b border-blueBrand space-y-2"><img src="<?= asset('assets/images/icon4.webp');?>" alt="Channels" class="w-[80px] h-[80px] mb-3" onerror='this.src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiByeD0iNCIgZmlsbD0iIzI1NjNlYiIvPgo8dGV4dCB4PSIxNiIgeT0iMjAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0id2hpdGUiPjQ8L3RleHQ+Cjwvc3ZnPgo="'>
                                    <h3 class="text-blueBrand uppercase font-bold text-xl mb-[16px]">販売チャネル構築と<br>GTM 戦略設計</h3>
                                    <div class="flex flex-col gap-1.5 leading-snug text-black text-sm">
                                        <p>マーケと営業の連携がうまくいかずチグハグ</p>
                                        <p>営業プロセスが属人的で再現性がない</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center text-center py-8 border-b border-blueBrand space-y-2"><img src="<?= asset('assets/images/icon5.webp');?>" alt="value proposition" class="w-[80px] h-[80px] mb-3" onerror='this.src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiByeD0iNCIgZmlsbD0iIzI1NjNlYiIvPgo8dGV4dCB4PSIxNiIgeT0iMjAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0id2hpdGUiPjU8L3RleHQ+Cjwvc3ZnPgo="'>
                                    <h3 class="text-blueBrand uppercase font-bold text-xl mb-[16px]">サービス設計と<br>提供価値の明確化</h3>
                                    <div class="flex flex-col gap-1.5 leading-snug text-black text-sm">
                                        <p>顧客ニーズを把握しないままサービスを市場に投入</p>
                                        <p>特徴のみで、訴求ポイントがズレた資料を使用</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center text-center py-8 border-b border-blueBrand space-y-2"><img src="<?= asset('assets/images/icon6.webp');?>" alt="strategic tuning" class="w-[80px] h-[80px] mb-3" onerror='this.src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiByeD0iNCIgZmlsbD0iIzI1NjNlYiIvPgo8dGV4dCB4PSIxNiIgeT0iMjAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0id2hpdGUiPjY8L3RleHQ+Cjwvc3ZnPgo="'>
                                    <h3 class="text-blueBrand uppercase font-bold text-xl mb-[16px]">実行・測定・最適化</h3>
                                    <div class="flex flex-col gap-1.5 leading-snug text-black text-sm">
                                        <p>目先の数字ばかり追い、戦略最適化改善ない</p>
                                        <p>商談件数だけこなすだけの動きになりがち</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination bottom-0"></div>
                    </div>
                </div>
                <div class="space-y-0"></div>
            </div>
        </section>
        <section class="bg-[#f2f8fa]">
            <div class="bg-tintedbg lg-bg-tintedbg bg-bottom md:bg-cover bg-no-repeat">
                <div class="py-7 sm:py-16 md:py-20 lg:py-24 max-w-7xl w-[90%] lg:w-[82%] mx-auto lg:pb-36">
                    <div class="mx-auto text-center">
                        <h2 class="relative text-center uppercase text-2xl md:text-[39px] py-9 after:content-[''] after:block after:w-20 lg:after:w-36 after:h-[2px] after:bg-blueBrand after:mx-auto after:mt-4 lg:after:mt-8 text-blueBrand">Go-to-Market戦略<br><span class="text-black">設計の6ステップ</span></h2>
                        <p class="text-center mx-auto text-[14px] md:text-2xl pb-8 text-gray">誰に、何を、どう届ければ売れるのか──<br>GTM 戦略で、“売れる仕組み”を再構築します。</p>
                    </div>
                    <div class="relative mx-auto">
                        <div class="max-lg:hidden lg:block absolute left-1/2 top-[40px] h-[calc(100%-40px)] w-[1px] bg-gray-800 shadow-[inset_1px_0px_1px_#fff] -translate-x-1/2"></div>
                        <div class="space-y-[40px] lg:-space-y-10 lg:px-8">
                            <div class="relative flex items-center lg:flex-row justify-between">
                                <div class="lg:w-[calc(50%-56px)] max-lg:w-full"><span class="block max-lg:text-[48px] lg:text-[60px] font-bold text-steelMist leading-none">01 WHO</span>
                                    <div class="-mt-[20px] relative bg-white px-8 md:px-11 py-8 inline-block text-left w-full">
                                        <div class="flex items-center gap-1"><img class="mr-4 md:mr-[30px] w-9 lg-w-full" src="<?= asset('assets/images/timeline-who.webp');?>" alt="Timeline step - Who">
                                            <h3 class="pt-3 lg:text-2xl text-blueBrand">市場と顧客の理解</h3>
                                        </div>
                                        <p class="mt-3 text-sm md:text-lg text-grayText">本当に狙うべき顧客は誰か？<br>(市場・顧客課題の再定義)</p>
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
                                    <div class="-mt-[20px] relative bg-white px-8 md:px-11 py-8 inline-block text-left w-full">
                                        <div class="flex items-center gap-2"><img class="mr-4 md:mr-[30px] w-9 lg-w-full" src="<?= asset('assets/images/timeline-where.webp');?>" alt="Timeline step - where">
                                            <h3 class="pt-3 lg:text-2xl text-blueBrand">ターゲット戦略の明確化</h3>
                                        </div>
                                        <p class="mt-3 text-sm md:text-lg text-grayText">どの市場なら勝てるのか？<br>(競争優位を築くポジショニング)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="relative flex items-center lg:flex-row max-lg:flex-col justify-between">
                                <div class="lg:w-[calc(50%-56px)] max-lg:w-full"><span class="block max-lg:text-[48px] lg:text-[60px] font-bold text-steelMist leading-none">03 WHAT</span>
                                    <div class="-mt-[20px] relative bg-white px-8 md:px-11 py-8 inline-block text-left w-full">
                                        <div class="flex items-center gap-2"><img class="mr-4 md:mr-[30px] w-9 lg-w-full" src="<?= asset('assets/images/timeline-what.webp');?>" alt="Timeline step - what">
                                            <h3 class="pt-3 lg:text-2xl text-blueBrand">サービス設計・提供価値</h3>
                                        </div>
                                        <p class="mt-3 text-sm md:text-lg text-grayText">顧客が“欲しい”と思う価値は何か？<br>(サービス・価格・提供価値の設計)</p>
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
                                    <div class="-mt-[20px] relative bg-white px-8 md:px-11 py-8 inline-block text-left w-full">
                                        <div class="flex items-center gap-2"><img class="mr-4 md:mr-[30px] w-9 lg-w-full" src="<?= asset('assets/images/timeline-why.webp');?>" alt="Timeline step - why">
                                            <h3 class="pt-3 lg:text-2xl text-blueBrand">価値訴求と差別化</h3>
                                        </div>
                                        <p class="mt-3 text-sm md:text-lg text-grayText">なぜ競合ではなく自社を選ぶのか？<br>(選ばれる理由と独自性の整理)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="relative flex items-center lg:flex-row max-lg:flex-col justify-between">
                                <div class="lg:w-[calc(50%-56px)] max-lg:w-full"><span class="block max-lg:text-[48px] lg:text-[60px] font-bold text-steelMist leading-none">05 HOW</span>
                                    <div class="-mt-[20px] relative bg-white px-8 md:px-11 py-8 inline-block text-left w-full">
                                        <div class="flex items-center gap-2"><img class="mr-4 md:mr-[30px] w-9 lg-w-full" src="<?= asset('assets/images/timeline-how.webp');?>" alt="Timeline step - how">
                                            <h3 class="pt-3 lg:text-2xl text-blueBrand">売上導線の設計</h3>
                                        </div>
                                        <p class="mt-3 text-sm md:text-lg text-grayText">どうすれば継続的に売れるのか？<br>(販売導線・営業プロセス最適化)</p>
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
                                <div class="lg:w-[calc(50%-56px)] max-lg:w-full text-left"><span class="block max-lg:text-[52px] lg:text-[60px] font-bold text-steelMist leading-none">06 WHEN</span>
                                    <div class="-mt-[20px] relative bg-white px-8 md:px-11 py-8 inline-block text-left w-full">
                                        <div class="flex items-center gap-2"><img class="mr-4 md:mr-[30px] w-9 lg-w-full" src="<?= asset('assets/images/timeline-when.webp');?>" alt="Timeline step - when">
                                            <h3 class="pt-3 lg:text-2xl text-blueBrand">計画実行とチューニング</h3>
                                        </div>
                                        <p class="mt-3 text-sm md:text-lg text-grayText">成果につながる実行計画になっているか？<br>(KPI設計・改善サイクル構築)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-8 text-center"><a href="https://timerex.net/s/contact_d1e0_257d/86059caa" target="_blank" class="bg-[#f7722b] hover:bg-orange-500 cursor-pointer transition-colors duration-200 inline-block md:w-[320px] text-[20px] py-4 px-7 text-white uppercase rounded">GTM 課題を相談してみる</a></div>
                </div>
            </div>
        </section>
        <section id="service" class="bg-service lg-bg-service bg-cover">
            <div class="py-7 sm:py-16 md:py-20 lg:py-24 max-w-7xl w-[90%] lg:w-[82%] mx-auto lg:pb-36">
                <h2 class="relative text-center uppercase text-2xl md:text-[39px] py-9 after:content-[''] after:block after:w-20 lg:after:w-36 after:h-[2px] after:bg-[#2BCAFF] after:mx-auto after:mt-4 lg:after:mt-8 text-[#003361]">SERVICE<br><span class="text-white">サービス紹介</span></h2>
                <ul class="flex max-lg:flex-col max-lg:gap-10 lg:gap-6 lg:flex-wrap lg:justify-center pt-8">
                    <li class="bg-white rounded-2xl max-lg:py-4 lg:py-6 max-lg:px-4 lg:px-6 flex flex-col gap-3 lg:w-[30%] h-[260px]">
                        <h3 class="text-[18px] lg:text-[16px] text-blueBrand text-center">GTM 戦略設計</h3>
                        <p class="text-[16px] lg:text-[14px]">ターゲット、提供価値、チャネル、営業プロセスまでを整理し、売上につながるGTM 戦略を一気通貫で設計します。</p>
                    </li>
                    <li class="bg-white rounded-2xl max-lg:py-4 lg:py-6 max-lg:px-4 lg:px-6 flex flex-col gap-3 lg:w-[30%] h-[260px]">
                        <h3 class="text-[18px] lg:text-[16px] text-blueBrand text-center">ターゲット再定義</h3>
                        <p class="text-[16px] lg:text-[14px]">市場・顧客データをもとに、狙うべき顧客像と優先セグメントを明確化します。</p>
                    </li>
                    <li class="bg-white rounded-2xl max-lg:py-4 lg:py-6 max-lg:px-4 lg:px-6 flex flex-col gap-3 lg:w-[30%] h-[260px]">
                        <h3 class="text-[18px] lg:text-[16px] text-blueBrand text-center">価値提案・訴求設計</h3>
                        <p class="text-[16px] lg:text-[14px]">競合ではなく自社が選ばれる理由を整理し、顧客に伝わるメッセージへ落とし込みます。</p>
                    </li>
                    <li class="bg-white rounded-2xl max-lg:py-4 lg:py-6 max-lg:px-4 lg:px-6 flex flex-col gap-3 lg:w-[30%] h-[260px]">
                        <h3 class="text-[18px] lg:text-[16px] text-blueBrand text-center">営業プロセス・チャネル設計</h3>
                        <p class="text-[16px] lg:text-[14px]">インサイド、フィールド、パートナーなどの役割を整理し、商談化から受注までの導線を設計します。</p>
                    </li>
                    <li class="bg-white rounded-2xl max-lg:py-4 lg:py-6 max-lg:px-4 lg:px-6 flex flex-col gap-3 lg:w-[30%] h-[260px]">
                        <h3 class="text-[18px] lg:text-[16px] text-blueBrand text-center">GTM 実行支援・改善</h3>
                        <p class="text-[16px] lg:text-[14px]">月次レビューやKPI改善を通じて、戦略を実行に移し、継続的に成果へつなげます。</p>
                    </li>
                </ul>
            </div>
        </section>
        <section id="free" class="bg-lightBlue py-7 sm:py-16 md:py-20 lg:py-24 lg:pb-36">
            <div class="bg-blueBrand text-white flex max-md:flex-col justify-center items-center gap-4 lg:gap-10 max-w-[890px] w-[90%] lg:w-[82%] mx-auto py-6 px-6 rounded-2xl">
                <div class="w-[84px] shrink-0 flex justify-center"><img src="<?= asset('assets/images/cta.svg');?>" loading="lazy" alt="" class="w-full h-auto"></div>
                <div class="flex flex-col gap-4 w-full max-w-[560px]">
                    <h2 class="flex items-center justify-center gap-2 max-lg:text-[18px] lg:text-[28px] font-bold">GTM 成熟度診断 β版<img src="<?= asset('assets/images/icon-cta.svg')?>" loading="lazy" alt=""></h2>
                    <p class="text-4">貴社のGo-to-Market戦略の成熟度と課題を、3分で可視化。<br>“売れる仕組み”の改善ポイントを無料診断レポートでお届けします。</p>

                    <a href="<?= $redirectUrl;?>" class="bg-[#F2BD2D] hover:bg-[#e0ac1f] px-4 rounded text-center transition-colors duration-200 w-full mx-auto text-black font-bold cta-mobile-btn"><span class="cta-label"><span>無料で診断する</span><span class="cta-break-sp">（約３分で完了）</span></span></a>
                </div>
            </div>
        </section>
        <section class="bg-white py-7 sm:py-16 md:pt-20 lg:py-24 max-w-7xl w-[90%] lg:w-[82%] mx-auto" id="case">
            <h2 class="relative lg:hidden text-center uppercase text-2xl md:text-[39px] py-9 after:content-[''] after:block after:w-20 lg:after:w-36 after:h-[2px] after:bg-blueBrand after:mx-auto after:mt-4 lg:after:mt-8">case <span class="font-bold text-blueBrand">study</span></h2>
            <div class="w-full relative">
                <div class="swiper case-carousel swiper-container">
                    <div class="swiper-wrapper pb-[80px]">
                        <div class="swiper-slide">
                            <div class="flex max-lg:flex-col lg:flex-row items-center justify-between max-lg:gap-5 lg:gap-16">
                                <div class="flex-1">
                                    <h3 class="text-blueBrand pb-7 max-lg:text-[20px] lg:text-[32px] max-lg:text-center"><span class="text-black">外資系SaaS企業様</span></h3>
                                    <div class="max-w-full sm:w-[70%] lg:w-full max-lg:max-w-[580px] m-auto"><a href="<?= BASE_URL;?>/case-study1"><img src="<?= asset('assets/images/case-01.webp');?>" loading="lazy" alt="外資系SaaS企業 ケーススタディ"></a></div>
                                </div>
                                <div class="flex-1">
                                    <p class="max-lg:hidden lg:block relative text-left uppercase text-2xl md:text-[39px] pb-9 after:content-[''] after:block after:w-20 lg:after:w-36 after:h-[2px] after:bg-blueBrand after:mt-4">case <span class="font-bold text-blueBrand">study</span></p>
                                    <h4 class="text-skyBlue max-lg:text-[20px] md:text-[24px] max-lg:text-center font-bold pb-3">法人事業の立ち上げと収益基盤の構築</h4>
                                    <p class="max-lg:text-[16px] lg:text-[20px] text-grayText">属人的な営業から脱却し、ターゲット特化のGTM を設計。<br>立ち上げ初期から仕組み化を進め、再現性ある成長基盤を確立。</p>
                                    <a href="<?= BASE_URL;?>/case-study1" class="inline-block mt-4 text-blueBrand hover:underline">詳細を見る→</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="flex max-lg:flex-col lg:flex-row items-center justify-between max-lg:gap-5 lg:gap-16">
                                <div class="flex-1">
                                    <h3 class="text-blueBrand pb-7 max-lg:text-[20px] lg:text-[32px] max-lg:text-center"><span class="text-black">大手IT企業様</span></h3>
                                    <div class="max-w-full sm:w-[70%] lg:w-full max-lg:max-w-[580px] m-auto"><a href="<?= BASE_URL;?>/case-study2"><img src="<?= asset('assets/images/case-02.webp');?>" loading="lazy" alt="大手IT企業 ケーススタディ"></a></div>
                                </div>
                                <div class="flex-1">
                                    <p class="max-lg:hidden lg:block relative text-left uppercase text-2xl md:text-[39px] pb-9 after:content-[''] after:block after:w-20 lg:after:w-36 after:h-[2px] after:bg-blueBrand after:mt-4">case <span class="font-bold text-blueBrand">study</span></p>
                                    <h4 class="text-skyBlue max-lg:text-[20px] md:text-[24px] max-lg:text-center font-bold pb-3">クラウド事業の再成長に向けたGTM 再設計</h4>
                                    <p class="max-lg:text-[16px] lg:text-[20px] text-grayText">新規受注の停滞要因を整理し、ターゲットと価値訴求を再定義。<br>営業プロセスを再構築し、再現性ある成長モデルへ転換。</p>
                                    <a href="<?= BASE_URL;?>/case-study2" class="inline-block mt-4 text-blueBrand hover:underline">詳細を見る→</a>
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
                    <div class="lg:flex-1 max-lg:w-full font-poppins text-grayText leading-relaxed">
                        <p class="text-[16px] lg:text-[18px]">過去20年間で、営業・マーケティング機能は急速に専門化してきました。<br>インサイドセールス、フィールドセールス、カスタマーサクセス、そして多様化するマーケティング施策──<br><br>一方で、部分最適が進み、<br>組織の分断や数字責任の曖昧さが問題になっています。</p>
                        <ul class="leading-loose text-justify justify-center py-8 text-[15px]">
                            <li class="flex items-center gap-2"><span class="w-4 aspect-square bg-bluedot rounded-full inline-block"></span>戦略だけで終わる“机上設計”にさせない</li>
                            <li class="flex items-center gap-2"><span class="w-4 aspect-square bg-bluedot rounded-full inline-block"></span>現場が疲弊するだけの“実行論”にさせない</li>
                            <li class="flex items-center gap-2"><span class="w-4 aspect-square bg-bluedot rounded-full inline-block"></span>分断された組織を"売れる仕組み"として再設計</li>
                        </ul>
                        <p class="text-[18px]">私たちは現場と経営の両方に向き合いながら、<br class="hidden md:block">成果につながるGo-to-Market戦略を、組織に根づく"自走可能な仕組み"として構築・伴走します。</p>
                    </div>
                    <div class="max-lg:w-full lg:w-[42%] mb-4"><img class="w-full" src="<?= asset('assets/images/aboutUs.webp');?>" alt="About us"></div>
                </div>
            </div>
        </section>
<section class="py-7 sm:py-16 md:py-20 lg:py-24">
 <h2 class="relative text-center text-blueBrand text-2xl md:text-3xl lg:text-[39px] py-6 lg:py-9 after:content-[''] after:block after:w-20 sm:after:w-28 lg:after:w-36 after:h-[2px] after:bg-blueBrand after:mx-auto after:mt-4 lg:after:mt-8">FAQS</h2>

 <div class="w-[95%] sm:w-[85%] lg:w-[82%] max-w-5xl mx-auto px-4 max-lg:space-y-4 lg:space-y-8">

  <div class="w-full"><button class="w-full flex items-center justify-between pl-2 pr-4 sm:px-6 md:px-8 lg:px-10 py-3 lg:py-3 text-left bg-grayBg gap-2 cursor-pointer" aria-expanded="false" aria-controls="acc1" onclick='toggleAccordion("acc1")'>
   <h3 class="flex justify-start items-center space-x-2 flex-1 cursor-pointer" role="region" aria-labelledby="btn-acc1"><span class="flex-none -ml-6 sm:-ml-8 md:-ml-14 text-center leading-[40px] max-md:w-8 max-md:h-8 md:w-14 md:h-14 aspect-square text-white border-4 sm:border-6 md:border-8 border-white bg-blueBrand rounded-full font-semibold flex items-center justify-center">1</span>
   <span class="text-[16px] md:text-lg font-semibold text-blue-900 flex-1">本当に、営業やマーケティングの課題が改善するのでしょうか？</span></h3>
   <svg id="icon-acc1" class="max-md:w-3 max-md:h-3 md:w-6 md:h6 text-blue-900 transform transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
  </button>
   <div id="acc1" class="max-h-0 text-[14px] md:text-[16px] overflow-hidden transition-all duration-500 ease-in-out text-gray-700 bg-white">
    <p class="pt-2">GTM 戦略は、単なる営業改善ではありません。「誰に・何を・どう届けるか」を見直し、マーケティング・営業・提案内容・顧客導線まで一貫して設計します。その結果として、リード獲得数の改善、商談化率の向上、提案内容の整理、部門間の認識ズレ解消などにつながるケースがあります。特に、「施策は増えているのに売上につながらない」という企業で効果を発揮しやすい支援です。</p>
   </div>
  </div>

  <div class="w-full"><button class="w-full flex items-center justify-between pl-2 pr-4 sm:px-6 md:px-8 lg:px-10 py-3 lg:py-3 text-left bg-grayBg gap-2 cursor-pointer" aria-expanded="false" aria-controls="acc2" onclick='toggleAccordion("acc2")'>
   <h3 class="flex justify-start items-center space-x-2 flex-1 cursor-pointer" role="region" aria-labelledby="btn-acc2"><span class="flex-none -ml-6 sm:-ml-8 md:-ml-14 text-center leading-[40px] max-md:w-8 max-md:h-8 md:w-14 md:h-14 aspect-square text-white border-4 sm:border-6 md:border-8 border-white bg-blueBrand rounded-full font-semibold flex items-center justify-center">2</span>
   <span class="text-[16px] md:text-lg font-semibold text-blue-900">GTM 戦略とは、具体的に何をするのでしょうか？</span></h3>
   <svg id="icon-acc2" class="max-md:w-3 max-md:h-3 md:w-6 md:h6 text-blue-900 transform transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
  </button>
   <div id="acc2" class="max-h-0 text-[14px] md:text-[16px] overflow-hidden transition-all duration-500 ease-in-out text-gray-700 bg-white">
    <p class="pt-2">GTM（Go-to-Market）戦略とは、「誰に・何を・どう売るか」を整理し、“売れる仕組み”を設計する考え方です。単なる広告運用や営業代行ではなく、ターゲット設計、訴求整理、提案内容、営業導線、マーケティング施策までを一貫して見直します。新規事業立ち上げだけでなく、既存事業の伸び悩み改善にも活用されています。</p>
   </div>
  </div>

  <div class="w-full"><button class="w-full flex items-center justify-between pl-2 pr-4 sm:px-6 md:px-8 lg:px-10 py-3 lg:py-3 text-left bg-grayBg gap-2 cursor-pointer" aria-expanded="false" aria-controls="acc3" onclick='toggleAccordion("acc3")'>
   <h3 class="flex justify-start items-center space-x-2 flex-1 cursor-pointer" role="region" aria-labelledby="btn-acc3"><span class="flex-none -ml-6 sm:-ml-8 md:-ml-14 text-center leading-[40px] max-md:w-8 max-md:h-8 md:w-14 md:h-14 aspect-square text-white border-4 sm:border-6 md:border-8 border-white bg-blueBrand rounded-full font-semibold flex items-center justify-center">3</span>
   <span class="text-[16px] md:text-lg font-semibold text-blue-900">他のコンサル会社や営業支援と何が違いますか？</span></h3>
   <svg id="icon-acc3" class="max-md:w-3 max-md:h-3 md:w-6 md:h6 text-blue-900 transform transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
  </button>
   <div id="acc3" class="max-h-0 text-[14px] md:text-[16px] overflow-hidden transition-all duration-500 ease-in-out text-gray-700 bg-white">
    <p class="pt-2">戦略提案だけで終わらず、実行フェーズまで伴走する点が特徴です。例えば、営業資料、LP改善、訴求整理、商談導線、コンテンツ設計など、現場レベルまで踏み込んで支援します。また、マーケティングだけ、営業だけではなく、部門横断で“売れる仕組み”全体を見直す点も特徴です。</p>
   </div>
  </div>

  <div class="w-full"><button class="w-full flex items-center justify-between pl-2 pr-4 sm:px-6 md:px-8 lg:px-10 py-3 lg:py-3 text-left bg-grayBg gap-2 cursor-pointer" aria-expanded="false" aria-controls="acc4" onclick='toggleAccordion("acc4")'>
   <h3 class="flex justify-start items-center space-x-2 flex-1 cursor-pointer" role="region" aria-labelledby="btn-acc4"><span class="flex-none -ml-6 sm:-ml-8 md:-ml-14 text-center leading-[40px] max-md:w-8 max-md:h-8 md:w-14 md:h-14 aspect-square text-white border-4 sm:border-6 md:border-8 border-white bg-blueBrand rounded-full font-semibold flex items-center justify-center">4</span>
   <span class="text-[16px] md:text-lg font-semibold text-blue-900">どのような企業から相談が多いですか？</span></h3>
   <svg id="icon-acc4" class="max-md:w-3 max-md:h-3 md:w-6 md:h6 text-blue-900 transform transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
  </button>
   <div id="acc4" class="max-h-0 text-[14px] md:text-[16px] overflow-hidden transition-all duration-500 ease-in-out text-gray-700 bg-white">
    <p class="pt-2">特に多いのは、新規事業を立ち上げたが伸び悩んでいる、リードはあるが商談化しない、営業とマーケの連携が弱い、提案内容が属人化している、サービスの強みが伝わっていないといった課題を抱える企業です。IT・SaaS系が中心ですが、BtoBサービス全般でご相談いただいています。</p>
   </div>
  </div>

  <div class="w-full"><button class="w-full flex items-center justify-between pl-2 pr-4 sm:px-6 md:px-8 lg:px-10 py-3 lg:py-3 text-left bg-grayBg gap-2 cursor-pointer" aria-expanded="false" aria-controls="acc5" onclick='toggleAccordion("acc5")'>
   <h3 class="flex justify-start items-center space-x-2 flex-1 cursor-pointer" role="region" aria-labelledby="btn-acc5"><span class="flex-none -ml-6 sm:-ml-8 md:-ml-14 text-center leading-[40px] max-md:w-8 max-md:h-8 md:w-14 md:h-14 aspect-square text-white border-4 sm:border-6 md:border-8 border-white bg-blueBrand rounded-full font-semibold flex items-center justify-center">5</span>
   <span class="text-[16px] md:text-lg font-semibold text-blue-900">社内にマーケ担当者がいなくても大丈夫ですか？</span></h3>
   <svg id="icon-acc5" class="max-md:w-3 max-md:h-3 md:w-6 md:h6 text-blue-900 transform transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
  </button>
   <div id="acc5" class="max-h-0 text-[14px] md:text-[16px] overflow-hidden transition-all duration-500 ease-in-out text-gray-700 bg-white">
    <p class="pt-2">問題ありません。「マーケ専任がいない」「営業担当が兼務している」という企業からの相談も多くあります。現状の体制に合わせて、無理なく実行できる形で支援内容を設計します。</p>
   </div>
  </div>

  <div class="w-full"><button class="w-full flex items-center justify-between pl-2 pr-4 sm:px-6 md:px-8 lg:px-10 py-3 lg:py-3 text-left bg-grayBg gap-2 cursor-pointer" aria-expanded="false" aria-controls="acc6" onclick='toggleAccordion("acc6")'>
   <h3 class="flex justify-start items-center space-x-2 flex-1 cursor-pointer" role="region" aria-labelledby="btn-acc6"><span class="flex-none -ml-6 sm:-ml-8 md:-ml-14 text-center leading-[40px] max-md:w-8 max-md:h-8 md:w-14 md:h-14 aspect-square text-white border-4 sm:border-6 md:border-8 border-white bg-blueBrand rounded-full font-semibold flex items-center justify-center">6</span>
   <span class="text-[16px] md:text-lg font-semibold text-blue-900">どのくらいの期間で変化が出ますか？</span></h3>
   <svg id="icon-acc6" class="max-md:w-3 max-md:h-3 md:w-6 md:h6 text-blue-900 transform transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
  </button>
   <div id="acc6" class="max-h-0 text-[14px] md:text-[16px] overflow-hidden transition-all duration-500 ease-in-out text-gray-700 bg-white">
    <p class="pt-2">課題によりますが、早ければ1〜2ヶ月程度で、提案内容や商談反応の変化が見え始めるケースがあります。一方で、GTM 戦略は短期施策だけではなく、中長期で“売れる構造”を整える取り組みでもあります。そのため、3〜6ヶ月単位で改善を進めるケースが一般的です。</p>
   </div>
  </div>

  <div class="w-full"><button class="w-full flex items-center justify-between pl-2 pr-4 sm:px-6 md:px-8 lg:px-10 py-3 lg:py-3 text-left bg-grayBg gap-2 cursor-pointer" aria-expanded="false" aria-controls="acc7" onclick='toggleAccordion("acc7")'>
   <h3 class="flex justify-start items-center space-x-2 flex-1 cursor-pointer" role="region" aria-labelledby="btn-acc7"><span class="flex-none -ml-6 sm:-ml-8 md:-ml-14 text-center leading-[40px] max-md:w-8 max-md:h-8 md:w-14 md:h-14 aspect-square text-white border-4 sm:border-6 md:border-8 border-white bg-blueBrand rounded-full font-semibold flex items-center justify-center">7</span>
   <span class="text-[16px] md:text-lg font-semibold text-blue-900">まずは相談だけでも可能ですか？</span></h3>
   <svg id="icon-acc7" class="max-md:w-3 max-md:h-3 md:w-6 md:h6 text-blue-900 transform transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
  </button>
   <div id="acc7" class="max-h-0 text-[14px] md:text-[16px] overflow-hidden transition-all duration-500 ease-in-out text-gray-700 bg-white">
    <p class="pt-2">はい、可能です。現状の課題整理や、「どこにボトルネックがあるのか」を確認する初回相談から対応しています。「まだ依頼するか決まっていない」という段階でも問題ありません。</p>
   </div>
  </div>

 </div>
</section>
      <section class="relative" id="contact">
    <div class="flex max-lg:flex-col lg:flex-row justify-center items-center mx-auto w-full lg:w-[82%] max-w-7xl">
        <div class="relative py-7 sm:py-16 md:py-20 max-lg:w-full lg:w-[50%] mx-auto max-lg:text-center lg:pr-[50px]">
            <span class="font-semibold">CONTACT US</span>
            <h2 class="relative max-lg:text-center lg:text-left text-2xl md:text-3xl lg:text-[39px] pt-2 pb-6 lg:py-9 after:content-[''] after:block after:w-20 sm:after:w-28 lg:after:w-36 after:h-[2px] after:bg-blueBrand max-lg:after:mx-auto after:mt-4 lg:after:mt-8">
                “売れる仕組み”を、<br><span class="font-semibold text-blueBrand">GTM 戦略</span>から見直しませんか？
            </h2>
            <div class="text-lg max-lg:mx-auto text-grayText mt-8">
                <p>新規事業の立ち上げ、<br class="lg:hidden">営業・マーケティングの分断、<br>ブランド再設計や収益基盤の見直し──</p>
                <p class="py-3">貴社のGTM 課題を整理し、<br>次に取るべき戦略をご提案します。</p>
                <a href="https://timerex.net/s/contact_d1e0_257d/86059caa" target="_blank" class="bg-[#f7722b] hover:bg-orange-500 py-3 px-5 font-bold mt-10 max-w-[320px] mb-8 text-white uppercase inline-block rounded">
                    GTM 課題のご相談
                </a>
            </div>
            <img src="<?= asset('assets/images/bg-contact.webp');?>" class="absolute bottom-0 left-0 -z-1 lg:hidden" alt="">
        </div>

        <div class="bg-skyBlueBg max-lg:w-full lg:w-[50%] z-1" id="contact02">
            <div class="w-[95%] sm:w-[85%] mx-auto px-4 max-sm:py-7 md:py-4 lg:py-4">
                <h2 class="text-blueBrand text-2xl md:text-3xl lg:text-[39px] py-6 lg:py-0 font-bold">お問い合わせ</h2>

                <form id="contact-form" class="space-y-4 flex text-grayText text-[16px] flex-col">
                    <input type="hidden" id="lang" name="lang" value="ja">

                    <div>
                        <input id="name" name="name" placeholder="お名前"
                            class="bg-white w-full px-4 max-lg:px-8 py-4 max-lg:py-[26px]">
                        <p id="error-name" class="text-red text-sm mt-1 hidden"></p>
                    </div>

                    <div>
                        <input id="email" name="email" placeholder="メールアドレス"
                            class="bg-white w-full px-4 max-lg:px-8 py-4 max-lg:py-[26px]">
                        <p id="error-email" class="text-red text-sm mt-1 hidden"></p>
                    </div>

                    <div>
                        <textarea id="message" name="message" placeholder="お問い合わせ内容" rows="5"
                                class="resize-none bg-white w-full px-4 max-lg:px-8 py-4 max-lg:py-[26px]"></textarea>
                        <p id="error-message" class="text-red text-sm mt-1 hidden"></p>
                    </div>

                    <div class="py-4 flex flex-col gap-3">
                        <div class="flex items-start gap-2">
                            <input type="checkbox" id="agree-policy" class="mt-1">
                            <label for="agree-policy" class="text-sm">
                                <a href="/privacy-policy/" target="_blank" class="text-blueBrand underline">
                                    プライバシーポリシー
                                </a>
                                に同意します
                            </label>
                        </div>
                        <p id="error-policy" class="text-red text-sm mt-1 hidden"></p>

                        <button
                            type="button"
                            id="submit-btn"
                            class="max-md:text-sm md:text-base text-white bg-blueBrand block
                                max-lg:w-1/2 lg:max-w-[280px] py-3 px-4 text-center rounded"
                        >
                            まずは相談してみる
                        </button>

                        <p id="success-message" class="text-green-600 text-sm hidden">
                            送信が完了しました。ありがとうございました！
                        </p>
                    </div>
                </form>


            </div>
        </div>
    </div>

    <img src="<?= asset('assets/images/bg-contact.webp');?>" class="absolute bottom-0 left-0 -z-1 max-lg:hidden lg:block w-[100vw]" alt="">

    <script>
    document.addEventListener("DOMContentLoaded", () => {

        // ▼ フリーメールドメイン
        const freeDomains = [
            "gmail.com", "yahoo.co.jp", "yahoo.com",
            "outlook.com", "hotmail.com", "live.jp",
            "icloud.com", "me.com"
        ];

        // ▼ name / email / message の通常フィールド
        const inputFields = [
            { id: "name",   error: "error-name" },
            { id: "email",  error: "error-email" },
            { id: "message", error: "error-message" }
        ];

        inputFields.forEach(f => {
            const inputEl = document.getElementById(f.id);
            const errorEl = document.getElementById(f.error);

            if (inputEl && errorEl) {
                inputEl.addEventListener("input", () => {
                    // いったんエラーを消す
                    errorEl.textContent = "";
                    errorEl.classList.add("hidden");

                    // メールは入力中にもフリーメールチェック
                    if (f.id === "email") {
                        const val = inputEl.value.trim();
                        const domain = val.split("@")[1]?.toLowerCase();

                        if (domain && freeDomains.includes(domain)) {
                            errorEl.textContent = "フリーメールはご利用いただけません。";
                            errorEl.classList.remove("hidden");
                        }
                    }
                });
            }
        });

        // ▼ チェックボックス（同意）
        const agreeBox   = document.getElementById("agree-policy");
        const agreeError = document.getElementById("error-policy");

        if (agreeBox && agreeError) {
            agreeBox.addEventListener("change", () => {
                agreeError.textContent = "";
                agreeError.classList.add("hidden");
            });
        }

        // ▼ 送信ボタンイベント
        const submitBtn = document.getElementById("submit-btn");
        if (submitBtn) {
            submitBtn.addEventListener("click", sendForm);
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

    function sendForm() {

        clearErrors();
        document.getElementById("success-message").classList.add("hidden");

        const name   = document.getElementById("name").value.trim();
        const email  = document.getElementById("email").value.trim();
        const message = document.getElementById("message").value.trim();
        const agree  = document.getElementById("agree-policy").checked;

        let hasError = false;

        // ▼ 必須チェック
        if (!name) {
            showError("error-name", "お名前を入力してください。");
            hasError = true;
        }
        if (!email) {
            showError("error-email", "メールアドレスを入力してください。");
            hasError = true;
        }
        if (!message) {
            showError("error-message", "お問い合わせ内容を入力してください。");
            hasError = true;
        }

        // ▼ フリーメール拒否（送信前ダブルチェック）
        if (email) {
            const freeDomains = [
                "gmail.com", "yahoo.co.jp", "yahoo.com",
                "outlook.com", "hotmail.com", "live.jp",
                "icloud.com", "me.com"
            ];
            const emailDomain = email.split("@")[1]?.toLowerCase();
            if (freeDomains.includes(emailDomain)) {
                showError("error-email", "フリーメールはご利用いただけません。");
                hasError = true;
            }
        }

        // ▼ プライバシーポリシー同意
        if (!agree) {
            showError("error-policy", "プライバシーポリシーへの同意が必要です。");
            hasError = true;
        }

        if (hasError) return;

        // ▼ 送信処理
        const btn = document.getElementById("submit-btn");
        btn.disabled = true;
        btn.innerHTML = `<span class="loader mr-2"></span>送信中...`;

        const formData = new FormData();
        formData.append("name", name);
        formData.append("email", email);
        formData.append("message", message);
        formData.append("lang", "ja");

        fetch("<?= BASE_URL;?>/contact/send.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {

            btn.disabled = false;
            btn.innerHTML = "送信";

            if (data.success) {
                document.getElementById("success-message").classList.remove("hidden");
                document.getElementById("contact-form").reset();
            } else {
                showError("error-message", data.message || "送信に失敗しました。");
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = "送信";
            showError("error-message", "通信エラーが発生しました。");
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
</section>

<?php include 'inc/footer.php'; ?>
