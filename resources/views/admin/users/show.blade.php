{{-- resources/views/admin/users/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna: ' . $user->name)

@section('content')
@include('components.alert')

<!-- User Profile Card -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-user"></i>
                Informasi Pengguna
            </div>
            <div>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Photo Section -->
            <div class="col-md-3 text-center">
                <div class="profile-photo-container">
                    @if($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}"
                        alt="Foto {{ $user->full_name ?? $user->name }}" class="profile-photo" id="profile-image">
                    @else
                    <div class="profile-photo-placeholder">
                        <i class="fas fa-user fa-4x"></i>
                    </div>
                    @endif
                </div>
                <!-- Photo info -->
                <div class="mt-2">
                    @if($user->profile_photo)
                    <small class="text-muted d-block">
                        <i class="fas fa-camera"></i> Foto Profile
                    </small>
                    @else
                    <small class="text-muted d-block">
                        <i class="fas fa-user-circle"></i> No Photo
                    </small>
                    @endif
                </div>
            </div>

            <!-- User Information -->
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong><i class="fas fa-id-badge"></i> ID:</strong></td>
                                <td>{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <td><strong><i class="fas fa-user"></i> Username:</strong></td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td><strong><i class="fas fa-id-card"></i> Nama Lengkap:</strong></td>
                                <td>{{ $user->full_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong><i class="fas fa-envelope"></i> Email:</strong></td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            @if($user->gender)
                            <tr>
                                <td><strong><i class="fas fa-venus-mars"></i> Jenis Kelamin:</strong></td>
                                <td>{{ $user->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong><i class="fas fa-phone"></i> Telepon:</strong></td>
                                <td>{{ $user->phone ?? '-' }}</td>
                            </tr>
                            @if($user->birth_place || $user->birth_date)
                            <tr>
                                <td><strong><i class="fas fa-birthday-cake"></i> Tempat/Tanggal Lahir:</strong></td>
                                <td>
                                    {{ $user->birth_place ?? '' }}
                                    @if($user->birth_place && $user->birth_date), @endif
                                    {{ $user->birth_date ? $user->birth_date->format('d/m/Y') : '' }}
                                    @if(!$user->birth_place && !$user->birth_date) - @endif
                                </td>
                            </tr>
                            @endif
                            @if($user->address)
                            <tr>
                                <td><strong><i class="fas fa-map-marker-alt"></i> Alamat:</strong></td>
                                <td>{{ Str::limit($user->address, 50) }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td><strong><i class="fas fa-user-tag"></i> Role:</strong></td>
                                <td>
                                    <span
                                        class="badge {{ $user->role === 'admin' ? 'badge-danger' : 'badge-success' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong><i class="fas fa-calendar-plus"></i> Bergabung:</strong></td>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong><i class="fas fa-calendar-alt"></i> Terakhir Update:</strong></td>
                                <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-number">{{ $user->userCourses->count() }}</div>
            <div class="stat-label">Kelas Diikuti</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card info">
            <div class="stat-number">{{ $user->testResults->count() }}</div>
            <div class="stat-label">Test Dikerjakan</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="stat-number">{{ $user->testResults->where('passed', true)->count() }}</div>
            <div class="stat-label">Test Lulus</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="stat-number">
                {{ $user->testResults->count() > 0 ? round($user->testResults->avg('score'), 1) : 0 }}%</div>
            <div class="stat-label">Rata-rata Skor</div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Enrolled Courses -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-graduation-cap"></i>
                Kelas yang Diikuti ({{ $user->userCourses->count() }})
            </div>
            <div class="card-body">
                @if($user->userCourses->count() > 0)
                <div class="table-container">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Kelas</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->userCourses as $enrollment)
                            <tr>
                                <td>
                                    <strong>{{ $enrollment->course->name }}</strong><br>
                                    <small
                                        class="text-muted">{{ Str::limit($enrollment->course->description, 50) }}</small>
                                </td>
                                <td>
                                    <small>{{ $enrollment->created_at->format('d/m/Y') }}</small>
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{ $enrollment->status ?? 'Aktif' }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-3">
                    <i class="fas fa-graduation-cap fa-2x mb-2"></i>
                    <p>Belum mengikuti kelas apapun</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Test Results -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-line"></i>
                Hasil Test Terbaru ({{ $user->testResults->count() }})
            </div>
            <div class="card-body">
                @if($user->testResults->count() > 0)
                <div class="table-container">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Test</th>
                                <th>Skor</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->testResults->sortByDesc('created_at')->take(10) as $result)
                            <tr>
                                <td>
                                    <strong>{{ $result->test->name }}</strong><br>
                                    <small class="text-muted">{{ $result->test->course->name }}</small>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $result->score >= 70 ? 'success' : 'danger' }}">
                                        {{ $result->score }}%
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $result->passed ? 'success' : 'danger' }}">
                                        {{ $result->passed ? 'Lulus' : 'Tidak Lulus' }}
                                    </span>
                                </td>
                                <td>
                                    <small>{{ $result->created_at->format('d/m/Y') }}</small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-3">
                    <i class="fas fa-chart-line fa-2x mb-2"></i>
                    <p>Belum mengerjakan test apapun</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Activity Log (Fixed) -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-history"></i>
                Aktivitas Terakhir
            </div>
            <div class="card-body">
                <div class="timeline">
                    @if($user->testResults->count() > 0)
                    @foreach($user->testResults->sortByDesc('created_at')->take(5) as $result)
                    <div class="timeline-item">
                        <div class="timeline-marker bg-{{ $result->passed ? 'success' : 'danger' }}"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">
                                {{ $result->passed ? 'Lulus' : 'Tidak Lulus' }} Test: {{ $result->test->name }}
                            </h6>
                            <p class="timeline-text">
                                Skor: {{ $result->score }}% pada kelas {{ $result->test->course->name }}
                            </p>
                            <small class="text-muted">{{ $result->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @endforeach
                    @endif

                    {{-- FIX: Menggunakan userCourses relationship yang benar --}}
                    @if($user->userCourses->count() > 0)
                    @foreach($user->userCourses->sortByDesc('created_at')->take(3) as $enrollment)
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">
                                Bergabung dengan kelas: {{ $enrollment->course->name }}
                            </h6>
                            <small class="text-muted">{{ $enrollment->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @endforeach
                    @endif

                    <div class="timeline-item">
                        <div class="timeline-marker bg-info"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Mendaftar sebagai pengguna</h6>
                            <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.profile-photo-container {
    position: relative;
    display: inline-block;
}

.profile-photo {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    transition: transform 0.3s ease;
}

.profile-photo:hover {
    transform: scale(1.05);
}

.profile-photo-placeholder {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin: 0 auto;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.badge-lg {
    font-size: 0.9rem;
    padding: 8px 16px;
}

.stat-card {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-left: 4px solid #007bff;
    margin-bottom: 20px;
}

.stat-card.primary {
    border-left-color: #007bff;
}

.stat-card.info {
    border-left-color: #17a2b8;
}

.stat-card.success {
    border-left-color: #28a745;
}

.stat-card.warning {
    border-left-color: #ffc107;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
}

.stat-label {
    color: #666;
    font-size: 0.9rem;
    margin-top: 5px;
}

.table-container {
    max-height: 400px;
    overflow-y: auto;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-item:before {
    content: '';
    position: absolute;
    left: -24px;
    top: 8px;
    bottom: -12px;
    width: 2px;
    background: #e9ecef;
}

.timeline-item:last-child:before {
    display: none;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 8px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-title {
    margin-bottom: 5px;
    font-size: 1rem;
}

.timeline-text {
    margin-bottom: 5px;
    color: #666;
}

.bg-primary {
    background-color: #007bff !important;
}

.bg-success {
    background-color: #28a745 !important;
}

.bg-danger {
    background-color: #dc3545 !important;
}

.bg-info {
    background-color: #17a2b8 !important;
}

/* Modal untuk preview foto */
.modal-photo-preview .modal-dialog {
    max-width: 500px;
}

.modal-photo-preview .modal-body {
    text-align: center;
    padding: 20px;
}

.modal-photo-preview img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Photo preview on click
    const profileImage = document.getElementById('profile-image');
    if (profileImage) {
        profileImage.addEventListener('click', function() {
            // Create modal for photo preview
            const modal = document.createElement('div');
            modal.className = 'modal fade modal-photo-preview';
            modal.innerHTML = `
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Profile Photo</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img src="${this.src}" alt="Profile Photo Preview" class="img-fluid">
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            $(modal).modal('show');

            // Remove modal after hide
            $(modal).on('hidden.bs.modal', function() {
                document.body.removeChild(modal);
            });
        });
    }
});
</script>
@endpush
