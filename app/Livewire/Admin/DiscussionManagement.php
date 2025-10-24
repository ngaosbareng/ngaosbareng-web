<?php

namespace App\Livewire\Admin;

use App\Models\Book;
use App\Models\Chapter;
use App\Models\Discussion;
use Livewire\Component;
use Livewire\WithPagination;

class DiscussionManagement extends Component
{
    use WithPagination;

    public $bookId;
    public $chapterId;
    public $book;
    public $chapter;
    public $showCreateForm = false;
    public $showEditForm = false;
    public $editingDiscussion = null;
    
    public $title = '';
    public $content = '';
    public $order = 0;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'order' => 'required|integer|min:0',
    ];

    public function mount($bookId, $chapterId)
    {
        $this->bookId = $bookId;
        $this->chapterId = $chapterId;
        $this->book = Book::findOrFail($bookId);
        $this->chapter = Chapter::findOrFail($chapterId);
    }

    public function createDiscussion()
    {
        $this->validate();
        
        Discussion::create([
            'chapter_id' => $this->chapterId,
            'title' => $this->title,
            'content' => $this->content,
            'order' => $this->order,
        ]);

        $this->reset(['title', 'content', 'order', 'showCreateForm']);
        $this->dispatch('discussion-created');
    }

    public function editDiscussion($discussionId)
    {
        $this->editingDiscussion = Discussion::findOrFail($discussionId);
        $this->title = $this->editingDiscussion->title;
        $this->content = $this->editingDiscussion->content;
        $this->order = $this->editingDiscussion->order;
        $this->showEditForm = true;
    }

    public function updateDiscussion()
    {
        $this->validate();
        
        $this->editingDiscussion->update([
            'title' => $this->title,
            'content' => $this->content,
            'order' => $this->order,
        ]);

        $this->reset(['title', 'content', 'order', 'showEditForm', 'editingDiscussion']);
        $this->dispatch('discussion-updated');
    }

    public function deleteDiscussion($discussionId)
    {
        Discussion::findOrFail($discussionId)->delete();
        $this->dispatch('discussion-deleted');
    }

    public function cancelEdit()
    {
        $this->reset(['title', 'content', 'order', 'showEditForm', 'editingDiscussion']);
    }

    public function render()
    {
        $discussions = Discussion::where('chapter_id', $this->chapterId)
            ->orderBy('order')
            ->paginate(10);

        return view('livewire.admin.discussion-management', [
            'discussions' => $discussions,
        ]);
    }
}
