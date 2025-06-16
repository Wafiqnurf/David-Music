<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('enrollments')->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        try {
            // Validasi dengan is_active
            $request->validate([
                'name'        => 'required|string|max:255',
                'description' => 'required|string',
                'icon'        => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                'image'       => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                'is_active'   => 'required|boolean', // Tambahkan validasi is_active
            ]);

            // Ambil data dasar termasuk is_active
            $data = $request->only(['name', 'description', 'is_active']);

            // Handle file upload icon
            if ($request->hasFile('icon')) {
                $iconFile     = $request->file('icon');
                $data['icon'] = $iconFile->store('course_icons', 'public');
            }

            // Handle file upload image
            if ($request->hasFile('image')) {
                $imageFile     = $request->file('image');
                $data['image'] = $imageFile->store('course_images', 'public');
            }

            // Buat course baru
            $course = Course::create($data);

            // Log untuk debugging
            Log::info('Course created successfully', ['course_id' => $course->id, 'name' => $course->name]);

            return redirect()->route('admin.courses.index')->with('success', 'Kelas berhasil dibuat');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            // Log general errors
            Log::error('Error creating course', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat kelas: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Course $course)
    {
        $enrollments = $course->enrollments()->with('user')->get();
        return view('admin.courses.show', compact('course', 'enrollments'));
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        try {
            $request->validate([
                'name'        => 'required|string|max:255',
                'description' => 'required|string',
                'icon'        => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                'image'       => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                'is_active'   => 'required|boolean',
            ]);

            $data = $request->only(['name', 'description', 'is_active']);

            if ($request->hasFile('icon')) {
                if ($course->icon) {
                    Storage::disk('public')->delete($course->icon);
                }
                $data['icon'] = $request->file('icon')->store('course_icons', 'public');
            }

            if ($request->hasFile('image')) {
                if ($course->image) {
                    Storage::disk('public')->delete($course->image);
                }
                $data['image'] = $request->file('image')->store('course_images', 'public');
            }

            $course->update($data);

            return redirect()->route('admin.courses.index')->with('success', 'Kelas berhasil diperbarui');

        } catch (\Exception $e) {
            Log::error('Error updating course', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui kelas')->withInput();
        }
    }

    public function destroy(Course $course)
    {
        try {
            if ($course->icon) {
                Storage::disk('public')->delete($course->icon);
            }
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }

            $course->delete();

            return redirect()->route('admin.courses.index')->with('success', 'Kelas berhasil dihapus');

        } catch (\Exception $e) {
            Log::error('Error deleting course', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus kelas');
        }
    }
}
