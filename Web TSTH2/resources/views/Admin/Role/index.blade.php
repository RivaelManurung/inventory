@extends('Master.Layout.app')

@section('title')
    User Access Management
@endsection

@section('menu')
    System
@endsection

@section('icon')
    <i class="ph-shield-check"></i>
@endsection

@push('styles')
<style>
    /* Keep your existing styles */
</style>
@endpush

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">User Access Management</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">System</a></li>
            <li class="breadcrumb-item active" aria-current="page">Access Control</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Manage User Roles and Permissions</h3>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ph-checks me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row">
                    <!-- Users List -->
                    <div class="col-md-4">
                        <div class="card permission-card">
                            <div class="permission-card-header">
                                <i class="ph-users me-2"></i> Users
                            </div>
                            <div class="permission-card-body">
                                @foreach($users as $user)
                                    <div class="user-access-item">
                                        <h6 class="mb-1">{{ $user->name }}</h6>
                                        <p class="text-muted small mb-2">{{ $user->email }}</p>
                                        
                                        <div class="mt-2">
                                            @foreach($user->roles as $role)
                                                <span class="badge bg-primary me-1 role-badge">{{ $role }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Roles Management -->
                    <div class="col-md-4">
                        <div class="card permission-card">
                            <div class="permission-card-header d-flex justify-content-between align-items-center">
                                <span><i class="ph-shield me-2"></i>Roles</span>
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                                    <i class="ph-plus me-1"></i> Add Role
                                </button>
                            </div>
                            <div class="permission-card-body">
                                <ul class="list-group">
                                    @foreach($all_roles as $role)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $role }}
                                            <div>
                                                <button class="btn btn-sm btn-icon btn-info me-1" data-bs-toggle="modal" 
                                                    data-bs-target="#editRoleModal" 
                                                    data-role="{{ $role }}">
                                                    <i class="ph-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal" 
                                                    data-bs-target="#deleteRoleModal" 
                                                    data-role="{{ $role }}">
                                                    <i class="ph-trash"></i>
                                                </button>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Permissions Management -->
                    <div class="col-md-4">
                        <div class="card permission-card">
                            <div class="permission-card-header">
                                <i class="ph-key me-2"></i> Permissions
                            </div>
                            <div class="permission-card-body">
                                <div class="row">
                                    @foreach($all_permissions as $permission)
                                        <div class="col-md-6 mb-2">
                                            <span class="badge bg-success d-block text-start permission-badge">
                                                <i class="ph-check-circle me-1"></i> {{ $permission }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role Assignment Section -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="ph-user-switch me-2"></i>Assign Roles to Users</h3>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('user-access.assign-role') }}">
                                    @csrf
                                    <div class="row g-2">
                                        <div class="col-md-5">
                                            <select class="form-select" name="user_id" required>
                                                <option value="">Select User</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <select class="form-select" name="role" required>
                                                <option value="">Select Role</option>
                                                @foreach($all_roles as $role)
                                                    <option value="{{ $role }}">{{ $role }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="ph-check-circle me-1"></i> Assign
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permission Assignment Section -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="ph-keyhole me-2"></i>Grant Permissions to Users</h3>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('user-access.give-permission') }}">
                                    @csrf
                                    <div class="row g-2">
                                        <div class="col-md-5">
                                            <select class="form-select" name="user_id" required>
                                                <option value="">Select User</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <select class="form-select" name="permission" required>
                                                <option value="">Select Permission</option>
                                                @foreach($all_permissions as $permission)
                                                    <option value="{{ $permission }}">{{ $permission }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="ph-check-circle me-1"></i> Grant
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals remain the same as before -->
@endsection

@push('scripts')
<script>
    // Your existing JavaScript
</script>
@endpush