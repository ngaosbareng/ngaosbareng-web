<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use App\Models\Masail;
use App\Models\Discussion;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class MasailManagement extends Component
{
    use WithPagination;

    public $showCreateForm = false;
    public $showEditForm = false;
    public $showViewModal = false;
    public $selectedMasail = null;

    // Form properties
    #[Rule('required|string|max:255')]
    public $title = '';

    #[Rule('required|string')]
    public $question = '';

    #[Rule('nullable|string')]
    public $description = '';

    #[Rule('required|array|min:1')]
    public $selectedDiscussions = [];

    // Search properties
    public $search = '';
    public $perPage = 10;

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
        $this->selectedMasail = Masail::where('user_id', auth()->id())
                                    ->with('discussions')
                                    ->findOrFail($masailId);
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

        try {
            DB::beginTransaction();

            $masail = Masail::create([
                'title' => $this->title,
                'question' => $this->question,
                'description' => $this->description,
                'user_id' => auth()->id(),
            ]);

            $masail->discussions()->attach($this->selectedDiscussions);

            DB::commit();
            
            session()->flash('message', 'Masail berhasil ditambahkan!');
            $this->resetForm();
            $this->dispatch('masail-created');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat menyimpan masail. Silakan coba lagi.');
        }
    }

    public function update()
    {
        if (!$this->selectedMasail || $this->selectedMasail->user_id !== auth()->id()) {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengedit masail ini.');
            return;
        }

        $this->validate([
            'title' => 'required|string|max:255',
            'question' => 'required|string',
            'description' => 'nullable|string',
            'selectedDiscussions' => 'required|array|min:1',
            'selectedDiscussions.*' => 'exists:discussions,id'
        ]);

        try {
            DB::beginTransaction();

            $this->selectedMasail->update([
                'title' => $this->title,
                'question' => $this->question,
                'description' => $this->description,
            ]);

            $this->selectedMasail->discussions()->sync($this->selectedDiscussions);

            DB::commit();

            session()->flash('message', 'Masail berhasil diperbarui!');
            $this->resetForm();
            $this->dispatch('masail-updated');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat memperbarui masail. Silakan coba lagi.');
        }
    }

    public function delete($masailId)
    {
        try {
            $masail = Masail::where('user_id', auth()->id())->findOrFail($masailId);
            
            DB::beginTransaction();
            
            $masail->discussions()->detach();
            $masail->delete();
            
            DB::commit();

            session()->flash('message', 'Masail berhasil dihapus!');
            $this->dispatch('masail-deleted');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat menghapus masail. Silakan coba lagi.');
        }
    }

    public function show($masailId)
    {
        $this->selectedMasail = Masail::where('user_id', auth()->id())
            ->with(['discussions.chapter.book'])
            ->findOrFail($masailId);
        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->selectedMasail = null;
    }

    public function render()
    {
        // Only show current user's masail
        $masail = Masail::with('discussions.chapter.book')
            ->where('user_id', auth()->id())
            ->when($this->search, function ($query) {
                return $query->where(function($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('question', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate($this->perPage);

        // Only show discussions from current user's books
        $discussions = Discussion::whereHas('chapter.book', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('chapter.book')->get();

        return view('livewire.masail-management', [
            'masail' => $masail,
            'discussions' => $discussions
        ]);
    }
}
