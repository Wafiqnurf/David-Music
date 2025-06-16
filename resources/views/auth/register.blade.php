<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Music Platform</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
    <!-- Background Animation -->
    <div class="auth-bg">
        <div class="music-notes">
            <div class="note note-1">♪</div>
            <div class="note note-2">♫</div>
            <div class="note note-3">♪</div>
            <div class="note note-4">♫</div>
            <div class="note note-5">♪</div>
            <div class="note note-6">♫</div>
            <div class="note note-7">♪</div>
        </div>
    </div>

    <div class="auth-container">
        <div class="auth-card register-card">
            <div class="auth-header">
                <h2>Create Account</h2>
                <p>Join our music community today</p>
            </div>

            @if ($errors->any())
            <div class="notification notification-error"
                style="position: relative; opacity: 1; transform: translateX(0); margin-bottom: 1rem;">
                <ul style="margin: 0; padding: 0; list-style: none;">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="auth-form" enctype="multipart/form-data">
                @csrf

                <!-- Basic Information -->
                <div class="form-row">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">Username *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                        <label for="password">Password *</label>
                        <input type="password" id="password" name="password" required>
                        @error('password')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                        <label for="password_confirmation">Confirm Password *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                        @error('password_confirmation')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="form-group {{ $errors->has('full_name') ? 'has-error' : '' }}">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}">
                    @error('full_name')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group {{ $errors->has('birth_place') ? 'has-error' : '' }}">
                        <label for="birth_place">Birth Place</label>
                        <input type="text" id="birth_place" name="birth_place" value="{{ old('birth_place') }}">
                        @error('birth_place')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group {{ $errors->has('birth_date') ? 'has-error' : '' }}">
                        <label for="birth_date">Birth Date</label>
                        <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                        @error('birth_date')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                    <label for="address">Address</label>
                    <textarea id="address" name="address"
                        placeholder="Enter your full address">{{ old('address') }}</textarea>
                    @error('address')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Profile Photo Upload -->
                <div class="form-group {{ $errors->has('profile_photo') ? 'has-error' : '' }}">
                    <label for="profile_photo">Profile Photo</label>
                    <div class="file-upload-container">
                        <input type="file" id="profile_photo" name="profile_photo" accept="image/*"
                            style="display: none;" onchange="handleFileSelect(this)">
                        <button type="button" class="file-upload-btn"
                            onclick="document.getElementById('profile_photo').click()">
                            <span class="upload-icon">📸</span>
                            Choose Photo
                        </button>
                        <span class="file-name" id="file-name">No file chosen</span>
                        <div class="photo-preview" id="photo-preview" style="display: none;">
                            <img id="preview-image" src="" alt="Preview">
                        </div>
                    </div>
                    @error('profile_photo')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Terms and Conditions -->
                <div class="form-options">
                    <label class="checkbox-container {{ $errors->has('terms') ? 'has-error' : '' }}">
                        I agree to the <a href="#" class="terms-link">Terms and Conditions</a>
                        <input type="checkbox" name="terms" value="1" {{ old('terms') ? 'checked' : '' }} required>
                        <span class="checkmark"></span>
                    </label>
                    @error('terms')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="auth-btn">
                    Create Account
                </button>

                <div class="auth-switch">
                    <p>Already have an account? <a href="{{ route('login') }}">Sign in here</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
    function handleFileSelect(input) {
        const fileNameSpan = document.getElementById('file-name');
        const previewDiv = document.getElementById('photo-preview');
        const previewImage = document.getElementById('preview-image');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            fileNameSpan.textContent = file.name;

            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewDiv.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            fileNameSpan.textContent = 'No file chosen';
            previewDiv.style.display = 'none';
        }
    }

    // Auto-hide error notifications after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const notifications = document.querySelectorAll('.notification');
        notifications.forEach(function(notification) {
            setTimeout(function() {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100px)';
                setTimeout(function() {
                    notification.remove();
                }, 300);
            }, 5000);
        });
    });
    </script>
</body>

</html>
