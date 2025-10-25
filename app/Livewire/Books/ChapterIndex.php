<?php

namespace App\Livewire\Books;

use App\Models\Book;
use App\Models\Chapter;
use Livewire\Component;

class ChapterIndex extends Component
{
    public Book $book;
    public $editingChapter = [];
    public $newDiscussion = [];
    public $selectedChapterId;

    public function mount($book)
    {
        $this->book = $book;
    }

    public function editChapter($chapterId)
    {
        $chapter = Chapter::find($chapterId);
        $this->editingChapter = [
            'id' => $chapter->id,
            'title' => $chapter->title,
            'description' => $chapter->description,
            'level' => $chapter->level,
        ];
        
        $this->dispatch('edit-chapter-modal');
    }

    public function updateChapter()
    {
        $chapter = Chapter::find($this->editingChapter['id']);
        $chapter->update([
            'title' => $this->editingChapter['title'],
            'description' => $this->editingChapter['description'],
            'level' => $this->editingChapter['level'],
        ]);

        session()->flash('message', 'Bab berhasil diperbarui');
        $this->dispatch('close-modal');
    }

    public function addDiscussion($chapterId)
    {
        $this->selectedChapterId = $chapterId;
        $this->newDiscussion = [
            'title' => '',
            'content' => '',
        ];
        
        $this->dispatch('add-discussion-modal');
    }

    public function storeDiscussion()
    {
        $chapter = Chapter::find($this->selectedChapterId);
        
        $chapter->discussions()->create([
            'title' => $this->newDiscussion['title'],
            'content' => $this->newDiscussion['content'],
        ]);

        session()->flash('message', 'Pembahasan berhasil ditambahkan');
        $this->dispatch('close-modal');
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