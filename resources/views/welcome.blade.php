<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RWA Pay - Jembatan Gateway Pembayaran QRIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ocean: {
                            light: '#00a8e8',
                            DEFAULT: '#0077b6',
                            dark: '#003d5b',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .hero-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#0077b6 0.5px, transparent 0.5px), radial-gradient(#0077b6 0.5px, #f8fafc 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            background-attachment: fixed;
            opacity: 0.05;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <!-- Background Pattern -->
    <div class="hero-pattern fixed inset-0 z-0"></div>

    <!-- Content Container -->
    <div class="relative z-10">
        <!-- Navigation -->
        <nav class="bg-orange-400 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-center h-auto">
                    <p class="py-2 text-white"><b>Info!</b> ini adalah project pribadi, dan tidak akan dijual perbelikan
                        ataupun
                        dikomersilkan.
                    </p>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="sm:hidden absolute right-0 top-0 flex items-center pr-2 sm:static sm:inset-auto">
                <button type="button" id="mobile-menu-button"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-ocean hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-ocean">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </nav>

        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center">
                            <svg class="h-8 w-8 text-ocean" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M4 15h16c0.55 0 1-0.45 1-1V4c0-0.55-0.45-1-1-1H4C3.45 3 3 3.45 3 4v10C3 14.55 3.45 15 4 15zM4 21h16c0.55 0 1-0.45 1-1v-2c0-0.55-0.45-1-1-1H4c-0.55 0-1 0.45-1 1v2C3 20.55 3.45 21 4 21z">
                                </path>
                            </svg>
                            <span class="ml-2 text-xl font-bold text-ocean">RWA Pay</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="/" class="text-sm text-gray-600 hover:text-ocean transition">Beranda</a>
                        <a href="/#fitur" class="text-sm text-gray-600 hover:text-ocean transition">Fitur</a>
                        <a href="https://rwa-pay.apidog.io" target="_blank"
                            class="text-sm text-gray-600 hover:text-ocean transition">Dokumentasi API</a>
                        <a href="/admin"
                            class="ml-4 px-4 py-2 rounded-md text-sm font-medium text-white bg-ocean hover:bg-ocean-dark transition">Login</a>
                    </div>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="sm:hidden absolute right-0 top-0 flex items-center pr-2 sm:static sm:inset-auto">
                <button type="button" id="mobile-menu-button"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-ocean hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-ocean">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Mobile menu, show/hide based on menu state -->
        <div id="mobile-menu" class="sm:hidden hidden bg-white shadow-md">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-ocean hover:bg-gray-50">Beranda</a>
                <a href="/#fitur"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-ocean hover:bg-gray-50">Fitur</a>
                <a href="https://rwa-pay.apidog.io" target="_blank"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-ocean hover:bg-gray-50">Dokumentasi
                    API</a>
                <a href="/admin"
                    class="block px-3 py-2 rounded-md text-base font-medium text-white bg-ocean hover:bg-ocean-dark">Login</a>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="relative bg-white overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                    <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2"
                        fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <polygon points="50,0 100,0 50,100 0,100" />
                    </svg>

                    <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                        <div class="sm:text-center lg:text-left">
                            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                                <span class="block">RWA Pay</span>
                                <span class="block text-ocean">Jembatan Gateway Pembayaran QRIS</span>
                            </h1>
                            <p
                                class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                Solusi pembayaran digital yang aman, cepat, dan terpercaya untuk bisnis Anda.
                                Integrasikan QRIS dengan mudah dan tingkatkan pengalaman transaksi pelanggan Anda.
                            </p>
                            <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                <div class="rounded-md shadow">
                                    <a href="/admin"
                                        class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-ocean hover:bg-ocean-dark md:py-4 md:text-lg md:px-10">
                                        Mulai Sekarang
                                    </a>
                                </div>
                                <div class="mt-3 sm:mt-0 sm:ml-3">
                                    <a href="https://rwa-pay.apidog.io" target="_blank"
                                        class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-ocean bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                                        Dokumentasi API
                                    </a>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
            <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
                <div class="h-56 w-full bg-ocean sm:h-72 md:h-96 lg:w-full lg:h-full flex items-center justify-center">
                    <svg class="w-1/2 h-1/2 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-12 bg-white" id="fitur">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-ocean font-semibold tracking-wide uppercase">Fitur Utama</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Solusi Pembayaran Digital Terpadu
                    </p>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                        RWA Pay menyediakan berbagai fitur untuk memudahkan transaksi pembayaran digital Anda.
                    </p>
                </div>

                <div class="mt-10">
                    <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                        <div class="relative">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-ocean text-white">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Keamanan Terjamin</p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                Transaksi aman dengan enkripsi end-to-end dan kepatuhan terhadap standar keamanan
                                industri.
                            </dd>
                        </div>

                        <div class="relative">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-ocean text-white">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Integrasi Cepat</p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                Implementasi mudah dengan API yang komprehensif dan dokumentasi lengkap.
                            </dd>
                        </div>

                        <div class="relative">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-ocean text-white">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Laporan Real-time</p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                Pantau transaksi dan analisis bisnis Anda secara real-time dengan dashboard yang
                                intuitif.
                            </dd>
                        </div>

                        <div class="relative">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-ocean text-white">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                    </svg>
                                </div>
                                <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Biaya Kompetitif</p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                Nikmati biaya transaksi yang transparan dan kompetitif tanpa biaya tersembunyi.
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-ocean">
            <div
                class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
                <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    <span class="block">Siap untuk memulai?</span>
                    <span class="block text-blue-100">Daftar sekarang dan tingkatkan bisnis Anda.</span>
                </h2>
                <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                    <div class="inline-flex rounded-md shadow">
                        <a href="#"
                            class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-ocean bg-white hover:bg-blue-50">
                            Daftar Sekarang
                        </a>
                    </div>
                    <div class="ml-3 inline-flex rounded-md shadow">
                        <a href="#"
                            class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 md:flex md:items-center md:justify-between lg:px-8">
                <div class="flex justify-center space-x-6 md:order-2">
                    <a href="https://rwa-pay.apidog.io" target="_blank" class="text-gray-500 hover:text-ocean">
                        <span class="sr-only">Dokumentasi API</span>
                        <span class="text-sm">Dokumentasi API</span>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-ocean">
                        <span class="sr-only">Kebijakan Privasi</span>
                        <span class="text-sm">Kebijakan Privasi</span>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-ocean">
                        <span class="sr-only">Syarat & Ketentuan</span>
                        <span class="text-sm">Syarat & Ketentuan</span>
                    </a>
                </div>
                <div class="mt-8 md:mt-0 md:order-1">
                    <p class="text-center text-base text-gray-500">
                        &copy; 2025-{{ date('Y') }} RWA Pay
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>

</html>
