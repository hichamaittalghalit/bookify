<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'download_link' => 'nullable|file|mimes:pdf|max:10240',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|in:USD,EUR,GBP,CAD',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
            'is_best_seller' => 'boolean',
        ]);

        // Generate slug from title (ensure uniqueness)
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;
        while (Book::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;

        // Handle image upload - save to public folder
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = $slug . '.' . $extension;
            $publicPath = public_path('books/images');
            
            // Create directory if it doesn't exist
            if (!file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
            }
            
            // Move file to public folder
            $request->file('image')->move($publicPath, $filename);
            $validated['image'] = 'books/images/' . $filename; // Store relative path
        }

        // Handle PDF file upload - save to storage
        if ($request->hasFile('download_link')) {
            $filename = $slug . '.pdf';
            $pdfPath = $request->file('download_link')->storeAs('books/pdfs', $filename, 'public');
            $validated['path'] = $pdfPath; // Store path for storage access
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_new'] = $request->has('is_new');
        $validated['is_best_seller'] = $request->has('is_best_seller');

        Book::create($validated);

        return redirect()->route('admin.books.index')->with('success', __('admin.book_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::findOrFail($id);
        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        return view('admin.books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'download_link' => 'nullable|file|mimes:pdf|max:10240',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|in:USD,EUR,GBP,CAD',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
            'is_best_seller' => 'boolean',
        ]);

        // Generate slug from title (ensure uniqueness)
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;
        // Check if title changed or slug is empty
        if ($book->title !== $validated['title'] || empty($book->slug)) {
            while (Book::where('slug', $slug)->where('id', '!=', $book->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;
        } else {
            $slug = $book->slug;
        }

        // Handle image upload - save to public folder
        if ($request->hasFile('image')) {
            // Delete old image if it exists in public folder
            if ($book->image && file_exists(public_path($book->image))) {
                unlink(public_path($book->image));
            }
            
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = $slug . '.' . $extension;
            $publicPath = public_path('books/images');
            
            // Create directory if it doesn't exist
            if (!file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
            }
            
            // Move file to public folder
            $request->file('image')->move($publicPath, $filename);
            $validated['image'] = 'books/images/' . $filename; // Store relative path
        } else {
            // Keep existing image if not provided
            $validated['image'] = $book->image;
        }

        // Handle PDF file upload - save to storage
        if ($request->hasFile('download_link')) {
            // Delete old PDF if it exists
            if ($book->path && Storage::disk('public')->exists($book->path)) {
                Storage::disk('public')->delete($book->path);
            }
            
            $filename = $slug . '.pdf';
            $pdfPath = $request->file('download_link')->storeAs('books/pdfs', $filename, 'public');
            $validated['path'] = $pdfPath;
        } else {
            // Keep existing path if not provided
            $validated['path'] = $book->path;
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_new'] = $request->has('is_new');
        $validated['is_best_seller'] = $request->has('is_best_seller');

        $book->update($validated);

        return redirect()->route('admin.books.index')->with('success', __('admin.book_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', __('admin.book_deleted'));
    }
}
