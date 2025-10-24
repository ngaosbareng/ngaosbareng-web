<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Masail;
use App\Models\Discussion;
use App\Models\Book;

class MasailManagement extends Component
{
    use WithPagination;

    public $showCreateForm = false;
    public $showEditForm = false;
    public $selectedMasail = null;

    // Form properties
    public $title = '';
    public $question = '';
    public $description = '';
    public $selectedDiscussions = [];

    // Search properties
    public $search = '';

    public function resetForm()
    {
        $this->title = '';
        $this->question = '';
        $this->description = '';
        $this->selectedDiscussions = [];
        $this->showCreateForm = false;
        $this->showEditForm = false;
        $this->selectedMasail = null;
    }

    public function openCreateForm()
    {
        $this->resetForm();
        $this->showCreateForm = true;
    }

    public function openEditForm($masailId)
    {
        $this->resetForm();
        $this->selectedMasail = Masail::with('discussions')->findOrFail($masailId);
        $this->title = $this->selectedMasail->title;
        $this->question = $this->selectedMasail->question;
        $this->description = $this->selectedMasail->description;
        $this->selectedDiscussions = $this->selectedMasail->discussions->pluck('id')->toArray();
        $this->showEditForm = true;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'question' => 'required|string',
            'description' => 'nullable|string',
            'selectedDiscussions' => 'required|array|min:1',
            'selectedDiscussions.*' => 'exists:discussions,id'
        ]);

        $masail = Masail::create([
            'title' => $this->title,
            'question' => $this->question,
            'description' => $this->description,
        ]);

        $masail->discussions()->attach($this->selectedDiscussions);

        session()->flash('message', 'Masail berhasil ditambahkan!');
        $this->resetForm();
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'question' => 'required|string',
            'description' => 'nullable|string',
            'selectedDiscussions' => 'required|array|min:1',
            'selectedDiscussions.*' => 'exists:discussions,id'
        ]);

        $this->selectedMasail->update([
            'title' => $this->title,
            'question' => $this->question,
            'description' => $this->description,
        ]);

        $this->selectedMasail->discussions()->sync($this->selectedDiscussions);

        session()->flash('message', 'Masail berhasil diperbarui!');
        $this->resetForm();
    }

    public function delete($masailId)
    {
        $masail = Masail::findOrFail($masailId);
        $masail->discussions()->detach();
        $masail->delete();

        session()->flash('message', 'Masail berhasil dihapus!');
    }

    public function render()
    {
        $masail = Masail::with('discussions.chapter.book')
            ->when($this->search, function ($query) {
                return $query->where('title', 'like', '%' . $this->search . '%')
                           ->orWhere('question', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        $discussions = Discussion::with('chapter.book')->get();

        return view('livewire.admin.masail-management', [
            'masail' => $masail,
            'discussions' => $discussions
        ]);
    }
}
