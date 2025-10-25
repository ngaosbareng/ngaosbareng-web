<?php

namespace App\Livewire\Books;

use App\Models\Book;
use App\Models\Chapter;
use Livewire\Component;

class ChapterIndex extends Component
{
    public Book $book;
    public $editingChapter = [];
    public $newChapter = [];
    public $chapterToDelete;
    public $newDiscussion = [];
    public $selectedChapterId;

    public function mount($book)
    {
        $this->book = $book;
        $this->resetNewChapter();
    }
    
    public function resetNewChapter()
    {
        $this->newChapter = [
            'title' => '',
            'description' => '',
            'level' => 0,
        ];
    }

    public function createChapter()
    {
        $this->resetNewChapter();
        $this->dispatch('create-chapter-modal');
    }

    public function storeChapter()
    {
        $validated = $this->validate([
            'newChapter.title' => 'required|string|max:255',
            'newChapter.description' => 'nullable|string',
            'newChapter.level' => 'required|integer|min:0|max:2',
        ]);

        $this->book->chapters()->create([
            'title' => $validated['newChapter']['title'],
            'description' => $validated['newChapter']['description'],
            'level' => $validated['newChapter']['level'],
        ]);

        $this->resetNewChapter();
        session()->flash('message', 'Bab berhasil ditambahkan');
        $this->dispatch('close-modal');
    }

    public function confirmDeleteChapter($chapterId)
    {
        $this->chapterToDelete = $chapterId;
        $this->dispatch('delete-chapter-modal');
    }

    public function deleteChapter()
    {
        $chapter = Chapter::findOrFail($this->chapterToDelete);
        
        // Delete all discussions first
        $chapter->discussions()->delete();
        
        // Then delete the chapter
        $chapter->delete();

        session()->flash('message', 'Bab berhasil dihapus');
        $this->dispatch('close-modal');
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
        // Tambahkan validasi di sini
        $validated = $this->validate([
            'editingChapter.title' => 'required|string|max:255',
            'editingChapter.description' => 'nullable|string',
            'editingChapter.level' => 'required|integer|min:0|max:2',
        ]);
        
        $chapter = Chapter::find($this->editingChapter['id']);
        $chapter->update([
            'title' => $validated['editingChapter']['title'], // Gunakan nilai yang divalidasi
            'description' => $validated['editingChapter']['description'],
            'level' => $validated['editingChapter']['level'],
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
        // Tambahkan validasi di sini
        $validated = $this->validate([
            'newDiscussion.title' => 'required|string|max:255',
            'newDiscussion.content' => 'required|string',
        ]);
        
        $chapter = Chapter::find($this->selectedChapterId);
        
        $chapter->discussions()->create([
            'title' => $validated['newDiscussion']['title'], // Gunakan nilai yang divalidasi
            'content' => $validated['newDiscussion']['content'],
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