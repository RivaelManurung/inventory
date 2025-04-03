@extends('Master.Layout.app')

@section('content')
<div class="content-wrapper">
    <div class="content-inner">
        <div class="content">
            <!-- Dashboard content -->
            <div class="row">
                <!-- Quick stats boxes -->
                @if(in_array('barang.view', Session::get('permissions', [])))
                <div class="col-lg-3">
                    <div class="card bg-teal text-white">
                        <div class="card-body">
                            <div class="d-flex">
                                <h3 class="mb-10">{{ $barangs }}</h3>
                            </div>
                            <div>
                                Barang
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(in_array('jenisbarang.view', Session::get('permissions', [])))
                <div class="col-lg-3">
                    <div class="card bg-teal text-white">
                        <div class="card-body">
                            <div class="d-flex">
                                <h3 class="mb-10">{{ $jenisbarangs }}</h3>
                            </div>
                            <div>
                                Jenis Barang
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(in_array('transaksi.view', Session::get('permissions', [])))
                <div class="col-lg-3">
                    <div class="card bg-pink text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h3 class="mb-10">0</h3>
                                <div class="dropdown d-inline-flex ms-auto">
                                    <a href="#" class="text-white d-inline-flex align-items-center dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="ph-gear"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#" class="dropdown-item">
                                            <i class="ph-chart-line me-2"></i>
                                            Statistics
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                Transaksi
                            </div>
                        </div>
                        <div class="rounded-bottom overflow-hidden" id="server-load"></div>
                    </div>
                </div>
                @endif

                @if(in_array('satuan.view', Session::get('permissions', [])))
                <div class="col-lg-3">
                    <div class="card bg-teal text-white">
                        <div class="card-body">
                            <div class="d-flex">
                                <h3 class="mb-10">{{ $satuans }}</h3>
                            </div>
                            <div>
                                Satuan
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(in_array('user.view', Session::get('permissions', [])))
                <div class="col-lg-3">
                    <div class="card bg-teal text-white">
                        <div class="card-body">
                            <div class="d-flex">
                                <h3 class="mb-10">{{ $users }}</h3>
                            </div>
                            <div>
                                User
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(in_array('gudang.view', Session::get('permissions', [])))
                <div class="col-lg-3">
                    <div class="card bg-teal text-white">
                        <div class="card-body">
                            <div class="d-flex">
                                <h3 class="mb-10">{{ $gudangs }}</h3>
                            </div>
                            <div>
                                Gudang
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(in_array('status.view', Session::get('permissions', [])))
                <div class="col-lg-3">
                    <div class="card bg-teal text-white">
                        <div class="card-body">
                            <div class="d-flex">
                                <h3 class="mb-10">{{ $statuses ?? 0 }}</h3>
                            </div>
                            <div>
                                Status
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(in_array('jenistransaksi.view', Session::get('permissions', [])))
                <div class="col-lg-3">
                    <div class="card bg-teal text-white">
                        <div class="card-body">
                            <div class="d-flex">
                                <h3 class="mb-10">{{ $jenistransaksis ?? 0 }}</h3>
                            </div>
                            <div>
                                Jenis Transaksi
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="row mt-4">
                @if(in_array('transaksi.view', Session::get('permissions', [])))
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Transaksi</h5>
                        </div>
                        <div class="card-body">
                            <div class="fullcalendar-event-colors"></div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h5 class="mb-0">Daily financials</h5>
                            <div class="ms-auto">
                                <label class="form-check form-switch form-check-reverse">
                                    <input type="checkbox" class="form-check-input" id="realtime" checked>
                                    <span class="form-check-label">Realtime</span>
                                </label>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="chart mb-3" id="bullets"></div>

                            <div class="d-flex mb-3">
                                <div class="me-3">
                                    <div class="bg-pink bg-opacity-10 text-pink lh-1 rounded-pill p-2">
                                        <i class="ph-chart-line"></i>
                                    </div>
                                </div>
                                <div class="flex-fill">
                                    Stats for July, 6: <span class="fw-semibold">1938</span> orders, $4220 revenue
                                    <div class="text-muted fs-sm">2 hours ago</div>
                                </div>
                            </div>

                            <div class="d-flex mb-3">
                                <div class="me-3">
                                    <div class="bg-success bg-opacity-10 text-success lh-1 rounded-pill p-2">
                                        <i class="ph-check"></i>
                                    </div>
                                </div>
                                <div class="flex-fill">
                                    Invoices <a href="#">#4732</a> and <a href="#">#4734</a> have been paid
                                    <div class="text-muted fs-sm">Dec 18, 18:36</div>
                                </div>
                            </div>

                            <div class="d-flex mb-3">
                                <div class="me-3">
                                    <div class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                        <i class="ph-users"></i>
                                    </div>
                                </div>
                                <div class="flex-fill">
                                    Affiliate commission for June has been paid
                                    <div class="text-muted fs-sm">36 minutes ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Scan -->
        @if(in_array('scan.view', Session::get('permissions', [])))
        <button id="scan-btn" class="btn btn-primary d-flex btn-position btn-circle">
            <i class="ph-scan ph-2x rounded"></i>
        </button>

        <!-- Container Scanner -->
        <div id="scanner-container" style="display: none;">
            <button id="close-btn">✖</button>
            <video id="preview"></video>
            <input type="text" id="qrcode-result" class="form-control mt-2" readonly>
        </div>
        @endif
    </div>
</div>
@endsection