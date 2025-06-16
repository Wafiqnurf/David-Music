@extends('layouts.app')

@section('title', 'Edit Profile - David Music Course')

@section('content')
<!-- Main Content -->
<main class="profile-edit-section">
    <div class="container">
        <div class="edit-profile-container">
            <div class="edit-header">
                <div class="header-content">
                    <div>
                        <h1>Edit Profile</h1>
                        <p>Perbarui informasi pribadi Anda</p>
                    </div>
                    <a href="{{ route('profile.show') }}" class="back-btn">← Kembali ke Profile</a>
                </div>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                class="edit-profile-form">
                @csrf
                @method('PUT')

                <!-- Photo Section -->
                <div class="form-section">
                    <h2>Foto Profile</h2>
                    <div class="photo-upload-section">
                        <div class="current-photo">
                            @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Current Profile Photo"
                                id="current-photo-preview">
                            @else
                            <div class="default-avatar" id="current-photo-preview">
                                <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="photo-upload-controls">
                            <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                                class="file-input">
                            <label for="profile_photo" class="file-label">
                                📷 Pilih Foto Baru
                            </label>
                            <small class="file-help">Format yang didukung: JPEG, PNG, JPG, GIF<br>Ukuran maksimal:
                                2MB</small>
                            @error('profile_photo')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="form-section">
                    <h2>Informasi Pribadi</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="full_name" class="required">Nama Lengkap</label>
                            <input type="text" name="full_name" id="full_name"
                                value="{{ old('full_name', Auth::user()->full_name) }}"
                                placeholder="Masukkan nama lengkap" required>
                            @error('full_name')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nickname" class="required">Nickname</label>
                            <input type="text" name="nickname" id="nickname"
                                value="{{ old('nickname', Auth::user()->nickname) }}" placeholder="Masukkan nickname"
                                required>
                            @error('nickname')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="gender" class="required">Jenis Kelamin</label>
                            <select name="gender" id="gender" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male"
                                    {{ old('gender', Auth::user()->gender) == 'male' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="female"
                                    {{ old('gender', Auth::user()->gender) == 'female' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                            @error('gender')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="birth_place" class="required">Tempat Lahir</label>
                            <input type="text" name="birth_place" id="birth_place"
                                value="{{ old('birth_place', Auth::user()->birth_place) }}"
                                placeholder="Masukkan tempat lahir" required>
                            @error('birth_place')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="birth_date" class="required">Tanggal Lahir</label>
                            <input type="date" name="birth_date" id="birth_date"
                                value="{{ old('birth_date', Auth::user()->birth_date) }}" required>
                            @error('birth_date')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group full-width">
                            <label for="address" class="required">Alamat</label>
                            <textarea name="address" id="address" rows="3" placeholder="Masukkan alamat lengkap"
                                required>{{ old('address', Auth::user()->address) }}</textarea>
                            @error('address')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="form-section">
                    <h2>Informasi Kontak</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="email" class="required">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}"
                                placeholder="contoh@email.com" required>
                            @error('email')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone" class="required">No. Telepon</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', Auth::user()->phone) }}"
                                placeholder="08123456789" required>
                            @error('phone')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        💾 Simpan Perubahan
                    </button>
                    <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                        ❌ Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@section('styles')
<style>
* {
    box-sizing: border-box;
}

.profile-edit-section {
    padding: 40px 0;
    background-color: #f8f9fa;
    min-height: calc(100vh - 140px);
    margin-top: 60px;
}

.edit-profile-container {
    max-width: 800px;
    margin: 0 auto;
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.edit-header {
    padding: 32px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    position: relative;
}

.edit-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
}

.header-content {
    position: relative;
    z-index: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.edit-header h1 {
    font-size: 32px;
    font-weight: 700;
    margin: 0 0 8px 0;
}

.edit-header p {
    opacity: 0.9;
    font-size: 16px;
    margin: 0;
}

.back-btn {
    color: white;
    text-decoration: none;
    padding: 12px 24px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 8px;
    transition: all 0.3s ease;
    font-weight: 500;
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.1);
}

.back-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-2px);
    text-decoration: none;
    color: white;
}

.edit-profile-form {
    padding: 0;
}

.form-section {
    padding: 32px;
    border-bottom: 1px solid #e9ecef;
}

.form-section:last-child {
    border-bottom: none;
}

.form-section h2 {
    margin: 0 0 24px 0;
    font-size: 24px;
    color: #2d3748;
    font-weight: 600;
    position: relative;
    padding-bottom: 12px;
}

.form-section h2::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 3px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 2px;
}

.photo-upload-section {
    display: flex;
    align-items: center;
    gap: 32px;
    padding: 24px;
    background: #f8f9fc;
    border-radius: 12px;
    border: 2px dashed #e2e8f0;
}

.current-photo {
    position: relative;
}

