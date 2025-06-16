<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Test;
use App\Models\UserTestResult;
use Illuminate\Http\Request;

class TestResultController extends Controller
{
    public function index(Request $request)
    {
        $query = UserTestResult::with(['user', 'test.course']);

        // Filter berdasarkan kelas (course)
        if ($request->filled('course_id')) {
            $query->whereHas('test.course', function ($q) use ($request) {
                $q->where('id', $request->course_id);
            });
        }

        // Filter berdasarkan test
        if ($request->filled('test_id')) {
            $query->where('test_id', $request->test_id);
        }

        // Filter berdasarkan status (lulus/tidak lulus)
        if ($request->filled('status')) {
            if ($request->status === 'passed') {
                $query->whereRaw('score >= (SELECT passing_score FROM tests WHERE tests.id = user_test_results.test_id)');
            } elseif ($request->status === 'failed') {
                $query->whereRaw('score < (SELECT passing_score FROM tests WHERE tests.id = user_test_results.test_id)');
            }
        }

        // Filter berdasarkan review status
        if ($request->filled('review_status')) {
            if ($request->review_status === 'reviewed') {
                $query->whereNotNull('admin_review');
            } elseif ($request->review_status === 'not_reviewed') {
                $query->whereNull('admin_review');
            }
        }

        // Pencarian berdasarkan nama user atau email
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $results = $query->latest()->paginate(10);

        // Data untuk dropdown filter
        $courses = Course::orderBy('name')->get();
        $tests   = Test::with('course')->orderBy('title')->get();

        return view('admin.test-results.index', compact('results', 'courses', 'tests'));
    }

    public function show(UserTestResult $result)
    {
        $result->load(['user', 'test.course', 'answers.question']);
        return view('admin.test-results.show', compact('result'));
    }

    public function review(Request $request, UserTestResult $result)
    {
        $request->validate([
            'admin_review' => 'required|string',
        ]);

        $result->update([
            'admin_review' => $request->admin_review,
        ]);

        return redirect()->back()->with('success', 'Review berhasil ditambahkan');
    }
}
