@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        <div class="row justify-content-center">
            <div class="col-lg-12">

                <!-- Header -->
                <div class="mb-3">
                    <h4 class="fw-bold mb-1">
                        <i class="ri-shield-user-line text-primary"></i>
                        Edit Role
                    </h4>
                    <small class="text-muted">Update role information below</small>
                </div>

                <!-- Card -->
                <div class="card border-0 shadow-lg rounded-3">

                    <div class="card-body p-4">

                        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Role Name -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="ri-user-settings-line me-1"></i> Role Name
                                </label>

                                <input type="text" name="role_name" value="{{ $role->role_name }}"
                                    class="form-control form-control-lg rounded-2" placeholder="Enter role name">
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="ri-file-text-line me-1"></i> Description
                                </label>

                                <textarea name="description" class="form-control rounded-2" rows="4" placeholder="Enter role description...">{{ $role->description }}</textarea>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-between mt-4">

                                <a href="{{ route('admin.roles.index') }}" class="btn btn-light px-4">
                                    <i class="ri-arrow-left-line"></i> Back
                                </a>

                                <button class="btn btn-success px-4 shadow-sm">
                                    <i class="ri-save-line"></i> Update Role
                                </button>

                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
