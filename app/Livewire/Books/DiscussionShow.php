<?php

namespace App\Livewire\Books;

use App\Models\Discussion;
use Livewire\Component;

class DiscussionShow extends Component
{
    public Discussion $discussion;
    
    public function mount($discussion)
    {
        $this->discussion = $discussion;
    }

    public function render()
    {
        return view('livewire.books.discussion-show');
    }
}