{{-- resources/views/admin/courses/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Kelas')
@section('page-title', 'Edit Kelas')

@section('breadcrumb')
<nav style="margin-top: 0.5rem;">
    <a href="{{ route('admin.courses.index') }}" class="text-muted" style="text-decoration: none;">
        <i class="fas fa-book"></i> Kelola Kelas
    </a>
    <span class="text-muted"> / Edit Kelas</span>
</nav>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-edit"></i>
        Form Edit Kelas: {{ $course->name }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data"
            id="course-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name" class="form-label">Nama Kelas *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    value="{{ old('name', $course->name) }}" required placeholder="Masukkan nama kelas">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Deskripsi *</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                    name="description" rows="4" required
                    placeholder="Jelaskan tentang kelas ini">{{ old('description', $course->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="icon" class="form-label">Icon Kelas</label>
                    @if($course->icon)
                    <div class="mb-2">
                        <strong>Icon Saat Ini:</strong><br>
                        <img src="{{ asset('storage/' . $course->icon) }}" alt="Current Icon" class="image-preview">
                    </div>
                    @endif
                    <div class="file-upload">
                        <input type="file" class="@error('icon') is-invalid @enderror" id="icon" name="icon"
                            accept="image/*" onchange="previewImage(this, 'icon-preview')">
                        <label for="icon" class="file-upload-label">
                            <i class="fas fa-upload"></i>
                            {{ $course->icon ? 'Ganti Icon' : 'Pilih Icon' }} (PNG, JPG, JPEG - Max 2MB)
                        </label>
                    </div>
                    @error('icon')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <img id="icon-preview" class="image-preview" style="display: none;">
                </div>

                <div class="form-group">
                    <label for="image" class="form-label">Gambar Kelas</label>
                    @if($course->image)
                    <div class="mb-2">
                        <strong>Gambar Saat Ini:</strong><br>
                        <img src="{{ asset('storage/' . $course->image) }}" alt="Current Image" class="image-preview">
                    </div>
                    @endif
                    <div class="file-upload">
                        <input type="file" class="@error('image') is-invalid @enderror" id="image" name="image"
                            accept="image/*" onchange="previewImage(this, 'image-preview')">
                        <label for="image" class="file-upload-label">
                            <i class="fas fa-upload"></i>
                            {{ $course->image ? 'Ganti Gambar' : 'Pilih Gambar' }} (PNG, JPG, JPEG - Max 2MB)
                        </label>
                    </div>
                    @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <img id="image-preview" class="image-preview" style="display: none;">
                </div>
            </div>

            <div class="form-group">
                <label for="is_active" class="form-label">Status</label>
                <select class="form-control form-select @error('is_active') is-invalid @enderror" id="is_active"
                    name="is_active">
                    <option value="1" {{ old('is_active', $course->is_active) == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('is_active', $course->is_active) == '0' ? 'selected' : '' }}>Tidak Aktif
                    </option>
                </select>
                @error('is_active')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </form>
    </div>

    <div class="card-footer">
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <div>
                <button type="submit" form="course-form" class="btn btn-success">
                    <i class="fas fa-save"></i> Update Kelas
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Course Information -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-info-circle"></i>
        Informasi Kelas
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div>
                <strong>Dibuat:</strong>
                <p class="text-muted mb-2">{{ $course->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <strong>Terakhir Diupdate:</strong>
                <p class="text-muted mb-2">{{ $course->updated_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <strong>Total Peserta:</strong>
                <p class="text-muted mb-2">{{ $course->enrollments()->count() }} orang</p>
            </div>
            <div>
                <strong>Total Test:</strong>
                <p class="text-muted mb-2">{{ $course->tests()->count() }} test</p>
            </div>
        </div>
    </div>
</div>
@endsection
