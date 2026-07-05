@extends('layouts.app')

@section('content')
    <style>
        .page-wrap {
            background: #f6f8fc;
            min-height: 100vh;
            padding-bottom: 30px;
        }

        .page-header {
            background: linear-gradient(135deg, #60a5fa, #3b82f6, #1d4ed8);
            color: #fff;
            padding: 20px;
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(59, 130, 246, 0.25);
            margin-bottom: 20px;
        }

        .card-modern {
            border: none;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .section-title {
            font-size: 12px;
            letter-spacing: .08em;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 10px;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            padding: 11px 12px;
            border: 1px solid #e5e7eb;
            transition: .2s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.15);
        }

        .btn-modern {
            background: linear-gradient(135deg, #60a5fa, #3b82f6);
            border: none;
            padding: 10px 18px;
            border-radius: 12px;
            font-weight: 600;
            color: #fff;
            box-shadow: 0 8px 18px rgba(59, 130, 246, 0.25);
        }

        hr {
            border-top: 1px solid #eef2f7;
            margin: 20px 0;
        }

        .sim-preview {
            background: #f1f5f9;
            border: 1px dashed #94a3b8;
            padding: 10px;
            border-radius: 12px;
            font-weight: 600;
            color: #0f172a;
        }
    </style>

    <div class="page-wrap">

        <div class="container-pg">

            {{-- HEADER --}}
            <div class="page-header">
                <h4>🚛 Tambah Driver</h4>
                <small>SIM dibuat otomatis oleh sistem</small>
            </div>

            <form action="{{ route('admin.drivers.store') }}" method="POST">
                @csrf

                <div class="card card-modern">

                    <div class="card-body">

                        {{-- SECTION 1 --}}
                        <div class="section-title">Informasi Operator</div>

                        <div class="row g-3">

                            <div class="col-md-12">
                                <label>Operator</label>
                                <select name="operator_id" class="form-select" required>
                                    <option value="">Pilih Operator</option>
                                    @foreach ($operators as $o)
                                        <option value="{{ $o->id }}">
                                            {{ $o->operator_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <hr>

                        {{-- SECTION 2 --}}
                        <div class="section-title">Identitas Driver</div>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label>Nama Driver</label>
                                <input type="text" name="driver_name" class="form-control"
                                    placeholder="Masukkan nama driver" required>
                            </div>

                            {{-- SIM AUTO INFO --}}
                            <div class="col-md-6">
                                <label>No SIM</label>
                                <div class="sim-preview">
                                    🆔 SIM akan otomatis dibuat oleh sistem
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label>No HP</label>
                                <input type="text" name="phone" class="form-control" placeholder="0812xxxxxx">
                            </div>

                            <div class="col-md-6">
                                <label>Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="active">Active</option>
                                    <option value="on_duty">On Duty</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                        </div>

                        <hr>

                        {{-- SECTION 3 --}}
                        <div class="section-title">Alamat & Catatan</div>

                        <div class="row g-3">

                            <div class="col-md-12">
                                <label>Alamat</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Alamat lengkap driver"></textarea>
                            </div>

                        </div>

                    </div>

                    {{-- FOOTER --}}
                    <div class="card-footer bg-white border-0 text-end">
                        <button type="submit" class="btn btn-modern">
                            💾 Simpan Driver
                        </button>
                    </div>

                </div>

            </form>

        </div>

    </div>
@endsection
