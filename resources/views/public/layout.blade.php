<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $siteName = App\Models\Setting::getValue('site_name', config('app.name', 'Bookify'));
        $siteDescription = App\Models\Setting::getValue('site_description', 'Your Digital Bookstore');
    @endphp

    <title>@yield('title', $siteName . ' - ' . $siteDescription)</title>
    <meta name="description" content="@yield('meta_description', $siteDescription)">
    <link rel="sitemap" type="application/xml" href="{{ url('/sitemap.xml') }}">

    @yield('meta_tags')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <script src="{{ asset('tailwindcss.js') }}"></script>

    @stack('styles')

    <!-- Google Analytics -->
    @if(App\Models\Setting::getValue('google_analytics'))
        {!! App\Models\Setting::getValue('google_analytics') !!}
    @endif
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Header Content from Settings -->
    @if(App\Models\Setting::getValue('header_content'))
        <div class="header-content">
            {!! App\Models\Setting::getValue('header_content') !!}
        </div>
    @endif

    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('books.index') }}" class="text-2xl font-bold text-indigo-600 hover:text-indigo-700 transition">
                        📚 {{ $siteName }}
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('contact.index') }}" class="text-gray-700 hover:text-indigo-600 font-medium transition">
                        {{ __('common.contact') }}
                    </a>
                    <a href="{{ route('pages.faq') }}" class="text-gray-700 hover:text-indigo-600 font-medium transition">
                        {{ __('pages.faq.title') }}
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            @if(App\Models\Setting::getValue('footer_content'))
                <div class="footer-content mb-8">
                    {!! App\Models\Setting::getValue('footer_content') !!}
                </div>
            @else
                <div class="text-center mb-8">
                    <h3 class="text-xl font-bold mb-4">📚 {{ $siteName }}</h3>
                    <p class="text-gray-400">{{ $siteDescription }}</p>
                </div>
            @endif
            
            <!-- Legal Pages Links -->
            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="{{ route('pages.faq') }}" class="text-gray-400 hover:text-white transition">
                        {{ __('pages.faq.title') }}
                    </a>
                    <a href="{{ route('pages.legal-notice') }}" class="text-gray-400 hover:text-white transition">
                        {{ __('pages.legal_notice.title') }}
                    </a>
                    <a href="{{ route('pages.terms') }}" class="text-gray-400 hover:text-white transition">
                        {{ __('pages.terms.title') }}
                    </a>
                    <a href="{{ route('pages.privacy') }}" class="text-gray-400 hover:text-white transition">
                        {{ __('pages.privacy.title') }}
                    </a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

