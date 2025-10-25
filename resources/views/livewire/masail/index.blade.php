<div>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Kelola Masail</h2>
                <p class="text-gray-600 mt-1">Kelola kumpulan pertanyaan yang merujuk ke pembahasan dari berbagai kitab</p>
            </div>
            <a href="{{ route('masail.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Masail
            </a>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex justify-between items-center">
                <span>{{ session('message') }}</span>
                <button type="button" wire:click="$set('flashMessage', '')" class="text-green-700 hover:text-green-900">
                    <span class="text-2xl">&times;</span>
                </button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex justify-between items-center">
                <span>{{ session('error') }}</span>
                <button type="button" wire:click="$set('flashMessage', '')" class="text-red-700 hover:text-red-900">
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
                                        <a href="{{ route('masail.show', $item) }}" 
                                           class="text-blue-600 hover:text-blue-900 text-sm flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Lihat
                                        </a>
                                        <a href="{{ route('masail.edit', $item) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 text-sm flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </a>
                                        <button wire:click="delete({{ $item->id }})" 
                                                wire:confirm="Yakin ingin menghapus masail ini?"
                                                class="text-red-600 hover:text-red-900 text-sm flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                                
                                <p class="text-gray-700 mt-2">{{ $item->question }}</p>
                                
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
    </div>
</div>