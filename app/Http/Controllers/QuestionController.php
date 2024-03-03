<?php

namespace App\Http\Controllers;

use App\Models\Question;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        $question = DB::table('questions')->get();

        return response()->json([
            'data' => $question,
            'status' => true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required',
            'question' => 'required',
            'answers' => 'required',
            'correct_answer' => 'required',
            'time' => 'required',
        ]);

        DB::table('questions')->insert([
            'exam_id' => $request->input('exam_id'),
            'question' => $request->input('question'),
            'answers' => $request->input('answers'),
            'correct_answer' => $request->input('correct_answer'),
            'time' => $request->input('time'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'با موفقیت ثبت شد.'
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Exam $exam
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Question $question)
    {
        $school = DB::table('schools')->select('user_id')->where('exam_id', $question->exam_id)->first();
        if ($request->user_id != $school->user_id) {
            return response()->json(['error' => 'You can only edit your own exams.'], 403);
        }

        $request->validate([
            'question' => 'required',
            'answers' => 'required',
            'correct_answer' => 'required',
            'time' => 'required',
        ]);

        $question->update([
            'question' => $request->input('question'),
            'answers' => $request->input('answers'),
            'correct_answer' => $request->input('correct_answer'),
            'time' => $request->input('time'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'با موفقیت ثبت شد.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Exam $exam
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return response()->json(null, 204);
    }
}
