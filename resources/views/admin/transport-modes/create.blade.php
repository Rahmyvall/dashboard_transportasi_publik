{{-- resources/views/admin/transport-modes/create.blade.php --}}

@extends('layouts.app')

@section('content')

    <style>
        .tm-create {
            --primary: #2563eb;
            --border: #e2e8f0;
            --muted: #64748b;
        }

        .tm-card {
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, .06);
            overflow: hidden;
        }

        .tm-header {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: #fff;
            border-radius: 20px;
            padding: 22px;
        }

        .form-control:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .15);
        }

        .btn-primary {
            background: #2563eb;
            border: none;
        }

        .btn-primary:hover {
            background: #1e40af;
        }

        .btn-light {
            border: 1px solid #e2e8f0;
        }
    </style>

    <div class="tm-create container-fluid">

        {{-- HEADER --}}
        <div class="tm-header mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h3 class="mb-1 fw-bold">Tambah Mode Transportasi</h3>
                <small>Input data moda transportasi baru</small>
            </div>

            <a href="{{ route('admin.transport-modes.index') }}" class="btn btn-light">
                ← Kembali
            </a>

        </div>

        {{-- CARD FORM --}}
        <div class="card tm-card">

            <div class="card-body p-4">

                {{-- ERROR --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Terjadi kesalahan!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORM --}}
                <form action="{{ route('admin.transport-modes.store') }}" method="POST">

                    @csrf

                    {{-- MODE CODE --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Mode</label>
                        <input type="text" name="mode_code" class="form-control" placeholder="Contoh: BUS, TRAIN, FERRY"
                            value="{{ old('mode_code') }}" required>
                        <small class="text-muted">Kode unik untuk identifikasi transportasi</small>
                    </div>

                    {{-- MODE NAME --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Mode</label>
                        <input type="text" name="mode_name" class="form-control" placeholder="Contoh: Bus Kota"
                            value="{{ old('mode_name') }}" required>
                        <small class="text-muted">Nama lengkap jenis transportasi</small>
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" rows="3" class="form-control" placeholder="Deskripsi tambahan (opsional)">{{ old('description') }}</textarea>
                        <small class="text-muted">Penjelasan tambahan mengenai mode transportasi</small>
                    </div>

                    {{-- BUTTON --}}
                    <div class="d-flex gap-2">

                        <button type="submit" class="btn btn-primary px-4">
                            Simpan Data
                        </button>

                        <a href="{{ route('admin.transport-modes.index') }}" class="btn btn-light">
                            Batal
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
