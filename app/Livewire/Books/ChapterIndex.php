<?php

namespace App\Livewire\Books;

use App\Models\Book;
use App\Models\Chapter;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule as LivewireRule;

class ChapterIndex extends Component
{
    use WithPagination;

    #[LivewireRule('exists:books,id')]
    public $bookId;

    public $book;

    public $selectedChapterId = '';
    public $parentChapterId = null;

    public function mount(Book $book)
    {
        $this->book = $book;
        $this->bookId = $book->id;
    }

    protected function getListeners()
    {
        return [
            'chapter-deleted' => 'updateOrder',
        ];
    }

    public $orderPosition = 'end';

    public $editingChapterId;

    public $newChapter = [
        'title' => '',
        'description' => '',
        'order' => null,
    ];

    public $newDiscussion = [
        'title' => '',
        'content' => '',
    ];

    public $editingChapter = [
        'title' => '',
        'description' => '',
        'order' => null,
    ];

    #[Computed]
    public function chapters(): Collection
    {
        if (!$this->book) {
            return collect();
        }
        return $this->book->chapters()->orderBy('order', 'asc')->get();
    }

    public function editChapter($chapterId)
    {
        $chapter = $this->book->chapters()->findOrFail($chapterId);
        $this->editingChapterId = $chapter->id;
        $this->editingChapter = [
            'title' => $chapter->title,
            'description' => $chapter->description,
            'order' => $chapter->order,
        ];

        $this->dispatch('edit-chapter-modal');
    }

    public function updateChapter()
    {
        $this->validate([
            'editingChapter.title' => 'required|string|min:3',
            'editingChapter.description' => 'nullable|string',
            'editingChapter.order' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('chapters', 'order')
                    ->where('book_id', $this->bookId)
                    ->ignore($this->editingChapterId),
            ],
        ]);

        $chapter = $this->book->chapters()->findOrFail($this->editingChapterId);
        $newOrder = $this->editingChapter['order'];
        $oldOrder = $chapter->order;

        // Reorder affected chapters if order has changed
        if ($newOrder !== $oldOrder) {
            if ($newOrder < $oldOrder) {
                // Moving chapter up: increment order of chapters in between
                $this->book->chapters()
                    ->where('order', '>=', $newOrder)
                    ->where('order', '<', $oldOrder)
                    ->increment('order');
            } else {
                // Moving chapter down: decrement order of chapters in between
                $this->book->chapters()
                    ->where('order', '>', $oldOrder)
                    ->where('order', '<=', $newOrder)
                    ->decrement('order');
            }
        }

        $chapter->update([
            'title' => $this->editingChapter['title'],
            'description' => $this->editingChapter['description'],
            'order' => $newOrder,
        ]);

        $this->resetEditingChapter();
        $this->dispatch('close-modal');
    }

    #[On('chapter-deleted')]
    public function updateOrder(): void
    {
        $this->chapters->each(function ($chapter, $index) {
            $chapter->update(['order' => $index + 1]);
        });
    }

    public function confirmDeleteChapter($chapterId)
    {
        $this->editingChapterId = $chapterId;
        $this->dispatch('delete-chapter-modal');
    }

    public function deleteChapter()
    {
        $chapter = $this->book->chapters()->findOrFail($this->editingChapterId);
        $deletedOrder = $chapter->order;

        // Delete chapter and its discussions
        $chapter->discussions()->delete();
        $chapter->delete();

        // Reorder remaining chapters
        $this->book->chapters()
            ->where('order', '>', $deletedOrder)
            ->decrement('order');

        $this->dispatch('close-modal');
    }

    public function storeChapter()
    {
        $this->validate([
            'newChapter.title' => 'required|string|min:3',
            'newChapter.description' => 'nullable|string',
            'newChapter.order' => 'nullable|integer|min:1',
            'orderPosition' => 'required|in:start,end,custom',
            'parentChapterId' => 'nullable|exists:chapters,id',
        ]);

        $query = $this->book->chapters();
        
        if ($this->parentChapterId) {
            $parentChapter = Chapter::find($this->parentChapterId);
            $lastOrder = $parentChapter->children()->max('order') ?? 0;
        } else {
            $lastOrder = $query->whereNull('parent_id')->max('order') ?? 0;
        }
        
        $order = match($this->orderPosition) {
            'start' => 1,
            'end' => $lastOrder + 1,
            'custom' => $this->newChapter['order'] ?? $lastOrder + 1,
            default => $lastOrder + 1,
        };

        // If inserting at start or custom position, shift existing chapters
        if ($this->orderPosition === 'start' || ($this->orderPosition === 'custom' && $order <= $lastOrder)) {
            $query->when($this->parentChapterId, function ($q) use ($order) {
                    $q->where('parent_id', $this->parentChapterId);
                }, function ($q) {
                    $q->whereNull('parent_id');
                })
                ->where('order', '>=', $order)
                ->increment('order');
        }

        $this->book->chapters()->create([
            'title' => $this->newChapter['title'],
            'description' => $this->newChapter['description'],
            'order' => $order,
            'parent_id' => $this->parentChapterId,
        ]);

        $this->resetNewChapter();
        $this->dispatch('close-modal');
    }

    public function storeDiscussion()
    {
        $this->validate([
            'selectedChapterId' => 'required|exists:chapters,id',
            'newDiscussion.title' => 'required|string|min:3',
            'newDiscussion.content' => 'required|string|min:10',
        ]);

        Chapter::find($this->selectedChapterId)->discussions()->create([
            'title' => $this->newDiscussion['title'],
            'content' => $this->newDiscussion['content'],
        ]);

        $this->resetNewDiscussion();
        $this->dispatch('close-modal');
    }

    public function resetNewChapter()
    {
        $this->reset(['newChapter', 'orderPosition', 'parentChapterId']);
    }

    public function resetNewDiscussion()
    {
        $this->reset('newDiscussion', 'selectedChapterId');
    }

    public function resetEditingChapter()
    {
        $this->reset('editingChapter', 'editingChapterId');
    }

    #[On('chapter-deleted')]
    public function render()
    {
        return view('livewire.books.chapter-index');
    }
}