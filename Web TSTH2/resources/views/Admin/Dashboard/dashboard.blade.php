@extends('Master.Layout.app')

@section('title', 'Dashboard Admin')

@section('content')
<main class="page-content">
    <div class="content-wrapper">
        <div class="content-inner">
            <!-- User Info Header -->
            <div class="navbar navbar-expand-lg navbar-light border-bottom py-2">
                <div class="container-fluid">
                    <h5 class="mb-0">Dashboard</h5>
                    <div class="navbar-nav align-items-center ms-auto">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="ph-user me-1"></i>
                                {{ $user->user_nmlengkap }}
                                <span class="badge bg-primary ms-1">
                                    {{ $user->role }}
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">
                                    <i class="ph-user-circle me-1"></i> Profile
                                </a>
                                <a href="{{ route('logout') }}" class="dropdown-item">
                                    <i class="ph-sign-out me-1"></i> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Main Content -->
            <div class="content pt-3">
                <!-- Stats Cards -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3">
                                        <i class="ph-package"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Total Barang</h6>
                                        <span class="text-muted">125 items</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Other stat cards... -->
                </div>

                <!-- Sample Inventory Table -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Daftar Barang</h5>
                                {{-- @if(isset($user->permissions) && in_array('barang.create', $user->permissions))
                                    <a href="{{ route('barang.create') }}" class="btn btn-primary btn-sm">
                                        <i class="ph-plus-circle me-1"></i> Tambah Barang
                                    </a>
                                @endif --}}
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="staticDataTable">
                                        <!-- Table content... -->
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection