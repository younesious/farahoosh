<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        $exams = Exam::all();

        return response()->json([
            'data' => $exams,
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
            'school_id' => 'required',
            'exam_title' => 'required',
            'time' => 'required',
        ]);

        if ($request->filled('negative_point')) {
            Exam::create([
                'school_id' => $request->input('school_id'),
                'exam_title' => $request->input('exam_title'),
                'time' => $request->input('time'),
                'negative_point' => $request->input('negative_point')
            ]);

        } else {
            Exam::create([
                'school_id' => $request->input('school_id'),
                'exam_title' => $request->input('exam_title'),
                'time' => $request->input('time'),
            ]);

        }

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
    public function update(Request $request, Exam $exam)
    {
        $school = DB::table('schools')->select('user_id')->where('exam_id', $exam->id)->first();


        if ($request->user_id != $school->user_id) {
            return response()->json(['error' => 'You can only edit your own exams.'], 403);
        }


        $request->validate([
            'exam_title' => 'required',
            'time' => 'required',
        ]);

        $exam->update([
            'exam_title' => $request->input('exam_title'),
            'time' => $request->input('time')
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
    public function destroy(Exam $exam)
    {
        $exam->delete();

        return response()->json(null, 204);
    }

    public function uploadExam()
    {
        return view('uploadExam');
    }

    public function showExam(Request $request)
    {
        $path = $request->file('exam')->store('exams');

        return response()->json([
            'path' => $path,
            'status' => true,
        ]);
    }
}
