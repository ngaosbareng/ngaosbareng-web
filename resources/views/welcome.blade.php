<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 min-h-screen antialiased flex flex-col">

    <header class="sticky top-0 z-50 w-full bg-white/90 dark:bg-gray-950/90 backdrop-blur-md shadow-sm border-b border-gray-200/50 dark:border-gray-800/50">
        @if (Route::has('login'))
            <nav class="max-w-7xl mx-auto px-6 lg:px-8 py-4 flex items-center justify-between">
                <a href="/" class="flex items-center space-x-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C6.5 6.253 3 9.253 3 13.253c0 4 3.5 7 9 7s9-3 9-7c0-4-3.5-7-9-7z">
                        </path>
                    </svg>
                    <span>Ngaos Bareng</span>
                </a>

                <ul class="hidden md:flex items-center space-x-8 text-sm font-medium">
                    <li>
                        <a href="#features"
                            class="text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors duration-200">Fitur</a>
                    </li>
                    <li>
                        <a href="#about"
                            class="text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors duration-200">Tentang</a>
                    </li>
                    <li>
                        <a href="#contact"
                            class="text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors duration-200">Kontak</a>
                    </li>
                </ul>

                <div class="flex items-center space-x-3">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200 shadow-sm">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-900 dark:text-white rounded-lg hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors duration-200">
                            Masuk
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-emerald-600 border border-transparent rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-950 transition-all duration-200 shadow-md shadow-emerald-600/30">
                                Daftar
                            </a>
                        @endif
                    @endauth
                </div>
            </nav>
        @endif
    </header>

    <main class="flex-grow w-full max-w-7xl mx-auto px-6 lg:px-8 py-16 lg:py-24">
        <section id="hero" class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-sm font-semibold text-emerald-600 uppercase tracking-widest mb-3 block">
                    Digitalisasi Pesantren
                </span>
                <h1 class="text-5xl lg:text-6xl font-extrabold mb-5 text-gray-900 dark:text-white leading-tight">
                    Platform Belajar untuk <span class="text-emerald-600">Santri</span> Modern
                </h1>
                <p class="text-xl mb-10 text-gray-600 dark:text-gray-400 leading-relaxed">
                    Perkaya ilmu agamamu kapanpun dan dimanapun. Akses **Kitab Kuning** digital, berdiskusi, dan ikuti ujian pemahaman bersama komunitas santri dari seluruh Nusantara.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center justify-center px-8 py-3 text-lg font-semibold text-white bg-emerald-600 border border-transparent rounded-xl hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-950 transition-all duration-300 shadow-lg shadow-emerald-600/40 transform hover:scale-[1.02]">
                        Mulai Belajar Sekarang
                    </a>
                    <a href="#features"
                        class="inline-flex items-center justify-center px-8 py-3 text-lg font-semibold text-gray-700 dark:text-gray-300 bg-transparent border-2 border-gray-300 dark:border-gray-700 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-300 transform hover:shadow-md">
                        Lihat Fitur
                    </a>
                </div>
            </div>

            <div class="hidden lg:flex justify-center">
                <div class="w-full max-w-md h-80 bg-gray-200 dark:bg-gray-800 rounded-2xl flex items-center justify-center text-gray-500 dark:text-gray-400 border border-dashed border-gray-400 dark:border-gray-600">
                    <span class="text-center p-4">
                        [Placeholder: Illustration/Image of Santri learning]
                    </span>
                </div>
            </div>
        </section>

        <div class="my-20">
            <hr class="border-gray-200 dark:border-gray-800">
        </div>

        <section id="features">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">
                Keunggulan Platform Kami
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-gray-800 transform hover:scale-[1.01]">
                    <svg class="w-10 h-10 text-emerald-600 mb-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C6.5 6.253 3 9.253 3 13.253c0 4 3.5 7 9 7s9-3 9-7c0-4-3.5-7-9-7z">
                        </path>
                    </svg>
                    <h3 class="text-2xl font-semibold mb-3 text-gray-900 dark:text-white">Kitab Digital Pilihan</h3>
                    <p class="text-gray-600 dark:text-gray-400">Akses dan pelajari berbagai kitab kuning dari ulama terkemuka dengan fitur pencarian dan anotasi yang mudah.</p>
                </div>

                <div
                    class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-gray-800 transform hover:scale-[1.01]">
                    <svg class="w-10 h-10 text-emerald-600 mb-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-2xl font-semibold mb-3 text-gray-900 dark:text-white">Ujian & Sertifikasi</h3>
                    <p class="text-gray-600 dark:text-gray-400">Uji pemahamanmu secara berkala dan dapatkan sertifikat yang diakui setelah menyelesaikan modul tertentu.</p>
                </div>

                <div
                    class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-gray-800 transform hover:scale-[1.01]">
                    <svg class="w-10 h-10 text-emerald-600 mb-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    <h3 class="text-2xl font-semibold mb-3 text-gray-900 dark:text-white">Forum Diskusi Aktif</h3>
                    <p class="text-gray-600 dark:text-gray-400">Bergabung dengan forum dan komunitas untuk berdiskusi masail fiqhiyah dengan santri dan asatidz.</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="w-full border-t border-gray-200 dark:border-gray-800 mt-12 py-8">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center text-sm text-gray-500 dark:text-gray-400">
            <p>&copy; {{ date('Y') }} Ngaos Bareng. All rights reserved.</p>
            <p class="mt-1">Dibuat dengan semangat santri untuk kemajuan umat.</p>
        </div>
    </footer>
</body>

</html>