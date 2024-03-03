<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use App\Models\Result;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;

// replace all user and user_id with auth()->user()->id to authenticate user correctly

class ResultController extends Controller
{
    public function grade(Question $question, Request $request)
    {
        $result = Result::firstOrCreate([
            'user_id' => $request->header('user_id'),
            'exam_id' => $request->header('exam_id')
        ]);

        if ($question->correct_answer == $request->input('answer')) {
            $result->increment('correct');
        } else
            if ($question->correct_answer != $request->input('answer') and $request->filled('answer')) {
                $result->increment('wrong');
            } else {
                $result->increment('empty');
            }


    }

    public function result(Result $result, Request $request)
    {
        //    $user = auth()->user();
        $answer = DB::table('results')->where('user_id', $request->header('user_id'))
            ->where('exam_id', $result->exam_id)
            ->first();

        $question_count = $answer->correct + $answer->wrong + $answer->empty;
        $grade = $answer->correct - ($answer->wrong * 1 / 3);
        $grade_percent = ($grade / ($question_count)) * 100;
        $grade = ($grade * 20) / $question_count;

        return response()->json([
            'percent' => $grade_percent,
            '20' => $grade,
        ]);
    }

    public function details($exam_id)
    {
        $exams = DB::table('results')->where('exam_id', $exam_id)->get();
        $user_count = $exams->count();
        $sum = 0;


        foreach ($exams as $exam) {
            $question_count = $exam->correct + $exam->wrong + $exam->empty;
            $grade = $exam->correct - ($exam->wrong * 1 / 3);
            $grade = ($grade * 20) / $question_count;
            $sum += $grade;
        }


        $mean = $sum / $user_count;

        $sum = 0;
        foreach ($exams as $exam) {
            $question_count = $exam->correct + $exam->wrong + $exam->empty;
            $grade = $exam->correct - ($exam->wrong * 1 / 3);
            $grade = ($grade * 20) / $question_count;
            $sum += pow($grade - $mean, 2);
        }
        $variance = $sum / $user_count;
        $std = sqrt($variance);


        return response()->json([
            'mean' => $mean,
            'variance' => $variance,
            'std' => $std,
        ]);
    }
}
