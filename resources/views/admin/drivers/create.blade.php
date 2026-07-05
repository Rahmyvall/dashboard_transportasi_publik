@extends('layouts.app')

@section('content')
    <style>
        :root {
            --bg: #f5f7fb;
            --card: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --primary: #2563eb;
            --border: #e5e7eb;
            --radius: 18px;
            --shadow: 0 12px 30px rgba(15, 23, 42, .08);
        }

        .wrap {
            background: var(--bg);
            min-height: 100vh;
            padding: 24px;
        }

        /* HEADER */
        .header {
            background: linear-gradient(135deg, #60a5fa, #3b82f6, #1d4ed8);
            color: #fff;
            padding: 22px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-bottom: 20px;
        }

        .header h4 {
            margin: 0;
            font-weight: 900;
            letter-spacing: -.3px;
        }

        .header small {
            opacity: .85;
        }

        /* CARD */
        .card-modern {
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .card-body {
            padding: 22px;
        }

        .section {
            margin-bottom: 18px;
        }

        .section-title {
            font-size: 11px;
            letter-spacing: .12em;
            font-weight: 800;
            color: var(--muted);
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        /* INPUT */
        label {
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 6px;
            display: block;
        }

        .form-control,
        .form-select {
            border-radius: 14px;
            border: 1px solid var(--border);
            padding: 11px 12px;
            transition: .2s;
            font-size: 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, .15);
        }

        /* GRID INPUT */
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }

        /* SIM BOX */
        .sim-box {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            border: 1px dashed #94a3b8;
            border-radius: 14px;
            padding: 12px;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* FOOTER */
        .footer {
            padding: 16px 22px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            background: #fff;
        }

        .btn-save {
            background: linear-gradient(135deg, #60a5fa, #3b82f6);
            border: none;
            color: #fff;
            padding: 11px 18px;
            border-radius: 14px;
            font-weight: 800;
            box-shadow: 0 10px 25px rgba(59, 130, 246, .25);
            transition: .2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-save:hover {
            transform: translateY(-2px);
        }

        /* RESPONSIVE */
        @media(max-width:768px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="wrap">

        {{-- HEADER --}}
        <div class="header">
            <h4>Tambah Driver</h4>
            <small>SIM dibuat otomatis oleh sistem secara real-time</small>
        </div>

        <form action="{{ route('admin.drivers.store') }}" method="POST">
            @csrf

            <div class="card-modern">

                <div class="card-body">

                    {{-- SECTION 1 --}}
                    <div class="section">
                        <div class="section-title">Operator</div>

                        <label>Nama Operator</label>
                        <select name="operator_id" class="form-select" required>
                            <option value="">Pilih Operator</option>
                            @foreach ($operators as $o)
                                <option value="{{ $o->id }}">{{ $o->operator_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- SECTION 2 --}}
                    <div class="section">
                        <div class="section-title">Data Driver</div>

                        <div class="grid">

                            <div>
                                <label>Nama Driver</label>
                                <input type="text" name="driver_name" class="form-control"
                                    placeholder="Nama lengkap driver" required>
                            </div>

                            <div>
                                <label>Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="active">Active</option>
                                    <option value="on_duty">On Duty</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <div>
                                <label>No HP</label>
                                <input type="text" name="phone" class="form-control" placeholder="0812xxxxxxx">
                            </div>

                            <div>
                                <label>No SIM</label>
                                <div class="sim-box">
                                    <i class="ri-id-card-line"></i>
                                    SIM akan dibuat otomatis oleh sistem
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- SECTION 3 --}}
                    <div class="section">
                        <div class="section-title">Alamat</div>

                        <label>Alamat Lengkap</label>
                        <textarea name="address" class="form-control" rows="3" placeholder="Masukkan alamat driver"></textarea>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="footer">
                    <button type="submit" class="btn-save">
                        <i class="ri-save-line"></i>
                        Simpan Driver
                    </button>
                </div>

            </div>

        </form>

    </div>
@endsection
