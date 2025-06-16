@extends('layouts.admin')

@section('title', 'Edit Test')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Edit Test</h1>
    <a href="{{ route('admin.tests.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Edit Test</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.tests.update', $test) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="course_id" class="form-label">Kelas <span class="text-danger">*</span></label>
                <select name="course_id" id="course_id"
                    class="form-control form-select @error('course_id') is-invalid @enderror" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}"
                        {{ (old('course_id', $test->course_id) == $course->id) ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                    @endforeach
                </select>
                @error('course_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="title" class="form-label">Judul Test <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title', $test->title) }}" placeholder="Masukkan judul test" required>
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" rows="4"
                    class="form-control @error('description') is-invalid @enderror"
                    placeholder="Masukkan deskripsi test (opsional)">{{ old('description', $test->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Test
                </button>
                <a href="{{ route('admin.tests.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
