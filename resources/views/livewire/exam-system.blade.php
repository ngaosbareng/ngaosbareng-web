<div class="p-6">
    @if(!$isExamStarted)
        <!-- Exam Start Screen -->
        <div class="text-center">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Ujian Masail</h3>
            <p class="text-gray-600 mb-6">
                Ujian ini akan menampilkan {{ $totalQuestions }} masail secara acak. 
                Anda akan diminta untuk menentukan apakah pembahasan yang ditampilkan 
                berkaitan dengan masail tersebut atau tidak.
            </p>
            
            <div class="mb-6">
                <label for="totalQuestions" class="block text-sm font-medium text-gray-700 mb-2">
                    Jumlah Soal:
                </label>
                <select wire:model="totalQuestions" id="totalQuestions" 
                        class="border-gray-300 rounded-md shadow-sm">
                    <option value="5">5 Soal</option>
                    <option value="10">10 Soal</option>
                    <option value="15">15 Soal</option>
                    <option value="20">20 Soal</option>
                </select>
            </div>
            
            <button wire:click="startExam" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
                Mulai Ujian
            </button>
        </div>
        
    @elseif($isExamCompleted)
        <!-- Exam Results -->
        <div class="text-center">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Hasil Ujian</h3>
            
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <div class="text-3xl font-bold text-blue-600 mb-2">
                    {{ $exam->score }}%
                </div>
                <p class="text-gray-600">
                    {{ $exam->correct_answers }} dari {{ $exam->total_questions }} jawaban benar
                </p>
            </div>
            
            <div class="mb-6">
                <p class="text-sm text-gray-500">
                    Ujian dimulai: {{ $exam->started_at->format('d/m/Y H:i') }}<br>
                    Ujian selesai: {{ $exam->completed_at->format('d/m/Y H:i') }}<br>
                    Durasi: {{ $exam->started_at->diffForHumans($exam->completed_at, true) }}
                </p>
            </div>
            
            <div class="space-x-4">
                <a href="{{ route('exams.start') }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Ujian Baru
                </a>
                <a href="{{ route('exams.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
        
    @else
        <!-- Exam Question -->
        <div>
            <!-- Progress Bar -->
            <div class="mb-6">
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Soal {{ $currentQuestionIndex + 1 }} dari {{ count($examAnswers) }}</span>
                    <span>{{ number_format($this->getProgressPercentage(), 0) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                         style="width: {{ $this->getProgressPercentage() }}%"></div>
                </div>
            </div>

            @if($currentMasail && $currentDiscussion)
                <!-- Masail Question -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Masail:</h4>
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                        <h5 class="font-medium text-blue-900">{{ $currentMasail->title }}</h5>
                        <p class="text-blue-800 mt-2">{{ $currentMasail->question }}</p>
                        @if($currentMasail->description)
                            <p class="text-blue-700 mt-2 text-sm">{{ $currentMasail->description }}</p>
                        @endif
                    </div>
                </div>

                <!-- Discussion -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Pembahasan:</h4>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <h5 class="font-medium text-gray-900 mb-2">{{ $currentDiscussion->title }}</h5>
                        <div class="text-gray-700 text-sm">
                            {!! nl2br(e($currentDiscussion->content)) !!}
                        </div>
                    </div>
                </div>

                <!-- Question -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">
                        Apakah pembahasan di atas berkaitan dengan masail tersebut?
                    </h4>
                    
                    <div class="space-y-3">
                        <button wire:click="submitAnswer(true)" 
                                class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg text-left">
                            Ya, pembahasan ini berkaitan dengan masail
                        </button>
                        
                        <button wire:click="submitAnswer(false)" 
                                class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg text-left">
                            Tidak, pembahasan ini tidak berkaitan dengan masail
                        </button>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
