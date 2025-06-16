<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\UserCourse;
use App\Models\UserTestResult;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'       => User::where('role', 'user')->count(),
            'total_courses'     => Course::count(),
            'total_enrollments' => UserCourse::count(),
            'total_tests_taken' => UserTestResult::count(),
        ];

        $recentEnrollments = UserCourse::with(['user', 'course'])
            ->latest()
            ->take(5)
            ->get();

        $recentTests = UserTestResult::with(['user', 'test.course'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentEnrollments', 'recentTests'));
    }
}
