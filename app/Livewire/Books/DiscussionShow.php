<?php

namespace App\Livewire\Books;

use App\Models\Discussion;
use Livewire\Component;
use Livewire\Attributes\On;

class DiscussionShow extends Component
{
    public Discussion $discussion;
    
    public function mount($discussion)
    {
        $this->discussion = $discussion;
    }

    #[On('discussion-updated')]
    public function refreshDiscussion()
    {
        $this->discussion->refresh();
        session()->flash('message', 'Pembahasan berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.books.discussion-show');
    }
}