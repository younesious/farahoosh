<?php

namespace App\Http\Controllers;

use App\Models\TickEight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TickEightController extends Controller
{
    public function show($group)
    {
        $data = DB::table('tick_eights')->where('group', $group)->groupBy('group')->get();
        if ($data === null) {
            return response()->json([
                'message' => 'Not found.'
            ], 404);
        } else {
            return response()->json([
                'data' => $data,
                'status' => true]);
        }
    }

    public function calculate($word, Request $request)
    {
        $data = DB::table('tick_eights')->where('word', $word)->first();

        if ($request->input('answer') === $data->answer) {
            $data->hidden = false;
            DB::table('tick_eights')->where('word', $word)->increment('true');
            return response()->json([
                'status' => true,
                'message' => 'پاسخ صحیح است.'
            ]);

        } else {
            DB::table('tick_eights')->where('word', $word)->increment('false');
            return response()->json([
                'status' => false,
                'message' => 'پاسخ اشتباه است.لطفا دوباره تلاش کنید!'
            ]);
        }
    }

    public function add(Request $request)
    {
        $request->validate([
            'word' => 'required',
            'answer' => 'required',
            'group' => 'required',
        ]);

        TickEight::create([
            'word' => $request->input('word'),
            'answer' => $request->input('answer'),
            'group' => $request->input('group'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'با موفقیت ثبت شد.'
        ]);
    }
}
