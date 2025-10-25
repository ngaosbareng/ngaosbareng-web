<div>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold leading-6 text-gray-900">{{ $masail->title }}</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Dibuat {{ $masail->created_at->diffForHumans() }}
                            @if($masail->created_at != $masail->updated_at)
                                · Diupdate {{ $masail->updated_at->diffForHumans() }}
                            @endif
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('masail.edit', $masail) }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <button wire:click="delete" 
                                wire:confirm="Yakin ingin menghapus masail ini?"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                        <a href="{{ route('masail.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Pertanyaan</dt>
                            <dd class="mt-1 text-lg text-gray-900">{{ $masail->question }}</dd>
                        </div>

                        @if($masail->description)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                                <dd class="mt-1 text-gray-900">{{ $masail->description }}</dd>
                            </div>
                        @endif

                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 mb-3">Pembahasan Terkait</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <div class="space-y-4">
                                    @foreach($masail->discussions->groupBy('chapter.book.title') as $bookTitle => $bookDiscussions)
                                        <div class="border-l-4 border-blue-500 pl-4">
                                            <h4 class="font-medium text-gray-900 mb-2">📚 {{ $bookTitle }}</h4>
                                            @foreach($bookDiscussions->groupBy('chapter.title') as $chapterTitle => $chapterDiscussions)
                                                <div class="ml-4 mb-3">
                                                    <h5 class="font-medium text-gray-700">📄 {{ $chapterTitle }}</h5>
                                                    <ul class="mt-2 space-y-1 ml-4">
                                                        @foreach($chapterDiscussions as $discussion)
                                                            <li class="text-gray-600">📝 {{ $discussion->title }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>