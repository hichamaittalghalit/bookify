<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Bookify</title>
    <script src="{{ asset('tailwindcss.js') }}"></script>
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-indigo-900 text-white fixed h-screen flex flex-col">
            <div class="p-6 flex-shrink-0">
                <h1 class="text-2xl font-bold mb-8">Bookify Admin</h1>
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-indigo-800 transition {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-800' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        {{ __('admin.dashboard') }}
                    </a>
                    <a href="{{ route('admin.books.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-indigo-800 transition {{ request()->routeIs('admin.books.*') ? 'bg-indigo-800' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        {{ __('common.books') }}
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-indigo-800 transition {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-800' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        {{ __('admin.orders') }}
                    </a>
                    <a href="{{ route('admin.paypals.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-indigo-800 transition {{ request()->routeIs('admin.paypals.*') ? 'bg-indigo-800' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        {{ __('admin.paypal_management') }}
                    </a>
                    <a href="{{ route('admin.contacts.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-indigo-800 transition {{ request()->routeIs('admin.contacts.*') ? 'bg-indigo-800' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ __('admin.contacts') }}
                    </a>
                    <a href="{{ route('admin.contacts.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-indigo-800 transition {{ request()->routeIs('admin.contacts.*') ? 'bg-indigo-800' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ __('admin.contacts') }}
                    </a>
                    <a href="{{ route('admin.smtps.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-indigo-800 transition {{ request()->routeIs('admin.smtps.*') ? 'bg-indigo-800' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ __('admin.smtps') }}
                    </a>
                    <a href="{{ route('admin.smtps.emails.all') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-indigo-800 transition {{ request()->routeIs('admin.smtps.emails.*') ? 'bg-indigo-800' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        {{ __('admin.all_received_emails') }}
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-indigo-800 transition {{ request()->routeIs('admin.settings.*') ? 'bg-indigo-800' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ __('admin.settings') }}
                    </a>
                    <a href="{{ route('admin.profile.edit') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-indigo-800 transition {{ request()->routeIs('admin.profile.*') ? 'bg-indigo-800' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ __('admin.profile') }}
                    </a>
                </nav>
            </div>
            <div class="p-6 border-t border-indigo-800 mt-auto flex-shrink-0">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 rounded-lg hover:bg-indigo-800 transition text-red-300">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        {{ __('common.logout') }}
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b">
                <div class="px-6 py-4 flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Welcome, {{ Auth::user()->name }}</span>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="p-6">
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-4">
                        <p class="text-green-800 text-sm font-medium">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                        <p class="text-red-800 text-sm font-medium">{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
    @stack('scripts')
</body>
</html>

