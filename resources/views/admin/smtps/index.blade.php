@extends('admin.layout')

@section('title', __('admin.smtps_management'))
@section('page-title', __('admin.smtps_management'))

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-lg font-semibold text-gray-900">{{ __('admin.smtps') }}</h3>
    <div class="flex space-x-2">
        <a href="{{ route('admin.smtps.emails.all') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            {{ __('admin.view_all_emails') }}
        </a>
        <a href="{{ route('admin.smtps.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            + {{ __('admin.add_new_smtp') }}
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.name') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.host') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.username') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.status') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.last_fetched') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($smtps as $smtp)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $smtp->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $smtp->host }}:{{ $smtp->port }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $smtp->username }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $smtp->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $smtp->is_active ? __('admin.active') : __('admin.inactive') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $smtp->last_fetched_at ? $smtp->last_fetched_at->format('Y-m-d H:i') : __('admin.never') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.smtps.show', $smtp->id) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('admin.view') }}</a>
                                <a href="{{ route('admin.smtps.edit', $smtp->id) }}" class="text-yellow-600 hover:text-yellow-900">{{ __('admin.edit') }}</a>
                                <form action="{{ route('admin.smtps.fetch-emails', $smtp->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:text-blue-900">{{ __('admin.fetch_emails') }}</button>
                                </form>
                                <form action="{{ route('admin.smtps.destroy', $smtp->id) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('admin.confirm_delete') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">{{ __('admin.delete') }}</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">{{ __('admin.no_smtps_found') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($smtps->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $smtps->links() }}
        </div>
    @endif
</div>
@endsection

