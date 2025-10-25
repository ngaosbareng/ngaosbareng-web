<x-layouts.app>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Daftar Kitab</h3>

                    @if ($books->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($books as $book)
                                <a href="{{ route('books.chapters', $book) }}"
                                    class="bg-gray-50 border border-gray-200 rounded-lg p-6 hover:bg-gray-100 transition-colors">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $book->title }}</h4>
                                    <p class="text-gray-600 text-sm">{{ Str::limit($book->description, 150) }}</p>
                                    <div class="mt-4 text-xs text-gray-500">
                                        {{ $book->chapters->count() }} bab
                                    </div>
                                </a>
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
            </div>
        </div>
    </div>
</x-layouts.app>
