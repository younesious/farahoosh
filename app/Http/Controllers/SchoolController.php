<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'exam_id' => 'required',
            'course_title' => 'required',
        ]);

        School::create([
            'user_id' => $request->input('user_id'),
            'exam_id' => $request->input('exam_id'),
            'course_title' => $request->input('course_title'),
        ]);
        return response()->json([
            'status' => true,
            'message' => 'با موفقیت ثبت شد.'
        ]);
    }

    public
    function show($course_title)
    {
        $school = DB::table('schools')->where('course_title', $course_title)->get();
        if ($school === null) {
            return response()->json([
                'message' => 'Not found.'
            ], 404);
        } else {
            return response()->json([
                'data' => $school,
                'status' => true]);
        }
    }

}
