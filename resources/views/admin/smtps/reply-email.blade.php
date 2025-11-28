@extends('admin.layout')

@section('title', __('admin.reply_to_email'))
@section('page-title', __('admin.reply_to_email'))

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-4xl">
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('admin.original_email') }}</h3>
        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-indigo-500">
            <p class="text-sm text-gray-700"><strong>{{ __('admin.from') }}:</strong> {{ $email->from_email }} @if($email->from_name)({{ $email->from_name }})@endif</p>
            <p class="text-sm text-gray-700"><strong>{{ __('admin.to') }}:</strong> {{ $email->to_email }} @if($email->to_name)({{ $email->to_name }})@endif</p>
            <p class="text-sm text-gray-700"><strong>{{ __('mail.subject') }}:</strong> {{ $email->subject }}</p>
            <p class="text-sm text-gray-700"><strong>{{ __('admin.received_at') }}:</strong> {{ $email->received_at->format('Y-m-d H:i:s') }}</p>
            <p class="text-sm text-gray-700 mt-2"><strong>{{ __('admin.message') }}:</strong></p>
            <div class="text-sm text-gray-900 mt-1 prose max-w-none">
                {!! $email->body_html ?: nl2br(e($email->body)) !!}
            </div>
        </div>
    </div>

    <form action="{{ route('admin.smtps.emails.send-reply', [$smtp->id, $email->id]) }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                {{ __('mail.subject') }} ({{ __('admin.optional') }})
            </label>
            <input type="text" 
                   id="subject" 
                   name="subject" 
                   value="{{ old('subject', __('mail.re_re') . ': ' . $email->subject) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            @error('subject')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                {{ __('admin.reply_message') }} <span class="text-red-500">*</span>
            </label>
            <textarea id="message" 
                      name="message" 
                      rows="10"
                      required
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                      placeholder="{{ __('admin.reply_message_placeholder') }}">{{ old('message') }}</textarea>
            @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-end space-x-4 pt-6 border-t">
            <a href="{{ route('admin.smtps.show', $smtp->id) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                {{ __('common.cancel') }}
            </a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                {{ __('admin.send_reply') }}
            </button>
        </div>
    </form>
</div>
@endsection

