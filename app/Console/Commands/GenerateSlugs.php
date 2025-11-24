<?php

namespace App\Console\Commands;

use App\Models\Book;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate slugs for books that don\'t have them';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Generate slugs for books
        $books = Book::whereNull('slug')->orWhere('slug', '')->get();
        $this->info("Generating slugs for {$books->count()} books...");
        
        foreach ($books as $book) {
            $slug = Str::slug($book->title);
            $originalSlug = $slug;
            $counter = 1;
            
            while (Book::where('slug', $slug)->where('id', '!=', $book->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            $book->slug = $slug;
            $book->save();
            $this->line("  - Book '{$book->title}' -> slug: {$slug}");
        }
        
        $this->info('Done!');
        
        return Command::SUCCESS;
    }
}
