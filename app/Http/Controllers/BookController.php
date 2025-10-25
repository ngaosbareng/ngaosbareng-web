<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Chapter;
use App\Models\Discussion;

class BookController extends Controller
{
    public function index()
    {
        return view('books.index');
    }

    public function chapters(Book $book)
    {
        return view('books.chapters', [
            'book' => $book
        ]);
    }

    public function discussions(Chapter $chapter)
    {
        $chapter->load('book');
        
        return view('books.discussions', [
            'chapter' => $chapter
        ]);
    }

    public function showDiscussion(Discussion $discussion)
    {
        $discussion->load('chapter.book');
        
        return view('books.discussion-show', [
            'discussion' => $discussion
        ]);
    }
}
