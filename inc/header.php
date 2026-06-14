<?php

$currentUrl     =    currentUrl();

$pageName       =   getLastUriSegment($currentUrl);
?>
<body class="overflow-x-hidden<?= !empty($isHomeV2) ? ' home-v2' : '' ?>">
    <div class="m-0 p-0 w-screen">
        <div class="relative my-0">
            <?php if (!empty($isHomeV2)): /* Homepage single-row header bar — Figma 案02_ver02 */ ?>
            <header class="home-v2-header">
                <div class="home-v2-header__bar">
                    <h1 class="home-v2-header__logo"><a href="<?= BASE_URL;?>"><img src="<?= asset('assets/images/logo.svg');?>" alt="GO-TO-MARKET STRATEGY"></a></h1>
                    <nav class="home-v2-header__nav">
                        <ul>
                            <li><a href="<?= BASE_URL;?>">ホーム</a></li>
                            <li><a href="<?= BASE_URL;?>/#service">サービス概要</a></li>
                            <li><a href="<?= BASE_URL;?>/#free">GTM成熟度 無料診断</a></li>
                            <li><a href="<?= BASE_URL;?>/#case">ケーススタディ</a></li>
                        </ul>
                    </nav>
                    <div class="home-v2-header__right">
                        <div class="home-v2-header__lang">
                            <a href="/en/" onclick="clearAssessmentStorage()">EN</a>
                            <a href="javascript:void(0)" class="is-active" aria-current="page">JP</a>
                        </div>
                        <a href="<?= BASE_URL;?>/#contact" class="home-v2-header__cta">お問い合わせ</a>
                    </div>
                    <button id="mobile-menu-btn" class="home-v2-header__burger" aria-label="Toggle menu" aria-expanded="false" aria-controls="mobile-menu">
                        <span></span><span></span><span></span>
                    </button>
                </div>
                <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>
                <div id="mobile-menu" class="fixed top-0 left-0 h-full w-64 bg-gray-800 transform -translate-x-full transition-transform duration-300 ease-in-out z-50"><button id="close-menu-btn" class="absolute top-4 right-4 text-white text-2xl focus:outline-none">✕</button>
                    <nav class="flex flex-col py-4">
                        <a href="<?= BASE_URL;?>" class="block px-4 py-3 text-white hover:text-blueText hover:bg-gray-700 transition-all duration-200 border-b border-gray-700">ホーム</a>
                        <a href="<?= BASE_URL;?>/#service" class="block px-4 py-3 text-white hover:text-blueText hover:bg-gray-700 transition-all duration-200 border-b border-gray-700">サービス概要</a>
                        <a href="<?= BASE_URL;?>/#free" class="block px-4 py-3 text-white hover:text-blueText hover:bg-gray-700 transition-all duration-200 border-b border-gray-700">GTM成熟度 無料診断</a>
                        <a href="<?= BASE_URL;?>/#case" class="block px-4 py-3 text-white hover:text-blueText hover:bg-gray-700 transition-all duration-200">ケーススタディ</a>
                        <a href="<?= BASE_URL;?>/#contact" class="bg-blueBrand hover:bg-cyan-900 py-3 px-4 mx-4 mt-4 text-white rounded text-center transition-colors duration-200">お問い合わせ</a>
                    </nav>
                </div>
            </header>
            <?php else: ?>
            <header class="flex flex-col lg:justify-between items-center px-4 sm:px-6 lg:px-8 pt-2 sm:pt-4 text-sm 2xl:text-[17px] md:px-8 w-full max-w-7xl z-1 absolute left-0 right-0 m-auto">
                <div class="flex justify-between w-full py-2 pl-4 pr-[50px] lg:pr-2 bg-white rounded-[44px] md:rounded-[50px] relative">
                    <h1 class="lg:flex-shrink-0 max-lg:w-full flex"><a href="<?= BASE_URL;?>">
                        <img src="<?= asset('assets/images/logo.svg');?>" alt="Logo" class="h-10 lg:h-12 lg:hidden">
                        <img src="<?= asset('assets/images/logo.svg');?>" alt="Logo" class="h-10 lg:h-12 max-lg:hidden"></a></h1>

                    <div class="flex bg-lightBlue rounded-full p-1 gap-0.5 m-auto mr-0">
                        <a href="/en/" onclick="clearAssessmentStorage()" class="px-2 py-1 text-sm rounded-full text-gray-600 hover:bg-gray-200 hover:text-gray-900 transition-all duration-200">EN </a>
                        <a href="javascript:void(0)"  class="px-2 py-1 text-sm font-medium rounded-full bg-blueBrand text-white cursor-default">JP</a>
                    </div>
                    <button id="mobile-menu-btn" class="lg:hidden flex flex-col justify-center absolute right-[16px] top-[11px] items-center w-8 h-8 space-y-1.5 focus:outline-none" aria-label="Toggle menu" aria-expanded="false" aria-controls="mobile-menu">
                        <span class="hamburger-line w-6 h-0.5 bg-blueBrand transition-all duration-300"></span>
                        <span class="hamburger-line w-6 h-0.5 bg-blueBrand transition-all duration-300"></span>
                        <span class="hamburger-line w-6 h-0.5 bg-blueBrand transition-all duration-300"></span>
                    </button>
                </div>
                <div class="flex lg:justify-between items-center w-full px-4">
                    <nav class="hidden lg:flex space-x-4 xl:space-x-7 items-center justify-between w-full pt-2 text-white">
                        <ul class="flex gap-6">
                            <li>
                                <a href="<?= BASE_URL;?>"
                                   class="relative inline-block px-2
                                   <?= ($pageName == 'register' || $pageName=='gtm-assessment') ? 'text-black' : 'hover:text-blueText'; ?>
                                   before:content-[''] before:absolute before:-top-1 before:left-1/2 before:-translate-x-1/2 before:w-4 before:h-[1px] before:bg-blueBrand before:opacity-0 hover:before:opacity-100 before:transition focus:outline-none">
                                    ホーム
                                </a>
                            </li>

                            <li>
                                <a href="<?= BASE_URL;?>/#service"
                                   class="relative inline-block px-2
                                   <?= ($pageName == 'register' || $pageName=='gtm-assessment') ? 'text-black' : 'hover:text-blueText'; ?>
                                   before:content-[''] before:absolute before:-top-1 before:left-1/2 before:-translate-x-1/2 before:w-5 before:h-[1px] before:bg-blueBrand before:opacity-0 hover:before:opacity-100 before:transition focus:outline-none">
                                    サービス概要
                                </a>
                            </li>

                            <li>
                                <a href="<?= BASE_URL;?>/#free"
                                   class="relative inline-block px-2
                                   <?= ($pageName == 'register' || $pageName=='gtm-assessment') ? 'text-black' : 'hover:text-blueText'; ?>
                                   before:content-[''] before:absolute before:-top-1 before:left-1/2 before:-translate-x-1/2 before:w-12 before:h-[1px] before:bg-blueBrand before:opacity-0 hover:before:opacity-100 before:transition focus:outline-none">
                                    GTM成熟度 無料診断
                                </a>
                            </li>
                            <li>
                                <a href="<?= BASE_URL;?>/#case"
                                   class="relative inline-block px-2
                                   <?= ($pageName == 'register' || $pageName=='gtm-assessment') ? 'text-black' : 'hover:text-blueText'; ?>
                                   before:content-[''] before:absolute before:-top-1 before:left-1/2 before:-translate-x-1/2 before:w-8 before:h-[1px] before:bg-blueBrand before:opacity-0 hover:before:opacity-100 before:transition focus:outline-none">
                                    ケーススタディ
                                </a>
                            </li>

                        </ul>
                        <div><a href="<?= BASE_URL;?>/#contact" class="hidden sm:block bg-blueBrand hover:bg-cyan-900 py-5 sm:py-3 px-20 sm:px-20 text-white rounded uppercase text-xs sm:text-sm transition-colors duration-200">お問い合わせ</a></div>
                    </nav>
                    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>
                    <div id="mobile-menu" class="fixed top-0 left-0 h-full w-64 bg-gray-800 transform -translate-x-full transition-transform duration-300 ease-in-out z-50"><button id="close-menu-btn" class="absolute top-4 right-4 text-white text-2xl focus:outline-none">✕</button>
                        <nav class="flex flex-col py-4">
                            <a href="<?= BASE_URL;?>" class="block px-4 py-3 text-white hover:text-blueText hover:bg-gray-700 transition-all duration-200 border-b border-gray-700">ホーム</a>
                            <a href="<?= BASE_URL;?>/#service" class="block px-4 py-3 text-white hover:text-blueText hover:bg-gray-700 transition-all duration-200 border-b border-gray-700">サービス概要</a>
                            <a href="<?= BASE_URL;?>/#free" class="block px-4 py-3 text-white hover:text-blueText hover:bg-gray-700 transition-all duration-200 border-b border-gray-700">GTM成熟度 無料診断</a>
                            <a href="<?= BASE_URL;?>/#case" class="block px-4 py-3 text-white hover:text-blueText hover:bg-gray-700 transition-all duration-200">ケーススタディ</a>
                            <a href="<?= BASE_URL;?>/#contact" class="bg-blueBrand hover:bg-cyan-900 py-3 px-4 mx-4 mt-4 text-white rounded uppercase text-center transition-colors duration-200">お問い合わせ</a></nav>
                    </div>
                </div>
            </header>
            <?php endif; ?>
