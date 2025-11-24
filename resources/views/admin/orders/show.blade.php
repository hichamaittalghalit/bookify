@extends('admin.layout')

@section('title', __('admin.order_details'))
@section('page-title', __('admin.order_details'))

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-4xl">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('admin.order') }} #{{ $order->num }}</h2>
            <p class="text-gray-600 mt-2">{{ __('admin.created') }}: {{ $order->created_at->format('M d, Y H:i') }}</p>
        </div>
        <span class="px-3 py-1 text-sm font-semibold rounded-full 
            @if($order->status === 'completed') bg-green-100 text-green-800
            @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
            @else bg-red-100 text-red-800
            @endif">
            {{ __('common.' . $order->status) }}
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">{{ __('admin.customer_information') }}</h3>
                <div class="mt-2 space-y-1">
                    <p class="text-gray-900"><strong>{{ __('common.name') }}:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                    <p class="text-gray-900"><strong>{{ __('common.email') }}:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">{{ __('admin.book_information') }}</h3>
                <div class="mt-2 space-y-1">
                    <p class="text-gray-900"><strong>{{ __('common.title') }}:</strong> {{ $order->book->title ?? 'N/A' }}</p>
                    <p class="text-gray-900"><strong>{{ __('common.price') }}:</strong> ${{ number_format($order->price, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">{{ __('admin.payment_information') }}</h3>
                <div class="mt-2 space-y-1">
                    <p class="text-gray-900"><strong>{{ __('admin.paypal_payment_id') }}:</strong> {{ $order->paypal_payment_id ?? 'N/A' }}</p>
                    <p class="text-gray-900"><strong>{{ __('admin.paypal_payer_id') }}:</strong> {{ $order->paypal_payer_id ?? 'N/A' }}</p>
                    <p class="text-gray-900"><strong>{{ __('admin.paypal_account') }}:</strong> {{ $order->paypal->title ?? 'N/A' }}</p>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">{{ __('admin.order_summary') }}</h3>
                <div class="mt-2 space-y-1">
                    <p class="text-gray-900"><strong>{{ __('admin.order_number') }}:</strong> {{ $order->num }}</p>
                    <p class="text-gray-900"><strong>{{ __('admin.amount') }}:</strong> ${{ number_format($order->price, 2) }}</p>
                    <p class="text-gray-900"><strong>{{ __('common.status') }}:</strong> {{ __('common.' . $order->status) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 pt-6 border-t">
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
            {{ __('admin.back_to_orders') }}
        </a>
    </div>
</div>
@endsection

