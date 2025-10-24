<?php

namespace App\Livewire\Admin;

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
        ]);

        $this->reset(['title', 'description', 'showCreateForm']);
        $this->dispatch('book-created');
    }

    public function editBook($bookId)
    {
        $this->editingBook = Book::findOrFail($bookId);
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
        Book::findOrFail($bookId)->delete();
        $this->dispatch('book-deleted');
    }

    public function cancelEdit()
    {
        $this->reset(['title', 'description', 'showEditForm', 'editingBook']);
    }

    public function render()
    {
        return view('livewire.admin.book-management', [
            'books' => Book::latest()->paginate(10),
        ]);
    }
}
