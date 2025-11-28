@extends('admin.layout')

@section('title', __('admin.contact') . ' - ' . $contact->name)
@section('page-title', __('admin.contact') . ' - ' . $contact->name)

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-4xl">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-900">{{ __('admin.contact_details') }}</h3>
        <div class="flex space-x-2">
            <a href="{{ route('admin.contacts.reply', $contact->id) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                {{ __('admin.reply') }}
            </a>
            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('admin.confirm_delete') }}');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    {{ __('admin.delete') }}
                </button>
            </form>
        </div>
    </div>

    <div class="space-y-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('common.name') }}</label>
            <p class="text-sm text-gray-900">{{ $contact->name }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('common.email') }}</label>
            <p class="text-sm text-gray-900">{{ $contact->email }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.object') }}</label>
            <p class="text-sm text-gray-900">{{ $contact->object }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.message') }}</label>
            <div class="mt-1 p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $contact->subject }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 pt-4 border-t">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.ip_address') }}</label>
                <p class="text-sm text-gray-900">{{ $contact->ip_address ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.created') }}</label>
                <p class="text-sm text-gray-900">{{ $contact->created_at->format('Y-m-d H:i:s') }}</p>
            </div>
        </div>
    </div>

    <div class="mt-6 pt-6 border-t">
        <a href="{{ route('admin.contacts.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
            {{ __('common.back') }}
        </a>
    </div>
</div>
@endsection

