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

                    <a href="{{ route('books.discussions', $chapter) }}"
                        class="block border rounded-xl p-5 shadow hover:shadow-lg transition-shadow duration-200 ease-in-out {{ $level_class }}"
                        style="margin-left: {{ $level_indent }}px;">
                        <div class="flex items-start justify-between">
                            {{-- Info Bab --}}
                            <div class="flex items-start flex-1 mr-4">
                                <span class="text-2xl mr-4 mt-0.5"
                                    title="Level {{ $chapter->level }}">{{ $level_icon }}</span>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 leading-snug">
                                        {{ $chapter->title }}
                                    </h4>
                                    @if ($chapter->description)
                                        <p class="text-gray-600 text-sm mt-1 leading-relaxed">
                                            {{ $chapter->description }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            {{-- Jumlah Pembahasan --}}
                            <div
                                class="text-sm font-semibold text-indigo-700 bg-indigo-100 px-4 py-1.5 rounded-full shadow-sm whitespace-nowrap">
                                {{ $chapter->discussions->count() }} Pembahasan
                            </div>
                        </div>
                    </a>
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
</div>
