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
</div>