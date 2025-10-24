<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Masail;
use App\Models\User;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index()
    {
        // Show all books and masail from other users (public library)
        $books = Book::with(['user', 'allChapters'])
                    ->whereNot('user_id', auth()->id())
                    ->latest()
                    ->paginate(12);

        $masail = Masail::with(['user', 'discussions.chapter.book'])
                       ->whereNot('user_id', auth()->id())
                       ->latest()
                       ->paginate(12);

        return view('library.index', compact('books', 'masail'));
    }

    public function showBook($id)
    {
        // Show book from another user (read-only)
        $book = Book::with(['user', 'chapters.discussions'])
                   ->whereNot('user_id', auth()->id())
                   ->findOrFail($id);

        return view('library.book', compact('book'));
    }

    public function showMasail($id)
    {
        // Show masail from another user (read-only)
        $masail = Masail::with(['user', 'discussions.chapter.book'])
                       ->whereNot('user_id', auth()->id())
                       ->findOrFail($id);

        return view('library.masail', compact('masail'));
    }
}
