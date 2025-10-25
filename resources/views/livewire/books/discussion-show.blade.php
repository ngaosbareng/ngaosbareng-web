<div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <a href="{{ route('books.discussions', $discussion->chapter) }}"
                    class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-2">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke {{ $discussion->chapter->title }}
                </a>
                <h1 class="text-3xl font-bold text-gray-900">{{ $discussion->title }}</h1>
            </div>
            <button wire:click="$dispatch('edit-discussion')" 
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Pembahasan
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-8">
            <div class="prose prose-lg max-w-none">
                {!! nl2br(e($discussion->content)) !!}
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex items-center justify-between text-sm text-gray-500">
                    <div class="space-y-1">
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            Kitab: <span class="font-medium text-gray-900">{{ $discussion->chapter->book->title }}</span>
                        </p>
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Bab: <span class="font-medium text-gray-900">{{ $discussion->chapter->title }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div x-data="{ open: false }" 
        @edit-discussion.window="open = true" 
        @close-modal.window="open = false"
        @discussion-updated.window="open = false; $dispatch('notify', { message: 'Pembahasan berhasil diperbarui!' })">

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
            class="fixed inset-0 z-[100] overflow-y-auto" role="dialog" aria-modal="true">
            
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="absolute right-0 top-0 hidden pr-4 pt-4 sm:block">
                            <button @click="open = false" type="button" 
                                class="rounded-md bg-white text-gray-400 hover:text-gray-500 p-1 transition">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="w-full">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">Edit Pembahasan</h3>
                            <livewire:books.discussion-form :chapter="$discussion->chapter" :discussion="$discussion" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
