<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Chapter;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        // Show only current user's books
        $books = Book::where('user_id', auth()->id())
            ->with('allChapters')
            ->latest()
            ->paginate(12);

        return view('books.index', compact('books'));
    }

    public function show($id)
    {
        // Show only current user's book
        $book = Book::where('user_id', auth()->id())
            ->where('id', $id)
            ->with(['chapters.discussions'])
            ->firstOrFail();

        return view('books.show', compact('book'));
    }

    public function discussions($bookId, $chapterId)
    {
        // Ensure user owns the book
        $book = Book::where('user_id', auth()->id())
                   ->where('id', $bookId)
                   ->firstOrFail();

        $chapter = Chapter::where('book_id', $bookId)
                         ->where('id', $chapterId)
                         ->with(['discussions', 'book'])
                         ->firstOrFail();

        return view('books.discussions', compact('book', 'chapter'));
    }
}
