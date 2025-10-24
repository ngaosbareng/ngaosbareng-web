<div class="p-6">
    <!-- Book Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-gray-900">{{ $book->title }}</h3>
                <p class="text-gray-600">{{ $book->description }}</p>
            </div>
            <a href="{{ route('admin.books.index') }}" 
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

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Judul Bab
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Bab Induk
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Urutan
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Sub Bab
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($chapters as $chapter)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $chapter->title }}</div>
                            @if($chapter->description)
                                <div class="text-sm text-gray-500">{{ Str::limit($chapter->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $chapter->parent ? $chapter->parent->title : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $chapter->order }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $chapter->children->count() }} sub bab
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button wire:click="editChapter({{ $chapter->id }})" 
                                    class="text-indigo-600 hover:text-indigo-900">
                                Edit
                            </button>
                            <button wire:click="deleteChapter({{ $chapter->id }})" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus bab ini?')"
                                    class="text-red-600 hover:text-red-900">
                                Hapus
                            </button>
                            <a href="{{ route('admin.books.show', ['id' => $bookId, 'chapter' => $chapter->id]) }}" 
                               class="text-green-600 hover:text-green-900">
                                Kelola Pembahasan
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $chapters->links() }}
    </div>
</div>
