<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\UserCourse;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('is_active', true)->get();
        return view('courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $isEnrolled = false;
        if (Auth::check()) {
            $isEnrolled = UserCourse::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->exists();
        }

        return view('courses.show', compact('course', 'isEnrolled'));
    }

    public function enroll(Course $course)
    {
        $user = Auth::user();

        // Check if already enrolled
        $existingEnrollment = UserCourse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar di kelas ini');
        }

        UserCourse::create([
            'user_id'     => $user->id,
            'course_id'   => $course->id,
            'enrolled_at' => now(),
            'status'      => 'active',
        ]);

        return redirect()->route('courses.show', $course)->with('success', 'Berhasil mendaftar ke kelas!');
    }
}
