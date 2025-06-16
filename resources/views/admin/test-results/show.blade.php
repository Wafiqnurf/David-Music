{{-- resources/views/admin/test-results/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Hasil Test')
@section('page-title', 'Detail Hasil Test')

@section('content')
<div class="row">
    <!-- Test Result Summary -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i>
                Informasi Test
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Pengguna:</strong><br>
                    <span>{{ $result->user->name ?? 'Tidak tersedia' }}</span><br>
                    <small class="text-muted">{{ $result->user->email ?? 'Email tidak tersedia' }}</small>
                </div>

                <div class="mb-3">
                    <strong>Test:</strong><br>
                    <span>{{ $result->test->title ?? 'Judul test tidak tersedia' }}</span>
                </div>

                <div class="mb-3">
                    <strong>Kelas:</strong><br>
                    <span class="badge badge-light">{{ $result->test->course->name ?? 'Kelas tidak tersedia' }}</span>
                </div>

                <div class="mb-3">
                    <strong>Tanggal:</strong><br>
                    <span>{{ $result->created_at ? $result->created_at->format('d/m/Y H:i:s') : 'Tanggal tidak tersedia' }}</span><br>
                    <small
                        class="text-muted">{{ $result->created_at ? $result->created_at->diffForHumans() : '' }}</small>
                </div>
            </div>
        </div>

        <!-- Score Summary -->
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-chart-pie"></i>
                Ringkasan Skor
            </div>
            <div class="card-body text-center">
                <div class="score-display mb-3">
                    <div
                        class="score-circle {{ ($result->score ?? 0) >= ($result->test->passing_score ?? 0) ? 'success' : 'danger' }}">
                        <span class="score-number">{{ $result->score ?? 0 }}%</span>
                    </div>
                </div>

                <div class="row text-center">
                    <div class="col-4">
                        <div class="stat-item">
                            <div class="stat-number text-success">{{ $result->correct_answers ?? 0 }}</div>
                            <div class="stat-label">Benar</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-item">
                            <div class="stat-number text-danger">
                                {{ ($result->total_questions ?? 0) - ($result->correct_answers ?? 0) }}
                            </div>
                            <div class="stat-label">Salah</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-item">
                            <div class="stat-number text-info">{{ $result->total_questions ?? 0 }}</div>
                            <div class="stat-label">Total</div>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                </div>
            </div>
        </div>
    </div>

    <!-- Video Submission -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-video"></i>
                Video yang Dikirim Siswa
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Link Video:</strong><br>
                    @if($result->video_url)
                    <a href="{{ $result->video_url }}" target="_blank" class="btn btn-primary">
                        <i class="fas fa-play"></i> Lihat Video
                    </a>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Admin Review Section -->
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-comment-alt"></i>
                Review Admin
            </div>
            <div class="card-body">
                @if($result->admin_review)
                <div class="existing-review">
                    <div class="alert alert-info">
                        <strong>Review:</strong><br>
                        {{ $result->admin_review }}
                    </div>
                </div>
                @endif

                <form action="{{ route('admin.test-results.review', $result) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="admin_review">
                            {{ $result->admin_review ? 'Update Review:' : 'Tambah Review:' }}
                        </label>
                        <textarea class="form-control @error('admin_review') is-invalid @enderror" id="admin_review"
                            name="admin_review" rows="4"
                            placeholder="Masukkan review atau catatan untuk hasil test ini...">{{ old('admin_review', $result->admin_review) }}</textarea>
                        @error('admin_review')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        {{ $result->admin_review ? 'Update Review' : 'Simpan Review' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="card mt-3">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.test-results.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
            <div>
                <button onclick="window.print()" class="btn btn-info">
                    <i class="fas fa-print"></i> Cetak
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.score-circle {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    border: 4px solid;
    position: relative;
}

.score-circle.success {
    border-color: #28a745;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}

.score-circle.danger {
    border-color: #dc3545;
    background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
    color: white;
}

.score-number {
    font-size: 1.5rem;
    font-weight: bold;
}

.stat-item {
    padding: 10px;
}

.stat-item .stat-number {
    font-size: 1.25rem;
    font-weight: bold;
}

.stat-item .stat-label {
    font-size: 0.875rem;
    color: #6c757d;
}

.badge-lg {
    font-size: 1rem;
    padding: 0.5rem 1rem;
}

.existing-review .alert {
    border-left: 4px solid #17a2b8;
}

@media print {
    .card-header {
        background-color: #f8f9fa !important;
        -webkit-print-color-adjust: exact;
    }

    .btn,
    .breadcrumb {
        display: none !important;
    }
}
</style>
@endpush
