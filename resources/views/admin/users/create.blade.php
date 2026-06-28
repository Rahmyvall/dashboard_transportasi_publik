@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-0 fw-bold">Tambah User</h4>
                <small class="text-muted">Buat akun pengguna baru</small>
            </div>

            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" placeholder="Nama lengkap" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username login"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email (opsional)">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role</label>
                            <select name="role_id" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">
                                        {{ $role->role_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Operator</label>
                            <select name="operator_id" class="form-select">
                                <option value="">-- Opsional --</option>
                                @foreach ($operators as $op)
                                    <option value="{{ $op->id }}">
                                        {{ $op->operator_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>

                    </div>

                    <button class="btn btn-success">
                        <i class="fa fa-save me-1"></i> Simpan User
                    </button>

                </form>

            </div>
        </div>

    </div>
@endsection
