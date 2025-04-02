@extends('Master.Layout.app')

@section('content')
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
                            {{ Session::get('user.name') }}
                            <span class="badge bg-primary ms-1">
                                {{ implode(', ', Session::get('roles', [])) }}
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="{{ route('logout') }}" class="dropdown-item">
                                <i class="ph-sign-out me-1"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content pt-3">
            <!-- Stats Cards -->
            <div class="row">
                @if(in_array('barang.view', Session::get('permissions', [])))
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
                @endif

                @if(in_array('gudang.view', Session::get('permissions', [])))
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 text-success rounded p-2 me-3">
                                    <i class="ph-warehouse"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Total Gudang</h6>
                                    <span class="text-muted">5 locations</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="row mt-4">
                @if(in_array('barang.create', Session::get('permissions', [])))
                <div class="col-md-3">
                    <a href="{{ route('barang.create') }}" class="card card-hover">
                        <div class="card-body text-center">
                            <i class="ph-plus-circle ph-2x text-primary mb-2"></i>
                            <h6>Tambah Barang</h6>
                        </div>
                    </a>
                </div>
                @endif

                @if(in_array('gudang.create', Session::get('permissions', [])))
                <div class="col-md-3">
                    <a href="{{ route('gudang.create') }}" class="card card-hover">
                        <div class="card-body text-center">
                            <i class="ph-warehouse ph-2x text-success mb-2"></i>
                            <h6>Tambah Gudang</h6>
                        </div>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection