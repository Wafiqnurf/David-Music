{{-- resources/views/admin/courses/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Kelola Kelas')
@section('page-title', 'Kelola Kelas')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-book"></i>
            Daftar Kelas
        </div>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Kelas
        </a>
    </div>

    <div class="card-body">
        @if($courses->count() > 0)
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Nama Kelas</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Peserta</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                    <tr>
                        <td>
                            @if($course->icon)
                            <img src="{{ asset('storage/' . $course->icon) }}" alt="Icon"
                                style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                            @else
                            <div
                                style="width: 40px; height: 40px; background: #f8f9fa; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-book text-muted"></i>
                            </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $course->name }}</strong>
                        </td>
                        <td>
                            <div style="max-width: 300px;">
                                {{ Str::limit($course->description, 100) }}
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-primary">
                                {{ $course->enrollments->count() }} Peserta
                            </span>
                        </td>
                        <td>
                            @if($course->is_active)
                            <span class="badge badge-success">Aktif</span>
                            @else
                            <span class="badge badge-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.courses.destroy', $course) }}"
                                    style="display: inline-block;"
                                    onsubmit="return confirmDelete('Apakah Anda yakin ingin menghapus kelas ini? Semua data terkait akan ikut terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center text-muted">
            <i class="fas fa-book fa-4x mb-3"></i>
            <h4>Belum Ada Kelas</h4>
            <p>Mulai dengan membuat kelas pertama Anda.</p>
            <a href="{{ route('admin.courses.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Kelas Pertama
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Quick Stats -->
<div class="stats-grid">
    <div class="stat-card primary">
        <div class="stat-number">{{ $courses->count() }}</div>
        <div class="stat-label">Total Kelas</div>
    </div>

    <div class="stat-card success">
        <div class="stat-number">{{ $courses->where('is_active', true)->count() }}</div>
        <div class="stat-label">Kelas Aktif</div>
    </div>

    <div class="stat-card warning">
        <div class="stat-number">{{ $courses->sum(function($course) { return $course->enrollments->count(); }) }}</div>
        <div class="stat-label">Total Peserta</div>
    </div>

    <div class="stat-card info">
        <div class="stat-number">
            {{ $courses->avg(function($course) { return $course->enrollments->count(); }) ? number_format($courses->avg(function($course) { return $course->enrollments->count(); }), 1) : 0 }}
        </div>
        <div class="stat-label">Rata-rata Peserta</div>
    </div>
</div>
@endsection
