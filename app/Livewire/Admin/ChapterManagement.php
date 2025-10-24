<?php

namespace App\Livewire\Admin;

use App\Models\Book;
use App\Models\Chapter;
use Livewire\Component;
use Livewire\WithPagination;

class ChapterManagement extends Component
{
    use WithPagination;

    public $bookId;
    public $book;
    public $showCreateForm = false;
    public $showEditForm = false;
    public $editingChapter = null;
    
    public $title = '';
    public $description = '';
    public $parentId = null;
    public $order = 0;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'parentId' => 'nullable|exists:chapters,id',
        'order' => 'required|integer|min:0',
    ];

    public function mount($bookId)
    {
        $this->bookId = $bookId;
        $this->book = Book::findOrFail($bookId);
    }

    public function createChapter()
    {
        $this->validate();
        
        Chapter::create([
            'book_id' => $this->bookId,
            'parent_id' => $this->parentId,
            'title' => $this->title,
            'description' => $this->description,
            'order' => $this->order,
        ]);

        $this->reset(['title', 'description', 'parentId', 'order', 'showCreateForm']);
        $this->dispatch('chapter-created');
    }

    public function editChapter($chapterId)
    {
        $this->editingChapter = Chapter::findOrFail($chapterId);
        $this->title = $this->editingChapter->title;
        $this->description = $this->editingChapter->description;
        $this->parentId = $this->editingChapter->parent_id;
        $this->order = $this->editingChapter->order;
        $this->showEditForm = true;
    }

    public function updateChapter()
    {
        $this->validate();
        
        $this->editingChapter->update([
            'title' => $this->title,
            'description' => $this->description,
            'parent_id' => $this->parentId,
            'order' => $this->order,
        ]);

        $this->reset(['title', 'description', 'parentId', 'order', 'showEditForm', 'editingChapter']);
        $this->dispatch('chapter-updated');
    }

    public function deleteChapter($chapterId)
    {
        Chapter::findOrFail($chapterId)->delete();
        $this->dispatch('chapter-deleted');
    }

    public function cancelEdit()
    {
        $this->reset(['title', 'description', 'parentId', 'order', 'showEditForm', 'editingChapter']);
    }

    public function render()
    {
        // Get hierarchical chapters
        $hierarchicalChapters = $this->getAllChaptersHierarchical();

        $availableParents = Chapter::where('book_id', $this->bookId)
            ->orderBy('order')
            ->get();

        return view('livewire.admin.chapter-management', [
            'hierarchicalChapters' => $hierarchicalChapters,
            'availableParents' => $availableParents,
        ]);
    }

    // Helper method to get all chapters flattened for hierarchy display
    public function getAllChaptersHierarchical()
    {
        $chapters = Chapter::where('book_id', $this->bookId)
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
}
