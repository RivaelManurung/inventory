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
                                {{ $user->user_nama }}
                                <span class="badge bg-primary ms-1">
                                    {{ $user->roles->first()->name ?? 'User' }}
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
                                        <span class="text-muted">{{ $totalBarang }} items</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 text-success rounded p-2 me-3">
                                        <i class="ph-arrow-clockwise"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Transaksi Hari Ini</h6>
                                        <span class="text-muted">{{ $totalTransaksiHariIni }} transactions</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning bg-opacity-10 text-warning rounded p-2 me-3">
                                        <i class="ph-hand-palm"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Peminjaman Aktif</h6>
                                        <span class="text-muted">{{ $totalPeminjamanAktif }} items</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-danger bg-opacity-10 text-danger rounded p-2 me-3">
                                        <i class="ph-clock"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Pengembalian Terlambat</h6>
                                        <span class="text-muted">{{ $totalPengembalianTerlambat }} items</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sample Inventory Table -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Sample Inventory Data</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>Stock</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>001</td>
                                                <td>Microcontroller X200</td>
                                                <td>Electronics</td>
                                                <td>1250</td>
                                                <td><span class="badge bg-success">In Stock</span></td>
                                            </tr>
                                            <tr>
                                                <td>002</td>
                                                <td>Aluminum Alloy</td>
                                                <td>Raw Material</td>
                                                <td>85</td>
                                                <td><span class="badge bg-warning">Low Stock</span></td>
                                            </tr>
                                            <tr>
                                                <td>003</td>
                                                <td>Plastic Casing</td>
                                                <td>Components</td>
                                                <td>420</td>
                                                <td><span class="badge bg-success">In Stock</span></td>
                                            </tr>
                                        </tbody>
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

@section('scripts')
@endsection