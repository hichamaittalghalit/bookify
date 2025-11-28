@extends('admin.layout')

@section('title', __('admin.all_received_emails'))
@section('page-title', __('admin.all_received_emails'))

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">{{ __('admin.all_received_emails') }}</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.smtp') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.from') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('mail.subject') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.received_at') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($emails as $email)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <a href="{{ route('admin.smtps.show', $email->smtp_id) }}" class="text-indigo-600 hover:text-indigo-900">
                                {{ $email->smtp->name }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $email->from_email }}
                            @if($email->from_name)
                                <span class="text-gray-500">({{ $email->from_name }})</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ Str::limit($email->subject, 50) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $email->received_at->format('Y-m-d H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button onclick="showEmail({{ $email->id }})" class="text-indigo-600 hover:text-indigo-900">
                                    {{ __('admin.view') }}
                                </button>
                                <a href="{{ route('admin.smtps.emails.reply', [$email->smtp_id, $email->id]) }}" class="text-green-600 hover:text-green-900">
                                    {{ __('admin.reply') }}
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">{{ __('admin.no_emails_found') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($emails->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $emails->links() }}
        </div>
    @endif
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
// Sanitize HTML to prevent XSS attacks
function sanitizeHtml(html) {
    if (!html) return '';
    const div = document.createElement('div');
    div.textContent = html;
    return div.innerHTML;
}

// Sanitize HTML content while preserving safe HTML tags
function sanitizeHtmlContent(html) {
    if (!html) return '';
    // Remove script, iframe, object, embed tags and their content
    const temp = document.createElement('div');
    temp.innerHTML = html;
    
    // Remove dangerous elements
    const dangerous = temp.querySelectorAll('script, iframe, object, embed, form, input, button');
    dangerous.forEach(el => el.remove());
    
    // Remove event handlers from remaining elements
    const all = temp.querySelectorAll('*');
    all.forEach(el => {
        Array.from(el.attributes).forEach(attr => {
            if (attr.name.startsWith('on')) {
                el.removeAttribute(attr.name);
            }
        });
    });
    
    return temp.innerHTML;
}

function showEmail(id) {
    fetch(`{{ url('/admin/received-emails') }}/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('emailSubject').textContent = data.subject || '';
            
            // Sanitize email addresses and names
            const fromEmail = sanitizeHtml(data.from_email || '');
            const fromName = data.from_name ? '(' + sanitizeHtml(data.from_name) + ')' : '';
            const toEmail = sanitizeHtml(data.to_email || '');
            const toName = data.to_name ? '(' + sanitizeHtml(data.to_name) + ')' : '';
            const receivedAt = sanitizeHtml(data.received_at || '');
            
            // Sanitize email body - use HTML if available, otherwise plain text
            let bodyContent = '';
            if (data.body_html) {
                bodyContent = sanitizeHtmlContent(data.body_html);
            } else if (data.body) {
                // For plain text, escape and convert newlines to <br>
                bodyContent = sanitizeHtml(data.body).replace(/\n/g, '<br>');
            }
            
            document.getElementById('emailContent').innerHTML = `
                <div><strong>{{ __('admin.from') }}:</strong> ${fromEmail} ${fromName}</div>
                <div><strong>{{ __('admin.to') }}:</strong> ${toEmail} ${toName}</div>
                <div><strong>{{ __('admin.received_at') }}:</strong> ${receivedAt}</div>
                <div class="border-t pt-4">
                    <div class="prose max-w-none">${bodyContent}</div>
                </div>
            `;
            document.getElementById('emailModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error fetching email:', error);
            alert('Error loading email details');
        });
}

function closeEmailModal() {
    document.getElementById('emailModal').classList.add('hidden');
}
</script>
@endsection

