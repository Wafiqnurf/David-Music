{{-- resources/views/admin/test-results/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Hasil Test')
@section('page-title', 'Hasil Test')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-chart-line"></i>
            Daftar Hasil Test
        </div>
        <div>
            <span class="badge badge-info">{{ $results->total() }} Total</span>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card-body border-bottom">
        <form method="GET" action="{{ route('admin.test-results.index') }}" class="row g-3">
            <!-- Search -->
            <div class="col-md-3">
                <label for="search" class="form-label">Cari Pengguna</label>
                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}"
                    placeholder="Nama atau email...">
            </div>

            <!-- Course Filter -->
            <div class="col-md-2">
                <label for="course_id" class="form-label">Kelas</label>
                <select class="form-control" id="course_id" name="course_id">
                    <option value="">Semua Kelas</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Test Filter -->
            <div class="col-md-2">
                <label for="test_id" class="form-label">Test</label>
                <select class="form-control" id="test_id" name="test_id">
                    <option value="">Semua Test</option>
                    @foreach($tests as $test)
                    <option value="{{ $test->id }}" {{ request('test_id') == $test->id ? 'selected' : '' }}>
                        {{ $test->title }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Review Status Filter -->
            <div class="col-md-2">
                <label for="review_status" class="form-label">Review</label>
                <select class="form-control" id="review_status" name="review_status">
                    <option value="">Semua Review</option>
                    <option value="reviewed" {{ request('review_status') == 'reviewed' ? 'selected' : '' }}>Sudah
                    </option>
                    <option value="not_reviewed" {{ request('review_status') == 'not_reviewed' ? 'selected' : '' }}>
                        Belum</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="col-md-1">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('admin.test-results.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="card-body">
        @if($results->count() > 0)
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Test</th>
                        <th>Kelas</th>
                        <th>Skor</th>
                        <th>Tanggal</th>
                        <th>Review</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                    <tr>
                        <td>
                            <div>
                                <strong>{{ $result->user->name }}</strong><br>
                                <small class="text-muted">{{ $result->user->email }}</small>
                            </div>
                        </td>
                        <td>
                            <strong>{{ $result->test->title }}</strong>
                        </td>
                        <td>
                            <span class="badge badge-light">{{ $result->test->course->name }}</span>
                        </td>
                        <td>
                            <div class="text-center">
                                <strong
                                    class="{{ $result->score >= $result->test->passing_score ? 'text-success' : 'text-danger' }}">
                                    {{ $result->score }}%
                                </strong>
                                <br>
                                <small class="text-muted">
                                    {{ $result->correct_answers }}/{{ $result->total_questions }} benar
                                </small>
                            </div>
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $result->created_at->format('d/m/Y H:i') }}
                                <br>
                                <em>{{ $result->created_at->diffForHumans() }}</em>
                            </small>
                        </td>
                        <td>
                            @if($result->admin_review)
                            <span class="badge badge-success">
                                <i class="fas fa-check"></i> Sudah
                            </span>
                            @else
                            <span class="badge badge-warning">
                                <i class="fas fa-clock"></i> Belum
                            </span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.test-results.show', $result) }}" class="btn btn-info btn-sm"
                                    title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Menampilkan {{ $results->firstItem() ?? 0 }} sampai {{ $results->lastItem() ?? 0 }}
                dari {{ $results->total() }} hasil
            </div>
            <div>
                {{ $results->appends(request()->query())->links() }}
            </div>
        </div>

        @else
        <div class="text-center text-muted py-5">
            <i class="fas fa-clipboard-list fa-3x mb-3"></i>
            <h5>
                @if(request()->hasAny(['search', 'course_id', 'test_id', 'status', 'review_status']))
                Tidak Ada Hasil yang Sesuai Filter
                @else
                Belum Ada Hasil Test
                @endif
            </h5>
            <p>
                @if(request()->hasAny(['search', 'course_id', 'test_id', 'status', 'review_status']))
                Coba ubah filter atau hapus filter untuk melihat semua hasil.
                @else
                Hasil test akan muncul di sini setelah ada siswa yang mengerjakan test.
                @endif
            </p>
            @if(request()->hasAny(['search', 'course_id', 'test_id', 'status', 'review_status']))
            <a href="{{ route('admin.test-results.index') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-times"></i> Hapus Filter
            </a>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.stat-card {
    background: white;
    border-radius: 8px;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-left: 4px solid;
}

.stat-card.success {
    border-left-color: #28a745;
}

.stat-card.danger {
    border-left-color: #dc3545;
}

.stat-card.info {
    border-left-color: #17a2b8;
}

.stat-card.warning {
    border-left-color: #ffc107;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #6c757d;
    font-size: 0.875rem;
}

.table th {
    border-top: none;
    font-weight: 600;
    background-color: #f8f9fa;
}

.btn-group .btn {
    margin-right: 2px;
}

.form-label {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.card-body.border-bottom {
    border-bottom: 1px solid #dee2e6 !important;
}

.g-3>* {
    margin-bottom: 1rem;
}

@media (max-width: 768px) {

    .col-md-1,
    .col-md-2,
    .col-md-3 {
        margin-bottom: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when filters change (optional)
    const filters = document.querySelectorAll('#course_id, #test_id, #status, #review_status');
    filters.forEach(filter => {
        filter.addEventListener('change', function() {
            // Uncomment the line below if you want auto-submit on filter change
            // this.form.submit();
        });
    });

    // Update test options based on selected course
    const courseSelect = document.getElementById('course_id');
    const testSelect = document.getElementById('test_id');
    const allTests = @json($tests);

    courseSelect.addEventListener('change', function() {
        const selectedCourseId = this.value;

        // Clear current test options
        testSelect.innerHTML = '<option value="">Semua Test</option>';

        if (selectedCourseId) {
            // Filter tests by selected course
            const filteredTests = allTests.filter(test => test.course.id == selectedCourseId);

            filteredTests.forEach(test => {
                const option = document.createElement('option');
                option.value = test.id;
                option.textContent = test.title;
                if ({
                        {
                            request('test_id') ?? 'null'
                        }
                    } == test.id) {
                    option.selected = true;
                }
                testSelect.appendChild(option);
            });
        } else {
            // Show all tests if no course selected
            allTests.forEach(test => {
                const option = document.createElement('option');
                option.value = test.id;
                option.textContent = test.title;
                if ({
                        {
                            request('test_id') ?? 'null'
                        }
                    } == test.id) {
                    option.selected = true;
                }
                testSelect.appendChild(option);
            });
        }
    });
});
</script>
@endpush
