<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Chapter;
use App\Models\Discussion;
use Livewire\Component;
use Livewire\WithPagination;

class BookReader extends Component
{
    use WithPagination;

    public $bookId = null;
    public $book = null;
    public $selectedChapter = null;
    public $selectedDiscussion = null;
    public $viewMode = 'books'; // books, chapters, discussions, reading

    public function mount($bookId = null)
    {
        if ($bookId) {
            $this->bookId = $bookId;
            $this->book = Book::with('chapters')->findOrFail($bookId);
            $this->viewMode = 'chapters';
        }
    }

    public function selectBook($bookId)
    {
        $this->bookId = $bookId;
        $this->book = Book::with('chapters')->findOrFail($bookId);
        $this->viewMode = 'chapters';
        $this->selectedChapter = null;
        $this->selectedDiscussion = null;
    }

    public function selectChapter($chapterId)
    {
        $this->selectedChapter = Chapter::with('discussions')->findOrFail($chapterId);
        $this->viewMode = 'discussions';
        $this->selectedDiscussion = null;
    }

    public function selectDiscussion($discussionId)
    {
        $this->selectedDiscussion = Discussion::with('chapter.book')->findOrFail($discussionId);
        $this->viewMode = 'reading';
    }

    public function backToBooks()
    {
        $this->viewMode = 'books';
        $this->book = null;
        $this->selectedChapter = null;
        $this->selectedDiscussion = null;
    }

    public function backToChapters()
    {
        $this->viewMode = 'chapters';
        $this->selectedChapter = null;
        $this->selectedDiscussion = null;
    }

    public function backToDiscussions()
    {
        $this->viewMode = 'discussions';
        $this->selectedDiscussion = null;
    }

    // Helper method to get all chapters flattened for hierarchy display
    public function getAllChaptersHierarchical()
    {
        if (!$this->book) return [];
        
        $chapters = Chapter::where('book_id', $this->book->id)
            ->with(['parent', 'children'])
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
        $data = [];

        switch ($this->viewMode) {
            case 'books':
                $data['books'] = Book::latest()->paginate(12);
                break;
            case 'chapters':
                // Hierarchical chapters will be handled in the view via getAllChaptersHierarchical()
                break;
            case 'discussions':
                $data['discussions'] = $this->selectedChapter ? $this->selectedChapter->discussions()->paginate(20) : collect();
                break;
        }

        return view('livewire.book-reader', $data);
    }
}
