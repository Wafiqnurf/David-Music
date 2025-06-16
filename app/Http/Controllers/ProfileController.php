<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user        = Auth::user();
        $testResults = $user->testResults()->with(['test.course'])->latest()->get();

        return view('profile.show', compact('user', 'testResults'));
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'full_name'     => 'required|string|max:255',
            'nickname'      => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'phone'         => 'required|string|max:20',
            'gender'        => 'required|in:male,female',
            'birth_place'   => 'required|string|max:255',
            'birth_date'    => 'required|date',
            'address'       => 'required|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only([
            'full_name', 'nickname', 'email', 'phone', 'gender',
            'birth_place', 'birth_date', 'address',
        ]);

        if ($request->hasFile('profile_photo')) {
            // Delete old photo
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $path                  = $request->file('profile_photo')->store('profile_photos', 'public');
            $data['profile_photo'] = $path;
        }

        $user->update($data);

        return redirect()->route('profile.show')->with('success', 'Profile berhasil diperbarui');
    }
}
