{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Kelola Pengguna')
@section('page-title', 'Kelola Pengguna')

@section('content')
@include('components.alert')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-users"></i>
            Daftar Pengguna
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Pengguna
        </a>
    </div>
    <div class="card-body">
        @if($users->count() > 0)
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Nama Lengkap</th>
                        <th>Telepon</th>
                        <th>Role</th>
                        <th>Kelas Diikuti</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            <strong>{{ $user->name }}</strong>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->full_name ?? '-' }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $user->role === 'admin' ? 'badge-danger' : 'badge-success' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $user->courses->count() }} Kelas</span>
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $user->created_at->format('d/m/Y') }}
                            </small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info btn-sm"
                                    title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <!-- <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a> -->
                                @if($user->role !== 'admin')
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                    style="display: inline;"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center text-muted py-5">
            <i class="fas fa-users fa-4x mb-3"></i>
            <h5>Belum Ada Pengguna</h5>
            <p>Tambahkan pengguna pertama untuk memulai.</p>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Pengguna
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Statistics Card -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-number">{{ $users->count() }}</div>
            <div class="stat-label">Total Pengguna</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card info">
            <div class="stat-number">{{ $users->sum(function($user) { return $user->courses->count(); }) }}</div>
            <div class="stat-label">Total Pendaftaran</div>
        </div>
    </div>
</div>
@endsection
