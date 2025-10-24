<div class="p-6">
    <!-- Book Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-gray-900">{{ $book->title }}</h3>
                <p class="text-gray-600">{{ $book->description }}</p>
            </div>
            <a href="{{ route('books.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali ke Daftar Kitab
            </a>
        </div>
    </div>

    <!-- Chapter Management -->
    <div class="flex justify-between items-center mb-6">
        <h4 class="text-lg font-medium text-gray-900">Daftar Bab</h4>
        <button wire:click="$set('showCreateForm', true)" 
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah Bab Baru
        </button>
    </div>

    @if($showCreateForm)
        <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
            <h5 class="text-md font-medium mb-4">Tambah Bab Baru</h5>
            <form wire:submit.prevent="createChapter">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Bab</label>
                        <input type="text" wire:model="title" id="title" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="parentId" class="block text-sm font-medium text-gray-700">Bab Induk (Opsional)</label>
                        <select wire:model="parentId" id="parentId" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Pilih Bab Induk --</option>
                            @foreach($availableParents as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->title }}</option>
                            @endforeach
                        </select>
                        @error('parentId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div class="mt-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea wire:model="description" id="description" rows="3"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="mt-4">
                    <label for="order" class="block text-sm font-medium text-gray-700">Urutan</label>
                    <input type="number" wire:model="order" id="order" min="0"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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

    @if($showEditForm && $editingChapter)
        <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
            <h5 class="text-md font-medium mb-4">Edit Bab</h5>
            <form wire:submit.prevent="updateChapter">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="edit_title" class="block text-sm font-medium text-gray-700">Judul Bab</label>
                        <input type="text" wire:model="title" id="edit_title" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="edit_parentId" class="block text-sm font-medium text-gray-700">Bab Induk (Opsional)</label>
                        <select wire:model="parentId" id="edit_parentId" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Pilih Bab Induk --</option>
                            @foreach($availableParents as $parent)
                                @if($parent->id !== $editingChapter->id)
                                    <option value="{{ $parent->id }}">{{ $parent->title }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('parentId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div class="mt-4">
                    <label for="edit_description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea wire:model="description" id="edit_description" rows="3"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="mt-4">
                    <label for="edit_order" class="block text-sm font-medium text-gray-700">Urutan</label>
                    <input type="number" wire:model="order" id="edit_order" min="0"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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

    <!-- Hierarchical Chapter Display -->
    <div class="space-y-4">
        @foreach($hierarchicalChapters as $chapter)
            <div class="bg-white border border-gray-200 rounded-lg" 
                 style="margin-left: {{ $chapter->level * 2 }}rem;">
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2">
                                @if($chapter->level > 0)
                                    <span class="text-gray-400">
                                        @for($i = 0; $i < $chapter->level; $i++)
                                            └─
                                        @endfor
                                    </span>
                                @endif
                                
                                <h5 class="text-lg font-semibold text-gray-900">
                                    @if($chapter->level === 0)
                                        📖 {{ $chapter->title }}
                                    @elseif($chapter->level === 1)
                                        📄 {{ $chapter->title }}
                                    @else
                                        📝 {{ $chapter->title }}
                                    @endif
                                </h5>
                                
                                <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                                    Urutan: {{ $chapter->order }}
                                </span>
                                
                                @if($chapter->children->count() > 0)
                                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                        {{ $chapter->children->count() }} sub bab
                                    </span>
                                @endif
                            </div>
                            
                            @if($chapter->description)
                                <p class="text-gray-600 text-sm mt-2" style="margin-left: {{ $chapter->level > 0 ? '2rem' : '0' }};">
                                    {{ $chapter->description }}
                                </p>
                            @endif
                            
                            @if($chapter->parent)
                                <p class="text-xs text-gray-500 mt-1" style="margin-left: {{ $chapter->level > 0 ? '2rem' : '0' }};">
                                    Sub bab dari: {{ $chapter->parent->title }}
                                </p>
                            @endif
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <button wire:click="editChapter({{ $chapter->id }})" 
                                    class="px-3 py-1 text-sm text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 rounded">
                                Edit
                            </button>
                            <button wire:click="deleteChapter({{ $chapter->id }})" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus bab ini dan semua sub babnya?')"
                                    class="px-3 py-1 text-sm text-red-600 hover:text-red-900 hover:bg-red-50 rounded">
                                Hapus
                            </button>
                            <a href="{{ route('books.discussions', ['bookId' => $bookId, 'chapterId' => $chapter->id]) }}" 
                               class="px-3 py-1 text-sm text-green-600 hover:text-green-900 hover:bg-green-50 rounded border border-green-200">
                                Kelola Pembahasan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        
        @if(empty($hierarchicalChapters))
            <div class="text-center py-8">
                <p class="text-gray-500">Belum ada bab dalam kitab ini.</p>
            </div>
        @endif
    </div>
</div>
