@extends('layouts.admin')

@section('title', 'Kelola Soal Test')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Kelola Soal Test</h1>
        <p class="text-muted mb-0">{{ $test->title }} - {{ $test->course->name }}</p>
    </div>
    <div>
        <a href="{{ route('admin.tests.questions.create', $test) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Soal
        </a>
        <a href="{{ route('admin.tests.show', $test) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Informasi Test</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <strong>Total Soal:</strong><br>
                <span class="text-primary">{{ $questions->count() }}</span>
            </div>
            <div class="col-md-3">
                <strong>Durasi:</strong><br>
                <span class="text-info">{{ $test->duration_minutes }} menit</span>
            </div>
            <div class="col-md-3">
                <strong>Nilai Lulus:</strong><br>
                <span class="text-warning">{{ $test->passing_score }}%</span>
            </div>
            <div class="col-md-3">
                <strong>Status:</strong><br>
                @if($questions->count() > 0)
                <span class="badge badge-success">Siap Digunakan</span>
                @else
                <span class="badge badge-warning">Belum Ada Soal</span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Soal</h5>
    </div>
    <div class="card-body">
        @if($questions->count() > 0)
        @foreach($questions as $question)
        <div class="question-item">
            <div class="question-header">
                <div class="question-number">{{ $question->order }}</div>
                <div class="question-text">{{ $question->question }}</div>
                <div class="action-buttons">
                    <a href="{{ route('admin.tests.questions.edit', [$test, $question]) }}"
                        class="btn btn-sm btn-warning" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.tests.questions.destroy', [$test, $question]) }}" method="POST"
                        style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>

            <ul class="options-list">
                @foreach($question->options as $index => $option)
                <li class="option-item {{ $index == $question->correct_answer ? 'correct' : '' }}">
                    <strong>{{ chr(65 + $index) }}.</strong> {{ $option }}
                </li>
                @endforeach
            </ul>

            @if($question->explanation)
            <div class="explanation">
                <strong>Penjelasan:</strong> {{ $question->explanation }}
            </div>
            @endif
        </div>
        @endforeach
        @else
        <div class="text-center">
            <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada soal</h5>
            <p class="text-muted">Silakan tambah soal untuk test ini.</p>
            <a href="{{ route('admin.tests.questions.create', $test) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Soal Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
