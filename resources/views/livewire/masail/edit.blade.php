<div>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Edit Masail</h2>
                    <p class="text-gray-600 mt-1">Edit pertanyaan yang merujuk ke pembahasan dari berbagai kitab</p>
                </div>
                <a href="{{ route('masail.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="update" class="space-y-6 bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <!-- Title -->
                    <div class="sm:col-span-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Masail</label>
                        <div class="mt-1">
                            <input type="text" 
                                   wire:model="title" 
                                   id="title"
                                   class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Question -->
                    <div class="sm:col-span-6">
                        <label for="question" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                        <div class="mt-1">
                            <textarea wire:model="question" 
                                      id="question"
                                      rows="3"
                                      class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                        </div>
                        @error('question') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Description -->
                    <div class="sm:col-span-6">
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            <span>Deskripsi</span>
                            <span class="text-gray-500 text-xs">(Opsional)</span>
                        </label>
                        <div class="mt-1">
                            <textarea wire:model="description" 
                                      id="description"
                                      rows="3"
                                      class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                        </div>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Related Discussions -->
                    <div class="sm:col-span-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Pembahasan Terkait
                        </label>
                        <div class="bg-white border border-gray-300 rounded-md max-h-96 overflow-y-auto p-4">
                            @foreach($discussions->groupBy('chapter.book.title') as $bookTitle => $bookDiscussions)
                                <div class="mb-6 last:mb-0">
                                    <h4 class="font-medium text-gray-900 mb-2">📚 {{ $bookTitle }}</h4>
                                    @foreach($bookDiscussions->groupBy('chapter.title') as $chapterTitle => $chapterDiscussions)
                                        <div class="ml-4 mb-3">
                                            <h5 class="font-medium text-gray-700 text-sm mb-2">📄 {{ $chapterTitle }}</h5>
                                            <div class="space-y-2 ml-4">
                                                @foreach($chapterDiscussions as $discussion)
                                                    <label class="flex items-center">
                                                        <input type="checkbox" 
                                                               wire:model="selectedDiscussions" 
                                                               value="{{ $discussion->id }}" 
                                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 h-4 w-4">
                                                        <span class="ml-2 text-sm text-gray-600">
                                                            📝 {{ $discussion->title }}
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        @error('selectedDiscussions') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('masail.show', $masail) }}" 
                       class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Batal
                    </a>
                    <button type="submit"
                            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>