<div class="p-6">
    <!-- Navigation Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <button wire:click="backToBooks" 
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Perpustakaan
                </button>
            </li>
            @if($book)
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <button wire:click="backToChapters"
                                class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                            {{ $book->title }}
                        </button>
                    </div>
                </li>
            @endif
            @if($selectedChapter)
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <button wire:click="backToDiscussions"
                                class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                            {{ $selectedChapter->title }}
                        </button>
                    </div>
                </li>
            @endif
            @if($selectedDiscussion)
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $selectedDiscussion->title }}</span>
                    </div>
                </li>
            @endif
        </ol>
    </nav>

    @if($viewMode === 'books')
        <!-- Books List -->
        <div>
            <h3 class="text-xl font-bold text-gray-900 mb-6">Daftar Kitab</h3>
            
            @if(isset($books) && $books->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($books as $bookItem)
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 hover:bg-gray-100 transition-colors cursor-pointer"
                             wire:click="selectBook({{ $bookItem->id }})">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $bookItem->title }}</h4>
                            <p class="text-gray-600 text-sm">{{ Str::limit($bookItem->description, 150) }}</p>
                            <div class="mt-4 text-xs text-gray-500">
                                {{ $bookItem->allChapters->count() }} bab
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6">
                    {{ $books->links() }}
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">Belum ada kitab yang tersedia.</p>
                </div>
            @endif
        </div>

    @elseif($viewMode === 'chapters')
        <!-- Chapters List with Hierarchy -->
        <div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $book->title }}</h3>
            <p class="text-gray-600 mb-6">{{ $book->description }}</p>
            
            @php
                $hierarchicalChapters = $this->getAllChaptersHierarchical();
            @endphp
            
            @if(count($hierarchicalChapters) > 0)
                <div class="space-y-3">
                    @foreach($hierarchicalChapters as $chapter)
                        <div class="bg-white border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors cursor-pointer" 
                             style="margin-left: {{ $chapter->level * 20 }}px;"
                             wire:click="selectChapter({{ $chapter->id }})">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    @if($chapter->level == 0)
                                        <span class="text-lg mr-2">📖</span>
                                    @elseif($chapter->level == 1)
                                        <span class="text-lg mr-2">📄</span>
                                    @else
                                        <span class="text-lg mr-2">📝</span>
                                    @endif
                                    <div>
                                        <h4 class="text-lg font-medium text-gray-900">{{ $chapter->title }}</h4>
                                        @if($chapter->description)
                                            <p class="text-gray-600 text-sm mt-1">{{ $chapter->description }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $chapter->discussions->count() }} pembahasan
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">Belum ada bab dalam kitab ini.</p>
                </div>
            @endif
        </div>

    @elseif($viewMode === 'discussions')
        <!-- Discussions List -->
        <div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $selectedChapter->title }}</h3>
            @if($selectedChapter->description)
                <p class="text-gray-600 mb-6">{{ $selectedChapter->description }}</p>
            @endif
            
            @if(isset($discussions) && $discussions->count() > 0)
                <div class="space-y-3">
                    @foreach($discussions as $discussion)
                        <div class="bg-white border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors cursor-pointer"
                             wire:click="selectDiscussion({{ $discussion->id }})">
                            <h4 class="text-lg font-medium text-gray-900">{{ $discussion->title }}</h4>
                            <p class="text-gray-600 text-sm mt-2">{{ Str::limit(strip_tags($discussion->content), 200) }}</p>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6">
                    {{ $discussions->links() }}
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">Belum ada pembahasan dalam bab ini.</p>
                </div>
            @endif
        </div>

    @elseif($viewMode === 'reading')
        <!-- Reading View -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-white border border-gray-200 rounded-lg p-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $selectedDiscussion->title }}</h1>
                
                <div class="prose prose-lg max-w-none">
                    {!! nl2br(e($selectedDiscussion->content)) !!}
                </div>
                
                <div class="mt-8 pt-6 border-t border-gray-200 text-sm text-gray-500">
                    <p>Bab: {{ $selectedDiscussion->chapter->title }}</p>
                    <p>Kitab: {{ $selectedDiscussion->chapter->book->title }}</p>
                </div>
            </div>
        </div>
    @endif
</div>
