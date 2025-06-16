{{-- resources/views/admin/courses/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Kelas')
@section('page-title', 'Tambah Kelas')

@section('breadcrumb')
<nav style="margin-top: 0.5rem;">
    <a href="{{ route('admin.courses.index') }}" class="text-muted" style="text-decoration: none;">
        <i class="fas fa-book"></i> Kelola Kelas
    </a>
    <span class="text-muted"> / Tambah Kelas</span>
</nav>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-plus"></i>
        Form Tambah Kelas
    </div>

    <div class="card-body">
        {{-- Tambahkan ID langsung ke form --}}
        <form id="course-form" method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Nama Kelas *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    value="{{ old('name') }}" required placeholder="Masukkan nama kelas">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Deskripsi *</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                    name="description" rows="4" required
                    placeholder="Jelaskan tentang kelas ini">{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="icon" class="form-label">Icon Kelas</label>
                    <div class="file-upload">
                        <input type="file" class="@error('icon') is-invalid @enderror" id="icon" name="icon"
                            accept="image/*" onchange="previewImage(this, 'icon-preview')">
                        <label for="icon" class="file-upload-label">
                            <i class="fas fa-upload"></i>
                            Pilih Icon (PNG, JPG, JPEG - Max 2MB)
                        </label>
                    </div>
                    @error('icon')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <img id="icon-preview" class="image-preview" style="display: none;">
                </div>

                <div class="form-group">
                    <label for="image" class="form-label">Gambar Kelas</label>
                    <div class="file-upload">
                        <input type="file" class="@error('image') is-invalid @enderror" id="image" name="image"
                            accept="image/*" onchange="previewImage(this, 'image-preview')">
                        <label for="image" class="file-upload-label">
                            <i class="fas fa-upload"></i>
                            Pilih Gambar (PNG, JPG, JPEG - Max 2MB)
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
                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('is_active')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Pindahkan tombol submit ke dalam form --}}
            <div class="form-group mt-4">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <div>
                        <button type="button" onclick="this.form.reset()" class="btn btn-warning">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan Kelas
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Help Card -->
<div class="card mt-3">
    <div class="card-header">
        <i class="fas fa-info-circle"></i>
        Panduan Pengisian
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem;">
            <div>
                <strong>Nama Kelas:</strong>
                <p class="text-muted mb-2">Berikan nama yang jelas dan mudah dipahami untuk kelas Anda.</p>
            </div>
            <div>
                <strong>Deskripsi:</strong>
                <p class="text-muted mb-2">Jelaskan materi yang akan dipelajari dalam kelas ini.</p>
            </div>
            <div>
                <strong>Icon:</strong>
                <p class="text-muted mb-2">Icon kecil yang akan ditampilkan sebagai representasi kelas.</p>
            </div>
            <div>
                <strong>Gambar:</strong>
                <p class="text-muted mb-2">Gambar besar yang akan ditampilkan sebagai thumbnail kelas.</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Fungsi untuk preview gambar
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}
</script>
@endpush
@endsection
