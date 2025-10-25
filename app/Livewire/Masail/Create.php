<?php

namespace App\Livewire\Masail;

use Livewire\Component;
use App\Models\Masail;
use App\Models\Discussion;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public $title = '';
    public $question = '';
    public $description = '';
    public $selectedDiscussions = [];

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

    public function store()
    {
        $this->validate();

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
            
            return redirect()->route('masail.show', $masail);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat menyimpan masail. Silakan coba lagi.');
        }
    }

    public function render()
    {
        $discussions = Discussion::whereHas('chapter.book', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('chapter.book')->get();

        return view('livewire.masail.create', [
            'discussions' => $discussions
        ]);
    }
}