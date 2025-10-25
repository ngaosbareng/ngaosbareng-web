<div>
    <header>
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-900 leading-tight tracking-tight">
                {{ $book->title }}
            </h2>
            <a href="{{ route('books.index') }}"
                class="inline-flex items-center gap-2 text-base font-semibold text-indigo-600 hover:text-indigo-800 transition duration-150 ease-in-out">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Daftar Kitab</span>
            </a>
        </div>
    </header>

    <section class="p-4">
        {{-- Deskripsi Kitab --}}
        <div class="mb-10 border-l-4 border-indigo-500 pl-6 py-4 bg-indigo-50/60 rounded-xl shadow-sm">
            <p class="text-gray-700 italic text-lg">
                "{{ $book->description }}"
            </p>
        </div>

        {{-- Daftar Bab --}}
        @if (count($chapters) > 0)
            <h3 class="text-2xl font-bold text-gray-800 mb-7 border-b-2 border-indigo-100 pb-3">
                Daftar Isi Kitab
            </h3>
            <div class="space-y-5">
                @foreach ($chapters as $chapter)
                    @php
                        $level_indent = $chapter->level * 28;
                        $level_class = '';
                        $level_icon = '';
                        if ($chapter->level == 0) {
                            $level_class = 'bg-indigo-100/80 border-indigo-300 font-bold';
                            $level_icon = '📚';
                        } elseif ($chapter->level == 1) {
                            $level_class = 'bg-white border-gray-200';
                            $level_icon = '📝';
                        } else {
                            $level_class = 'bg-white border-gray-100 text-base';
                            $level_icon = '•';
                        }
                    @endphp

                    <div class="block border rounded-xl p-5 shadow hover:shadow-lg transition-shadow duration-200 ease-in-out {{ $level_class }}"
                        style="margin-left: {{ $level_indent }}px;">
                        <div class="flex items-start justify-between">
                            {{-- Info Bab --}}
                            <div class="flex items-start flex-1 mr-4">
                                <span class="text-2xl mr-4 mt-0.5"
                                    title="Level {{ $chapter->level }}">{{ $level_icon }}</span>
                                <div class="w-full">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900 leading-snug">
                                                <a href="{{ route('books.discussions', $chapter) }}" class="hover:underline">
                                                    {{ $chapter->title }}
                                                </a>
                                            </h4>
                                            @if ($chapter->description)
                                                <p class="text-gray-600 text-sm mt-1 leading-relaxed">
                                                    {{ $chapter->description }}
                                                </p>
                                            @endif
                                        </div>
                                        <button wire:click="editChapter({{ $chapter->id }})" 
                                                class="text-indigo-600 hover:text-indigo-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {{-- Actions --}}
                            <div class="flex items-center space-x-4">
                                <button wire:click="addDiscussion({{ $chapter->id }})"
                                    class="text-indigo-600 hover:text-indigo-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </button>
                                {{-- Jumlah Pembahasan --}}
                                <div
                                    class="text-sm font-semibold text-indigo-700 bg-indigo-100 px-4 py-1.5 rounded-full shadow-sm whitespace-nowrap">
                                    {{ $chapter->discussions->count() }} Pembahasan
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Kosong State --}}
            <div class="text-center py-16 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50">
                <svg class="mx-auto h-14 w-14 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    aria-hidden="true">
                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="M12 6v-3m0 18v-3m0-12a9 9 0 100 18 9 9 0 000-18zm-9 9h3m18 0h-3" />
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum ada bab</h3>
                <p class="mt-2 text-base text-gray-500">
                    Mulai tambahkan bab untuk kitab ini.
                </p>
            </div>
        @endif
    </section>

    {{-- Edit Chapter Modal --}}
    <div x-data="{ open: false }" @edit-chapter-modal.window="open = true" @close-modal.window="open = false">
        <div x-show="open" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div x-show="open" 
             class="fixed inset-0 z-10 overflow-y-auto"
             @click.away="open = false">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    <div class="absolute right-0 top-0 hidden pr-4 pt-4 sm:block">
                        <button @click="open = false" type="button" class="rounded-md bg-white text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <form wire:submit.prevent="updateChapter">
                        <div>
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Edit Bab</h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                                    <input type="text" wire:model.defer="editingChapter.title" id="title" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                    <textarea wire:model.defer="editingChapter.description" id="description" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                </div>
                                <div>
                                    <label for="level" class="block text-sm font-medium text-gray-700">Level</label>
                                    <select wire:model.defer="editingChapter.level" id="level"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="0">Kitab</option>
                                        <option value="1">Bab</option>
                                        <option value="2">Sub Bab</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                            <button type="submit" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:col-start-2">
                                Simpan Perubahan
                            </button>
                            <button @click="open = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Discussion Modal --}}
    <div x-data="{ open: false }" @add-discussion-modal.window="open = true" @close-modal.window="open = false">
        <div x-show="open" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div x-show="open" 
             class="fixed inset-0 z-10 overflow-y-auto"
             @click.away="open = false">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    <div class="absolute right-0 top-0 hidden pr-4 pt-4 sm:block">
                        <button @click="open = false" type="button" class="rounded-md bg-white text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <form wire:submit.prevent="storeDiscussion">
                        <div>
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Tambah Pembahasan Baru</h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Pembahasan</label>
                                    <input type="text" wire:model.defer="newDiscussion.title" id="title" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label for="content" class="block text-sm font-medium text-gray-700">Isi Pembahasan</label>
                                    <textarea wire:model.defer="newDiscussion.content" id="content" rows="5"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                            <button type="submit" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:col-start-2">
                                Tambah Pembahasan
                            </button>
                            <button @click="open = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
