@extends('public.layout')

@php
    $siteName = App\Models\Setting::getValue('site_name', config('app.name', 'Bookify'));
@endphp

@section('title', __('pages.faq.title') . ' - ' . $siteName)

@section('content')
<div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                {{ __('pages.faq.title') }}
            </h1>
            <p class="text-xl text-gray-600">
                {{ __('pages.faq.subtitle') }}
            </p>
        </div>

        <div class="space-y-4">
            @foreach(__('pages.faq.questions') as $index => $item)
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    {{ $item['question'] }}
                </h3>
                <p class="text-gray-700 leading-relaxed">
                    {{ $item['answer'] }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

