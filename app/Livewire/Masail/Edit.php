<?php

namespace App\Livewire\Masail;

use Livewire\Component;
use App\Models\Masail;
use App\Models\Discussion;
use Illuminate\Support\Facades\DB;

class Edit extends Component
{
    public Masail $masail;
    public $title;
    public $question;
    public $description;
    public $selectedDiscussions = [];

    public function mount(Masail $masail)
    {
        if ($masail->user_id !== auth()->id()) {
            return redirect()->route('masail.index');
        }

        $this->masail = $masail;
        $this->title = $masail->title;
        $this->question = $masail->question;
        $this->description = $masail->description;
        $this->selectedDiscussions = $masail->discussions->pluck('id')->toArray();
    }

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'question' => 'required|string',
            'description' => 'nullable|string',
            'selectedDiscussions' => 'required|array|min:1',
            'selectedDiscussions.*' => 'exists:discussions,id'
        ];
    }

    public function update()
    {
        if ($this->masail->user_id !== auth()->id()) {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengedit masail ini.');
            return redirect()->route('masail.index');
        }

        $this->validate();

        try {
            DB::beginTransaction();

            $this->masail->update([
                'title' => $this->title,
                'question' => $this->question,
                'description' => $this->description,
            ]);

            $this->masail->discussions()->sync($this->selectedDiscussions);

            DB::commit();

            session()->flash('message', 'Masail berhasil diperbarui!');
            
            return redirect()->route('masail.show', $this->masail);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat memperbarui masail. Silakan coba lagi.');
        }
    }

    public function render()
    {
        $discussions = Discussion::whereHas('chapter.book', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('chapter.book')->get();

        return view('livewire.masail.edit', [
            'discussions' => $discussions
        ]);
    }
}