@extends('admin.layout')

@section('title', __('admin.edit') . ' ' . __('admin.smtp'))
@section('page-title', __('admin.edit') . ' ' . __('admin.smtp'))

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-4xl">
    <form action="{{ route('admin.smtps.update', $smtp->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.name') }} *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $smtp->name) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="host" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.host') }} *</label>
                <input type="text" id="host" name="host" value="{{ old('host', $smtp->host) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('host')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="port" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.port') }} *</label>
                <input type="number" id="port" name="port" value="{{ old('port', $smtp->port) }}" required min="1" max="65535"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('port')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.username') }} *</label>
                <input type="text" id="username" name="username" value="{{ old('username', $smtp->username) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('username')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.password') }}</label>
                <input type="password" id="password" name="password" value=""
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="{{ __('admin.leave_blank_to_keep_current') }}">
                <p class="mt-1 text-xs text-gray-500">{{ __('admin.leave_blank_to_keep_current') }}</p>
                @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="encryption" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.encryption') }} *</label>
                <select id="encryption" name="encryption" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="ssl" {{ old('encryption', $smtp->encryption) == 'ssl' ? 'selected' : '' }}>SSL</option>
                    <option value="tls" {{ old('encryption', $smtp->encryption) == 'tls' ? 'selected' : '' }}>TLS</option>
                    <option value="none" {{ old('encryption', $smtp->encryption) == 'none' ? 'selected' : '' }}>None</option>
                </select>
                @error('encryption')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="mailbox" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.mailbox') }}</label>
                <input type="text" id="mailbox" name="mailbox" value="{{ old('mailbox', $smtp->mailbox) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('mailbox')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $smtp->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-700">{{ __('admin.active') }}</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end space-x-4 pt-6 border-t">
            <a href="{{ route('admin.smtps.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                {{ __('common.cancel') }}
            </a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                {{ __('common.update') }}
            </button>
        </div>
    </form>
</div>
@endsection

