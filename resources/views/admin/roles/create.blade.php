@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        <div class="row justify-content-center">
            <div class="col-lg-12">

                <!-- Header -->
                <div class="mb-3">
                    <h4 class="fw-bold mb-1">
                        <i class="ri-user-add-line text-primary"></i>
                        Create Role
                    </h4>
                    <small class="text-muted">Add new role to the system</small>
                </div>

                <!-- Card -->
                <div class="card border-0 shadow-lg rounded-3">

                    <div class="card-body p-4">

                        <form action="{{ route('admin.roles.store') }}" method="POST">
                            @csrf

                            <!-- Role Name -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="ri-shield-user-line me-1"></i>
                                    Role Name
                                </label>

                                <input type="text" name="role_name" class="form-control form-control-lg rounded-2"
                                    placeholder="e.g. Admin, Operator, Manager">
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="ri-file-text-line me-1"></i>
                                    Description
                                </label>

                                <textarea name="description" class="form-control rounded-2" rows="4" placeholder="Write role description..."></textarea>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-between mt-4">

                                <a href="{{ route('admin.roles.index') }}" class="btn btn-light px-4">
                                    <i class="ri-arrow-left-line"></i> Back
                                </a>

                                <button class="btn btn-primary px-4 shadow-sm">
                                    <i class="ri-save-line"></i> Save Role
                                </button>

                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
