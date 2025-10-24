<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-medium text-gray-900">Daftar Kitab</h3>
        <button wire:click="$set('showCreateForm', true)" 
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah Kitab Baru
        </button>
    </div>

    @if($showCreateForm)
        <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
            <h4 class="text-md font-medium mb-4">Tambah Kitab Baru</h4>
            <form wire:submit.prevent="createBook">
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                    <input type="text" wire:model="title" id="title" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea wire:model="description" id="description" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="flex space-x-2">
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

    @if($showEditForm && $editingBook)
        <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
            <h4 class="text-md font-medium mb-4">Edit Kitab</h4>
            <form wire:submit.prevent="updateBook">
                <div class="mb-4">
                    <label for="edit_title" class="block text-sm font-medium text-gray-700">Judul</label>
                    <input type="text" wire:model="title" id="edit_title" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-4">
                    <label for="edit_description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea wire:model="description" id="edit_description" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="flex space-x-2">
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
                        Judul
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Deskripsi
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal Dibuat
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($books as $book)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $book->title }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ Str::limit($book->description, 100) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $book->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button wire:click="editBook({{ $book->id }})" 
                                    class="text-indigo-600 hover:text-indigo-900">
                                Edit
                            </button>
                            <button wire:click="deleteBook({{ $book->id }})" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus kitab ini?')"
                                    class="text-red-600 hover:text-red-900">
                                Hapus
                            </button>
                            <a href="{{ route('books.show', $book->id) }}" 
                               class="text-green-600 hover:text-green-900">
                                Kelola Bab
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $books->links() }}
    </div>
</div>
