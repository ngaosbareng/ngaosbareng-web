<div>
    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed top-4 right-4 z-50 rounded-lg bg-green-50 p-4 shadow-xl border border-green-200"
            role="alert">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-green-800">
                        {{ session('message') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <header>
        <div class="flex justify-between items-center mb-8 border-b border-gray-200 pb-4">
            <h2 class="font-extrabold text-4xl text-gray-900 tracking-tight">
                {{ $book->title }}
            </h2>
            <div class="flex items-center gap-4">
                <a href="{{ route('books.index') }}"
                    class="inline-flex items-center justify-center gap-2 text-base font-semibold text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali ke Daftar Kitab</span>
                </a>
                <button x-data @click="$dispatch('create-modal')"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-xl shadow-lg hover:bg-indigo-700 transition transform hover:scale-[1.02]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span class="font-semibold">Tambah Bab/Pembahasan</span>
                </button>
            </div>
        </div>
    </header>

    <section class="mt-8">
        {{-- Deskripsi Kitab --}}
        <div class="mb-10 border-l-4 border-indigo-600 pl-6 py-4 bg-indigo-50/70 rounded-2xl shadow-md">
            <p class="text-gray-700 italic text-xl">
                "{{ $book->description }}"
            </p>
        </div>

        {{-- Daftar Bab --}}
        @if ($this->chapters->count() > 0)
            <h3 class="text-3xl font-extrabold text-gray-800 mb-7 tracking-tight">
                Daftar Isi Kitab
            </h3>
            <div class="space-y-4">
                @foreach ($this->chapters as $chapter)
                    @php
                        // Properti 'level' disuntikkan oleh function 'flattenChapters' di Livewire class
                        $level_indent = $chapter->level * 28;
                        $level_class = '';
                        $level_icon = '';
                        if ($chapter->level == 0) {
                            $level_class = 'bg-indigo-50 border-indigo-400 font-extrabold shadow-lg';
                            $level_icon = '📘';
                        } elseif ($chapter->level == 1) {
                            $level_class = 'bg-white border-gray-200 font-semibold';
                            $level_icon = '📖';
                        } else {
                            $level_class = 'bg-gray-50 border-gray-100 text-base';
                            $level_icon = '•';
                        }
                    @endphp

                    <div class="block border rounded-xl p-5 transition-all duration-300 ease-in-out hover:shadow-xl bg-white border-gray-200">
                        <div class="flex items-start justify-between">
                            {{-- Info Bab --}}
                            <div class="flex items-start flex-1 mr-4">
                                <span class="text-lg font-bold mr-4 text-indigo-600 bg-indigo-50 rounded-full w-8 h-8 flex items-center justify-center">
                                    {{ $chapter->order }}
                                </span>
                                <div class="w-full">
                                    <h4 class="text-lg text-gray-900 leading-snug">
                                        {{-- Catatan: Rute 'books.discussions' harus menerima model Chapter --}}
                                        <a href="{{ route('books.discussions', $chapter) }}" class="hover:underline focus:outline-none focus:ring focus:ring-indigo-300 rounded-md">
                                            {{ $chapter->title }}
                                        </a>
                                    </h4>
                                    @if ($chapter->description)
                                        <p class="text-gray-600 text-sm mt-1 leading-relaxed">
                                            {{ $chapter->description }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Actions --}}
                            <div class="flex items-center space-x-3 sm:space-x-4">
                                <div
                                    class="text-sm font-bold text-indigo-700 bg-indigo-200/50 px-3 py-1 rounded-full whitespace-nowrap hidden sm:block">
                                    {{ $chapter->discussions->count() }} Pembahasan
                                </div>
                                {{-- Add Discussion --}}
                                <button x-data @click="$dispatch('create-modal'); $nextTick(() => { type = 'discussion'; document.getElementById('selectedChapterId').value = {{ $chapter->id }} })"
                                    class="text-green-600 hover:text-green-800 p-2 rounded-full hover:bg-green-100 transition"
                                    aria-label="Tambah Pembahasan untuk {{ $chapter->title }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </button>
                                {{-- Edit Chapter --}}
                                <button wire:click="editChapter({{ $chapter->id }})" 
                                        class="text-indigo-600 hover:text-indigo-800 p-2 rounded-full hover:bg-indigo-100 transition"
                                        aria-label="Edit bab {{ $chapter->title }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                {{-- Delete Chapter --}}
                                <button wire:click="confirmDeleteChapter({{ $chapter->id }})"
                                    class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-100 transition"
                                    aria-label="Hapus bab {{ $chapter->title }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Kosong State --}}
            <div class="text-center py-16 border-2 border-dashed border-gray-300 rounded-2xl bg-gray-50/80 mt-12">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    aria-hidden="true">
                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="M12 6v-3m0 18v-3m0-12a9 9 0 100 18 9 9 0 000-18zm-9 9h3m18 0h-3" />
                </svg>
                <h3 class="mt-4 text-xl font-semibold text-gray-900">Belum ada bab</h3>
                <p class="mt-2 text-base text-gray-500">
                    Mulai tambahkan bab pertama untuk kitab ini.
                </p>
                <div class="mt-6">
                    <button x-data @click="$dispatch('create-modal')"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Tambah Bab/Pembahasan</span>
                    </button>
                </div>
            </div>
        @endif
    </section>

    {{-- CREATE MODAL --}}
    <div x-data="{ open: false, type: 'chapter' }" @create-modal.window="open = true" @close-modal.window="open = false">
        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-[99]"></div>

        <div x-show="open" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="fixed inset-0 z-[100] overflow-y-auto" role="dialog" aria-modal="true"
            aria-labelledby="create-modal-title">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="absolute right-0 top-0 hidden pr-4 pt-4 sm:block">
                            <button @click="open = false" type="button" class="rounded-md bg-white text-gray-400 hover:text-gray-500 p-1 transition" aria-label="Tutup Modal">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {{-- Tab Selector --}}
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                <button @click="type = 'chapter'" :class="{'border-indigo-500 text-indigo-600': type === 'chapter', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': type !== 'chapter'}"
                                    class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                                    Bab Baru
                                </button>
                                <button @click="type = 'discussion'" :class="{'border-indigo-500 text-indigo-600': type === 'discussion', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': type !== 'discussion'}"
                                    class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                                    Pembahasan Baru
                                </button>
                            </nav>
                        </div>

                        {{-- Chapter Form --}}
                        <form x-show="type === 'chapter'" wire:submit.prevent="storeChapter" class="mt-4">
                            <div class="space-y-4">
                                <div>
                                    <label for="newChapter.title" class="block text-sm font-medium text-gray-700">Judul Bab</label>
                                    <input type="text" wire:model.blur="newChapter.title" id="newChapter.title" 
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('newChapter.title') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="newChapter.description" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                                    <textarea wire:model.blur="newChapter.description" id="newChapter.description" rows="3"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                    @error('newChapter.description') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Posisi</label>
                                    <div class="mt-2 space-y-2">
                                        <div class="flex items-center">
                                            <input type="radio" wire:model="orderPosition" value="start" id="order-start"
                                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                            <label for="order-start" class="ml-3 text-sm text-gray-700">Di awal (sebelum semua bab)</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" wire:model="orderPosition" value="end" id="order-end"
                                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                            <label for="order-end" class="ml-3 text-sm text-gray-700">Di akhir (setelah semua bab)</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" wire:model="orderPosition" value="custom" id="order-custom"
                                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                            <label for="order-custom" class="ml-3 text-sm text-gray-700">Urutan khusus</label>
                                        </div>
                                    </div>
                                    @if($orderPosition === 'custom')
                                        <div class="mt-3">
                                            <label for="newChapter.order" class="block text-sm font-medium text-gray-700">Nomor Urut</label>
                                            <input type="number" wire:model.defer="newChapter.order" id="newChapter.order"
                                                class="mt-1 block w-24 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                min="1">
                                        </div>
                                    @endif
                                    @error('newChapter.order') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse">
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-indigo-700 sm:ml-3 sm:w-auto transition">
                                    Tambah Bab
                                </button>
                                <button @click="open = false" type="button"
                                    class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition">
                                    Batal
                                </button>
                            </div>
                        </form>

                        {{-- Discussion Form --}}
                        <form x-show="type === 'discussion'" wire:submit.prevent="storeDiscussion" class="mt-4">
                            <div class="space-y-4">
                                <div class="mb-4">
                                    <label for="selectedChapterId" class="block text-sm font-medium text-gray-700">Pilih Bab</label>
                                    <select wire:model="selectedChapterId" id="selectedChapterId"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Pilih Bab</option>
                                        @foreach($this->chapters as $chapter)
                                            <option value="{{ $chapter->id }}">{{ $chapter->order }}. {{ $chapter->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('selectedChapterId') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="newDiscussion.title" class="block text-sm font-medium text-gray-700">Judul Pembahasan</label>
                                    <input type="text" wire:model.blur="newDiscussion.title" id="newDiscussion.title" 
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('newDiscussion.title') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="newDiscussion.content" class="block text-sm font-medium text-gray-700">Isi Pembahasan</label>
                                    <textarea wire:model.blur="newDiscussion.content" id="newDiscussion.content" rows="5"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                    @error('newDiscussion.content') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse">
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-indigo-700 sm:ml-3 sm:w-auto transition">
                                    Tambah Pembahasan
                                </button>
                                <button @click="open = false" type="button"
                                    class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- EDIT CHAPTER MODAL --}}
    <div x-data="{ open: false }" @edit-chapter-modal.window="open = true" @close-modal.window="open = false">
        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-[99]"></div>

        <div x-show="open" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="fixed inset-0 z-[100] overflow-y-auto" role="dialog" aria-modal="true"
            aria-labelledby="edit-chapter-modal-title">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <form wire:submit.prevent="updateChapter">
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="absolute right-0 top-0 hidden pr-4 pt-4 sm:block">
                                <button @click="open = false" type="button" class="rounded-md bg-white text-gray-400 hover:text-gray-500 p-1 transition" aria-label="Tutup Modal">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold leading-6 text-gray-900" id="edit-chapter-modal-title">Edit Bab</h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label for="editingChapter.title" class="block text-sm font-medium text-gray-700">Judul</label>
                                        <input type="text" wire:model.blur="editingChapter.title" id="editingChapter.title" 
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        {{-- CATATAN: Validasi untuk 'editingChapter' perlu didefinisikan di Livewire class sebelum update --}}
                                        @error('editingChapter.title') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="editingChapter.description" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                                        <textarea wire:model.blur="editingChapter.description" id="editingChapter.description" rows="3"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                        @error('editingChapter.description') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="editingChapter.order" class="block text-sm font-medium text-gray-700">Urutan</label>
                                        <input type="number" wire:model.defer="editingChapter.order" id="editingChapter.order"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            min="1">
                                        @error('editingChapter.order') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-indigo-700 sm:ml-3 sm:w-auto transition">
                                Simpan Perubahan
                            </button>
                            <button @click="open = false" type="button"
                                class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- DELETE CHAPTER MODAL --}}
    <div x-data="{ open: false }" @delete-chapter-modal.window="open = true" @close-modal.window="open = false">
        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-[99]"></div>

        <div x-show="open" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="fixed inset-0 z-[100] overflow-y-auto" role="dialog" aria-modal="true"
            aria-labelledby="delete-chapter-modal-title">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900" id="delete-chapter-modal-title">Hapus Bab</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Apakah Anda yakin ingin menghapus bab ini? Tindakan ini akan **menghapus semua pembahasan** dalam bab ini dan tidak dapat dibatalkan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button wire:click="deleteChapter" type="button"
                            class="inline-flex w-full justify-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-red-700 sm:ml-3 sm:w-auto transition">
                            Hapus
                        </button>
                        <button @click="open = false" type="button"
                            class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>