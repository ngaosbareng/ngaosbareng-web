<div class="p-4 sm:p-8 bg-gray-50 min-h-screen font-sans">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 bg-white p-6 md:p-8 rounded-2xl shadow-lg border border-gray-100">
        <div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">
                <span class="text-indigo-600">📖</span> Kelola Masail
            </h1>
            <p class="text-gray-500 mt-1 text-base">Kumpulan pertanyaan dan referensi pembahasannya dari berbagai kitab.</p>
        </div>
        <button wire:click="openCreateForm"
                class="mt-4 md:mt-0 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-xl shadow-xl transition duration-300 ease-in-out transform hover:scale-[1.02] focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Masail Baru
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg mb-6 flex justify-between items-center shadow-md animate-fadeIn">
            <span class="font-medium">{{ session('message') }}</span>
            <button wire:click="$set('flashMessage', '')" class="text-green-600 hover:text-green-800 transition duration-150">
                <span class="text-xl font-bold">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-lg mb-6 flex justify-between items-center shadow-md animate-fadeIn">
            <span class="font-medium">{{ session('error') }}</span>
            <button wire:click="$set('flashMessage', '')" class="text-red-600 hover:text-red-800 transition duration-150">
                <span class="text-xl font-bold">&times;</span>
            </button>
        </div>
    @endif

    <div class="mb-8 flex flex-col lg:flex-row gap-4 bg-white p-6 rounded-xl shadow-lg border border-gray-100">
        <div class="flex-1">
            <label for="search" class="sr-only">Cari Masail</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <input type="text"
                       wire:model.live.debounce.300ms="search"
                       placeholder="Cari berdasarkan judul, pertanyaan, atau deskripsi..."
                       id="search"
                       class="w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out placeholder-gray-400">
            </div>
        </div>
        <div class="flex items-center gap-3 flex-shrink-0">
            <label for="perPage" class="text-sm font-medium text-gray-600">Tampilkan:</label>
            <select wire:model.live="perPage" id="perPage" class="border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out shadow-sm">
                <option value="10">10 per halaman</option>
                <option value="25">25 per halaman</option>
                <option value="50">50 per halaman</option>
                <option value="100">100 per halaman</option>
            </select>
        </div>
    </div>

    <div class="bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-100">
        <ul class="divide-y divide-gray-100">
            @forelse($masail as $item)
                <li class="px-6 py-5 hover:bg-indigo-50 transition duration-200 ease-in-out group">
                    <div class="flex flex-col sm:flex-row items-start justify-between gap-4">
                        <div class="flex-1 min-w-0" wire:click="show({{ $item->id }})" class="cursor-pointer">
                            <div class="flex items-center space-x-3 mb-1">
                                <h3 class="text-xl font-bold text-gray-900 truncate group-hover:text-indigo-600 transition duration-200 cursor-pointer">{{ $item->title }}</h3>
                                <span class="text-xs text-gray-400 font-medium whitespace-nowrap hidden sm:inline-block">
                                    {{ $item->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-gray-700 mt-2 line-clamp-2 italic">"{{ $item->question }}"</p>

                            @if($item->description)
                                <p class="text-gray-500 text-sm mt-1 line-clamp-1">{{ $item->description }}</p>
                            @endif

                            <div class="mt-4 flex flex-wrap gap-2 items-center">
                                @if($item->discussions->count() > 0)
                                    <span class="text-xs font-semibold text-indigo-700 bg-indigo-100 px-3 py-1.5 rounded-full border border-indigo-200 shadow-sm">
                                        {{ $item->discussions->count() }} Pembahasan Terkait
                                    </span>
                                @endif

                                @foreach($item->discussions->take(2) as $discussion)
                                    <span class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-blue-50 text-blue-700 rounded-full border border-blue-200">
                                        📚 {{ Str::limit($discussion->chapter->book->title, 20) }}
                                    </span>
                                @endforeach
                                @if($item->discussions->count() > 2)
                                    <span class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-gray-100 text-gray-600 rounded-full border border-gray-200">
                                        +{{ $item->discussions->count() - 2 }} lainnya
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex space-x-2 mt-4 sm:mt-0 sm:ml-4 flex-shrink-0">
                            <button wire:click="show({{ $item->id }})"
                                    class="text-blue-600 hover:text-white text-sm font-medium p-3 rounded-full hover:bg-blue-500 transition duration-200 ease-in-out shadow-md"
                                    title="Lihat Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                            <button wire:click="openEditForm({{ $item->id }})"
                                    class="text-indigo-600 hover:text-white text-sm font-medium p-3 rounded-full hover:bg-indigo-500 transition duration-200 ease-in-out shadow-md"
                                    title="Edit Masail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button wire:click="delete({{ $item->id }})"
                                    wire:confirm="Yakin ingin menghapus masail ini secara permanen?"
                                    class="text-red-600 hover:text-white text-sm font-medium p-3 rounded-full hover:bg-red-500 transition duration-200 ease-in-out shadow-md"
                                    title="Hapus Masail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-6 py-16 text-center text-gray-500">
                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M5.636 5.636l-.707.707m12.728 0A8 8 0 0112 21A8 8 0 015.636 5.636m12.728 0l-.707.707m-12.728 0l.707.707m7.071 5.657l.707.707m-7.071-.707l-.707.707M10 10h4m-2 2v4"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum ada Masail</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Mulai dengan menambahkan Masail baru untuk pengelolaan referensi kitab yang lebih mudah.
                    </p>
                    <div class="mt-6">
                        <button wire:click="openCreateForm"
                                class="inline-flex items-center px-6 py-3 border border-transparent shadow-lg text-base font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Masail
                        </button>
                    </div>
                </li>
            @endforelse
        </ul>
    </div>

    <div class="mt-8">
        {{ $masail->links() }}
    </div>

    @if($showCreateForm || $showEditForm)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <div class="fixed inset-0" wire:click="resetForm"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <form wire:submit.prevent="{{ $showCreateForm ? 'store' : 'update' }}">
                        <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-4">
                            <h3 class="text-2xl font-extrabold text-gray-900 mb-6 border-b pb-3">
                                {{ $showCreateForm ? 'Tambah Masail Baru' : 'Edit Masail' }}
                            </h3>

                            <div class="space-y-6">
                                <div>
                                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Masail <span class="text-red-500">*</span></label>
                                    <input type="text"
                                           id="title"
                                           wire:model="title"
                                           placeholder="Contoh: Hukum Wudhu saat Terkena Najis"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-3 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 shadow-sm">
                                    @error('title') <span class="mt-1 text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="question" class="block text-sm font-semibold text-gray-700 mb-2">Pertanyaan <span class="text-red-500">*</span></label>
                                    <textarea id="question"
                                              wire:model="question"
                                              rows="3"
                                              placeholder="Tuliskan pertanyaan inti yang menjadi dasar masail ini..."
                                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-3 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 shadow-sm"></textarea>
                                    @error('question') <span class="mt-1 text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi (Opsional)</label>
                                    <textarea id="description"
                                              wire:model="description"
                                              rows="2"
                                              placeholder="Berikan detail atau konteks tambahan untuk pertanyaan ini..."
                                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-3 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 shadow-sm"></textarea>
                                    @error('description') <span class="mt-1 text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Pembahasan Terkait (Pilih referensi dari kitab)
                                    </label>
                                    <div class="max-h-96 overflow-y-auto border-2 border-indigo-200 rounded-xl p-4 bg-indigo-50 shadow-inner">
                                        @forelse($discussions->groupBy('chapter.book.title') as $bookTitle => $bookDiscussions)
                                            <div class="mb-5 border-l-4 border-indigo-500 pl-4 bg-white p-3 rounded-lg shadow-sm">
                                                <h4 class="font-bold text-indigo-700 mb-2 text-md flex items-center">📚 {{ $bookTitle }}</h4>
                                                @foreach($bookDiscussions->groupBy('chapter.title') as $chapterTitle => $chapterDiscussions)
                                                    <div class="ml-4 mb-3 border-l border-gray-200 pl-3">
                                                        <h5 class="font-semibold text-gray-800 text-sm mb-1 border-b border-gray-100 pb-1 flex items-center">
                                                            <span class="mr-2 text-blue-500">📄</span> {{ $chapterTitle }}
                                                        </h5>
                                                        <div class="space-y-1 mt-2">
                                                            @foreach($chapterDiscussions as $discussion)
                                                                <label class="flex items-start cursor-pointer group hover:bg-gray-50 rounded-md p-1 -m-1 transition duration-100">
                                                                    <input type="checkbox"
                                                                           wire:model="selectedDiscussions"
                                                                           value="{{ $discussion->id }}"
                                                                           class="mr-3 mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                                    <span class="text-sm text-gray-600 group-hover:text-gray-800 transition duration-100 font-medium">📝 {{ $discussion->title }}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @empty
                                            <p class="text-center text-gray-500 py-4">Belum ada pembahasan yang bisa dipilih.</p>
                                        @endforelse
                                    </div>
                                    @error('selectedDiscussions') <span class="mt-1 text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 sm:px-8 flex flex-col-reverse sm:flex-row justify-end border-t border-gray-100">
                            <button type="button"
                                    wire:click="resetForm"
                                    class="mt-3 w-full inline-flex justify-center rounded-xl border-2 border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm transition duration-150">
                                Batal
                            </button>
                            <button type="submit"
                                    class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-lg px-6 py-3 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition duration-150 transform hover:scale-[1.02]">
                                {{ $showCreateForm ? 'Simpan Masail' : 'Update Masail' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if($showViewModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="view-modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <div class="fixed" wire:click="closeViewModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl sm:w-full">
                    <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-4">
                        <div class="w-full">
                            <div class="flex justify-between items-start mb-6 border-b pb-3">
                                <h3 class="text-3xl sm:text-4xl font-extrabold text-gray-900" id="view-modal-title">
                                    {{ $selectedMasail->title }}
                                </h3>
                                <button wire:click="closeViewModal" class="text-gray-400 hover:text-gray-600 p-2 -mr-2 transition duration-150">
                                    <span class="text-3xl font-light">&times;</span>
                                </button>
                            </div>

                            <div class="space-y-6">
                                <div class="p-5 bg-indigo-50 rounded-xl border-l-4 border-indigo-500 shadow-sm">
                                    <h4 class="text-xl font-bold text-indigo-700 mb-2 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c0-3.194 4.542-3.194 4.542 0M10.5 12c-2.122 0-3.844-1.748-3.844-3.883S8.378 4.234 10.5 4.234s3.844 1.748 3.844 3.883S12.622 12 10.5 12zM12 18v2m-6-1h12"/></svg>
                                        Pertanyaan:
                                    </h4>
                                    <p class="text-gray-800 text-lg italic mt-3">{{ $selectedMasail->question }}</p>
                                </div>

                                @if($selectedMasail->description)
                                    <div class="p-5 bg-gray-50 rounded-xl border-l-4 border-gray-300 shadow-sm">
                                        <h4 class="text-xl font-bold text-gray-700 mb-2 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Deskripsi Tambahan:
                                        </h4>
                                        <p class="text-gray-700 mt-3">{{ $selectedMasail->description }}</p>
                                    </div>
                                @endif

                                <div>
                                    <h4 class="text-2xl font-extrabold text-gray-900 mb-4">Referensi Kitab / Pembahasan Terkait:</h4>
                                    <div class="space-y-5 max-h-[60vh] overflow-y-auto p-4 border border-gray-200 rounded-xl bg-white shadow-inner">
                                        @forelse($selectedMasail->discussions->groupBy('chapter.book.title') as $bookTitle => $bookDiscussions)
                                            <div class="border border-blue-200 rounded-xl p-5 shadow-lg bg-blue-50">
                                                <h5 class="text-xl font-bold text-blue-800 flex items-center mb-3 border-b border-blue-200 pb-2">
                                                    <span class="text-2xl mr-2">📚</span> {{ $bookTitle }}
                                                </h5>
                                                <div class="space-y-4 pl-4 border-l-2 border-blue-300">
                                                    @foreach($bookDiscussions->groupBy('chapter.title') as $chapterTitle => $chapterDiscussions)
                                                        <div class="pt-2">
                                                            <h6 class="font-bold text-gray-900 flex items-center mb-1">
                                                                <span class="text-xl mr-2 text-blue-600">📄</span> {{ $chapterTitle }}
                                                            </h6>
                                                            <ul class="ml-8 mt-1 space-y-1 text-base list-disc">
                                                                @foreach($chapterDiscussions as $discussion)
                                                                    <li class="text-gray-700">
                                                                        <span class="font-medium">📝 {{ $discussion->title }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-center text-gray-500 py-6 text-lg">Masail ini belum merujuk ke pembahasan manapun.</p>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="mt-6 pt-4 border-t border-gray-200 text-sm text-gray-600">
                                    <p>Dibuat: <span class="font-semibold text-gray-800">{{ $selectedMasail->created_at->format('d M Y, H:i') }}</span></p>
                                    @if($selectedMasail->created_at != $selectedMasail->updated_at)
                                        <p>Terakhir diupdate: <span class="font-semibold text-gray-800">{{ $selectedMasail->updated_at->format('d M Y, H:i') }}</span></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 sm:px-8 flex justify-end border-t border-gray-100">
                        <button wire:click="closeViewModal"
                                class="inline-flex justify-center px-6 py-3 text-base font-medium text-gray-700 bg-white border-2 border-gray-300 rounded-xl shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>