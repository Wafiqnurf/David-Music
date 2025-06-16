@extends('layouts.app')

@section('title', 'Profile - David Music Course')

@section('content')
<!-- Main Content -->
<main class="profile-section">
    <div class="container">
        <div class="profile-container">
            <!-- Profile Photo Section -->
            <div class="profile-photo-section">
                <div class="profile-photo">
                    @if($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo">
                    @else
                    <div class="default-avatar">
                        <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                    @endif
                </div>
                <div class="profile-actions">
                    <a href="{{ route('profile.edit') }}" class="edit-profile-btn">Edit Profile</a>
                </div>
            </div>

            <!-- Profile Info Section -->
            <div class="profile-info">
                <div class="info-row">
                    <div class="info-label">Nama :</div>
                    <div class="info-value">{{ $user->full_name ?: $user->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Nickname :</div>
                    <div class="info-value">{{ $user->nickname ?: $user->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Jenis Kelamin :</div>
                    <div class="info-value">
                        {{ $user->gender ? ($user->gender == 'male' ? 'Laki-laki' : 'Perempuan') : '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tempat/Tanggal Lahir :</div>
                    <div class="info-value">
                        @if($user->birth_place && $user->birth_date)
                        {{ $user->birth_place }}, {{ \Carbon\Carbon::parse($user->birth_date)->format('d F Y') }}
                        @else
                        -
                        @endif
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Alamat :</div>
                    <div class="info-value">{{ $user->address ?: '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email :</div>
                    <div class="info-value">{{ $user->email }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">No.Telepon :</div>
                    <div class="info-value">{{ $user->phone ?: '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="results-section">
            <h2 class="results-title">Hasil Test</h2>

            @if($testResults->count() > 0)
            <div class="table-responsive">
                <table class="results-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Test</th>
                            <th>Kelas</th>
                            <th>Test</th>
                            <th>Skor</th>
                            <th>Video</th>
                            <th>Catatan Pengajar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($testResults as $index => $result)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $result->completed_at->format('d M Y') }}</td>
                            <td>{{ $result->test->course->name }}</td>
                            <td>{{ $result->test->title }}</td>
                            <td>
                                <span
                                    class="score-badge {{ $result->score >= $result->test->passing_score ? 'pass' : 'fail' }}">
                                    {{ $result->score }}%
                                </span>
                            </td>
                            <td>
                                @if($result->video_url)
                                <a href="{{ $result->video_url }}" target="_blank" class="video-link">Lihat Video</a>
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @if($result->admin_review)
                                <div class="review-preview" title="{{ $result->admin_review }}">
                                    {{ Str::limit($result->admin_review, 50) }}
                                </div>
                                @else
                                <span class="review-pending">Menunggu review</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('test.result', $result) }}" class="detail-btn">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            @endif
        </div>
    </div>
</main>
@endsection

@section('styles')
<style>
.profile-actions {
    margin-top: 15px;
    text-align: center;
}

.edit-profile-btn {
    background-color: #007bff;
    color: white;
    padding: 8px 16px;
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
}

.edit-profile-btn:hover {
    background-color: #0056b3;
}

.default-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background-color: #007bff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 48px;
    font-weight: bold;
}

.table-responsive {
    overflow-x: auto;
}

.score-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-weight: bold;
    font-size: 12px;
}

.score-badge.pass {
    background-color: #d4edda;
    color: #155724;
}

.score-badge.fail {
    background-color: #f8d7da;
    color: #721c24;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: bold;
}

.status-badge.success {
    background-color: #28a745;
    color: white;
}

.status-badge.failed {
    background-color: #dc3545;
    color: white;
}

.video-link {
    color: #007bff;
    text-decoration: none;
    font-size: 12px;
}

.video-link:hover {
    text-decoration: underline;
}

.review-preview {
    font-size: 12px;
    cursor: help;
}

.review-pending {
    font-style: italic;
    color: #6c757d;
    font-size: 12px;
}

.detail-btn {
    background-color: #17a2b8;
    color: white;
    padding: 4px 8px;
    text-decoration: none;
    border-radius: 4px;
    font-size: 12px;
}

.detail-btn:hover {
    background-color: #138496;
}

.no-results {
    text-align: center;
    padding: 40px;
}

.no-results .cta-btn {
    margin-top: 20px;
}
</style>
@endsection
