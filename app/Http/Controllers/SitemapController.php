<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate sitemap.xml
     */
    public function index()
    {
        $baseUrl = rtrim(config('app.url'), '/');
        
        $urls = [];
        
        // Homepage
        $urls[] = [
            'loc' => $baseUrl,
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '1.0'
        ];
        
        // Active books
        $books = Book::where('is_active', true)
            ->orderBy('updated_at', 'desc')
            ->get();
            
        foreach ($books as $book) {
            $urls[] = [
                'loc' => $baseUrl . route('books.show', $book->slug, false),
                'lastmod' => $book->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ];
        }
        
        // Static pages
        $staticPages = [
            ['route' => 'contact.index', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['route' => 'pages.faq', 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['route' => 'pages.legal-notice', 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['route' => 'pages.terms', 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['route' => 'pages.privacy', 'priority' => '0.5', 'changefreq' => 'yearly'],
        ];
        
        foreach ($staticPages as $page) {
            $urls[] = [
                'loc' => $baseUrl . route($page['route'], [], false),
                'lastmod' => now()->toAtomString(),
                'changefreq' => $page['changefreq'],
                'priority' => $page['priority']
            ];
        }
        
        $xml = view('sitemap', ['urls' => $urls])->render();
        
        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }
}
