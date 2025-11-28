@extends('admin.layout')

@section('title', __('admin.smtp') . ' - ' . $smtp->name)
@section('page-title', __('admin.smtp') . ' - ' . $smtp->name)

@section('content')
<div class="space-y-6">
    <!-- SMTP Details -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900">{{ __('admin.smtp_details') }}</h3>
            <div class="flex space-x-2">
                <a href="{{ route('admin.smtps.edit', $smtp->id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                    {{ __('admin.edit') }}
                </a>
                <form action="{{ route('admin.smtps.fetch-emails', $smtp->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        {{ __('admin.fetch_emails') }}
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('admin.name') }}</label>
                <p class="mt-1 text-sm text-gray-900">{{ $smtp->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('admin.status') }}</label>
                <p class="mt-1">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $smtp->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $smtp->is_active ? __('admin.active') : __('admin.inactive') }}
                    </span>
                </p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('admin.host') }}</label>
                <p class="mt-1 text-sm text-gray-900">{{ $smtp->host }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('admin.port') }}</label>
                <p class="mt-1 text-sm text-gray-900">{{ $smtp->port }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('admin.username') }}</label>
                <p class="mt-1 text-sm text-gray-900">{{ $smtp->username }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('admin.encryption') }}</label>
                <p class="mt-1 text-sm text-gray-900 uppercase">{{ $smtp->encryption }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('admin.mailbox') }}</label>
                <p class="mt-1 text-sm text-gray-900">{{ $smtp->mailbox }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('admin.last_fetched') }}</label>
                <p class="mt-1 text-sm text-gray-900">{{ $smtp->last_fetched_at ? $smtp->last_fetched_at->format('Y-m-d H:i:s') : __('admin.never') }}</p>
            </div>
        </div>
    </div>

    <!-- Received Emails -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">{{ __('admin.received_emails') }}</h3>
            <a href="{{ route('admin.smtps.emails.all') }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                {{ __('admin.view_all_emails') }}
            </a>
        </div>
        
        @if($emails->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('admin.from') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('admin.subject') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('admin.received_at') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($emails as $email)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $email->from_email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($email->subject, 50) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $email->received_at->format('Y-m-d H:i') }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex space-x-2">
                                        <button onclick="showEmail({{ $email->id }})" class="text-indigo-600 hover:text-indigo-900">
                                            {{ __('admin.view') }}
                                        </button>
                                        <a href="{{ route('admin.smtps.emails.reply', [$smtp->id, $email->id]) }}" class="text-green-600 hover:text-green-900">
                                            {{ __('admin.reply') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $emails->links() }}
            </div>
        @else
            <p class="text-gray-500">{{ __('admin.no_emails_found') }}</p>
        @endif
    </div>
</div>

<!-- Email Modal -->
<div id="emailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold" id="emailSubject"></h3>
                <button onclick="closeEmailModal()" class="text-gray-500 hover:text-gray-700">✕</button>
            </div>
            <div id="emailContent" class="space-y-4"></div>
        </div>
    </div>
</div>

<script>
function showEmail(id) {
    // Fetch email details via AJAX
    fetch(`{{ url('/admin/received-emails') }}/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('emailSubject').textContent = data.subject;
            document.getElementById('emailContent').innerHTML = `
                <div><strong>From:</strong> ${data.from_email} (${data.from_name || 'N/A'})</div>
                <div><strong>To:</strong> ${data.to_email} (${data.to_name || 'N/A'})</div>
                <div><strong>Received:</strong> ${data.received_at}</div>
                <div class="border-t pt-4">
                    <div class="prose max-w-none">${data.body_html || data.body}</div>
                </div>
            `;
            document.getElementById('emailModal').classList.remove('hidden');
        });
}

function closeEmailModal() {
    document.getElementById('emailModal').classList.add('hidden');
}
</script>
@endsection

