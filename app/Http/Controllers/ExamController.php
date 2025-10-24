<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
            
        return view('exams.index', compact('exams'));
    }

    public function start()
    {
        return view('exams.start');
    }

    public function show($id)
    {
        $exam = Exam::where('user_id', auth()->id())
            ->findOrFail($id);
            
        return view('exams.show', compact('exam'));
    }

    public function results()
    {
        $exams = Exam::where('user_id', auth()->id())
            ->where('status', 'completed')
            ->latest()
            ->paginate(10);
            
        return view('exams.results', compact('exams'));
    }
}
