@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-0 fw-bold">Data User</h4>
                <small class="text-muted">Manajemen akun pengguna sistem</small>
            </div>

            <a href="{{ route('users.create') }}" class="btn btn-primary shadow-sm">
                <i class="fa fa-plus me-1"></i> Tambah User
            </a>
        </div>

        <!-- CARD -->
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Pengguna</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Operator</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $i => $user)
                                <tr>

                                    {{-- ✅ FIX NOMOR PAGINATION --}}
                                    <td class="fw-semibold">
                                        {{ $users->firstItem() + $i }}
                                    </td>

                                    <!-- USER INFO -->
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold">{{ $user->name }}</span>
                                            <small class="text-muted">
                                                <i class="fa fa-envelope me-1"></i>
                                                {{ $user->email ?? '-' }}
                                            </small>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $user->username }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-info text-dark px-3 py-2">
                                            <i class="fa fa-user-shield me-1"></i>
                                            {{ $user->role->role_name ?? '-' }}
                                        </span>
                                    </td>

                                    <td>
                                        <i class="fa fa-building text-muted me-1"></i>
                                        {{ $user->operator->operator_name ?? '-' }}
                                    </td>

                                    <!-- STATUS -->
                                    <td>
                                        @if ($user->status == 'aktif')
                                            <span class="badge bg-success px-3 py-2">
                                                <i class="fa fa-check me-1"></i> Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-danger px-3 py-2">
                                                <i class="fa fa-xmark me-1"></i> Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <!-- ACTION -->
                                    <td class="text-center">

                                        <a href="{{ route('users.edit', $user->id) }}"
                                            class="btn btn-sm btn-warning text-white me-1">
                                            <i class="fa fa-pen"></i>
                                        </a>

                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin hapus user ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                        </form>

                                    </td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                <!-- ✅ PAGINATION -->
                <div class="d-flex justify-content-between align-items-center mt-3">

                    <small class="text-muted">
                        Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }}
                        dari {{ $users->total() }} data
                    </small>

                    <div>
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>

                </div>

            </div>
        </div>

    </div>
@endsection
