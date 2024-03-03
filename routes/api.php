<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::prefix('exams')->name('exam.')->group(function () {
    Route::get('/', [App\Http\Controllers\ExamController::class, 'index'])->name('index');
    Route::post('/', [App\Http\Controllers\ExamController::class, 'store'])->name('store');
    Route::match(['put', 'patch'], '/{exam}', [App\Http\Controllers\ExamController::class, 'update'])->name('update');
    Route::delete('/{exam}', [App\Http\Controllers\ExamController::class, 'destroy'])->name('destroy');
    Route::get('uploadExam', [App\Http\Controllers\ExamController::class, 'uploadExam']);
    Route::get('showExam', [App\Http\Controllers\ExamController::class, 'showExam']);
});

Route::post('schools/', [App\Http\Controllers\SchoolController::class, 'create']);
Route::get('schools/{course_title}', [App\Http\Controllers\SchoolController::class, 'show']);

Route::post('results/{question}', [App\Http\Controllers\ResultController::class, 'grade']);
Route::get('result/{result}', [App\Http\Controllers\ResultController::class, 'result']);
Route::get('results/details/{exam_id}', [App\Http\Controllers\ResultController::class, 'details']);

Route::get('tick_eight/{group}', [App\Http\Controllers\TickEightController::class, 'show']);
Route::post('tick_eight/{word}', [App\Http\Controllers\TickEightController::class, 'calculate']);
Route::post('tick_eight/', [App\Http\Controllers\TickEightController::class, 'add']);

Route::get('guidebook', [App\Http\Controllers\GuideController::class, 'upload_pdf']);
Route::post('guidebook', [App\Http\Controllers\GuideController::class, 'create']);

Route::prefix('questions')->name('question.')->group(function () {
    Route::get('/', [App\Http\Controllers\QuestionController::class, 'index'])->name('index');
    Route::post('/', [App\Http\Controllers\QuestionController::class, 'store'])->name('store');
    Route::match(['put', 'patch'], '/{question}', [App\Http\Controllers\QuestionController::class, 'update'])->name('update');
    Route::delete('/{question}', [App\Http\Controllers\QuestionController::class, 'destroy'])->name('destroy');
});
