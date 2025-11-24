@extends('public.layout')

@php
    $siteName = App\Models\Setting::getValue('site_name', config('app.name', 'Bookify'));
@endphp

@section('title', __('pages.privacy.title') . ' - ' . $siteName)

@section('content')
<div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                {{ __('pages.privacy.title') }}
            </h1>
            <p class="text-xl text-gray-600">
                {{ __('pages.privacy.subtitle') }}
            </p>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('pages.privacy.content.introduction.title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    {{ __('pages.privacy.content.introduction.text') }}
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('pages.privacy.content.data_collection.title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    {{ __('pages.privacy.content.data_collection.text') }}
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('pages.privacy.content.data_use.title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    {{ __('pages.privacy.content.data_use.text') }}
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('pages.privacy.content.data_storage.title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    {{ __('pages.privacy.content.data_storage.text') }}
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('pages.privacy.content.your_rights.title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    {{ __('pages.privacy.content.your_rights.text') }}
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('pages.privacy.content.cookies.title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    {{ __('pages.privacy.content.cookies.text') }}
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('pages.privacy.content.contact.title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    {{ __('pages.privacy.content.contact.text') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

