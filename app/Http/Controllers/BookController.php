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

    public function updateChapter(Request $request, Chapter $chapter)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'required|integer|min:0|max:5',
        ]);

        $chapter->update($validated);

        return back()->with('message', 'Bab berhasil diperbarui');
    }

    public function storeDiscussion(Request $request, Chapter $chapter)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $discussion = $chapter->discussions()->create($validated);

        return back()->with('message', 'Pembahasan berhasil ditambahkan');
    }

    public function destroyDiscussion(Discussion $discussion)
    {
        $discussion->delete();
        
        return back()->with('message', 'Pembahasan berhasil dihapus');
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
