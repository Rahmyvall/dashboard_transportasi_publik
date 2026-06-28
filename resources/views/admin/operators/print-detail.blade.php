<!DOCTYPE html>
<html>

<head>
    <title>Detail Operator</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #fff;
            font-size: 14px;
            color: #333;
        }

        .header-box {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .title {
            letter-spacing: 2px;
        }

        .info-table th {
            width: 220px;
            background: #f8f9fa;
        }

        .badge-status {
            font-size: 12px;
            padding: 6px 12px;
        }

        .signature {
            margin-top: 60px;
        }

        .signature-box {
            width: 250px;
            text-align: center;
        }

        .line {
            margin-top: 70px;
            border-top: 1px solid #000;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="container mt-4">

        <!-- HEADER -->
        <div class="text-center header-box mb-4">
            <h4 class="fw-bold title">DETAIL OPERATOR</h4>
            <div class="text-muted">Laporan Data Operator Sistem</div>
        </div>

        <!-- CONTENT TABLE -->
        <div class="card border-0 shadow-sm">

            <div class="card-body p-0">

                <table class="table table-bordered mb-0 info-table">

                    <tr>
                        <th>Nama Operator</th>
                        <td class="fw-semibold">{{ $operator->operator_name }}</td>
                    </tr>

                    <tr>
                        <th>No Telepon</th>
                        <td>{{ $operator->phone ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{ $operator->email ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Alamat</th>
                        <td>{{ $operator->address ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($operator->status == 'aktif')
                                <span class="badge bg-success badge-status">Aktif</span>
                            @else
                                <span class="badge bg-danger badge-status">Nonaktif</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Tanggal Dibuat</th>
                        <td>{{ $operator->created_at?->format('d M Y H:i') }}</td>
                    </tr>

                </table>

            </div>

        </div>

        <!-- SIGNATURE -->
        <div class="row signature">

            <div class="col-6"></div>

            <div class="col-6 text-center signature-box">

                <div>
                    {{ date('d M Y') }}
                    <br>
                    Kepala Bagian
                </div>

                <div class="line"></div>

                <div class="fw-semibold mt-2">
                    (____________________)
                </div>

            </div>

        </div>

        <!-- BUTTON -->
        <div class="text-center no-print mt-4">
            <button onclick="window.print()" class="btn btn-primary px-4">
                Print Lagi
            </button>

            <button onclick="window.close()" class="btn btn-secondary px-4">
                Tutup
            </button>
        </div>

    </div>

</body>

</html>
