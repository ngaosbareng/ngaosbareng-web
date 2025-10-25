<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Kelola Masail</h2>
            <p class="text-gray-600 mt-1">Kelola kumpulan pertanyaan yang merujuk ke pembahasan dari berbagai kitab</p>
        </div>
        <button wire:click="openCreateForm" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Tambah Masail
        </button>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex justify-between items-center">
            <span>{{ session('message') }}</span>
            <button wire:click="$set('flashMessage', '')" class="text-green-700 hover:text-green-900">
                <span class="text-2xl">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex justify-between items-center">
            <span>{{ session('error') }}</span>
            <button wire:click="$set('flashMessage', '')" class="text-red-700 hover:text-red-900">
                <span class="text-2xl">&times;</span>
            </button>
        </div>
    @endif

    <!-- Search and Filter Controls -->
    <div class="mb-6 flex gap-4">
        <div class="flex-1">
            <input type="text" 
                   wire:model.live="search" 
                   placeholder="Cari masail berdasarkan judul, pertanyaan, atau deskripsi..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="flex items-center gap-2">
            <label for="perPage" class="text-sm text-gray-600">Tampilkan:</label>
            <select wire:model.live="perPage" id="perPage" class="border border-gray-300 rounded-lg px-2 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>

    <!-- Masail List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @forelse($masail as $item)
                <li class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $item->title }}</h3>
                                        <span class="text-sm text-gray-500">
                                            {{ $item->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button wire:click="show({{ $item->id }})" 
                                                class="text-blue-600 hover:text-blue-900 text-sm flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Lihat
                                        </button>
                                        <button wire:click="openEditForm({{ $item->id }})" 
                                                class="text-indigo-600 hover:text-indigo-900 text-sm flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </button>
                                        <button wire:click="delete({{ $item->id }})" 
                                                wire:confirm="Yakin ingin menghapus masail ini?"
                                                class="text-red-600 hover:text-red-900 text-sm flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>
                                </div>                            <p class="text-gray-700 mt-2">{{ $item->question }}</p>
                            
                            @if($item->description)
                                <p class="text-gray-500 text-sm mt-1">{{ $item->description }}</p>
                            @endif
                            
                            <!-- Related Discussions -->
                            <div class="mt-3">
                                <p class="text-sm font-medium text-gray-900 mb-2">
                                    Merujuk ke {{ $item->discussions->count() }} pembahasan:
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($item->discussions as $discussion)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            📚 {{ $discussion->chapter->book->title }} → 
                                            📄 {{ $discussion->chapter->title }} → 
                                            📝 {{ $discussion->title }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-6 py-4 text-center text-gray-500">
                    Belum ada masail. Klik "Tambah Masail" untuk membuat yang pertama.
                </li>
            @endforelse
        </ul>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $masail->links() }}
    </div>

    <!-- Create/Edit Form Modal -->
    @if($showCreateForm || $showEditForm)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="resetForm"></div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <form wire:submit.prevent="{{ $showCreateForm ? 'store' : 'update' }}">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                        {{ $showCreateForm ? 'Tambah Masail Baru' : 'Edit Masail' }}
                                    </h3>

                                    <!-- Title -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul Masail</label>
                                        <input type="text" 
                                               wire:model="title" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Question -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Pertanyaan</label>
                                        <textarea wire:model="question" 
                                                  rows="3" 
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                        @error('question') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (Opsional)</label>
                                        <textarea wire:model="description" 
                                                  rows="2" 
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Related Discussions -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Pembahasan Terkait (Pilih pembahasan dari berbagai kitab)
                                        </label>
                                        <div class="max-h-60 overflow-y-auto border border-gray-300 rounded-md p-3">
                                            @foreach($discussions->groupBy('chapter.book.title') as $bookTitle => $bookDiscussions)
                                                <div class="mb-4">
                                                    <h4 class="font-medium text-gray-900 mb-2">📚 {{ $bookTitle }}</h4>
                                                    @foreach($bookDiscussions->groupBy('chapter.title') as $chapterTitle => $chapterDiscussions)
                                                        <div class="ml-4 mb-2">
                                                            <h5 class="font-medium text-gray-700 text-sm mb-1">📄 {{ $chapterTitle }}</h5>
                                                            @foreach($chapterDiscussions as $discussion)
                                                                <label class="flex items-center ml-4 mb-1">
                                                                    <input type="checkbox" 
                                                                           wire:model="selectedDiscussions" 
                                                                           value="{{ $discussion->id }}" 
                                                                           class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                                    <span class="text-sm text-gray-600">📝 {{ $discussion->title }}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('selectedDiscussions') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" 
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                {{ $showCreateForm ? 'Simpan' : 'Update' }}
                            </button>
                            <button type="button" 
                                    wire:click="resetForm" 
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- View Modal -->
    @if($showViewModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="closeViewModal"></div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="w-full">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-2xl font-bold text-gray-900">
                                        {{ $selectedMasail->title }}
                                    </h3>
                                    <button wire:click="closeViewModal" class="text-gray-400 hover:text-gray-500">
                                        <span class="text-2xl">&times;</span>
                                    </button>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <h4 class="text-lg font-medium text-gray-900 mb-2">Pertanyaan:</h4>
                                        <p class="text-gray-700">{{ $selectedMasail->question }}</p>
                                    </div>

                                    @if($selectedMasail->description)
                                        <div>
                                            <h4 class="text-lg font-medium text-gray-900 mb-2">Deskripsi:</h4>
                                            <p class="text-gray-700">{{ $selectedMasail->description }}</p>
                                        </div>
                                    @endif

                                    <div>
                                        <h4 class="text-lg font-medium text-gray-900 mb-2">Pembahasan Terkait:</h4>
                                        <div class="space-y-2">
                                            @foreach($selectedMasail->discussions->groupBy('chapter.book.title') as $bookTitle => $bookDiscussions)
                                                <div class="border-l-4 border-blue-500 pl-4">
                                                    <h5 class="font-medium text-gray-900">📚 {{ $bookTitle }}</h5>
                                                    @foreach($bookDiscussions->groupBy('chapter.title') as $chapterTitle => $chapterDiscussions)
                                                        <div class="ml-4 mt-2">
                                                            <h6 class="font-medium text-gray-700">📄 {{ $chapterTitle }}</h6>
                                                            <ul class="ml-4 mt-1 space-y-1">
                                                                @foreach($chapterDiscussions as $discussion)
                                                                    <li class="text-gray-600">📝 {{ $discussion->title }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="mt-4 text-sm text-gray-500">
                                        Dibuat: {{ $selectedMasail->created_at->format('d M Y H:i') }}
                                        @if($selectedMasail->created_at != $selectedMasail->updated_at)
                                            <br>
                                            Terakhir diupdate: {{ $selectedMasail->updated_at->format('d M Y H:i') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
                        <button wire:click="closeViewModal" 
                                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
