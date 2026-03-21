@extends('layouts.app')
@section('title','Manajemen User')
@section('page-title','Manajemen User')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">
        <span class="fw-semibold"><i class="bi bi-person-gear me-2"></i>Daftar User</span>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah User</a>
    </div>
    <div class="card-body border-bottom pb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama / email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select form-select-sm">
                    <option value="">Semua Role</option>
                    <option value="admin"  {{ request('role')==='admin'?'selected':'' }}>Admin</option>
                    <option value="guru"   {{ request('role')==='guru'?'selected':'' }}>Guru</option>
                    <option value="user"   {{ request('role')==='user'?'selected':'' }}>User</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-outline-primary flex-grow-1"><i class="bi bi-search me-1"></i>Cari</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Terdaftar</th>
                    <th class="text-end pe-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($userList as $u)
            <tr>
                <td class="ps-3 fw-semibold">{{ $u->name }}</td>
                <td class="small text-muted">{{ $u->email }}</td>
                <td>
                    <span class="badge bg-{{ $u->role==='admin'?'danger':($u->role==='guru'?'primary':'success') }}">
                        {{ ucfirst($u->role) }}
                    </span>
                </td>
                <td class="small text-muted">{{ $u->created_at->format('d M Y') }}</td>
                <td class="text-end pe-3">
                    <a href="{{ route('admin.users.edit',$u) }}" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil"></i></a>
                    @if($u->id !== auth()->id())
                    <form id="del-u-{{ $u->id }}" method="POST" action="{{ route('admin.users.destroy',$u) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-form="del-u-{{ $u->id }}"><i class="bi bi-trash"></i></button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada user ditemukan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($userList->hasPages())
    <div class="card-footer">{{ $userList->links() }}</div>
    @endif
</div>
@endsection
