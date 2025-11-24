@extends('public.layout')

@php
    $siteName = App\Models\Setting::getValue('site_name', config('app.name', 'Bookify'));
@endphp

@section('title', 'Browse Books - ' . $siteName)

@section('content')
<div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                {{ __('public.discover_amazing_books') }}
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                {{ __('public.explore_collection') }}
            </p>
        </div>

        <!-- Books Grid -->
        @if($books->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-12">
                @foreach($books as $book)
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group">
                        <!-- Book Image -->
                        <div class="bg-gradient-to-br from-indigo-400 to-purple-500 h-64 relative overflow-hidden group-hover:shadow-lg transition-all">
                            <img src="{{ $book->image_url }}" 
                                 alt="{{ $book->title }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                            
                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex flex-row gap-2 z-10">
                                @if($book->is_new)
                                    <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg whitespace-nowrap">
                                        {{ __('common.new') }}
                                    </span>
                                @endif
                                @if($book->is_best_seller)
                                    <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg whitespace-nowrap">
                                        🔥 {{ __('common.bestseller') }}
                                    </span>
                                @endif
                            </div>
                            @if($book->is_featured)
                                <span class="absolute top-4 right-4 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full shadow-lg z-10 whitespace-nowrap">
                                    ⭐ {{ __('common.featured') }}
                                </span>
                            @endif
                        </div>

                        <!-- Book Info -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-indigo-600 transition">
                                {{ $book->title }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ \Illuminate\Support\Str::limit(strip_tags($book->description), 120) }}
                            </p>
                            
                            <!-- Price and Action -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-2xl font-bold text-indigo-600">{{ $book->currency }} {{ number_format($book->price, 2) }}</span>
                                </div>
                                <a href="{{ route('books.show', $book->slug) }}" 
                                   class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-indigo-700 transition transform hover:scale-105">
                                    {{ __('common.view_details') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $books->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="text-6xl mb-4">📚</div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ __('public.no_books_available') }}</h3>
                <p class="text-gray-600">{{ __('public.check_back_soon') }}</p>
            </div>
        @endif
    </div>
</div>
@endsection

