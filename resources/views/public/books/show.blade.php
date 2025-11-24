@extends('public.layout')

@php
    $siteName = App\Models\Setting::getValue('site_name', config('app.name', 'Bookify'));
    $seoTitle = $book->seo_title ?: $book->title;
    $seoDescription = $book->seo_description ?: \Illuminate\Support\Str::limit(strip_tags($book->description), 160);
@endphp

@section('title', $seoTitle . ' - ' . $siteName)
@section('meta_description', $seoDescription)

@section('meta_tags')
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:image" content="{{ $book->image_url }}">
    <meta property="og:type" content="book">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $book->image_url }}">
@endsection

@section('content')
<div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-4">
                <p class="text-green-800 text-sm font-medium">
                    {{ session('success') }}
                </p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                <p class="text-red-800 text-sm font-medium">
                    {{ session('error') }}
                </p>
            </div>
        @endif

        <!-- Back Button -->
        <a href="{{ route('books.index') }}" 
           class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium mb-8 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            {{ __('common.back_to_books') }}
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Book Image and Info -->
            <div>
                <div class="bg-gradient-to-br from-indigo-400 to-purple-500 rounded-2xl shadow-2xl mb-8 relative overflow-hidden">
                    <img src="{{ $book->image_url }}" 
                         alt="{{ $book->title }}" 
                         class="w-full h-auto object-cover rounded-2xl">
                    
                    <!-- Badges -->
                    <div class="absolute top-6 left-6 flex flex-row gap-2 z-10">
                        @if($book->is_new)
                            <span class="bg-green-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg whitespace-nowrap">
                                {{ __('common.new') }}
                            </span>
                        @endif
                        @if($book->is_best_seller)
                            <span class="bg-red-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg whitespace-nowrap">
                                🔥 {{ __('common.bestseller') }}
                            </span>
                        @endif
                    </div>
                    @if($book->is_featured)
                        <span class="absolute top-6 right-6 bg-yellow-400 text-yellow-900 text-sm font-bold px-4 py-2 rounded-full shadow-lg z-10 whitespace-nowrap">
                            ⭐ {{ __('common.featured') }}
                        </span>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $book->title }}</h1>
                    
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-indigo-600">{{ $book->currency }} {{ number_format($book->price, 2) }}</span>
                    </div>

                    <div class="prose max-w-none">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ __('common.description') }}</h3>
                        <div class="text-gray-700 leading-relaxed">
                            {!! $book->description !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Purchase Form -->
            <div>
                <div class="bg-white rounded-2xl shadow-2xl p-8 sticky top-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('public.purchase_this_book') }}</h2>
                    
                    @if(!$paypal || !$paypal->is_active)
                        <!-- Payment Disabled Message -->
                        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-6 mb-6">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-red-600 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <h3 class="text-lg font-semibold text-red-900 mb-2">{{ __('public.payment_disabled') }}</h3>
                                    <p class="text-red-800">
                                        {{ __('public.payment_unavailable') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <form id="purchaseForm" action="{{ route('payment.initiate') }}" method="POST" class="space-y-6" @if(!$paypal || !$paypal->is_active) style="opacity: 0.5; pointer-events: none;" @endif>
                        @csrf
                        
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('public.full_name') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition outline-none"
                                   placeholder="John Doe">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('public.email_address') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition outline-none"
                                   placeholder="john@example.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Book Info (Hidden) -->
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <input type="hidden" name="book_price" value="{{ $book->price }}">

                        <!-- Price Summary -->
                        <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                            <div class="flex justify-between text-gray-700">
                                <span>{{ __('public.book') }}:</span>
                                <span class="font-medium">{{ $book->title }}</span>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <span>{{ __('common.price') }}:</span>
                                <span class="font-medium">{{ $book->currency }} {{ number_format($book->price, 2) }}</span>
                            </div>
                            <div class="border-t border-gray-300 pt-2 flex justify-between text-lg font-bold text-gray-900">
                                <span>{{ __('public.total') }}:</span>
                                <span class="text-indigo-600">{{ $book->currency }} {{ number_format($book->price, 2) }}</span>
                            </div>
                        </div>

                        @if($paypal && $paypal->is_active)
                            <!-- Buy Button -->
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold py-4 px-6 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition transform hover:scale-105 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed mt-6">
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                    </svg>
                                    {{ __('common.pay_with_paypal') }}
                                </span>
                            </button>
                        @else
                            <div class="pt-4 text-center">
                                <p class="text-gray-500 text-sm">{{ __('public.payment_unavailable_message') }}</p>
                            </div>
                        @endif

                        <!-- Security Notice -->
                        <p class="text-xs text-gray-500 text-center pt-4">
                            🔒 Secure payment powered by PayPal. Your information is safe and encrypted.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

