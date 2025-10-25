<div class="p-4 sm:p-6 lg:p-8 bg-white shadow-xl rounded-xl">
    <div class="sm:flex sm:justify-between sm:items-center mb-6 border-b pb-4">
        <h3 class="text-2xl font-bold text-gray-800">📚 Daftar Kitab</h3>
        <button wire:click="$set('showCreateForm', true)" 
                class="mt-4 sm:mt-0 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out">
            <svg class="w-5 h-5 inline-block mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Kitab Baru
        </button>
    </div>

    @if($showCreateForm)
        <div class="mb-8 p-6 border border-gray-200 rounded-xl shadow-lg bg-gray-50 transition-all duration-300 ease-in-out">
            <h4 class="text-xl font-semibold mb-4 text-indigo-700 border-b pb-2">Masukkan Data Kitab Baru</h4>
            <form wire:submit.prevent="createBook">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="col-span-1">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Kitab</label>
                        <input type="text" wire:model.defer="title" id="title" placeholder="Contoh: Shahih Bukhari"
                               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                        @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="col-span-full">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kitab</label>
                        <textarea wire:model.defer="description" id="description" rows="3" placeholder="Jelaskan secara singkat isi dari kitab ini"
                                  class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"></textarea>
                        @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div class="flex space-x-3 mt-6">
                    <button type="submit" 
                            class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 inline-block mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Kitab
                    </button>
                    <button type="button" wire:click="$set('showCreateForm', false)"
                            class="px-5 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    @endif

    @if($showEditForm && $editingBook)
        <div class="mb-8 p-6 border border-gray-200 rounded-xl shadow-lg bg-yellow-50 transition-all duration-300 ease-in-out">
            <h4 class="text-xl font-semibold mb-4 text-yellow-700 border-b pb-2">Perbarui Data Kitab</h4>
            <form wire:submit.prevent="updateBook">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="col-span-1">
                        <label for="edit_title" class="block text-sm font-medium text-gray-700 mb-1">Judul Kitab</label>
                        <input type="text" wire:model.defer="title" id="edit_title" 
                               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 transition duration-150 ease-in-out">
                        @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="col-span-full">
                        <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kitab</label>
                        <textarea wire:model.defer="description" id="edit_description" rows="3"
                                  class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 transition duration-150 ease-in-out"></textarea>
                        @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div class="flex space-x-3 mt-6">
                    <button type="submit" 
                            class="px-5 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 inline-block mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Update
                    </button>
                    <button type="button" wire:click="cancelEdit"
                            class="px-5 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    @endif

    <div class="overflow-x-auto shadow-lg rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-indigo-600">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                        Judul
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider hidden sm:table-cell">
                        Deskripsi
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider hidden md:table-cell">
                        Tanggal Dibuat
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($books as $book)
                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                        <td class="px-6 py-4 font-semibold text-gray-900">
                            {{ $book->title }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 hidden sm:table-cell">
                            {{ Str::limit($book->description, 70) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                            {{ $book->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex items-center justify-center space-x-2">
                                <button wire:click="editBook({{ $book->id }})"
                                        class="inline-flex items-center px-2 py-1 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-md shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-400"
                                        title="Edit">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    <span class="hidden md:inline">Edit</span>
                                </button>
                                <button wire:click="deleteBook({{ $book->id }})"
                                        wire:confirm.prompt="Ketik HAPUS untuk konfirmasi|HAPUS"
                                        class="inline-flex items-center px-2 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded-md shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-400"
                                        title="Hapus">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <span class="hidden md:inline">Hapus</span>
                                </button>
                                <a href="{{ route('books.chapters', $book->id) }}"
                                   class="inline-flex items-center px-2 py-1 bg-green-100 hover:bg-green-200 text-green-700 rounded-md shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-400"
                                   title="Kelola Bab">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m4 1h4M7 17h2m10 0h2"></path>
                                    </svg>
                                    <span class="hidden md:inline">Bab</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                     <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 italic">
                            Belum ada kitab yang ditambahkan. Silakan klik "Tambah Kitab Baru".
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($books->hasPages())
        <div class="mt-6 p-4 border-t border-gray-200">
            {{ $books->links() }}
        </div>
    @endif
</div>