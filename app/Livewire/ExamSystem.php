<?php

namespace App\Livewire;

use App\Models\Exam;
use App\Models\ExamAnswer;
use App\Models\Masail;
use App\Models\Discussion;
use Livewire\Component;

class ExamSystem extends Component
{
    public $exam = null;
    public $currentQuestionIndex = 0;
    public $currentMasail = null;
    public $currentDiscussion = null;
    public $examAnswers = [];
    public $totalQuestions = 10;
    public $isExamStarted = false;
    public $isExamCompleted = false;
    public $userAnswer = null;

    public function mount($examId = null)
    {
        if ($examId) {
            $this->exam = Exam::with('examAnswers.masail', 'examAnswers.discussion')->findOrFail($examId);
            $this->isExamStarted = true;
            $this->examAnswers = $this->exam->examAnswers->toArray();
            
            if ($this->exam->status === 'completed') {
                $this->isExamCompleted = true;
            } else {
                $this->loadCurrentQuestion();
            }
        }
    }

    public function startExam()
    {
        // Create new exam
        $this->exam = Exam::create([
            'user_id' => auth()->id(),
            'title' => 'Ujian Masail - ' . now()->format('d/m/Y H:i'),
            'total_questions' => $this->totalQuestions,
            'started_at' => now(),
        ]);

        // Get random masail
        $masailList = Masail::with('discussions')->inRandomOrder()->limit($this->totalQuestions)->get();
        
        // Create exam questions with random discussions
        foreach ($masailList as $masail) {
            // Get related discussions
            $relatedDiscussions = $masail->discussions;
            
            // Get random unrelated discussions
            $unrelatedDiscussions = Discussion::whereNotIn('id', $relatedDiscussions->pluck('id'))
                ->inRandomOrder()
                ->limit(2)
                ->get();
            
            // Combine and shuffle
            $allDiscussions = $relatedDiscussions->concat($unrelatedDiscussions)->shuffle();
            
            // Create exam answers for each discussion
            foreach ($allDiscussions->take(3) as $discussion) {
                ExamAnswer::create([
                    'exam_id' => $this->exam->id,
                    'masail_id' => $masail->id,
                    'discussion_id' => $discussion->id,
                    'is_correct' => $relatedDiscussions->contains($discussion->id),
                ]);
            }
        }

        $this->examAnswers = $this->exam->fresh()->examAnswers->toArray();
        $this->isExamStarted = true;
        $this->loadCurrentQuestion();
    }

    public function loadCurrentQuestion()
    {
        if ($this->currentQuestionIndex < count($this->examAnswers)) {
            $currentAnswer = $this->examAnswers[$this->currentQuestionIndex];
            $this->currentMasail = Masail::find($currentAnswer['masail_id']);
            $this->currentDiscussion = Discussion::find($currentAnswer['discussion_id']);
            $this->userAnswer = $currentAnswer['user_answer'];
        }
    }

    public function submitAnswer($answer)
    {
        // Update the exam answer
        $examAnswer = ExamAnswer::find($this->examAnswers[$this->currentQuestionIndex]['id']);
        $examAnswer->update(['user_answer' => $answer]);
        
        // Update local array
        $this->examAnswers[$this->currentQuestionIndex]['user_answer'] = $answer;
        
        $this->nextQuestion();
    }

    public function nextQuestion()
    {
        $this->currentQuestionIndex++;
        
        if ($this->currentQuestionIndex >= count($this->examAnswers)) {
            $this->completeExam();
        } else {
            $this->loadCurrentQuestion();
        }
    }

    public function completeExam()
    {
        $this->exam->complete();
        $this->isExamCompleted = true;
    }

    public function getProgressPercentage()
    {
        return ($this->currentQuestionIndex / count($this->examAnswers)) * 100;
    }

    public function render()
    {
        return view('livewire.exam-system');
    }
}
