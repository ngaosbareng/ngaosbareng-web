<x-layouts.app :title="__('Dashboard')">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                        Selamat datang, {{ auth()->user()->name }}!
                    </h2>
                    
                    @if(auth()->user()->isAdmin())
                        <!-- Admin Dashboard -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <a href="{{ route('admin.books.index') }}" 
                               class="bg-blue-50 border border-blue-200 rounded-lg p-6 hover:bg-blue-100 transition-colors">
                                <div class="flex items-center">
                                    <div class="p-2 bg-blue-500 rounded-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Kelola Kitab</h3>
                                        <p class="text-gray-600">Manage books, chapters, and discussions</p>
                                    </div>
                                </div>
                            </a>
                            
            <a href="{{ route('admin.masail') }}" 
               class="bg-green-50 border border-green-200 rounded-lg p-6 hover:bg-green-100 transition-colors">
                <div class="flex items-center">
                    <div class="p-2 bg-green-500 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Kelola Masail</h3>
                        <p class="text-gray-600">Kelola kumpulan pertanyaan yang merujuk ke pembahasan dari berbagai kitab</p>
                    </div>
                </div>
            </a>                            <a href="{{ route('exams.index') }}" 
                               class="bg-purple-50 border border-purple-200 rounded-lg p-6 hover:bg-purple-100 transition-colors">
                                <div class="flex items-center">
                                    <div class="p-2 bg-purple-500 rounded-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Monitor Ujian</h3>
                                        <p class="text-gray-600">View exam results and statistics</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @else
                        <!-- Member Dashboard -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <a href="{{ route('books.index') }}" 
                               class="bg-blue-50 border border-blue-200 rounded-lg p-6 hover:bg-blue-100 transition-colors">
                                <div class="flex items-center">
                                    <div class="p-2 bg-blue-500 rounded-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Baca Kitab</h3>
                                        <p class="text-gray-600">Access and read available books</p>
                                    </div>
                                </div>
                            </a>
                            
                            <a href="{{ route('exams.start') }}" 
                               class="bg-green-50 border border-green-200 rounded-lg p-6 hover:bg-green-100 transition-colors">
                                <div class="flex items-center">
                                    <div class="p-2 bg-green-500 rounded-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 7h3m-6 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Mulai Ujian</h3>
                                        <p class="text-gray-600">Ikuti ujian masail - pertanyaan yang merujuk ke berbagai kitab</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    
                    <!-- Recent Activity -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-600">Belum ada aktivitas terbaru.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
