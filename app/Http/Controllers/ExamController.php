<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Question;
use App\Models\ExamAttempt;
use App\Models\AttemptedQuestion;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams = Exam::withCount('questions')->with('user')->get();

        return view('dashboard',compact('exams'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user()->id;
        $exam = $request->examid;
        $examattempt = ExamAttempt::where('user_id',$user)
                                    ->where('exam_id',$exam)
                                    ->firstOrFail();

        $questions = $request->input('questions');
            foreach($questions as $question){
                if(isset($question['selected_option_id'])){
                    $attemptques = AttemptedQuestion::create([
                        'exam_attempt_id' => $examattempt['id'],
                        'question_id' => $question['question_id'],
                        'selected_option_id' => $question['selected_option_id'],
                    ]);
                }
            }

        $examat = $examattempt['id'];
        $score = 0;

        foreach ($questions as $question) {
            if(isset($question['selected_option_id'])){
                $qs = Question::find($question['question_id']);
                if ($question['selected_option_id'] == $qs['correct_option_id']) {
                    $score++;
                }
            }
        }

        ExamAttempt::find($examat)->update([
            'completed_at' => Carbon::now('Asia/Kolkata'),
            'score' => $score,
        ]);

        return redirect()->route('dashboard')->with('status', 'Exam Submitted Successfully.');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user()->id;
        $attempt = ExamAttempt::where('user_id',$user)
                                ->where('exam_id',$id)
                                ->first();
        if($attempt && $attempt->completed_at){
            return redirect()->route('dashboard')->with('status', 'You have already attempted this Exam.');
        }else{
            $examattempt = ExamAttempt::create([
                'user_id' => $user,
                'exam_id' => $id,
                'started_at' => Carbon::now('Asia/Kolkata'),
                'completed_at' => Carbon::now('Asia/Kolkata'),
                'score' => 0,
            ]);
            $exam = Exam::withCount('questions')->with('questions.options')->find($id);
            return response()
            ->view('exam', compact('exam'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
