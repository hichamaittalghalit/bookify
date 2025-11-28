@extends('public.layout')

@php
    $siteName = App\Models\Setting::getValue('site_name', config('app.name', 'Bookify'));
@endphp

@section('title', __('contact.title') . ' - ' . $siteName)

@section('content')
<div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                {{ __('contact.title') }}
            </h1>
            <p class="text-xl text-gray-600">
                {{ __('contact.subtitle') }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8">
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

            <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('contact.name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition outline-none @error('name') border-red-500 @enderror"
                           placeholder="{{ __('contact.name_placeholder') }}">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('contact.email') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition outline-none @error('email') border-red-500 @enderror"
                           placeholder="{{ __('contact.email_placeholder') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="object" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('contact.object') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="object" 
                           name="object" 
                           value="{{ old('object') }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition outline-none @error('object') border-red-500 @enderror"
                           placeholder="{{ __('contact.object_placeholder') }}">
                    @error('object')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('contact.subject') }} <span class="text-red-500">*</span>
                    </label>
                    <textarea id="subject" 
                              name="subject" 
                              rows="6"
                              required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition outline-none @error('subject') border-red-500 @enderror"
                              placeholder="{{ __('contact.subject_placeholder') }}">{{ old('subject') }}</textarea>
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold py-3 px-6 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition transform hover:scale-105 shadow-lg">
                    {{ __('contact.send') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

