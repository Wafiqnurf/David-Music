{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card primary">
        <div class="stat-number">{{ $stats['total_users'] }}</div>
        <div class="stat-label">Total Pengguna</div>
    </div>

    <div class="stat-card success">
        <div class="stat-number">{{ $stats['total_courses'] }}</div>
        <div class="stat-label">Total Kelas</div>
    </div>

    <div class="stat-card warning">
        <div class="stat-number">{{ $stats['total_enrollments'] }}</div>
        <div class="stat-label">Total Pendaftaran</div>
    </div>

    <div class="stat-card info">
        <div class="stat-number">{{ $stats['total_tests_taken'] }}</div>
        <div class="stat-label">Test Dikerjakan</div>
    </div>
</div>

<div class="d-flex" style="gap: 2rem;">
    <!-- Recent Enrollments -->
    <div class="card" style="flex: 1;">
        <div class="card-header">
            <i class="fas fa-user-plus"></i>
            Pendaftaran Terbaru
        </div>
        <div class="card-body">
            @if($recentEnrollments->count() > 0)
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Kelas</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentEnrollments as $enrollment)
                        <tr>
                            <td>
                                <strong>{{ $enrollment->user->name }}</strong><br>
                                <small class="text-muted">{{ $enrollment->user->email }}</small>
                            </td>
                            <td>{{ $enrollment->course->name }}</td>
                            <td>
                                <small class="text-muted">
                                    {{ $enrollment->created_at->format('d/m/Y H:i') }}
                                </small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center text-muted">
                <i class="fas fa-inbox fa-3x mb-3"></i>
                <p>Belum ada pendaftaran</p>
            </div>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.courses.index') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-eye"></i> Lihat Semua Kelas
            </a>
        </div>
    </div>

    <!-- Recent Test Results -->
    <div class="card" style="flex: 1;">
        <div class="card-header">
            <i class="fas fa-chart-line"></i>
            Hasil Test Terbaru
        </div>
        <div class="card-body">
            @if($recentTests->count() > 0)
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Test</th>
                            <th>Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTests as $result)
                        <tr>
                            <td>
                                <strong>{{ $result->user->name }}</strong><br>
                                <small class="text-muted">{{ $result->user->email }}</small>
                            </td>
                            <td>
                                <strong>{{ $result->test->title }}</strong><br>
                                <small class="text-muted">{{ $result->test->course->name }}</small>
                            </td>
                            <td>
                                <strong>{{ $result->score }}%</strong>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center text-muted">
                <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                <p>Belum ada hasil test</p>
            </div>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.test-results.index') }}" class="btn btn-info btn-sm">
                <i class="fas fa-eye"></i> Lihat Semua Hasil
            </a>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-bolt"></i>
        Aksi Cepat
    </div>
    <div class="card-body">
        <div class="d-flex" style="gap: 1rem; flex-wrap: wrap;">
            <a href="{{ route('admin.courses.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Kelas Baru
            </a>
            <a href="{{ route('admin.tests.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Buat Test Baru
            </a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-warning">
                <i class="fas fa-user-plus"></i> Tambah Pengguna
            </a>
            <a href="{{ route('admin.test-results.index') }}" class="btn btn-info">
                <i class="fas fa-chart-bar"></i> Lihat Laporan
            </a>
        </div>
    </div>
</div>
@endsection
