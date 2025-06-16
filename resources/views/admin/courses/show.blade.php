{{-- resources/views/admin/courses/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Kelas')
@section('page-title', 'Detail Kelas')

@section('breadcrumb')
<nav style="margin-top: 0.5rem;">
    <a href="{{ route('admin.courses.index') }}" class="text-muted" style="text-decoration: none;">
        <i class="fas fa-book"></i> Kelola Kelas
    </a>
    <span class="text-muted"> / Detail Kelas</span>
</nav>
@endsection

@section('content')
<!-- Course Information -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-info-circle"></i>
            Informasi Kelas
        </div>
        <div class="action-buttons">
            <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit Kelas
            </a>
            <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" style="display: inline-block;"
                onsubmit="return confirmDelete('Apakah Anda yakin ingin menghapus kelas ini? Semua data terkait akan ikut terhapus.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i> Hapus Kelas
                </button>
            </form>
        </div>
    </div>

    <div class="card-body">
        <div style="display: grid; grid-template-columns: auto 1fr; gap: 2rem; align-items: start;">
            <!-- Course Images -->
            <div>
                @if($course->image)
                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}"
                    style="width: 200px; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 1rem;">
                @endif

                @if($course->icon)
                <div>
                    <strong>Icon:</strong><br>
                    <img src="{{ asset('storage/' . $course->icon) }}" alt="Icon"
                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                </div>
                @endif
            </div>

            <!-- Course Details -->
            <div>
                <h2 class="mb-3">{{ $course->name }}</h2>

                <div class="mb-3">
                    @if($course->is_active)
                    <span class="badge badge-success">Aktif</span>
                    @else
                    <span class="badge badge-secondary">Tidak Aktif</span>
                    @endif
                </div>

                <div class="mb-3">
                    <strong>Deskripsi:</strong>
                    <p class="text-muted mt-1">{{ $course->description }}</p>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
                    <div>
                        <strong>Dibuat:</strong>
                        <p class="text-muted">{{ $course->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <strong>Diupdate:</strong>
                        <p class="text-muted">{{ $course->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <strong>Total Peserta:</strong>
                        <p class="text-muted">{{ $enrollments->count() }} orang</p>
                    </div>
                    <div>
                        <strong>Total Test:</strong>
                        <p class="text-muted">{{ $course->tests()->count() }} test</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="stats-grid">
    <div class="stat-card primary">
        <div class="stat-number">{{ $enrollments->count() }}</div>
        <div class="stat-label">Total Peserta</div>
    </div>

    <div class="stat-card success">
        <div class="stat-number">{{ $course->tests()->count() }}</div>
        <div class="stat-label">Total Test</div>
    </div>

    <div class="stat-card warning">
        <div class="stat-number">{{ $course->tests()->withCount('results')->get()->sum('results_count') }}</div>
        <div class="stat-label">Test Dikerjakan</div>
    </div>

    <div class="stat-card info">
        <div class="stat-number">
            @php
            $totalResults = $course->tests()->withCount('results')->get()->sum('results_count');
            $passedResults = 0;
            foreach($course->tests as $test) {
            $passedResults += $test->results()->where('score', '>=', $test->passing_score)->count();
            }
            $passRate = $totalResults > 0 ? round(($passedResults / $totalResults) * 100) : 0;
            @endphp
            {{ $passRate }}%
        </div>
        <div class="stat-label">Tingkat Kelulusan</div>
    </div>
</div>

<!-- Course Tests -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-clipboard-check"></i>
            Test dalam Kelas
        </div>
        <a href="{{ route('admin.tests.create') }}?course_id={{ $course->id }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i> Tambah Test
        </a>
    </div>

    <div class="card-body">
        @if($course->tests->count() > 0)
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Judul Test</th>
                        <th>Durasi</th>
                        <th>Nilai Lulus</th>
                        <th>Pertanyaan</th>
                        <th>Dikerjakan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($course->tests as $test)
                    <tr>
                        <td>
                            <strong>{{ $test->title }}</strong>
                            @if($test->description)
                            <br><small class="text-muted">{{ Str::limit($test->description, 50) }}</small>
                            @endif
                        </td>
                        <td>{{ $test->duration_minutes }} menit</td>
                        <td>{{ $test->passing_score }}%</td>
                        <td>
                            <span class="badge badge-info">{{ $test->questions()->count() }} soal</span>
                        </td>
                        <td>
                            <span class="badge badge-primary">{{ $test->results()->count() }} kali</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.tests.show', $test) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <a href="{{ route('admin.tests.questions', $test) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-question-circle"></i> Soal
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center text-muted">
            <i class="fas fa-clipboard-check fa-3x mb-3"></i>
            <h5>Belum Ada Test</h5>
            <p>Mulai dengan membuat test pertama untuk kelas ini.</p>
            <a href="{{ route('admin.tests.create') }}?course_id={{ $course->id }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Buat Test
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Course Enrollments -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-users"></i>
            Peserta Kelas
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#exportModal">
                <i class="fas fa-download"></i> Export Data
            </button>
            <a href="{{ route('admin.enrollments.create') }}?course_id={{ $course->id }}"
                class="btn btn-success btn-sm">
                <i class="fas fa-user-plus"></i> Tambah Peserta
            </a>
        </div>
    </div>

    <div class="card-body">
        @if($enrollments->count() > 0)
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Peserta</th>
                        <th>Email</th>
                        <th>Tanggal Bergabung</th>
                        <th>Status</th>
                        <th>Test Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrollments as $enrollment)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar">
                                    @if($enrollment->user->avatar)
                                    <img src="{{ asset('storage/' . $enrollment->user->avatar) }}"
                                        alt="{{ $enrollment->user->name }}" class="rounded-circle"
                                        style="width: 32px; height: 32px; object-fit: cover;">
                                    @else
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                        style="width: 32px; height: 32px; font-size: 14px;">
                                        {{ strtoupper(substr($enrollment->user->name, 0, 1)) }}
                                    </div>
                                    @endif
                                </div>
                                <div class="ml-2">
                                    <strong>{{ $enrollment->user->name }}</strong>
                                </div>
                            </div>
                        </td>
                        <td>{{ $enrollment->user->email }}</td>
                        <td>{{ $enrollment->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($enrollment->is_active)
                            <span class="badge badge-success">Aktif</span>
                            @else
                            <span class="badge badge-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            @php
                            $completedTests = $enrollment->user->testResults()
                            ->whereHas('test', function($q) use ($course) {
                            $q->where('course_id', $course->id);
                            })->count();
                            @endphp
                            <span class="badge badge-info">{{ $completedTests }} dari
                                {{ $course->tests()->count() }}</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.users.show', $enrollment->user) }}"
                                    class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Profile
                                </a>
                                <button class="btn btn-warning btn-sm"
                                    onclick="toggleEnrollmentStatus({{ $enrollment->id }}, {{ $enrollment->is_active ? 'false' : 'true' }})">
                                    <i class="fas fa-{{ $enrollment->is_active ? 'pause' : 'play' }}"></i>
                                    {{ $enrollment->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination if needed -->
        @if($enrollments instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-center mt-3">
            {{ $enrollments->links() }}
        </div>
        @endif
        @else
        <div class="text-center text-muted">
            <i class="fas fa-users fa-3x mb-3"></i>
            <h5>Belum Ada Peserta</h5>
            <p>Belum ada peserta yang terdaftar di kelas ini.</p>
            <a href="{{ route('admin.enrollments.create') }}?course_id={{ $course->id }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Tambah Peserta Pertama
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Data Kelas</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Pilih jenis data yang ingin di-export:</p>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="exportEnrollments" checked>
                        <label class="form-check-label" for="exportEnrollments">
                            Data Peserta Kelas
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="exportTestResults" checked>
                        <label class="form-check-label" for="exportTestResults">
                            Hasil Test Peserta
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="exportStatistics">
                        <label class="form-check-label" for="exportStatistics">
                            Statistik Kelas
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="{{ route('admin.courses.export', $course) }}" class="btn btn-primary" id="exportBtn">
                    <i class="fas fa-download"></i> Export ke Excel
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(message) {
    return confirm(message);
}

function toggleEnrollmentStatus(enrollmentId, newStatus) {
    if (confirm('Apakah Anda yakin ingin mengubah status peserta ini?')) {
        fetch(`/admin/enrollments/${enrollmentId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    is_active: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Terjadi kesalahan saat mengubah status peserta.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengubah status peserta.');
            });
    }
}

// Handle export modal
document.getElementById('exportBtn').addEventListener('click', function(e) {
    e.preventDefault();

    const params = new URLSearchParams();
    if (document.getElementById('exportEnrollments').checked) {
        params.append('include[]', 'enrollments');
    }
    if (document.getElementById('exportTestResults').checked) {
        params.append('include[]', 'test_results');
    }
    if (document.getElementById('exportStatistics').checked) {
        params.append('include[]', 'statistics');
    }

    const exportUrl = `{{ route('admin.courses.export', $course) }}?${params.toString()}`;
    window.location.href = exportUrl;

    // Close modal
    $('#exportModal').modal('hide');
});
</script>
@endpush

@push('styles')
<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 8px;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-left: 4px solid;
}

.stat-card.primary {
    border-left-color: #007bff;
}

.stat-card.success {
    border-left-color: #28a745;
}

.stat-card.warning {
    border-left-color: #ffc107;
}

.stat-card.info {
    border-left-color: #17a2b8;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #6c757d;
    font-size: 0.9rem;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.action-buttons .btn {
    white-space: nowrap;
}

.table-container {
    overflow-x: auto;
}

.user-avatar {
    flex-shrink: 0;
}

@media (max-width: 768px) {
    .action-buttons {
        flex-direction: column;
        align-items: stretch;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .card-header .d-flex {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch !important;
    }
}
</style>
@endpush
