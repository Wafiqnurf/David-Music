@extends('layouts.admin')

@section('title', 'Detail Test')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Detail Test</h1>
    <div>
        <a href="{{ route('admin.tests.questions', $test) }}" class="btn btn-info">
            <i class="fas fa-list"></i> Kelola Soal
        </a>
        <a href="{{ route('admin.tests.edit', $test) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.tests.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card primary">
        <div class="stat-number">{{ $test->questions->count() }}</div>
        <div class="stat-label">Total Soal</div>
    </div>
    <div class="stat-card success">
        <div class="stat-number">{{ $test->results->count() }}</div>
        <div class="stat-label">Total Peserta</div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Informasi Test</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6><strong>Judul Test:</strong></h6>
                <p>{{ $test->title }}</p>

                <h6><strong>Kelas:</strong></h6>
                <p><span class="badge badge-primary">{{ $test->course->name }}</span></p>
            </div>
            <div class="col-md-6">
                <h6><strong>Status:</strong></h6>
                <p>
                    @if($test->questions->count() > 0)
                    <span class="badge badge-success">Aktif</span>
                    @else
                    <span class="badge badge-warning">Belum Ada Soal</span>
                    @endif
                </p>

                <h6><strong>Dibuat:</strong></h6>
                <p>{{ $test->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        @if($test->description)
        <div class="mt-3">
            <h6><strong>Deskripsi:</strong></h6>
            <p>{{ $test->description }}</p>
        </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Hasil Test</h5>
    </div>
    <div class="card-body">
        @if($test->results->count() > 0)
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Email</th>
                        <th>Nilai</th>
                        <th>Waktu Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($test->results->sortByDesc('created_at') as $index => $result)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $result->user->name }}</td>
                        <td>{{ $result->user->email }}</td>
                        <td>
                            <strong
                                class="{{ $result->score >= $test->passing_score ? 'text-success' : 'text-danger' }}">
                                {{ $result->score }}%
                            </strong>
                        </td>
                        <td>{{ $result->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.test-results.show', $result) }}" class="btn btn-sm btn-primary"
                                title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center">
            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada hasil test</h5>
            <p class="text-muted">Belum ada peserta yang mengerjakan test ini.</p>
        </div>
        @endif
    </div>
</div>
@endsection
