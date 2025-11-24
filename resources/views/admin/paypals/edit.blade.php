@extends('admin.layout')

@section('title', 'Edit PayPal Account')
@section('page-title', 'Edit PayPal Account')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-4xl">
    <form action="{{ route('admin.paypals.update', $paypal->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $paypal->title) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                <input type="email" id="email" name="email" value="{{ old('email', $paypal->email) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="flex items-center mt-8">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $paypal->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-700">Active</span>
                </label>
            </div>

            <div class="md:col-span-2 border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Test Credentials (Sandbox)</h3>
            </div>

            <div>
                <label for="test_client_id" class="block text-sm font-medium text-gray-700 mb-2">Test Client ID *</label>
                <input type="text" id="test_client_id" name="test_client_id" value="{{ old('test_client_id', $paypal->test_client_id) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('test_client_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="test_secret_key" class="block text-sm font-medium text-gray-700 mb-2">Test Secret Key *</label>
                <input type="text" id="test_secret_key" name="test_secret_key" value="{{ old('test_secret_key', $paypal->test_secret_key) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('test_secret_key')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2 border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Live Credentials (Production)</h3>
            </div>

            <div>
                <label for="live_client_id" class="block text-sm font-medium text-gray-700 mb-2">Live Client ID</label>
                <input type="text" id="live_client_id" name="live_client_id" value="{{ old('live_client_id', $paypal->live_client_id) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('live_client_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="live_secret_key" class="block text-sm font-medium text-gray-700 mb-2">Live Secret Key</label>
                <input type="text" id="live_secret_key" name="live_secret_key" value="{{ old('live_secret_key', $paypal->live_secret_key) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('live_secret_key')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end space-x-4 pt-6 border-t">
            <a href="{{ route('admin.paypals.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Update PayPal Account
            </button>
        </div>
    </form>
</div>
@endsection

