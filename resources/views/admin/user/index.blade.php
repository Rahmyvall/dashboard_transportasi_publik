@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="row mx-0">
        <div class="col-12 px-0">

            <div class="card border-0 shadow-sm rounded-0">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                        <div>
                            <h4 class="fw-bold mb-1">
                                <i class="mdi mdi-account-group-outline text-primary me-1"></i>
                                Data User
                            </h4>
                            <p class="text-muted mb-0">
                                Halaman ini digunakan untuk menampilkan dan mengelola data user.
                            </p>
                        </div>

                        <a href="#" class="btn btn-primary">
                            <i class="mdi mdi-plus-circle-outline me-1"></i>
                            Tambah User
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table id="alternative-page-datatable"
                               class="table table-bordered table-hover table-striped align-middle w-100 mb-0"
                               style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 5%;">No</th>
                                    <th>Nama User</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width: 15%;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                                 style="width: 38px; height: 38px;">
                                                A
                                            </div>
                                            <div>
                                                <h6 class="mb-0">Admin</h6>
                                                <small class="text-muted">Super Admin</small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <i class="mdi mdi-email-outline text-muted me-1"></i>
                                        admin@gmail.com
                                    </td>

                                    <td>
                                        <span class="badge bg-primary">
                                            Administrator
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-success">
                                            <i class="mdi mdi-check-circle-outline me-1"></i>
                                            Aktif
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="#" class="btn btn-sm btn-info text-white" title="Detail">
                                                <i class="mdi mdi-eye-outline"></i>
                                            </a>

                                            <a href="#" class="btn btn-sm btn-warning text-white" title="Edit">
                                                <i class="mdi mdi-pencil-outline"></i>
                                            </a>

                                            <a href="#"
                                               class="btn btn-sm btn-danger"
                                               title="Hapus"
                                               onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="mdi mdi-delete-outline"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center">2</td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2"
                                                 style="width: 38px; height: 38px;">
                                                U
                                            </div>
                                            <div>
                                                <h6 class="mb-0">User</h6>
                                                <small class="text-muted">Staff</small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <i class="mdi mdi-email-outline text-muted me-1"></i>
                                        user@gmail.com
                                    </td>

                                    <td>
                                        <span class="badge bg-secondary">
                                            Staff
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-success">
                                            <i class="mdi mdi-check-circle-outline me-1"></i>
                                            Aktif
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="#" class="btn btn-sm btn-info text-white" title="Detail">
                                                <i class="mdi mdi-eye-outline"></i>
                                            </a>

                                            <a href="#" class="btn btn-sm btn-warning text-white" title="Edit">
                                                <i class="mdi mdi-pencil-outline"></i>
                                            </a>

                                            <a href="#"
                                               class="btn btn-sm btn-danger"
                                               title="Hapus"
                                               onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="mdi mdi-delete-outline"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection