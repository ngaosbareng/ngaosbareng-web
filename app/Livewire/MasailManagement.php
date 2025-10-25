<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Masail;
use Illuminate\Support\Facades\DB;

class MasailManagement extends Component
{
    use WithPagination;

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

    public function updatingSearch()
    {
        $this->resetPage();
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
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat menghapus masail. Silakan coba lagi.');
        }
    }

    public function render()
    {
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

        return view('livewire.masail.index', [
            'masail' => $masail
        ]);
    }
}
