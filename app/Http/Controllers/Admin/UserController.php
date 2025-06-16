<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->with('courses')->get();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        // FIX: Eager load relationships yang benar
        $user->load([
            'userCourses.course',      // Load userCourses dengan course
            'testResults.test.course', // Load testResults dengan test dan course
        ]);

        return view('admin.users.show', compact('user'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|string|min:8|confirmed',
            'full_name' => 'nullable|string|max:255',
            'phone'     => 'nullable|string|max:20',
            'role'      => 'required|in:admin,user',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'full_name' => $request->full_name,
            'phone'     => $request->phone,
            'role'      => $request->role,
        ];

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo                 = $request->file('photo');
            $photoName             = time() . '_' . $photo->getClientOriginalName();
            $photoPath             = $photo->storeAs('users', $photoName, 'public');
            $data['profile_photo'] = $photoPath; // FIX: Sesuaikan dengan field name di database
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'password'  => 'nullable|string|min:8|confirmed',
            'full_name' => 'nullable|string|max:255',
            'phone'     => 'nullable|string|max:20',
            'role'      => 'required|in:admin,user',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'full_name', 'phone', 'role']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $photo                 = $request->file('photo');
            $photoName             = time() . '_' . $photo->getClientOriginalName();
            $photoPath             = $photo->storeAs('users', $photoName, 'public');
            $data['profile_photo'] = $photoPath; // FIX: Sesuaikan dengan field name di database
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Tidak dapat menghapus admin');
        }

        // Delete photo if exists
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }
}
