<div class="">
    <div class="">
        <div class="flex justify-between items-center mb-8">
            <h2 class="font-bold text-2xl text-indigo-800 tracking-tight flex items-center gap-2">
                <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 20l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12V4l9 5-9 5-9-5 9-5z" />
                </svg>
                {{ $chapter->title }}
            </h2>
            <a href="{{ route('books.chapters', $chapter->book) }}"
               class="inline-flex items-center px-4 py-2 bg-white border border-indigo-200 rounded-lg shadow-sm text-sm font-medium text-indigo-700 hover:bg-indigo-50 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke {{ $chapter->book->title }}
            </a>
        </div>
        <div class="bg-white/80 backdrop-blur-md shadow-2xl sm:rounded-2xl">
            <div class="p-8">
                @if($chapter->description)
                    <div class="mb-8">
                        <p class="text-gray-700 text-base italic border-l-4 border-indigo-300 pl-4 bg-indigo-50 py-2">
                            {{ $chapter->description }}
                        </p>
                    </div>
                @endif

                @if($discussions->count() > 0)
                    <div class="space-y-5">
                        @foreach($discussions as $discussion)
                            <div class="relative group">
                                <a href="{{ route('books.discussions.show', $discussion) }}"
                                   class="block bg-gradient-to-r from-indigo-50 to-white border border-indigo-100 rounded-xl p-6 hover:shadow-lg hover:scale-[1.01] transition-all duration-200">
                                    <h4 class="text-xl font-semibold text-indigo-800 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8a2 2 0 012-2h2" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 3h-6a2 2 0 00-2 2v4a2 2 0 002 2h6a2 2 0 002-2V5a2 2 0 00-2-2z" />
                                        </svg>
                                        {{ $discussion->title }}
                                    </h4>
                                    <p class="text-gray-600 text-sm mt-2">{{ Str::limit(strip_tags($discussion->content), 200) }}</p>
                                </a>
                                <button wire:click="confirmDelete({{ $discussion->id }})"
                                        class="absolute top-4 right-4 p-2 text-red-500 hover:text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-8 flex justify-center">
                        {{ $discussions->links() }}
                    </div>
                @else
                    <div class="flex flex-col items-center py-16">
                        <svg class="w-16 h-16 text-indigo-200 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20l9-5-9-5-9 5 9 5z" />
                        </svg>
                        <p class="text-gray-400 text-lg">Belum ada pembahasan dalam bab ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    {{-- Delete Confirmation Modal --}}
    <div x-data="{ open: false }" @delete-confirmation-modal.window="open = true" @close-modal.window="open = false">
        <div x-show="open" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div x-show="open" 
             class="fixed inset-0 z-10 overflow-y-auto"
             @click.away="open = false">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Hapus Pembahasan</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Apakah Anda yakin ingin menghapus pembahasan ini? Tindakan ini tidak dapat dibatalkan.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button wire:click="deleteDiscussion" type="button"
                            class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                            Hapus
                        </button>
                        <button @click="open = false" type="button"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>