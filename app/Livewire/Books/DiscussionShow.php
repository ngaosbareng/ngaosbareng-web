<?php

namespace App\Livewire\Books;

use App\Models\Discussion;
use Livewire\Component;

class DiscussionShow extends Component
{
    public Discussion $discussion;
    
    public function mount($discussionId)
    {
        $this->discussion = Discussion::with('chapter.book')->findOrFail($discussionId);
    }

    public function render()
    {
        return view('livewire.books.discussion-show');
    }
}