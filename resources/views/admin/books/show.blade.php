@extends('admin.layout')

@section('title', 'Book Details')
@section('page-title', 'Book Details')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-4xl">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $book->title }}</h2>
            <p class="text-gray-600 mt-2">{{ $book->currency }} {{ number_format($book->price, 2) }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.books.edit', $book->id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                Edit
            </a>
            <a href="{{ route('admin.books.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <img src="{{ $book->image_url }}" alt="{{ $book->title }}" class="w-full rounded-lg">
        </div>
        <div class="space-y-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Description</h3>
                <div class="mt-1 text-gray-900 prose max-w-none">
                    {!! $book->description !!}
                </div>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Book Path</h3>
                <p class="mt-1 text-gray-900">{{ $book->path }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Status</h3>
                <span class="mt-1 px-2 py-1 text-xs font-semibold rounded-full {{ $book->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $book->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Badges</h3>
                <div class="mt-1 flex flex-wrap gap-2">
                    @if($book->is_featured)
                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">Featured</span>
                    @endif
                    @if($book->is_best_seller)
                        <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Bestseller</span>
                    @endif
                    @if($book->is_new)
                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">New</span>
                    @endif
                </div>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Created At</h3>
                <p class="mt-1 text-gray-900">{{ $book->created_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

