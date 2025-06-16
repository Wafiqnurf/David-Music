<?php
namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\UserTestAnswer;
use App\Models\UserTestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function show(Test $test)
    {
        // Check if user is enrolled in the course
        $isEnrolled = Auth::user()->courses()->where('course_id', $test->course_id)->exists();

        if (! $isEnrolled) {
            return redirect()->route('courses.index')->with('error', 'Anda harus mendaftar ke kelas terlebih dahulu');
        }

        // Check if user has already taken this test
        $existingResult = UserTestResult::where('user_id', Auth::id())
            ->where('test_id', $test->id)
            ->first();

        if ($existingResult) {
            return redirect()->route('test.result', $existingResult->id);
        }

        $questions = $test->questions()->with('test')->get();
        return view('tests.show', compact('test', 'questions'));
    }

    public function submit(Request $request, Test $test)
    {
        $user      = Auth::user();
        $questions = $test->questions;

        $totalQuestions = $questions->count();
        $correctAnswers = 0;

        // Create test result
        $testResult = UserTestResult::create([
            'user_id'         => $user->id,
            'test_id'         => $test->id,
            'score'           => 0, // Will be updated
            'total_questions' => $totalQuestions,
            'correct_answers' => 0, // Will be updated
            'video_url'       => $request->video_link,
            'completed_at'    => now(),
        ]);

        // Process answers
        foreach ($questions as $question) {
            $userAnswer = $request->input("q{$question->id}");
            $isCorrect  = $userAnswer === $question->correct_answer;

            if ($isCorrect) {
                $correctAnswers++;
            }

            UserTestAnswer::create([
                'user_test_result_id' => $testResult->id,
                'test_question_id'    => $question->id,
                'answer'              => $userAnswer,
                'is_correct'          => $isCorrect,
            ]);
        }

        // Calculate score
        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;

        // Update test result
        $testResult->update([
            'score'           => $score,
            'correct_answers' => $correctAnswers,
        ]);

        return redirect()->route('test.result', $testResult->id);
    }

    public function result(UserTestResult $result)
    {
        if ($result->user_id !== Auth::id()) {
            abort(403);
        }

        return view('tests.result', compact('result'));
    }
}
