@extends('layouts.admin')

@section('title', 'Kelola Test')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Kelola Test</h1>
    <a href="{{ route('admin.tests.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Test
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Test</h5>
    </div>
    <div class="card-body">
        @if($tests->count() > 0)
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Test</th>
                        <th>Kelas</th>
                        <th>Jumlah Soal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tests as $index => $test)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $test->title }}</strong>
                            @if($test->description)
                            <br><small class="text-muted">{{ Str::limit($test->description, 50) }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-primary">{{ $test->course->name }}</span>
                        </td>
                        <td>{{ $test->questions->count() }} soal</td>
                        <td>
                            @if($test->questions->count() > 0)
                            <span class="badge badge-success">Aktif</span>
                            @else
                            <span class="badge badge-warning">Belum Ada Soal</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.tests.show', $test) }}" class="btn btn-sm btn-primary"
                                    title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.tests.questions', $test) }}" class="btn btn-sm btn-info"
                                    title="Kelola Soal">
                                    <i class="fas fa-list"></i>
                                </a>
                                <a href="{{ route('admin.tests.edit', $test) }}" class="btn btn-sm btn-warning"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.tests.destroy', $test) }}" method="POST"
                                    style="display: inline;"
                                    onsubmit="return confirm('Yakin ingin menghapus test ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
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
        <div class="text-center">
            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada test</h5>
            <p class="text-muted">Silakan tambah test baru untuk memulai.</p>
            <a href="{{ route('admin.tests.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Test Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
