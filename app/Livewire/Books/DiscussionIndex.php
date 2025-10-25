<?php

namespace App\Livewire\Books;

use App\Models\Chapter;
use Livewire\Component;
use Livewire\WithPagination;

class DiscussionIndex extends Component
{
    use WithPagination;
    
    public Chapter $chapter;
    public $discussionToDelete;
    
    public function mount($chapter)
    {
        $this->chapter = $chapter;
    }

    public function confirmDelete($discussionId)
    {
        $this->discussionToDelete = $discussionId;
        $this->dispatch('delete-confirmation-modal');
    }

    public function deleteDiscussion()
    {
        $discussion = $this->chapter->discussions()->findOrFail($this->discussionToDelete);
        $discussion->delete();

        session()->flash('message', 'Pembahasan berhasil dihapus');
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.books.discussion-index', [
            'discussions' => $this->chapter->discussions()->paginate(20)
        ]);
    }
}