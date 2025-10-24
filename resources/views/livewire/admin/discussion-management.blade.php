<div class="p-6">
    <!-- Navigation Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-gray-900">{{ $chapter->title }}</h3>
                <p class="text-gray-600">{{ $chapter->description }}</p>
                <p class="text-sm text-gray-500 mt-1">Kitab: {{ $book->title }}</p>
            </div>
            <a href="{{ route('admin.books.show', $bookId) }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali ke Daftar Bab
            </a>
        </div>
    </div>

    <!-- Discussion Management -->
    <div class="flex justify-between items-center mb-6">
        <h4 class="text-lg font-medium text-gray-900">Daftar Pembahasan</h4>
        <button wire:click="$set('showCreateForm', true)" 
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah Pembahasan Baru
        </button>
    </div>

    @if($showCreateForm)
        <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
            <h5 class="text-md font-medium mb-4">Tambah Pembahasan Baru</h5>
            <form wire:submit.prevent="createDiscussion">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Pembahasan</label>
                        <input type="text" wire:model="title" id="title" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700">Urutan</label>
                        <input type="number" wire:model="order" id="order" min="0"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div class="mt-4">
                    <label for="content" class="block text-sm font-medium text-gray-700">Isi Pembahasan</label>
                    <textarea wire:model="content" id="content" rows="6"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                              placeholder="Tulis isi pembahasan di sini..."></textarea>
                    @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="flex space-x-2 mt-4">
                    <button type="submit" 
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Simpan
                    </button>
                    <button type="button" wire:click="$set('showCreateForm', false)"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    @endif

    @if($showEditForm && $editingDiscussion)
        <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
            <h5 class="text-md font-medium mb-4">Edit Pembahasan</h5>
            <form wire:submit.prevent="updateDiscussion">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="edit_title" class="block text-sm font-medium text-gray-700">Judul Pembahasan</label>
                        <input type="text" wire:model="title" id="edit_title" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="edit_order" class="block text-sm font-medium text-gray-700">Urutan</label>
                        <input type="number" wire:model="order" id="edit_order" min="0"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div class="mt-4">
                    <label for="edit_content" class="block text-sm font-medium text-gray-700">Isi Pembahasan</label>
                    <textarea wire:model="content" id="edit_content" rows="6"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="flex space-x-2 mt-4">
                    <button type="submit" 
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Update
                    </button>
                    <button type="button" wire:click="cancelEdit"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    @endif

    <div class="space-y-4">
        @foreach($discussions as $discussion)
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <h5 class="text-lg font-semibold text-gray-900">{{ $discussion->title }}</h5>
                        <span class="text-sm text-gray-500">Urutan: {{ $discussion->order }}</span>
                    </div>
                    <div class="flex space-x-2">
                        <button wire:click="editDiscussion({{ $discussion->id }})" 
                                class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                            Edit
                        </button>
                        <button wire:click="deleteDiscussion({{ $discussion->id }})" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus pembahasan ini?')"
                                class="text-red-600 hover:text-red-900 text-sm font-medium">
                            Hapus
                        </button>
                    </div>
                </div>
                
                <div class="prose max-w-none">
                    <div class="text-gray-700 whitespace-pre-wrap">{{ $discussion->content }}</div>
                </div>
            </div>
        @endforeach
        
        @if($discussions->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">Belum ada pembahasan dalam bab ini.</p>
            </div>
        @endif
    </div>

    <div class="mt-6">
        {{ $discussions->links() }}
    </div>
</div>
