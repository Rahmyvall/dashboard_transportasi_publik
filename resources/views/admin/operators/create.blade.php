@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="mb-0 fw-bold">Tambah Operator</h3>
            <small class="text-muted">Input data operator baru ke sistem</small>
        </div>

        <a href="{{ route('admin.operators.index') }}"
            class="btn btn-light border d-inline-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>

    </div>

    <!-- CARD FORM -->
    <div class="card border-0 shadow-lg rounded-4">

        <div class="card-body p-4">

            <form action="{{ route('admin.operators.store') }}" method="POST">
                @csrf

                <div class="row g-4">

                    <!-- Nama -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Operator</label>

                        <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                            <span class="input-group-text bg-white border-0">
                                <i class="bi bi-person text-primary"></i>
                            </span>

                            <input type="text" name="operator_name" class="form-control border-0"
                                placeholder="Masukkan nama operator" required>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No Telepon</label>

                        <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                            <span class="input-group-text bg-white border-0">
                                <i class="bi bi-telephone text-success"></i>
                            </span>

                            <input type="text" name="phone" class="form-control border-0" placeholder="08xxxxxxxxxx">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>

                        <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                            <span class="input-group-text bg-white border-0">
                                <i class="bi bi-envelope text-danger"></i>
                            </span>

                            <input type="email" name="email" class="form-control border-0"
                                placeholder="email@domain.com">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status</label>

                        <select name="status" class="form-select form-select-lg shadow-sm rounded-3">
                            <option value="aktif">🟢 Aktif</option>
                            <option value="nonaktif">🔴 Nonaktif</option>
                        </select>
                    </div>

                    <!-- Address -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat</label>

                        <textarea name="address" rows="3" class="form-control shadow-sm rounded-3"
                            placeholder="Masukkan alamat lengkap operator"></textarea>
                    </div>

                </div>

                <!-- BUTTON ACTION -->
                <div class="d-flex justify-content-end gap-2 mt-5">

                    <a href="{{ route('admin.operators.index') }}" class="btn btn-outline-secondary px-4">
                        Batal
                    </a>

                    <button class="btn btn-primary px-4 d-inline-flex align-items-center gap-2 shadow-sm">
                        <i class="bi bi-save"></i>
                        Simpan Data
                    </button>

                </div>

            </form>

        </div>
    </div>
@endsection
