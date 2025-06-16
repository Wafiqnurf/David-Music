<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $user = $this->create($request->all());

        // Login the user after registration
        auth()->login($user);

        return redirect()->route('home')->with('success', 'Registration successful! Welcome to our platform.');
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'      => ['required', 'confirmed', Password::defaults()],
            'full_name'     => ['nullable', 'string', 'max:255'],
            'phone'         => ['nullable', 'string', 'max:20'],
            'gender'        => ['nullable', 'in:male,female'],
            'birth_place'   => ['nullable', 'string', 'max:255'],
            'birth_date'    => ['nullable', 'date', 'before:today'],
            'address'       => ['nullable', 'string', 'max:1000'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'terms'         => ['required', 'accepted'],
        ], [
            'name.required'       => 'Username is required.',
            'email.required'      => 'Email address is required.',
            'email.unique'        => 'This email is already registered.',
            'password.required'   => 'Password is required.',
            'password.confirmed'  => 'Password confirmation does not match.',
            'phone.max'           => 'Phone number must not exceed 20 characters.',
            'birth_date.before'   => 'Birth date must be in the past.',
            'profile_photo.image' => 'Profile photo must be an image.',
            'profile_photo.mimes' => 'Profile photo must be a jpeg, png, jpg, or gif file.',
            'profile_photo.max'   => 'Profile photo must not exceed 2MB.',
            'terms.required'      => 'You must accept the terms and conditions.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data)
    {
        $userData = [
            'name'        => $data['name'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'full_name'   => $data['full_name'] ?? null,
            'phone'       => $data['phone'] ?? null,
            'gender'      => $data['gender'] ?? null,
            'birth_place' => $data['birth_place'] ?? null,
            'birth_date'  => $data['birth_date'] ?? null,
            'address'     => $data['address'] ?? null,
            'role'        => 'user',
        ];

        // Handle profile photo upload
        if (request()->hasFile('profile_photo')) {
            $file                      = request()->file('profile_photo');
            $filename                  = time() . '_' . $file->getClientOriginalName();
            $path                      = $file->storeAs('profile_photos', $filename, 'public');
            $userData['profile_photo'] = $path;
        }

        return User::create($userData);
    }
}