.current-photo img,
.default-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid white;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

.current-photo img {
    object-fit: cover;
}

.default-avatar {
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 48px;
    font-weight: bold;
}

.photo-upload-controls {
    flex: 1;
}

.file-input {
    display: none;
}

.file-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 600;
    border: none;
    text-decoration: none;
}

.file-label:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
}

.file-help {
    display: block;
    margin-top: 12px;
    color: #718096;
    font-size: 14px;
    line-height: 1.5;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-group label {
    margin-bottom: 8px;
    font-weight: 600;
    color: #2d3748;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.required::after {
    content: '*';
    color: #e53e3e;
    font-weight: bold;
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 16px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: white;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    transform: translateY(-1px);
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
    font-family: inherit;
}

.error-message {
    margin-top: 8px;
    color: #e53e3e;
    font-size: 12px;
    font-weight: 500;
    padding: 8px 12px;
    background: #fed7d7;
    border-radius: 6px;
    border-left: 4px solid #e53e3e;
}

.form-actions {
    padding: 32px;
    background: linear-gradient(to bottom, #f7fafc, #edf2f7);
    display: flex;
    gap: 16px;
    justify-content: center;
    align-items: center;
}

.btn {
    padding: 16px 32px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-width: 160px;
    height: 56px;
    box-sizing: border-box;
}

.btn-primary {
    background: linear-gradient(135deg, #48bb78, #38a169);
    color: white;
    box-shadow: 0 4px 16px rgba(72, 187, 120, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(72, 187, 120, 0.4);
    background: linear-gradient(135deg, #38a169, #2f855a);
}

.btn-secondary {
    background: #e2e8f0;
    color: #4a5568;
    border: 1px solid #cbd5e0;
}

.btn-secondary:hover {
    background: #cbd5e0;
    color: #2d3748;
    transform: translateY(-1px);
    text-decoration: none;
}

/* Alert Styles */
.alert {
    padding: 16px 20px;
    margin: 20px 32px;
    border-radius: 8px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 12px;
}

.alert-success {
    background: #f0fff4;
    color: #22543d;
    border: 1px solid #9ae6b4;
    border-left: 4px solid #48bb78;
}

.alert-error {
    background: #fed7d7;
    color: #742a2a;
    border: 1px solid #feb2b2;
    border-left: 4px solid #e53e3e;
}

/* Responsive Design */
@media (max-width: 768px) {
    .profile-edit-section {
        padding: 20px 0;
    }

    .edit-header {
        padding: 24px;
    }

    .header-content {
        flex-direction: column;
        gap: 16px;
        text-align: center;
    }

    .edit-header h1 {
        font-size: 24px;
    }

    .photo-upload-section {
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }

    .form-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .form-section {
        padding: 24px 20px;
    }

    .form-actions {
        flex-direction: column;
        padding: 24px;
    }

    .btn {
        width: 100%;
        min-width: unset;
    }
}

@media (max-width: 480px) {
    .edit-profile-container {
        margin: 10px;
        border-radius: 12px;
    }

    .form-section h2 {
        font-size: 20px;
    }
}
</style>
@endsection

@section('scripts')
<script>
// Preview uploaded image
document.getElementById('profile_photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('current-photo-preview');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                // Replace default avatar with image
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Profile Photo Preview';
                img.id = 'current-photo-preview';
                img.style.width = '120px';
                img.style.height = '120px';
                img.style.borderRadius = '50%';
                img.style.objectFit = 'cover';
                img.style.border = '4px solid white';
                img.style.boxShadow = '0 8px 24px rgba(0, 0, 0, 0.15)';
                preview.parentNode.replaceChild(img, preview);
            }
        };
        reader.readAsDataURL(file);
    }
});

// Form validation
document.querySelector('.edit-profile-form').addEventListener('submit', function(e) {
    const requiredFields = ['full_name', 'nickname', 'email', 'phone', 'gender', 'birth_place', 'birth_date',
        'address'
    ];
    let hasErrors = false;

    requiredFields.forEach(field => {
        const input = document.getElementById(field);
        if (!input.value.trim()) {
            hasErrors = true;
            input.style.borderColor = '#e53e3e';
        } else {
            input.style.borderColor = '#e2e8f0';
        }
    });

    if (hasErrors) {
        e.preventDefault();
        alert('Mohon lengkapi semua field yang wajib diisi (*)');
    }
});

// Phone number formatting
document.getElementById('phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 0 && !value.startsWith('0')) {
        value = '0' + value;
    }
    e.target.value = value;
});

// Remove error styling on input
document.querySelectorAll('input, select, textarea').forEach(input => {
    input.addEventListener('input', function() {
        if (this.value.trim()) {
            this.style.borderColor = '#e2e8f0';
        }
    });
});
</script>
@endsection
