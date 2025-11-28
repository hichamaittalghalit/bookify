@extends('admin.layout')

@section('title', __('admin.contacts'))
@section('page-title', __('admin.contacts'))

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('common.name') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('common.email') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.object') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.created') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($contacts as $contact)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $contact->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $contact->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ Str::limit($contact->object, 50) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $contact->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.contacts.show', $contact->id) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('admin.view') }}</a>
                                <a href="{{ route('admin.contacts.reply', $contact->id) }}" class="text-green-600 hover:text-green-900">{{ __('admin.reply') }}</a>
                                <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('admin.confirm_delete') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">{{ __('admin.delete') }}</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">{{ __('admin.no_contacts_found') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($contacts->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $contacts->links() }}
        </div>
    @endif
</div>
@endsection

