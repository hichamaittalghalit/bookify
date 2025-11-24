@extends('public.layout')

@section('title', 'Payment Disabled - Bookify')

@section('content')
<div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen py-12 flex items-center justify-center">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12 text-center">
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 rounded-full mb-4">
                    <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Payment is Currently Disabled
                </h1>
                <p class="text-lg text-gray-600 mb-8">
                    We're sorry, but payment processing is temporarily unavailable. Please check back later or contact support if you need assistance.
                </p>
            </div>

            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-3">What you can do:</h2>
                <ul class="text-left space-y-2 text-gray-700">
                    <li class="flex items-start">
                        <span class="text-indigo-600 mr-2">•</span>
                        <span>Try again later when payment processing is restored</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-indigo-600 mr-2">•</span>
                        <span>Browse our other available books</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-indigo-600 mr-2">•</span>
                        <span>Contact our support team for assistance</span>
                    </li>
                </ul>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('books.index') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Books
                </a>
                <button onclick="window.history.back()" 
                        class="inline-flex items-center justify-center px-6 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
                    Go Back
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

