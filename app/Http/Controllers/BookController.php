<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Chapter;
use App\Models\Discussion;

class BookController extends Controller
{
    /**
     * Menampilkan halaman daftar buku
     */
    public function index()
    {
        return view('books.index');
    }

    /**
     * Menampilkan halaman daftar bab dari sebuah buku
     */
    public function chapters(Book $book)
    {
        return view('books.chapters', [
            'book' => $book
        ]);
    }

    /**
     * Menampilkan halaman daftar diskusi dari sebuah bab
     */
    public function discussions(Chapter $chapter)
    {
        $chapter->load('book');
        
        return view('books.discussions', [
            'chapter' => $chapter
        ]);
    }

    /**
     * Menampilkan halaman detail diskusi
     */
    public function showDiscussion(Discussion $discussion)
    {
        $discussion->load('chapter.book');
        
        return view('books.discussion-show', [
            'discussion' => $discussion
        ]);
    }
}
