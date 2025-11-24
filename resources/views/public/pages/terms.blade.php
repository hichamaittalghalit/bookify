@extends('public.layout')

@php
    $siteName = App\Models\Setting::getValue('site_name', config('app.name', 'Bookify'));
@endphp

@section('title', __('pages.terms.title') . ' - ' . $siteName)

@section('content')
<div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                {{ __('pages.terms.title') }}
            </h1>
            <p class="text-xl text-gray-600">
                {{ __('pages.terms.subtitle') }}
            </p>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('pages.terms.content.acceptance.title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    {{ __('pages.terms.content.acceptance.text') }}
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('pages.terms.content.products.title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    {{ __('pages.terms.content.products.text') }}
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('pages.terms.content.pricing.title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    {{ __('pages.terms.content.pricing.text') }}
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('pages.terms.content.payment.title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    {{ __('pages.terms.content.payment.text') }}
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('pages.terms.content.delivery.title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    {{ __('pages.terms.content.delivery.text') }}
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __('pages.terms.content.copyright.title') }}
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    {{ __('pages.terms.content.copyright.text') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

