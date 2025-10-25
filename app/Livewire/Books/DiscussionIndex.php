<?php

namespace App\Livewire\Books;

use App\Models\Chapter;
use Livewire\Component;
use Livewire\WithPagination;

class DiscussionIndex extends Component
{
    use WithPagination;
    
    public Chapter $chapter;
    
    public function mount($chapter)
    {
        $this->chapter = $chapter;
    }

    public function render()
    {
        return view('livewire.books.discussion-index', [
            'discussions' => $this->chapter->discussions()->paginate(20)
        ]);
    }
}