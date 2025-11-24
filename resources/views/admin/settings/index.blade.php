@extends('admin.layout')

@section('title', __('admin.settings'))
@section('page-title', __('admin.settings_management'))

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-4xl">
    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- General Settings -->
            <div class="border-b pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('admin.general_settings') }}</h3>
                <div class="space-y-4">
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.site_name') }}</label>
                        <input type="text" 
                               id="site_name" 
                               name="site_name" 
                               value="{{ old('site_name', App\Models\Setting::getValue('site_name', config('app.name'))) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="site_email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.site_email') }}</label>
                        <input type="email" 
                               id="site_email" 
                               name="site_email" 
                               value="{{ old('site_email', App\Models\Setting::getValue('site_email', '')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="site_description" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.site_description') }}</label>
                        <textarea id="site_description" 
                                  name="site_description" 
                                  rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('site_description', App\Models\Setting::getValue('site_description', '')) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Google Analytics -->
            <div class="border-b pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('admin.google_analytics') }}</h3>
                <div>
                    <label for="google_analytics" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.google_analytics_code') }}</label>
                    <textarea id="google_analytics" 
                              name="google_analytics" 
                              rows="5"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-mono text-sm"
                              placeholder="Paste your Google Analytics tracking code here (e.g., gtag.js or analytics.js)">{{ old('google_analytics', App\Models\Setting::getValue('google_analytics', '')) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">{{ __('admin.analytics_code_help') }}</p>
                </div>
            </div>

            <!-- Header Content -->
            <div class="border-b pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('admin.header_content') }}</h3>
                <div>
                    <label for="header_content" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.header_html_text') }}</label>
                    <textarea id="header_content" 
                              name="header_content" 
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-mono text-sm"
                              placeholder="Enter HTML or text content to display in the header">{{ old('header_content', App\Models\Setting::getValue('header_content', '')) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">{{ __('admin.header_content_help') }}</p>
                </div>
            </div>

            <!-- Footer Content -->
            <div class="pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('admin.footer_content') }}</h3>
                <div>
                    <label for="footer_content" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.footer_html_text') }}</label>
                    <textarea id="footer_content" 
                              name="footer_content" 
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-mono text-sm"
                              placeholder="Enter HTML or text content to display in the footer">{{ old('footer_content', App\Models\Setting::getValue('footer_content', '')) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">{{ __('admin.footer_content_help') }}</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4 pt-6 border-t">
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                {{ __('admin.save_settings') }}
            </button>
        </div>
    </form>
</div>
@endsection

