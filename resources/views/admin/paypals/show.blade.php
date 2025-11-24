@extends('admin.layout')

@section('title', 'PayPal Account Details')
@section('page-title', 'PayPal Account Details')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-4xl">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $paypal->title }}</h2>
            <p class="text-gray-600 mt-2">{{ $paypal->email }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.paypals.edit', $paypal->id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                Edit
            </a>
            <a href="{{ route('admin.paypals.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Status</h3>
                <span class="mt-1 px-2 py-1 text-xs font-semibold rounded-full {{ $paypal->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $paypal->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Transactions Count</h3>
                <p class="mt-1 text-gray-900">{{ $paypal->transactions_count }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Created At</h3>
                <p class="mt-1 text-gray-900">{{ $paypal->created_at->format('M d, Y H:i') }}</p>
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Test Client ID</h3>
                <div class="flex items-center space-x-2">
                    <p class="text-gray-900 font-mono text-sm flex-1 bg-gray-50 p-2 rounded" id="test_client_id_display">
                        {{ strlen($paypal->test_client_id) > 20 ? substr($paypal->test_client_id, 0, 20) . '...' : $paypal->test_client_id }}
                    </p>
                    <button type="button" 
                            onclick="copyToClipboard({{ json_encode($paypal->test_client_id) }}, this)"
                            class="px-3 py-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700 transition">
                        Copy
                    </button>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Test Secret Key</h3>
                <div class="flex items-center space-x-2">
                    <p class="text-gray-900 font-mono text-sm flex-1 bg-gray-50 p-2 rounded">
                        {{ strlen($paypal->test_secret_key) > 20 ? substr($paypal->test_secret_key, 0, 20) . '...' : $paypal->test_secret_key }}
                    </p>
                    <button type="button" 
                            onclick="copyToClipboard({{ json_encode($paypal->test_secret_key) }}, this)"
                            class="px-3 py-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700 transition">
                        Copy
                    </button>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Live Client ID</h3>
                <div class="flex items-center space-x-2">
                    <p class="text-gray-900 font-mono text-sm flex-1 bg-gray-50 p-2 rounded" id="live_client_id_display">
                        @if($paypal->live_client_id)
                            {{ strlen($paypal->live_client_id) > 20 ? substr($paypal->live_client_id, 0, 20) . '...' : $paypal->live_client_id }}
                        @else
                            Not set
                        @endif
                    </p>
                    @if($paypal->live_client_id)
                        <button type="button" 
                                onclick="copyToClipboard({{ json_encode($paypal->live_client_id) }}, this)"
                                class="px-3 py-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700 transition">
                            Copy
                        </button>
                    @endif
                </div>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Live Secret Key</h3>
                <div class="flex items-center space-x-2">
                    <p class="text-gray-900 font-mono text-sm flex-1 bg-gray-50 p-2 rounded" id="live_secret_key_display">
                        @if($paypal->live_secret_key)
                            ********************
                        @else
                            Not set
                        @endif
                    </p>
                    @if($paypal->live_secret_key)
                        <button type="button" 
                                onclick="copyToClipboard({{ json_encode($paypal->live_secret_key) }}, this)"
                                class="px-3 py-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700 transition">
                            Copy
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text, buttonElement) {
    // Try modern clipboard API first
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(function() {
            showCopyFeedback(buttonElement);
        }).catch(function(err) {
            // Fallback to old method if clipboard API fails
            fallbackCopyToClipboard(text, buttonElement);
        });
    } else {
        // Use fallback method for older browsers or non-HTTPS
        fallbackCopyToClipboard(text, buttonElement);
    }
}

function fallbackCopyToClipboard(text, buttonElement) {
    // Create a temporary textarea element
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-999999px';
    textArea.style.top = '-999999px';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        const successful = document.execCommand('copy');
        if (successful) {
            showCopyFeedback(buttonElement);
        } else {
            alert('Failed to copy. Please copy manually: ' + text);
        }
    } catch (err) {
        alert('Failed to copy. Please copy manually: ' + text);
    } finally {
        document.body.removeChild(textArea);
    }
}

function showCopyFeedback(buttonElement) {
    const originalText = buttonElement.textContent;
    buttonElement.textContent = 'Copied!';
    buttonElement.classList.add('bg-green-600');
    buttonElement.classList.remove('bg-indigo-600');
    
    setTimeout(function() {
        buttonElement.textContent = originalText;
        buttonElement.classList.remove('bg-green-600');
        buttonElement.classList.add('bg-indigo-600');
    }, 2000);
}
</script>
@endsection

