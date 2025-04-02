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
    .permission-card {
        margin-bottom: 1.5rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
    }
    .permission-card-header {
        background-color: #f3f4f6;
        padding: 0.75rem 1rem;
        font-weight: 600;
        border-bottom: 1px solid #e5e7eb;
    }
    .permission-card-body {
        padding: 1rem;
    }
    .user-access-item {
        margin-bottom: 1rem;
        padding: 1rem;
        background-color: #f9fafb;
        border-radius: 0.5rem;
    }
    .route-item {
        padding: 0.5rem;
        border-bottom: 1px dashed #e5e7eb;
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">User Access Management</h5>
    </div>
    
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <!-- Users List -->
            <div class="col-md-4">
                <div class="card permission-card">
                    <div class="permission-card-header">
                        Users
                    </div>
                    <div class="permission-card-body">
                        @foreach($accessInfo['users'] ?? [] as $user)
                            <div class="user-access-item">
                                <h6>{{ $user['name'] }}</h6>
                                <p class="text-muted small mb-2">{{ $user['email'] }}</p>
                                
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-sm btn-info view-permissions" 
                                        data-user-id="{{ $user['id'] }}">
                                        View Permissions
                                    </button>
                                    <button class="btn btn-sm btn-primary view-routes" 
                                        data-user-id="{{ $user['id'] }}">
                                        View Routes
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Permissions and Roles -->
            <div class="col-md-4">
                <div class="card permission-card">
                    <div class="permission-card-header">
                        Roles & Permissions
                    </div>
                    <div class="permission-card-body">
                        <h6>All Roles</h6>
                        <ul class="list-group mb-3">
                            @foreach($accessInfo['all_roles'] ?? [] as $role)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $role }}
                                    <span class="badge bg-primary rounded-pill">Assign</span>
                                </li>
                            @endforeach
                        </ul>

                        <h6>All Permissions</h6>
                        <ul class="list-group">
                            @foreach($accessInfo['all_permissions'] ?? [] as $permission)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $permission }}
                                    <span class="badge bg-success rounded-pill">Grant</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- User Details -->
            <div class="col-md-4">
                <div class="card permission-card">
                    <div class="permission-card-header">
                        User Details
                    </div>
                    <div class="permission-card-body" id="user-details">
                        <div class="text-center text-muted py-4">
                            Select a user to view details
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accessible Routes Modal -->
        <div class="modal fade" id="routesModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Accessible Routes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="routesModalBody">
                        Loading...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // View Permissions
    $('.view-permissions').click(function() {
        const userId = $(this).data('user-id');
        $.get(`/admin/user-access/permissions/${userId}`, function(response) {
            $('#user-details').html(`
                <h6>User Permissions</h6>
                <ul class="list-group mb-3">
                    ${response.data.permissions.map(p => `<li class="list-group-item">${p}</li>`).join('')}
                </ul>
                <h6>User Roles</h6>
                <ul class="list-group">
                    ${response.data.roles.map(r => `<li class="list-group-item">${r}</li>`).join('')}
                </ul>
            `);
        }).fail(function(error) {
            alert('Failed to load permissions');
        });
    });

    // View Routes
    $('.view-routes').click(function() {
        const userId = $(this).data('user-id');
        $.get(`/admin/user-access/routes/${userId}`, function(response) {
            $('#routesModalBody').html(`
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Method</th>
                                <th>URI</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${response.data.accessible_routes.map(route => `
                                <tr>
                                    <td>${route.method}</td>
                                    <td>${route.uri}</td>
                                    <td>${route.name || '-'}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `);
            $('#routesModal').modal('show');
        }).fail(function(error) {
            alert('Failed to load routes');
        });
    });
});
</script>
@endpush