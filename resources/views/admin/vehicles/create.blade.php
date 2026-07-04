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

        .auto-code {
            background: #f1f5f9;
            border: 1px dashed #94a3b8;
            color: #0f172a;
            font-weight: 600;
        }
    </style>

    <div class="page-wrap">

        <div class="container-pg">

            <!-- HEADER -->
            <div class="page-header">
                <h4>🚛 Tambah Vehicle</h4>
                <small>Monitoring armada transportasi publik otomatis system</small>
            </div>

            <form action="{{ route('admin.vehicles.store') }}" method="POST">
                @csrf

                <div class="card card-modern">

                    <div class="card-body">

                        <!-- SECTION 1 -->
                        <div class="section-title">Informasi Operasional</div>

                        <div class="row g-3">

                            <div class="col-md-6">
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

                            <div class="col-md-6">
                                <label>Transport Mode</label>
                                <select name="transport_mode_id" class="form-select" required>
                                    <option value="">Pilih Mode</option>
                                    @foreach ($modes as $m)
                                        <option value="{{ $m->id }}">
                                            {{ $m->mode_name ?? $m->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <hr>

                        <!-- SECTION 2 -->
                        <div class="section-title">Identitas Kendaraan</div>

                        <div class="row g-3">

                            <!-- AUTO VEHICLE CODE -->
                            <div class="col-md-6">
                                <label>Vehicle Code (Auto System)</label>
                                <input type="text" class="form-control auto-code" value="{{ $autoCode }}" readonly>

                                <small class="text-muted">
                                    Code dibuat otomatis oleh sistem
                                </small>
                            </div>

                            <div class="col-md-6">
                                <label>Plate Number</label>
                                <input type="text" name="plate_number" class="form-control"
                                    placeholder="Contoh: B 1234 ABC">
                            </div>

                            <div class="col-md-4">
                                <label>Capacity</label>
                                <input type="number" name="capacity" class="form-control" placeholder="Jumlah penumpang"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label>Manufacture Year</label>
                                <input type="number" name="manufacture_year" class="form-control"
                                    placeholder="Tahun produksi">
                            </div>

                            <div class="col-md-4">
                                <label>Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="available" selected>Available</option>
                                    <option value="on_trip">On Trip</option>
                                    <option value="maintenance">Maintenance</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                        </div>

                        <hr>

                        <!-- SECTION 3 -->
                        <div class="section-title">Maintenance & Notes</div>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label>Last Service Date</label>
                                <input type="date" name="last_service_date" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label>Notes</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Catatan kendaraan..."></textarea>
                            </div>

                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div class="card-footer bg-white border-0 text-end">
                        <button class="btn btn-modern">
                            💾 Simpan Vehicle
                        </button>
                    </div>

                </div>

            </form>

        </div>

    </div>
@endsection
