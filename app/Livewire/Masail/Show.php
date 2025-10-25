<?php

namespace App\Livewire\Masail;

use Livewire\Component;
use App\Models\Masail;

class Show extends Component
{
    public Masail $masail;

    public function mount(Masail $masail)
    {
        if ($masail->user_id !== auth()->id()) {
            return redirect()->route('masail.index');
        }

        $this->masail = $masail->load('discussions.chapter.book');
    }

    public function delete()
    {
        if ($this->masail->user_id !== auth()->id()) {
            session()->flash('error', 'Anda tidak memiliki akses untuk menghapus masail ini.');
            return redirect()->route('masail.index');
        }

        try {
            $this->masail->discussions()->detach();
            $this->masail->delete();

            session()->flash('message', 'Masail berhasil dihapus!');
            return redirect()->route('masail.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menghapus masail. Silakan coba lagi.');
        }
    }

    public function render()
    {
        return view('livewire.masail.show');
    }
}