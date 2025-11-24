@extends('public.layout')

@section('title', 'Thank You - Bookify')

@section('content')
<div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Message -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12 text-center mb-8">
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-6">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    🎉 {{ __('payment.success') }}
                </h1>
                <p class="text-xl text-gray-600 mb-2">
                    {{ __('payment.thank_you') }} <strong>{{ $order->user->name }}</strong>!
                </p>
                <p class="text-lg text-gray-500">
                    {{ __('payment.check_email') }} <strong>{{ $order->user->email }}</strong>
                </p>
            </div>
        </div>

        <!-- Order Details -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                {{ __('admin.order_details') }}
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Book Information -->
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('admin.book_information') }}</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">{{ __('email.book_title') }}</p>
                            <p class="text-lg font-medium text-gray-900">{{ $order->book->title }}</p>
                        </div>
                        @if($order->book->image)
                        <div>
                            <img src="{{ $order->book->image_url }}" 
                                 alt="{{ $order->book->title }}" 
                                 class="w-32 h-48 object-cover rounded-lg shadow-md">
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Order Information -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('admin.order_summary') }}</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ __('email.order_number') }}:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $order->num }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ __('common.price') }}:</span>
                            <span class="text-sm font-medium text-indigo-600">{{ $order->currency }} {{ number_format($order->price, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ __('common.payment') }}:</span>
                            <span class="text-sm font-medium text-gray-900">PayPal</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ __('admin.date') }}:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $order->created_at->format('F j, Y g:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Email Notice -->
        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6 mb-8">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <div>
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">📧 {{ __('public.check_email') }}</h3>
                    <p class="text-blue-800">
                        {{ __('payment.check_inbox') }} <strong>{{ $order->user->email }}</strong>. 
                        {{ __('payment.check_spam') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('books.index') }}" 
               class="inline-flex items-center justify-center px-8 py-4 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition transform hover:scale-105 shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                {{ __('common.all_books') }}
            </a>
        </div>
    </div>
</div>
@endsection

