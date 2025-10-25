<div>
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $discussion->title }}
        </h2>
        <a href="{{ route('books.discussions', $discussion->chapter) }}"
            class="text-sm text-gray-600 hover:text-gray-900">
            ← Kembali ke {{ $discussion->chapter->title }}
        </a>
    </div>

    <div class="p-8">
        <div class="prose prose-lg max-w-none">
            {!! nl2br(e($discussion->content)) !!}
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class="flex items-center justify-between text-sm text-gray-500">
                <div>
                    <p>Bab: {{ $discussion->chapter->title }}</p>
                    <p>Kitab: {{ $discussion->chapter->book->title }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
