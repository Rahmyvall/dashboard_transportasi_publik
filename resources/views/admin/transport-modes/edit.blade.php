{{-- resources/views/admin/transport-modes/edit.blade.php --}}

@extends('layouts.app')

@section('content')

    <style>
        .tm-edit {
            --primary: #2563eb;
            --border: #e2e8f0;
            --muted: #64748b;
        }

        .tm-card {
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, .06);
        }

        .tm-header {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #fff;
            border-radius: 20px;
            padding: 22px;
        }

        .form-control:focus {
            border-color: #fbbf24;
            box-shadow: 0 0 0 .2rem rgba(245, 158, 11, .15);
        }

        .btn-warning {
            background: #f59e0b;
            border: none;
            color: #fff;
        }

        .btn-warning:hover {
            background: #d97706;
            color: #fff;
        }

        .btn-light {
            border: 1px solid #e2e8f0;
        }
    </style>

    <div class="tm-edit container-fluid">

        {{-- HEADER --}}
        <div class="tm-header mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h3 class="mb-1 fw-bold">Edit Mode Transportasi</h3>
                <small>Perbarui data transport mode</small>
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
                <form action="{{ route('admin.transport-modes.update', $transportMode->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    {{-- MODE CODE --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Mode</label>
                        <input type="text" name="mode_code" class="form-control"
                            value="{{ old('mode_code', $transportMode->mode_code) }}"
                            placeholder="Contoh: BUS, TRAIN, FERRY" required>
                        <small class="text-muted">Kode unik transportasi</small>
                    </div>

                    {{-- MODE NAME --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Mode</label>
                        <input type="text" name="mode_name" class="form-control"
                            value="{{ old('mode_name', $transportMode->mode_name) }}" placeholder="Contoh: Bus Kota"
                            required>
                        <small class="text-muted">Nama jenis transportasi</small>
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" rows="3" class="form-control" placeholder="Deskripsi tambahan (opsional)">{{ old('description', $transportMode->description) }}</textarea>
                        <small class="text-muted">Penjelasan tambahan mode transportasi</small>
                    </div>

                    {{-- BUTTON --}}
                    <div class="d-flex gap-2">

                        <button type="submit" class="btn btn-warning px-4">
                            Update Data
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
