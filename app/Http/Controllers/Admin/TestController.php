<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Test;
use App\Models\TestQuestion;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::with(['course', 'questions'])->get();
        return view('admin.tests.index', compact('tests'));
    }

    public function create()
    {
        $courses = Course::where('is_active', true)->get();
        return view('admin.tests.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id'   => 'required|exists:courses,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Test::create($request->all());
        return redirect()->route('admin.tests.index')->with('success', 'Test berhasil dibuat');
    }

    public function show(Test $test)
    {
        $test->load(['course', 'questions', 'results.user']);
        return view('admin.tests.show', compact('test'));
    }

    public function edit(Test $test)
    {
        $courses = Course::where('is_active', true)->get();
        return view('admin.tests.edit', compact('test', 'courses'));
    }

    public function update(Request $request, Test $test)
    {
        $request->validate([
            'course_id'   => 'required|exists:courses,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $test->update($request->all());
        return redirect()->route('admin.tests.index')->with('success', 'Test berhasil diperbarui');
    }

    public function destroy(Test $test)
    {
        $test->delete();
        return redirect()->route('admin.tests.index')->with('success', 'Test berhasil dihapus');
    }

    // Questions Management
    public function questions(Test $test)
    {
        $questions = $test->questions()->orderBy('order')->get();
        return view('admin.tests.questions', compact('test', 'questions'));
    }

    public function createQuestion(Test $test)
    {
        return view('admin.tests.create-question', compact('test'));
    }

    public function storeQuestion(Request $request, Test $test)
    {
        $request->validate([
            'question'       => 'required|string',
            'options'        => 'required|array|min:2',
            'options.*'      => 'required|string',
            'correct_answer' => 'required|string',
        ]);

        $lastOrder = $test->questions()->max('order') ?? 0;

        TestQuestion::create([
            'test_id'        => $test->id,
            'question'       => $request->question,
            'options'        => $request->options,
            'correct_answer' => $request->correct_answer,
            'order'          => $lastOrder + 1,
        ]);

        return redirect()->route('admin.tests.questions', $test)->with('success', 'Pertanyaan berhasil ditambahkan');
    }

    public function editQuestion(Test $test, TestQuestion $question)
    {
        return view('admin.tests.edit-question', compact('test', 'question'));
    }

    public function updateQuestion(Request $request, Test $test, TestQuestion $question)
    {
        $request->validate([
            'question'       => 'required|string',
            'options'        => 'required|array|min:2',
            'options.*'      => 'required|string',
            'correct_answer' => 'required|string',
        ]);

        $question->update([
            'question'       => $request->question,
            'options'        => $request->options,
            'correct_answer' => $request->correct_answer,
        ]);

        return redirect()->route('admin.tests.questions', $test)->with('success', 'Pertanyaan berhasil diperbarui');
    }

    public function destroyQuestion(Test $test, TestQuestion $question)
    {
        $question->delete();
        return redirect()->route('admin.tests.questions', $test)->with('success', 'Pertanyaan berhasil dihapus');
    }
}
