<?php

$currentUrl     =    currentUrl();

$pageName       =   getLastUriSegment($currentUrl);;
?>
<body class="overflow-x-hidden<?= !empty($isHomeV2) ? ' home-v2' : '' ?>">
    <div class="m-0 p-0 w-screen">
        <div class="relative my-0">
            <?php if (!empty($isHomeV2)): /* Homepage single-row header bar — Figma 案02_ver02 */ ?>
            <header class="home-v2-header">
                <div class="home-v2-header__bar">
                    <div class="home-v2-header__left">
                        <h1 class="home-v2-header__logo"><a href="<?= BASE_URL;?>/en/"><img src="<?= BASE_URL;?>/assets/images/logo.svg" alt="GO-TO-MARKET STRATEGY"></a></h1>
                        <nav class="home-v2-header__nav">
                            <ul>
                                <li><a href="<?= BASE_URL;?>/en/">Home</a></li>
                                <li><a href="<?= BASE_URL;?>/en/#service">Our Services</a></li>
                                <li><a href="<?= BASE_URL;?>/en/#free">Free GTM Assessment</a></li>
                                <li><a href="<?= BASE_URL;?>/en/#case">Case Study</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="home-v2-header__right">
                        <div class="home-v2-header__lang">
                            <a href="javascript:void(0)" class="is-active" aria-current="page">EN</a>
                            <a href="/" onclick="clearAssessmentStorage()">JP</a>
                        </div>
                        <a href="<?= BASE_URL;?>/en/#contact" class="home-v2-header__cta">CONTACT US</a>
                    </div>
                    <button id="mobile-menu-btn" class="home-v2-header__burger" aria-label="Toggle menu" aria-expanded="false" aria-controls="mobile-menu">
                        <span></span><span></span><span></span>
                    </button>
                </div>
                <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>
                <div id="mobile-menu" class="fixed top-0 left-0 h-full w-64 bg-gray-800 transform -translate-x-full transition-transform duration-300 ease-in-out z-50"><button id="close-menu-btn" class="absolute top-4 right-4 text-white text-2xl focus:outline-none">✕</button>
                    <nav class="flex flex-col py-4"><a href="/en/" class="block px-4 py-3 text-white hover:text-blueText hover:bg-gray-700 transition-all duration-200 border-b border-gray-700">Home</a><a href="/en/#service" class="block px-4 py-3 text-white hover:text-blueText hover:bg-gray-700 transition-all duration-200 border-b border-gray-700">Our Services</a><a href="/en/#free" class="block px-4 py-3 text-white hover:text-blueText hover:bg-gray-700 transition-all duration-200 border-b border-gray-700">Free GTM Assessment</a><a href="/en/#case" class="block px-4 py-3 text-white hover:text-blueText hover:bg-gray-700 transition-all duration-200">Case Study</a> <a href="/en/#contact" class="bg-blueBrand hover:bg-greendot py-3 px-4 mx-4 mt-4 font-bold text-white rounded uppercase text-center transition-colors duration-200">Contact Us</a></nav>
                </div>
            </header>
            <?php else: ?>
            <header class="flex flex-col lg:justify-between items-center px-4 sm:px-6 lg:px-8 pt-2 sm:pt-4 text-sm md:px-8 w-full max-w-7xl z-1 absolute left-0 right-0 m-auto">
                <div class="flex justify-between w-full py-2 pl-4 pr-[50px] lg:pr-2 bg-white rounded-[44px] md:rounded-[50px] relative">
                    <div class="lg:flex-shrink-0 max-lg:w-full flex">
                        <a href="<?= BASE_URL;?>/en/">
                        <img src="<?= BASE_URL;?>/assets/images/logo.svg" alt="Logo" class="h-10 lg:h-12 lg:hidden">
                        <img src="<?= BASE_URL;?>/assets/images/logo.svg" alt="Logo" class="h-10 lg:h-12 max-lg:hidden">
                        </a>
                    </div>
                    <div class="flex bg-lightBlue rounded-full p-1 gap-0.5 m-auto mr-0">
                        <a href="javascript:void(0)" class="px-2 py-1 text-sm font-medium rounded-full bg-blueBrand text-white cursor-default">EN </a>
                        <a href="/" onclick="clearAssessmentStorage()" class="px-2 py-1 text-sm font-semibold rounded-full text-gray-600 hover:bg-gray-200 hover:text-gray-900 transition-all duration-200">JP</a>
                    </div>

                        <button id="mobile-menu-btn" class="lg:hidden flex flex-col justify-center absolute right-[16px] top-[11px] items-center w-8 h-8 space-y-1.5 focus:outline-none" aria-label="Toggle menu" aria-expanded="false" aria-controls="mobile-menu"><span class="hamburger-line w-6 h-0.5 bg-blueBrand transition-all duration-300"></span> <span class="hamburger-line w-6 h-0.5 bg-blueBrand transition-all duration-300"></span> <span class="hamburger-line w-6 h-0.5 bg-blueBrand transition-all duration-300"></span></button>
                </div>
                <div class="flex lg:justify-between items-center w-full px-4">
                    <nav class="hidden lg:flex space-x-4 xl:space-x-7 items-center justify-between w-full pt-2 text-white font-bold">
                        <ul class="flex gap-6">

                            <li>
                                <a href="<?= BASE_URL;?>/en/"
                                   class="relative inline-block px-2
                                   <?= ($pageName == 'register'  || $pageName=='gtm-assessment') ? 'text-black' : 'hover:text-blueText'; ?>
                                   before:content-[''] before:absolute before:-top-1 before:left-1/2 before:-translate-x-1/2 before:w-4 before:h-[1px] before:bg-blueBrand before:opacity-0 hover:before:opacity-100 before:transition focus:outline-none">
                                   Home
                                </a>
                            </li>

                            <li>
                                <a href="<?= BASE_URL;?>/en/#service"
                                   class="relative inline-block px-2
                                   <?= ($pageName == 'register'  || $pageName=='gtm-assessment') ? 'text-black' : 'hover:text-blueText'; ?>
                                   before:content-[''] before:absolute before:-top-1 before:left-1/2 before:-translate-x-1/2 before:w-5 before:h-[1px] before:bg-blueBrand before:opacity-0 hover:before:opacity-100 before:transition focus:outline-none">
                                    Our Services
                                </a>
                            </li>

                            <li>
                                <a href="<?= BASE_URL;?>/en/#free"
                                   class="relative inline-block px-2
                                   <?= ($pageName == 'register'  || $pageName=='gtm-assessment') ? 'text-black' : 'hover:text-blueText'; ?>
                                   before:content-[''] before:absolute before:-top-1 before:left-1/2 before:-translate-x-1/2 before:w-12 before:h-[1px] before:bg-blueBrand before:opacity-0 hover:before:opacity-100 before:transition focus:outline-none">
                                    Free GTM Assessment
                                </a>
                            </li>
                            <li>
                                <a href="<?= BASE_URL;?>/en/#case"
                                   class="relative inline-block px-2
                                   <?= ($pageName == 'register'  || $pageName=='gtm-assessment') ? 'text-black' : 'hover:text-blueText'; ?>
                                   before:content-[''] before:absolute before:-top-1 before:left-1/2 before:-translate-x-1/2 before:w-6 before:h-[1px] before:bg-blueBrand before:opacity-0 hover:before:opacity-100 before:transition focus:outline-none">
                                    Case Study
                                </a>
                            </li>
                        </ul>
                        <div><a href="#contact" class="hidden sm:block bg-blueBrand hover:bg-cyan-900 py-5 sm:py-3 px-20 sm:px-20 font-bold text-white rounded uppercase max-xl:text-xs xl:text-sm transition-colors duration-200">Contact Us</a></div>
                    </nav>
                    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>
                    <div id="mobile-menu" class="fixed top-0 left-0 h-full w-64 bg-gray-800 transform -translate-x-full transition-transform duration-300 ease-in-out z-50"><button id="close-menu-btn" class="absolute top-4 right-4 text-white text-2xl focus:outline-none">✕</button>
                        <nav class="flex flex-col py-4"><a href="/en/" class="block px-4 py-3 text-white hover:text-blueText hover:bg-gray-700 transition-all duration-200 border-b border-gray-700">Home</a><a href="/en/#service" class="block px-4 py-3 text-white hover:text-blueText hover:bg-gray-700 transition-all duration-200 border-b border-gray-700">Our Services</a><a href="/en/#free" class="block px-4 py-3 text-white hover:text-blueText hover:bg-gray-700 transition-all duration-200 border-b border-gray-700">Free GTM Assessment</a><a href="/en/#case" class="block px-4 py-3 text-white hover:text-blueText hover:bg-gray-700 transition-all duration-200">Case Study</a> <a href="/en/#contact" class="bg-blueBrand hover:bg-greendot py-3 px-4 mx-4 mt-4 font-bold text-white rounded uppercase text-center transition-colors duration-200">Contact Us</a></nav>
                    </div>
                </div>
            </header>
            <?php endif; ?>
