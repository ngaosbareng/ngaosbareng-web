<?php

namespace App\Livewire\Books;

use App\Models\Book;
use App\Models\Chapter;
use Livewire\Component;

class ChapterIndex extends Component
{
    public Book $book;

    public function mount($book)
    {
        $this->book = $book;
    }

    public function getAllChaptersHierarchical()
    {
        $chapters = Chapter::where('book_id', $this->book->id)
            ->with(['parent', 'children', 'discussions'])
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();

        $result = [];
        foreach ($chapters as $chapter) {
            $this->flattenChapters($chapter, $result, 0);
        }
        
        return $result;
    }

    private function flattenChapters($chapter, &$result, $level)
    {
        $chapter->level = $level;
        $result[] = $chapter;
        
        foreach ($chapter->children()->orderBy('order')->get() as $child) {
            $this->flattenChapters($child, $result, $level + 1);
        }
    }

    public function render()
    {
        return view('livewire.books.chapter-index', [
            'chapters' => $this->getAllChaptersHierarchical()
        ]);
    }
}