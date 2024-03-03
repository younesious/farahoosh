<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GuideController extends Controller
{

    function upload_pdf()
    {
        $questions = DB::table('guides')->select('question')->get();
        $answer = DB::table('guides')->select('answer')->get();
        $data = [$questions, $answer];
        $path = '/pdf/' . uniqid() . '.pdf';
        $pdf = Storage::put($path, json_encode($data));
        return response()->json([
            'data' => $data,
            'path' => $pdf,
            'status' => true,
        ]);
    }


    public function create(Request $request)
    {
        $request->validate([
            'class' => 'required',
            'question' => 'required',
            'answer' => 'required',
        ]);


        DB::table('guides')->insert([
            'class' => $request->input('class'),
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'با موفقیت ثبت شد.'
        ]);
    }
}

