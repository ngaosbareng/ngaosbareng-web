<?php

namespace App\Livewire\Books;

use App\Models\Discussion;
use App\Models\Chapter;
use Livewire\Component;
use Livewire\Attributes\Rule;

class DiscussionForm extends Component
{
    public $chapter;

    #[Rule('required|min:3')]
    public $title = '';

    #[Rule('required|min:10')]
    public $content = '';

    public $discussion;

    public function mount(Chapter $chapter, ?Discussion $discussion = null)
    {
        $this->chapter = $chapter;
        if ($discussion) {
            $this->discussion = $discussion;
            $this->title = $discussion->title;
            $this->content = $discussion->content;
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->discussion) {
            $this->discussion->update([
                'title' => $this->title,
                'content' => $this->content,
            ]);

            $this->dispatch('discussion-updated');
        } else {
            $this->chapter->discussions()->create([
                'title' => $this->title,
                'content' => $this->content,
            ]);

            $this->dispatch('discussion-created');
        }

        $this->reset(['title', 'content']);
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.books.discussion-form');
    }
}