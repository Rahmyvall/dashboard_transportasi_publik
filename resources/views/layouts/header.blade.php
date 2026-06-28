<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Monitoring Transportasi Publik | {{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/logo.png') }}">

    <!-- ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- jquery.vectormap css -->
    <link href="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- BOOTSTRAP (WAJIB STABLE) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- LOCAL TEMPLATE (SAFE LOAD) -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --dark-bg: #0f172a;
            /* background utama */
            --dark-card: #1e293b;
            /* card & panel */
            --dark-border: #334155;
            /* border */
            --dark-text: #e2e8f0;
            /* teks utama */
            --dark-muted: #94a3b8;
            /* teks placeholder */
            --dark-input: #111827;
            /* input field */
        }

        body.dark-mode {
            background-color: var(--dark-bg) !important;
            color: var(--dark-text) !important;
        }

        body.dark-mode .navbar-header,
        body.dark-mode .vertical-menu,
        body.dark-mode .main-content,
        body.dark-mode .page-content,
        body.dark-mode .card,
        body.dark-mode .table,
        body.dark-mode .footer {
            background-color: var(--dark-card) !important;
            color: var(--dark-text) !important;
        }

        body.dark-mode .card {
            border: 1px solid var(--dark-border) !important;
            border-radius: 10px;
        }

        body.dark-mode .table th,
        body.dark-mode .table td,
        body.dark-mode label,
        body.dark-mode h1,
        body.dark-mode h2,
        body.dark-mode h3,
        body.dark-mode h4,
        body.dark-mode h5,
        body.dark-mode h6,
        body.dark-mode p,
        body.dark-mode span {
            color: var(--dark-text) !important;
        }

        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background-color: var(--dark-input) !important;
            color: var(--dark-text) !important;
            border: 1px solid var(--dark-border) !important;
        }

        body.dark-mode .form-control::placeholder {
            color: var(--dark-muted) !important;
        }

        body.dark-mode .table {
            border-color: var(--dark-border) !important;
        }

        #themeToggle {
            font-weight: 600;
        }

        body.dark-mode #themeToggle {
            color: var(--dark-text) !important;
        }
    </style>
</head>
