<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\PayPal;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of active books.
     */
    public function index()
    {
        $books = Book::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('public.books.index', compact('books'));
    }

    /**
     * Display the specified book.
     */
    public function show($slug)
    {
        $book = Book::where('is_active', true)->where('slug', $slug)->firstOrFail();
        $paypal = PayPal::getActive();
        
        return view('public.books.show', compact('book', 'paypal'));
    }
}

