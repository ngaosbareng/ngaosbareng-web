<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;
use Livewire\WithPagination;

class BookManagement extends Component
{
    use WithPagination;

    public $showCreateForm = false;
    public $showEditForm = false;
    public $editingBook = null;
    
    public $title = '';
    public $description = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
    ];

    public function createBook()
    {
        $this->validate();
        
        Book::create([
            'title' => $this->title,
            'description' => $this->description,
            'user_id' => auth()->id(),
        ]);

        $this->reset(['title', 'description', 'showCreateForm']);
        $this->dispatch('book-created');
    }

    public function editBook($bookId)
    {
        $this->editingBook = Book::where('user_id', auth()->id())->findOrFail($bookId);
        $this->title = $this->editingBook->title;
        $this->description = $this->editingBook->description;
        $this->showEditForm = true;
    }

    public function updateBook()
    {
        $this->validate();
        
        $this->editingBook->update([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        $this->reset(['title', 'description', 'showEditForm', 'editingBook']);
        $this->dispatch('book-updated');
    }

    public function deleteBook($bookId)
    {
        Book::where('user_id', auth()->id())->findOrFail($bookId)->delete();
        $this->dispatch('book-deleted');
    }

    public function cancelEdit()
    {
        $this->reset(['title', 'description', 'showEditForm', 'editingBook']);
    }

    public function render()
    {
        return view('livewire.book-management', [
            'books' => Book::where('user_id', auth()->id())->latest()->paginate(10),
        ]);
    }
}
